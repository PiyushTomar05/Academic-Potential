@extends('layouts.app')

@section('title', 'Speaking Test | Test Center')

@section('styles')
<style>
    /* Voice Wave animation styles */
    .wave-bar {
        width: 4px;
        height: 15px;
        background-color: #ec4899;
        border-radius: 2px;
        animation: pulseWave 1s ease-in-out infinite;
        transition: height 0.15s ease;
    }
    .wave-bar:nth-child(2) { animation-delay: 0.1s; }
    .wave-bar:nth-child(3) { animation-delay: 0.2s; }
    .wave-bar:nth-child(4) { animation-delay: 0.3s; }
    .wave-bar:nth-child(5) { animation-delay: 0.4s; }
    .wave-bar:nth-child(6) { animation-delay: 0.5s; }
    .wave-bar:nth-child(7) { animation-delay: 0.6s; }
    .wave-bar:nth-child(8) { animation-delay: 0.7s; }

    @keyframes pulseWave {
        0%, 100% { height: 15px; }
        50% { height: 45px; }
    }
</style>
@endsection

@section('content')
<div class="p-6 lg:p-8 max-w-4xl mx-auto">
    <!-- Breadcrumb return navigation -->
    <div class="mb-4 mt-6">
        <a href="{{ route('tests.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-cyan-accent font-bold text-xs transition-colors select-none">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Return to Assessment Center</span>
        </a>
    </div>

    <!-- Header -->
    <div class="sticky top-16 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl z-20 py-4 px-6 rounded-3xl border border-slate-200/40 dark:border-slate-800/40 flex justify-between items-center mb-8 shadow-lg">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-pink-500">mic</span>
                Vocal Fluency Test
            </h2>
            <p class="text-xs text-slate-555 dark:text-slate-400">Independent speaking assessment evaluating fluency, confidence, and pronunciation.</p>
        </div>
    </div>

    <!-- Recorder Bento Card -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50 shadow-xl space-y-6">
        <!-- Prompt message -->
        <div class="bg-pink-500/5 dark:bg-pink-500/10 border border-pink-500/15 rounded-2xl p-6 space-y-3">
            <strong class="text-sm font-bold text-pink-650 dark:text-pink-400 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">record_voice_over</span>
                Speaking Prompt: Candidate Self Introduction
            </strong>
            <p class="text-xs text-slate-600 dark:text-slate-350 leading-relaxed font-semibold">
                "Please introduce yourself briefly. Mention your major course of study, your key technical skills, and your long-term career aspirations. Speak clearly, steadily, and aim for a duration of at least 10 seconds."
            </p>
        </div>

        <!-- Waveform visualizer & countdown -->
        <div class="flex flex-col items-center justify-center py-8 border border-slate-250/15 dark:border-slate-850/10 bg-slate-100/20 dark:bg-slate-950/20 rounded-3xl relative">
            <div id="recording-status" class="text-xs text-slate-400 font-extrabold uppercase tracking-widest block mb-4">Recorder Offline</div>
            
            <!-- Animated Waveform Bars (hidden by default) -->
            <div id="waveform" class="hidden items-center gap-1.5 h-16 mb-4">
                <div class="wave-bar"></div>
                <div class="wave-bar"></div>
                <div class="wave-bar"></div>
                <div class="wave-bar"></div>
                <div class="wave-bar"></div>
                <div class="wave-bar"></div>
                <div class="wave-bar"></div>
                <div class="wave-bar"></div>
            </div>

            <!-- Standby Microphone Icon (visible initially) -->
            <div id="standby-mic" class="w-16 h-16 rounded-full bg-slate-300/20 dark:bg-slate-800/20 flex items-center justify-center text-slate-400 mb-4">
                <span class="material-symbols-outlined text-[32px]">mic_off</span>
            </div>

            <!-- Seconds elapsed indicator -->
            <strong id="record-timer" class="text-3xl font-black text-slate-800 dark:text-slate-100">0.0s</strong>
        </div>

        <!-- Controls panel -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4 py-2">
            <!-- Record Toggle -->
            <button type="button" id="record-btn" class="w-full sm:w-auto px-8 py-3.5 bg-pink-600 hover:bg-pink-500 dark:bg-pink-500 dark:hover:bg-pink-400 text-white font-extrabold text-xs rounded-xl shadow-lg hover:shadow-pink-500/25 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">radio_button_checked</span>
                <span>Start Recording Voice</span>
            </button>

            <!-- Stop Toggle (hidden initially) -->
            <button type="button" id="stop-btn" class="w-full sm:w-auto px-8 py-3.5 bg-red-650 hover:bg-red-500 text-white font-extrabold text-xs rounded-xl shadow-lg hover:shadow-red-500/25 transition-all flex items-center justify-center gap-2 hidden">
                <span class="material-symbols-outlined text-[18px]">stop</span>
                <span>Stop & Evaluate Voice</span>
            </button>

            <!-- Fallback audio uploader (to handle permissions refusal gracefully) -->
            <div class="w-full sm:w-auto">
                <label for="fallback-upload" class="w-full flex items-center justify-center gap-2 px-6 py-3 border border-slate-200 dark:border-slate-800 text-slate-450 dark:text-slate-400 text-xs font-bold rounded-xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors cursor-pointer text-center">
                    <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                    <span>Upload Audio File Instead</span>
                </label>
                <input type="file" id="fallback-upload" accept="audio/*" class="hidden" onchange="handleFallbackFile(this)">
            </div>
        </div>
    </div>

    <!-- Action Back Panel -->
    <div class="flex justify-start py-6">
        <a href="{{ route('tests.index') }}" class="px-6 py-3 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-bold rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
            Return to Assessment Center
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function initSpeaking() {
        const recordBtn = document.getElementById('record-btn');
        const stopBtn = document.getElementById('stop-btn');
        const recStatus = document.getElementById('recording-status');
        const waveform = document.getElementById('waveform');
        const standbyMic = document.getElementById('standby-mic');
        const recordTimer = document.getElementById('record-timer');

        let mediaRecorder = null;
        let audioChunks = [];
        let recordStart = 0;
        let elapsedInterval = null;
        let finalDuration = 0;

        // Start Voice Recording
        recordBtn.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.addEventListener('dataavailable', event => {
                    audioChunks.push(event.data);
                });

                mediaRecorder.addEventListener('stop', () => {
                    stream.getTracks().forEach(track => track.stop());
                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    uploadAudioBlob(audioBlob);
                });

                // Start recording
                mediaRecorder.start();
                recordStart = performance.now();
                
                // Update UI state
                recordBtn.classList.add('hidden');
                stopBtn.classList.remove('hidden');
                recStatus.innerText = "RECORDING NOW...";
                recStatus.classList.add('text-pink-500', 'animate-pulse');
                recStatus.classList.remove('text-slate-400');
                waveform.classList.remove('hidden');
                waveform.classList.add('flex');
                standbyMic.classList.add('hidden');

                // Timer interval
                elapsedInterval = setInterval(() => {
                    const elapsed = ((performance.now() - recordStart) / 1000).toFixed(1);
                    recordTimer.innerText = `${elapsed}s`;
                    finalDuration = Math.round(parseFloat(elapsed));
                }, 100);

            } catch (err) {
                showToast('Microphone Blocked', 'Could not access audio hardware. Please upload an audio file.', 'error');
                console.error("Mic permissions refusal", err);
            }
        });

        // Stop Voice Recording
        stopBtn.addEventListener('click', () => {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                clearInterval(elapsedInterval);
                
                stopBtn.disabled = true;
                stopBtn.innerHTML = `
                    <span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
                    Evaluating vocal patterns...
                `;
            }
        });

        // Fallback File Upload handler
        window.handleFallbackFile = (input) => {
            const file = input.files[0];
            if (file) {
                showToast('Audio Logged!', `Vocal introduction loaded: ${file.name}`, 'success');
                uploadAudioBlob(file, 15);
            }
        };

        // Submit Audio to backend via AJAX
        function uploadAudioBlob(blob, overrideDuration = null) {
            const duration = overrideDuration || finalDuration;
            const formData = new FormData();
            formData.append('audio', blob);
            formData.append('duration', duration);
            
            // Add Laravel CSRF token
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('tests.speaking.save') }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Vocal Evaluation Complete!', ' Vowel resonance, pitch pacing, and pronunciations evaluated.', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1800);
                } else {
                    showToast('Error', 'Failed to submit voice recording.', 'error');
                    resetRecorderUI();
                }
            })
            .catch(err => {
                showToast('Network Error', 'Vocal upload failed. Please verify server status.', 'error');
                resetRecorderUI();
            });
        }

        function resetRecorderUI() {
            recordBtn.classList.remove('hidden');
            stopBtn.classList.add('hidden');
            stopBtn.disabled = false;
            stopBtn.innerHTML = `
                <span class="material-symbols-outlined text-[18px]">stop</span>
                <span>Stop & Evaluate Voice</span>
            `;
            recStatus.innerText = "Recorder Offline";
            recStatus.className = "text-xs text-slate-400 font-extrabold uppercase tracking-widest block mb-4";
            waveform.classList.add('hidden');
            waveform.classList.remove('flex');
            standbyMic.classList.remove('hidden');
            recordTimer.innerText = "0.0s";
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSpeaking);
    } else {
        initSpeaking();
    }
</script>
@endsection
