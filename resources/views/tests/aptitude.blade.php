@extends('layouts.app')

@section('title', 'Cognitive Aptitude Test | Test Center')

@section('content')
<div class="p-6 lg:p-8 max-w-4xl mx-auto">
    <!-- Breadcrumb return navigation -->
    <div class="mb-4 mt-6">
        <a href="{{ route('tests.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-cyan-accent font-bold text-xs transition-colors select-none">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Return to Assessment Center</span>
        </a>
    </div>

    <!-- Header & Timer -->
    <div class="sticky top-16 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl z-20 py-4 px-6 rounded-3xl border border-slate-200/40 dark:border-slate-800/40 flex justify-between items-center mb-8 shadow-lg">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-500">psychology_alt</span>
                Cognitive Aptitude
            </h2>
            <p class="text-xs text-slate-555 dark:text-slate-400">Total 6 questions evaluating sectional reasoning.</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Timer Display -->
            <div class="flex items-center gap-2 bg-red-500/10 border border-red-500/20 px-4 py-2 rounded-2xl text-red-500 font-extrabold text-sm animate-pulse">
                <span class="material-symbols-outlined text-[18px]">timer</span>
                <span id="timer-display">05:00</span>
            </div>
        </div>
    </div>

    <!-- Questions Form -->
    <form id="aptitude-form" class="space-y-6">
        @csrf
        <input type="hidden" name="time_taken" id="time_taken_input" value="0">

        <!-- 1. Quantitative Q1 -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-wider">Question 1: Quantitative Reasoning</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                A single manufacturing machine produces 100 units in 4 hours. How many units can 3 machines produce in 6 hours if operating concurrently at the same rate?
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                @foreach(['300', '400', '450', '600'] as $val)
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-indigo-500/5 dark:hover:bg-indigo-500/5 cursor-pointer transition-all">
                        <input class="text-indigo-650 focus:ring-indigo-650" type="radio" name="q1" value="{{ $val }}" required/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">{{ $val }} units</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 2. Quantitative Q2 -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-wider">Question 2: Quantitative Reasoning</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                A bag contains 3 red balls and 5 blue balls. If two balls are drawn at random one after another without replacement, what is the probability that the first ball is red and the second is blue?
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                @foreach(['15/64', '15/56', '3/8', '5/8'] as $val)
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-indigo-500/5 dark:hover:bg-indigo-500/5 cursor-pointer transition-all">
                        <input class="text-indigo-650 focus:ring-indigo-650" type="radio" name="q2" value="{{ $val }}" required/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">{{ $val }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 3. Logical Q3 -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-wider">Question 3: Logical Mapping</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                Identify the logic and complete the sequence: 2, 6, 12, 20, 30, ?
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                @foreach(['36', '40', '42', '45'] as $val)
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-indigo-500/5 dark:hover:bg-indigo-500/5 cursor-pointer transition-all">
                        <input class="text-indigo-650 focus:ring-indigo-650" type="radio" name="q3" value="{{ $val }}" required/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">{{ $val }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 4. Logical Q4 -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-wider">Question 4: Logical Mapping</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                If the word "SYSTEM" is encoded as "METSYS" in a certain cipher, how would you encode the word "PATTERN"?
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                @foreach(['NRETTAP', 'NRETAPT', 'RETTPAN', 'NRRETAP'] as $val)
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-indigo-500/5 dark:hover:bg-indigo-500/5 cursor-pointer transition-all">
                        <input class="text-indigo-650 focus:ring-indigo-650" type="radio" name="q4" value="{{ $val }}" required/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">{{ $val }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 5. Verbal Q5 -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-wider">Question 5: Verbal Competency</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                Select the option that represents the closest synonym of the word: "ACUMEN".
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                @foreach(['Anger', 'Wisdom', 'Hesitation', 'Courage'] as $val)
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-indigo-500/5 dark:hover:bg-indigo-500/5 cursor-pointer transition-all">
                        <input class="text-indigo-650 focus:ring-indigo-650" type="radio" name="q5" value="{{ $val }}" required/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">{{ $val }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 6. Verbal Q6 -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-wider">Question 6: Verbal Competency</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                Identify the correct spelling from the options listed below:
            </h3>
            <div class="grid grid-cols-1 gap-3 mt-4">
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-indigo-500/5 dark:hover:bg-indigo-500/5 cursor-pointer transition-all">
                    <input class="text-indigo-650 focus:ring-indigo-650" type="radio" name="q6" value="A" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">A) Accommodation (Double 'c', Double 'm')</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-indigo-500/5 dark:hover:bg-indigo-500/5 cursor-pointer transition-all">
                    <input class="text-indigo-650 focus:ring-indigo-650" type="radio" name="q6" value="B" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">B) Accomodation (Double 'c', Single 'm')</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-indigo-500/5 dark:hover:bg-indigo-500/5 cursor-pointer transition-all">
                    <input class="text-indigo-650 focus:ring-indigo-650" type="radio" name="q6" value="C" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">C) Acomodation (Single 'c', Single 'm')</span>
                </label>
            </div>
        </div>

        <!-- Submit Panel -->
        <div class="flex justify-between items-center py-6">
            <a href="{{ route('tests.index') }}" class="px-6 py-3 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-bold rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                Cancel Test
            </a>
            <button type="submit" id="submit-btn" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400 text-white font-bold rounded-2xl shadow-lg hover:shadow-indigo-500/25 transition-all">
                Submit Test Results
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function initAptitude() {
        let totalSeconds = 300; // 5 Minutes
        let elapsedSeconds = 0;
        const timerDisplay = document.getElementById('timer-display');
        const timeInput = document.getElementById('time_taken_input');
        const form = document.getElementById('aptitude-form');
        const submitBtn = document.getElementById('submit-btn');

        // Start Countdown Timer
        const interval = setInterval(() => {
            if (totalSeconds <= 0) {
                clearInterval(interval);
                timeInput.value = elapsedSeconds;
                showToast('Time Expired!', 'The assessment time limit has been reached. Auto-submitting...', 'warning');
                submitForm();
                return;
            }
            totalSeconds--;
            elapsedSeconds++;
            timeInput.value = elapsedSeconds;

            const mins = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
            const secs = (totalSeconds % 60).toString().padStart(2, '0');
            timerDisplay.innerText = `${mins}:${secs}`;
            
            // Pulsing fast alarm under 30s
            if (totalSeconds <= 30) {
                timerDisplay.parentElement.classList.add('bg-red-600/25');
                timerDisplay.parentElement.classList.remove('bg-red-500/10');
            }
        }, 1000);

        // Submit via AJAX
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            clearInterval(interval);
            submitForm();
        });

        function submitForm() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
                Processing...
            `;

            const formData = new FormData(form);
            fetch('{{ route('tests.aptitude.save') }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Assessment Completed!', data.message, 'success');
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
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAptitude);
    } else {
        initAptitude();
    }
</script>
@endsection
