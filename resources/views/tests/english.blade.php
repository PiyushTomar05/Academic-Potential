@extends('layouts.app')

@section('title', 'English Language Test | Test Center')

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
                <span class="material-symbols-outlined text-emerald-500">abc</span>
                English Language Test
            </h2>
            <p class="text-xs text-slate-555 dark:text-slate-400">Total 4 questions assessing grammar, vocabulary, and correction.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-red-500/10 border border-red-500/20 px-4 py-2 rounded-2xl text-red-500 font-extrabold text-sm animate-pulse">
                <span class="material-symbols-outlined text-[18px]">timer</span>
                <span id="timer-display">03:00</span>
            </div>
        </div>
    </div>

    <!-- Questions Form -->
    <form id="english-form" class="space-y-6">
        @csrf
        <input type="hidden" name="time_taken" id="time_taken_input" value="0">

        <!-- Q1: Grammar -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider">Question 1: Grammar Correction</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                Identify the option that grammatically corrects the following sentence: "She don't like playing soccer."
            </h3>
            <div class="grid grid-cols-1 gap-2.5 mt-4">
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q1" value="A" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">A) "She doesn't like playing soccer."</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q1" value="B" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">B) "She not like playing soccer."</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q1" value="C" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">C) "She don't likes playing soccer."</span>
                </label>
            </div>
        </div>

        <!-- Q2: Vocabulary -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider">Question 2: Vocabulary Synonym</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                Select the word that represents the closest synonym of the word: "MUTABLE".
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                @foreach(['Silent' => 'A', 'Changeable' => 'B', 'Permanent' => 'C'] as $name => $val)
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all text-center justify-center flex-col">
                        <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q2" value="{{ $val }}" required/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">{{ $name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Q3: Tenses -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 text-[10px] font-black uppercase tracking-wider">Question 3: Tenses & Sentence Correction</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                Fill in the blank using the correct tense formulation: "By next December, she _______ in this academy for five years."
            </h3>
            <div class="grid grid-cols-1 gap-2.5 mt-4">
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q3" value="A" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">A) "will have been teaching"</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q3" value="B" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">B) "will teach"</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q3" value="C" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">C) "is teaching"</span>
                </label>
            </div>
        </div>

        <!-- Q4: Antonym -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 text-[10px] font-black uppercase tracking-wider">Question 4: Vocabulary Antonym</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                Select the word that represents the closest antonym of the word: "EPHEMERAL".
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                @foreach(['Transient' => 'A', 'Weak' => 'B', 'Eternal' => 'C'] as $name => $val)
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all text-center justify-center flex-col">
                        <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q4" value="{{ $val }}" required/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-bold">{{ $name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Action Panel -->
        <div class="flex justify-between items-center py-6">
            <a href="{{ route('tests.index') }}" class="px-6 py-3 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-bold rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                Cancel Test
            </a>
            <button type="submit" id="submit-btn" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-400 text-white font-bold rounded-2xl shadow-lg hover:shadow-emerald-500/25 transition-all">
                Submit Test Results
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let totalSeconds = 180; // 3 Minutes
        let elapsedSeconds = 0;
        const timerDisplay = document.getElementById('timer-display');
        const timeInput = document.getElementById('time_taken_input');
        const form = document.getElementById('english-form');
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
            
            if (totalSeconds <= 30) {
                timerDisplay.parentElement.classList.add('bg-red-650/25');
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
            fetch('{{ route('tests.english.save') }}', {
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
    });
</script>
@endsection
