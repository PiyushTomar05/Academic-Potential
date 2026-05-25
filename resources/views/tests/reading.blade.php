@extends('layouts.app')

@section('title', 'Language & Reading Test | Test Center')

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
                <span class="material-symbols-outlined text-cyan-500">menu_book</span>
                Language & Reading
            </h2>
            <p class="text-xs text-slate-555 dark:text-slate-400">Evaluates information reading speed and comprehension accuracy.</p>
        </div>
    </div>

    <!-- 1. Reading Stopwatch Interface -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50 shadow-xl mb-6 space-y-6">
        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
            <span class="material-symbols-outlined text-cyan-500">timer</span>
            Stopwatch Passage Reader
        </h3>
        
        <!-- Interactive Instruction Phase -->
        <div id="instruction-panel" class="bg-cyan-500/5 dark:bg-cyan-500/10 border border-cyan-500/15 rounded-2xl p-6 space-y-3">
            <strong class="text-sm font-bold text-cyan-600 dark:text-cyan-400 block">How to take this assessment:</strong>
            <p class="text-xs text-slate-600 dark:text-slate-350 leading-relaxed">
                1. Click the **"Start Reading"** button below. A technical passage of approximately 100 words will be revealed.
                2. Read the passage at your normal, comfortable understanding speed. 
                3. Immediately upon finishing the last sentence, click **"Finish Reading"**.
                4. The passage will be hidden, your reading speed in Words Per Minute (WPM) will be calculated, and 3 comprehension questions will appear.
            </p>
            <div class="pt-3">
                <button type="button" id="start-reading-btn" class="px-6 py-3 bg-cyan-600 hover:bg-cyan-500 dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white font-extrabold text-xs rounded-xl shadow-lg hover:shadow-cyan-500/20 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                    Start Reading Stopwatch
                </button>
            </div>
        </div>

        <!-- Timer HUD (Hidden initially) -->
        <div id="timer-hud" class="hidden flex items-center gap-4 py-2 border-b border-slate-200/15">
            <span class="w-2.5 h-2.5 rounded-full bg-cyan-500 animate-ping"></span>
            <span class="text-xs text-cyan-500 font-extrabold tracking-widest uppercase">READING TIMELAPSE ACTIVE</span>
            <span class="text-sm text-slate-800 dark:text-slate-100 font-black ml-auto" id="hud-timer">0.0s</span>
        </div>

        <!-- The Passage (Hidden initially) -->
        <div id="passage-container" class="hidden relative select-none">
            <!-- Blur overlay to prevent pre-reading -->
            <div class="bg-white/50 dark:bg-slate-900/50 backdrop-blur-md rounded-2xl p-6 border border-slate-200/50 dark:border-slate-800/50">
                <p id="technical-passage" class="text-base sm:text-lg font-medium text-slate-850 dark:text-slate-200 leading-relaxed tracking-wide italic">
                    In the domain of computer science, modern deep learning architectures rely extensively on computational scaling laws. Neural networks optimize high-dimensional parameter spaces to generalize complex functions. However, achieving cognitive alignment remains a core challenge. Aligning the objective functions of deep MLP Classifiers with human preferences requires delicate optimization. Furthermore, neural representations are frequently sensitive to slight variations in prompting, introducing latency and inference bottlenecks. Efficacious systems resolve these bottleneck challenges by introducing lightweight, locally calculated heuristic layers. These local weighted models perform robustly without introducing the memory allocation and communication latency overhead of distributed cloud APIs, maintaining local sandbox integrity.
                </p>
            </div>
            
            <div class="mt-6 text-center">
                <button type="button" id="finish-reading-btn" class="px-8 py-3 bg-red-600 hover:bg-red-500 text-white font-extrabold text-xs rounded-xl shadow-lg hover:shadow-red-500/20 transition-all flex items-center gap-2 mx-auto">
                    <span class="material-symbols-outlined text-[16px]">stop</span>
                    Finish Reading & Lock Speed
                </button>
            </div>
        </div>

        <!-- Reading Metrics Dynamic Output (Hidden initially) -->
        <div id="metrics-panel" class="hidden bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-550/15 rounded-2xl p-6 grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
            <div class="space-y-1">
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block">READING TIMELAPSE</span>
                <strong class="text-xl font-black text-slate-800 dark:text-slate-100" id="stat-time">0.0 seconds</strong>
            </div>
            <div class="space-y-1 border-y sm:border-y-0 sm:border-x border-slate-200/10 py-3 sm:py-0">
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block">WORD COUNT</span>
                <strong class="text-xl font-black text-slate-800 dark:text-slate-100" id="stat-words">0 words</strong>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] text-emerald-500 font-extrabold uppercase tracking-widest block">READING SPEED</span>
                <strong class="text-xl font-black text-emerald-600 dark:text-emerald-450" id="stat-wpm">0 WPM</strong>
            </div>
        </div>
    </div>

    <!-- 2. Comprehension Questions Form (Hidden initially) -->
    <form id="reading-form" class="hidden space-y-6">
        @csrf
        <input type="hidden" name="wpm" id="wpm_input" value="0">
        <input type="hidden" name="time_taken" id="time_taken_input" value="0">

        <!-- Q1 -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-[10px] font-black uppercase tracking-wider">Question 1: Conceptual Alignment</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                What is identified as a core challenge of modern neural networks in the passage?
            </h3>
            <div class="grid grid-cols-1 gap-3 mt-4">
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-cyan-500/5 dark:hover:bg-cyan-500/5 cursor-pointer transition-all">
                    <input class="text-cyan-500 focus:ring-cyan-500" type="radio" name="q1" value="A" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">A) Achieving cognitive alignment with human preferences.</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-cyan-500/5 dark:hover:bg-cyan-500/5 cursor-pointer transition-all">
                    <input class="text-cyan-500 focus:ring-cyan-500" type="radio" name="q1" value="B" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">B) Installing cloud dependencies on isolated sandboxed nodes.</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-cyan-500/5 dark:hover:bg-cyan-500/5 cursor-pointer transition-all">
                    <input class="text-cyan-500 focus:ring-cyan-500" type="radio" name="q1" value="C" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">C) Training multi-layer models using continuous non-numerical target lists.</span>
                </label>
            </div>
        </div>

        <!-- Q2 -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-[10px] font-black uppercase tracking-wider">Question 2: Resolution Bottlenecks</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                According to the passage, how do highly efficacious systems resolve representation sensitivity and latency bottlenecks?
            </h3>
            <div class="grid grid-cols-1 gap-3 mt-4">
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-cyan-500/5 dark:hover:bg-cyan-500/5 cursor-pointer transition-all">
                    <input class="text-cyan-500 focus:ring-cyan-500" type="radio" name="q2" value="A" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">A) By upgrading deep hardware architecture parameters.</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-cyan-500/5 dark:hover:bg-cyan-500/5 cursor-pointer transition-all">
                    <input class="text-cyan-500 focus:ring-cyan-500" type="radio" name="q2" value="B" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">B) By introducing lightweight, locally calculated heuristic layers.</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-cyan-500/5 dark:hover:bg-cyan-500/5 cursor-pointer transition-all">
                    <input class="text-cyan-500 focus:ring-cyan-500" type="radio" name="q2" value="C" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">C) By migrating deep data dependencies onto massive distributed cloud APIs.</span>
                </label>
            </div>
        </div>

        <!-- Q3 -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-[10px] font-black uppercase tracking-wider">Question 3: Author Analysis</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                What is the overall tone and writing style of the author in this text?
            </h3>
            <div class="grid grid-cols-1 gap-3 mt-4">
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-cyan-500/5 dark:hover:bg-cyan-500/5 cursor-pointer transition-all">
                    <input class="text-cyan-500 focus:ring-cyan-500" type="radio" name="q3" value="A" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">A) Subjective and emotionally creative.</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-cyan-500/5 dark:hover:bg-cyan-500/5 cursor-pointer transition-all">
                    <input class="text-cyan-500 focus:ring-cyan-500" type="radio" name="q3" value="B" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">B) Critical and heavily skeptical.</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-cyan-500/5 dark:hover:bg-cyan-500/5 cursor-pointer transition-all">
                    <input class="text-cyan-500 focus:ring-cyan-500" type="radio" name="q3" value="C" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">C) Objective and technically analytical.</span>
                </label>
            </div>
        </div>

        <!-- Submit Panel -->
        <div class="flex justify-between items-center py-6">
            <a href="{{ route('tests.index') }}" class="px-6 py-3 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-bold rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                Cancel Test
            </a>
            <button type="submit" id="submit-btn" class="px-8 py-3 bg-cyan-600 hover:bg-cyan-500 dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white font-bold rounded-2xl shadow-lg hover:shadow-cyan-500/25 transition-all">
                Submit Test Results
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const startBtn = document.getElementById('start-reading-btn');
        const finishBtn = document.getElementById('finish-reading-btn');
        const instructionPanel = document.getElementById('instruction-panel');
        const timerHud = document.getElementById('timer-hud');
        const hudTimer = document.getElementById('hud-timer');
        const passageContainer = document.getElementById('passage-container');
        const technicalPassage = document.getElementById('technical-passage');
        
        const metricsPanel = document.getElementById('metrics-panel');
        const statTime = document.getElementById('stat-time');
        const statWords = document.getElementById('stat-words');
        const statWpm = document.getElementById('stat-wpm');
        
        const questionsForm = document.getElementById('reading-form');
        const wpmInput = document.getElementById('wpm_input');
        const timeInput = document.getElementById('time_taken_input');
        const submitBtn = document.getElementById('submit-btn');

        let startMs = 0;
        let activeTimer = null;
        const totalWords = technicalPassage.innerText.split(/\s+/).filter(w => w.length > 0).length;

        // 1. Click Start
        startBtn.addEventListener('click', () => {
            instructionPanel.classList.add('hidden');
            timerHud.classList.remove('hidden');
            passageContainer.classList.remove('hidden');
            
            startMs = performance.now();
            
            // Start local stopwatch interval
            activeTimer = setInterval(() => {
                const diffSec = ((performance.now() - startMs) / 1000).toFixed(1);
                hudTimer.innerText = `${diffSec}s`;
            }, 100);
        });

        // 2. Click Finish
        finishBtn.addEventListener('click', () => {
            const endMs = performance.now();
            clearInterval(activeTimer);
            
            const elapsedSecs = (endMs - startMs) / 1000;
            const wpm = (totalWords / (elapsedSecs / 60));

            // Hide Reading panel elements
            timerHud.classList.add('hidden');
            passageContainer.classList.add('hidden');
            
            // Show metrics and set inputs
            statTime.innerText = `${elapsedSecs.toFixed(1)} seconds`;
            statWords.innerText = `${totalWords} words`;
            statWpm.innerText = `${Math.round(wpm)} WPM`;
            metricsPanel.classList.remove('hidden');
            
            wpmInput.value = wpm.toFixed(2);
            timeInput.value = elapsedSecs.toFixed(2);

            // Reveal questions
            questionsForm.classList.remove('hidden');
            showToast('Reading Speed Logged!', `Recorded ${Math.round(wpm)} Words Per Minute. Please answer comprehension questions.`, 'success');
        });

        // 3. Submit Form
        questionsForm.addEventListener('submit', (e) => {
            e.preventDefault();
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
                Processing...
            `;

            const formData = new FormData(questionsForm);
            fetch('{{ route('tests.reading.save') }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Reading Test Completed!', data.message, 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    showToast('Error', 'Failed to save results. Please try again.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Submit Test Results';
                }
            })
            .catch(err => {
                showToast('Network Error', 'A communications error occurred. Check server status.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerText = 'Submit Test Results';
            });
        });
    });
</script>
@endsection
