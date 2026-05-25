@extends('layouts.app')

@section('title', 'Core Subject Test | Test Center')

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
                <span class="material-symbols-outlined text-amber-500">terminal</span>
                Core Subject Test
            </h2>
            <p class="text-xs text-slate-555 dark:text-slate-400">Stream-specific exam evaluating technical, science, or accounting competency.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-red-500/10 border border-red-500/20 px-4 py-2 rounded-2xl text-red-500 font-extrabold text-sm animate-pulse">
                <span class="material-symbols-outlined text-[18px]">timer</span>
                <span id="timer-display">02:00</span>
            </div>
        </div>
    </div>

    <!-- Questions Form -->
    <form id="core-form" class="space-y-6">
        @csrf
        
        <!-- Stream Selector Bento Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4 bg-gradient-to-r from-amber-500/5 to-yellow-500/5">
            <div class="flex flex-col gap-1.5">
                <label class="text-xs text-slate-650 dark:text-slate-400 font-black uppercase tracking-wider" for="stream-select">Select Academic Stream Major</label>
                <select id="stream-select" name="stream" class="w-full md:w-1/2 rounded-xl p-3 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-850 focus:ring-2 focus:ring-amber-500 outline-none text-sm font-semibold" onchange="toggleStreamQuestions()" required>
                    <option value="cs">Computer Science / IT Major (DSA, OS, DBMS)</option>
                    <option value="science">Pure Science Major (Mathematics, Physics, Chemistry)</option>
                    <option value="commerce">Commerce / Business Major (Accounts, Economics, Management)</option>
                </select>
            </div>
        </div>

        <!-- 1. CS Stream Questions Group -->
        <div id="cs-group" class="stream-questions space-y-6">
            <!-- Q1 -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 text-[10px] font-black uppercase tracking-wider">DBMS Component</span>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                    What does "ACID" stand for in Database Management Systems (DBMS)?
                </h3>
                <div class="grid grid-cols-1 gap-2.5 mt-4">
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="cs_q1" value="A"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">A) "Atomicity, Consistency, Isolation, Durability"</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="cs_q1" value="B"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">B) "Access, Control, Indexing, Delivery"</span>
                    </label>
                </div>
            </div>
            <!-- Q2 -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 text-[10px] font-black uppercase tracking-wider">Algorithms & Data Structures</span>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                    What is the average time complexity of performing a search operation in a balanced Binary Search Tree (BST)?
                </h3>
                <div class="grid grid-cols-1 gap-2.5 mt-4">
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="cs_q2" value="A"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">A) O(n) linear complexity</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="cs_q2" value="B"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">B) O(log n) logarithmic complexity</span>
                    </label>
                </div>
            </div>
            <!-- Q3 -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 text-[10px] font-black uppercase tracking-wider">Operating Systems</span>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                    Which option best defines the concept of Virtual Memory in Operating Systems?
                </h3>
                <div class="grid grid-cols-1 gap-2.5 mt-4">
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="cs_q3" value="A"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">A) The clock cache memory of secondary graphic cards.</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="cs_q3" value="B"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">B) Read-only firmware storage chips.</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="cs_q3" value="C"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">C) A memory management technique that maps address spaces to physical secondary storage.</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- 2. Science Stream Questions Group (hidden initially) -->
        <div id="science-group" class="stream-questions space-y-6 hidden">
            <!-- Q1 -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 text-[10px] font-black uppercase tracking-wider">Mathematics Derivative</span>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                    What is the mathematical derivative of the function f(x) = sin(x)?
                </h3>
                <div class="grid grid-cols-1 gap-2.5 mt-4">
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="sci_q1" value="A"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">A) cos(x)</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="sci_q1" value="B"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">B) -cos(x)</span>
                    </label>
                </div>
            </div>
            <!-- Q2 -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 text-[10px] font-black uppercase tracking-wider">Physics Dynamics</span>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                    Which mathematical formula represents Newton's Second Law of Motion?
                </h3>
                <div class="grid grid-cols-1 gap-2.5 mt-4">
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="sci_q2" value="A"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">A) E = mc²</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="sci_q2" value="B"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">B) F = ma</span>
                    </label>
                </div>
            </div>
            <!-- Q3 -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 text-[10px] font-black uppercase tracking-wider">Organic Chemistry</span>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                    What is the correct chemical formula representation of Benzene?
                </h3>
                <div class="grid grid-cols-1 gap-2.5 mt-4">
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="sci_q3" value="A"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">A) C2H2</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="sci_q3" value="B"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">B) CH4</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="sci_q3" value="C"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">C) C6H6</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- 3. Commerce Stream Questions Group (hidden initially) -->
        <div id="commerce-group" class="stream-questions space-y-6 hidden">
            <!-- Q1 -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 text-[10px] font-black uppercase tracking-wider">Accounting Liability</span>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                    Which of the options listed below constitutes a current liability under standard balance sheets?
                </h3>
                <div class="grid grid-cols-1 gap-2.5 mt-4">
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="com_q1" value="A"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">A) Creditors</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="com_q1" value="B"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">B) Machinery Equipment</span>
                    </label>
                </div>
            </div>
            <!-- Q2 -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 text-[10px] font-black uppercase tracking-wider">Economics Index</span>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                    What does the acronym "GDP" stand for in macroeconomics indicators?
                </h3>
                <div class="grid grid-cols-1 gap-2.5 mt-4">
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="com_q2" value="A"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">A) Gross Debt Percent</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="com_q2" value="B"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">B) Gross Domestic Product</span>
                    </label>
                </div>
            </div>
            <!-- Q3 -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 text-[10px] font-black uppercase tracking-wider">Business Studies</span>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                    Which definition represents "Management" in administrative business organizations?
                </h3>
                <div class="grid grid-cols-1 gap-2.5 mt-4">
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="com_q3" value="A"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">A) Manual machinery calibration logic.</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="com_q3" value="B"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">B) Capital asset depreciation schedules.</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-amber-500/5 dark:hover:bg-amber-500/5 cursor-pointer transition-all">
                        <input class="text-amber-500 focus:ring-amber-500" type="radio" name="com_q3" value="C"/>
                        <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">C) The art of coordinating resources and getting things done through others.</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Panel -->
        <div class="flex justify-between items-center py-6">
            <a href="{{ route('tests.index') }}" class="px-6 py-3 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-bold rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                Cancel Test
            </a>
            <button type="submit" id="submit-btn" class="px-8 py-3 bg-amber-600 hover:bg-amber-500 dark:bg-amber-500 dark:hover:bg-amber-400 text-white font-bold rounded-2xl shadow-lg hover:shadow-amber-500/25 transition-all">
                Submit Test Results
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let totalSeconds = 120; // 2 Minutes
        let elapsedSeconds = 0;
        const timerDisplay = document.getElementById('timer-display');
        const form = document.getElementById('core-form');
        const submitBtn = document.getElementById('submit-btn');

        // Start Countdown Timer
        const interval = setInterval(() => {
            if (totalSeconds <= 0) {
                clearInterval(interval);
                showToast('Time Expired!', 'The assessment time limit has been reached. Auto-submitting...', 'warning');
                submitForm();
                return;
            }
            totalSeconds--;
            elapsedSeconds++;

            const mins = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
            const secs = (totalSeconds % 60).toString().padStart(2, '0');
            timerDisplay.innerText = `${mins}:${secs}`;
        }, 1000);

        // Toggle visibility based on stream choice
        window.toggleStreamQuestions = () => {
            const stream = document.getElementById('stream-select').value;
            
            // Hide all groups
            document.querySelectorAll('.stream-questions').forEach(g => {
                g.classList.add('hidden');
            });
            
            // Uncheck all radios to prevent mismatch validation
            form.querySelectorAll('input[type="radio"]').forEach(r => {
                r.checked = false;
                r.required = false;
            });

            // Show active stream and set required
            const activeGroup = document.getElementById(`${stream}-group`);
            activeGroup.classList.remove('hidden');
            activeGroup.querySelectorAll('input[type="radio"]').forEach(r => {
                // Set first elements in group as required to enforce selection
            });
        };

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

            const stream = document.getElementById('stream-select').value;
            const payload = new FormData();
            payload.append('stream', stream);
            payload.append('_token', '{{ csrf_token() }}');

            // Gather only corresponding active stream answers
            if (stream === 'cs') {
                payload.append('q1', form.querySelector('input[name="cs_q1"]:checked')?.value || '');
                payload.append('q2', form.querySelector('input[name="cs_q2"]:checked')?.value || '');
                payload.append('q3', form.querySelector('input[name="cs_q3"]:checked')?.value || '');
            } else if (stream === 'science') {
                payload.append('q1', form.querySelector('input[name="sci_q1"]:checked')?.value || '');
                payload.append('q2', form.querySelector('input[name="sci_q2"]:checked')?.value || '');
                payload.append('q3', form.querySelector('input[name="sci_q3"]:checked')?.value || '');
            } else {
                payload.append('q1', form.querySelector('input[name="com_q1"]:checked')?.value || '');
                payload.append('q2', form.querySelector('input[name="com_q2"]:checked')?.value || '');
                payload.append('q3', form.querySelector('input[name="com_q3"]:checked')?.value || '');
            }

            fetch('{{ route('tests.core.save') }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: payload
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

        // Initialize toggle
        toggleStreamQuestions();
    });
</script>
@endsection
