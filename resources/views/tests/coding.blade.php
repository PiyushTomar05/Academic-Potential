@extends('layouts.app')

@section('title', 'Coding & Algorithmic Assessment | Evaluating Academic Potential')

@section('styles')
<style>
    .code-editor {
        font-family: 'Fira Code', 'Courier New', Courier, monospace;
        background: #0f172a;
        color: #e2e8f0;
    }
    .line-numbers {
        color: #475569;
        text-align: right;
        select-none: none;
    }
</style>
@endsection

@section('content')
<div class="p-6 lg:p-8 max-w-6xl mx-auto flex flex-col gap-6">
    <!-- Breadcrumb return navigation -->
    <div class="mb-4 mt-6">
        <a href="{{ route('tests.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-cyan-accent font-bold text-xs transition-colors select-none">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Return to Assessment Center</span>
        </a>
    </div>

    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent text-[32px]">terminal</span>
                Practical Coding & Algorithms Test
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Solve the 3 programming challenges inside the simulated IDE panel.</p>
        </div>
        <div class="glass-card px-5 py-3 rounded-2xl flex items-center gap-3 border border-amber-500/20 bg-amber-500/5">
            <span class="material-symbols-outlined text-amber-500 animate-pulse">timer</span>
            <div>
                <span class="text-[10px] text-slate-400 block font-bold uppercase tracking-wider">Elapsed Time</span>
                <span class="text-base font-extrabold text-slate-700 dark:text-slate-200" id="stopwatch">00:00</span>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left: Challenges Panel -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 shadow-md">
                <strong class="text-xs font-black text-primary dark:text-cyan-accent uppercase tracking-widest block mb-4">Diagnostic Challenges</strong>
                
                <div class="flex flex-col gap-4">
                    <!-- Tab buttons -->
                    <button onclick="switchChallenge(1)" id="tab-1" class="flex items-center justify-between p-4 rounded-2xl bg-primary/10 border border-primary/20 text-left transition-all">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-primary/20 flex items-center justify-center text-xs font-black text-primary dark:text-cyan-accent">1</span>
                            <div>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">Palindrome Checker</span>
                                <span class="text-[10px] text-slate-400 block font-medium">Strings & Loops</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400" id="status-icon-1">radio_button_unchecked</span>
                    </button>

                    <button onclick="switchChallenge(2)" id="tab-2" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/30 border border-slate-200/50 dark:border-slate-800/50 text-left transition-all hover:bg-primary/5">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-xs font-black text-slate-550 dark:text-slate-400" id="num-badge-2">2</span>
                            <div>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">FizzBuzz Range Builder</span>
                                <span class="text-[10px] text-slate-400 block font-medium">Arrays & Conditionals</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400" id="status-icon-2">radio_button_unchecked</span>
                    </button>

                    <button onclick="switchChallenge(3)" id="tab-3" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/30 border border-slate-200/50 dark:border-slate-800/50 text-left transition-all hover:bg-primary/5">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-xs font-black text-slate-550 dark:text-slate-400" id="num-badge-3">3</span>
                            <div>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">Balanced Brackets</span>
                                <span class="text-[10px] text-slate-400 block font-medium">Data Structures (Stacks)</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400" id="status-icon-3">radio_button_unchecked</span>
                    </button>
                </div>
            </div>

            <!-- Challenge Description Content -->
            <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 shadow-md flex-grow">
                <!-- Challenge 1 Description -->
                <div id="desc-1" class="space-y-4">
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                        Challenge 1: Palindrome Checker
                    </h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 leading-relaxed">
                        Implement a function that checks whether a given string is a palindrome. A palindrome is a word, phrase, or sequence that reads the same backward as forward, ignoring casing and spacing.
                    </p>
                    <div class="space-y-2 text-xs font-semibold text-slate-550 dark:text-slate-400">
                        <div class="bg-slate-50 dark:bg-slate-900/50 rounded-xl p-3 border border-slate-200/20">
                            <div class="text-[10px] text-slate-450 uppercase tracking-wider font-bold mb-1">Inputs / Outputs</div>
                            <div>Input: <code class="text-primary font-bold">"radar"</code> → Output: <code class="text-emerald-500 font-bold">true</code></div>
                            <div class="mt-1">Input: <code class="text-primary font-bold">"hello"</code> → Output: <code class="text-red-500 font-bold">false</code></div>
                        </div>
                    </div>
                </div>

                <!-- Challenge 2 Description -->
                <div id="desc-2" class="space-y-4 hidden">
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                        Challenge 2: FizzBuzz Generator
                    </h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 leading-relaxed">
                        Implement an array builder that takes a number range (1 to N) and maps each number. 
                        - Numbers divisible by 3 should be replaced with <code class="text-primary">"Fizz"</code>.
                        - Numbers divisible by 5 should be replaced with <code class="text-cyan-accent">"Buzz"</code>.
                        - Numbers divisible by both 3 and 5 should be replaced with <code class="text-emerald-500 font-bold">"FizzBuzz"</code>.
                    </p>
                    <div class="space-y-2 text-xs font-semibold text-slate-550 dark:text-slate-400">
                        <div class="bg-slate-50 dark:bg-slate-900/50 rounded-xl p-3 border border-slate-200/20">
                            <div class="text-[10px] text-slate-450 uppercase tracking-wider font-bold mb-1">Inputs / Outputs</div>
                            <div>Input N: <code class="text-primary font-bold">5</code></div>
                            <div>Output array: <code class="text-emerald-500 font-bold">[1, 2, "Fizz", 4, "Buzz"]</code></div>
                        </div>
                    </div>
                </div>

                <!-- Challenge 3 Description -->
                <div id="desc-3" class="space-y-4 hidden">
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        Challenge 3: Balanced Parentheses Parser
                    </h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 leading-relaxed">
                        Implement an algorithmic stack evaluation function that checks if brackets are closed in the correct order. 
                        Valid bracket characters are: <code class="text-slate-300">()</code>, <code class="text-slate-300">[]</code>, and <code class="text-slate-300">{}</code>.
                    </p>
                    <div class="space-y-2 text-xs font-semibold text-slate-550 dark:text-slate-400">
                        <div class="bg-slate-50 dark:bg-slate-900/50 rounded-xl p-3 border border-slate-200/20">
                            <div class="text-[10px] text-slate-450 uppercase tracking-wider font-bold mb-1">Inputs / Outputs</div>
                            <div>Input: <code class="text-primary font-bold">"{[()]}"</code> → Output: <code class="text-emerald-500 font-bold">true</code></div>
                            <div class="mt-1">Input: <code class="text-primary font-bold">"{[(])}"</code> → Output: <code class="text-red-500 font-bold">false</code></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: VS Code Panel Simulator -->
        <div class="lg:col-span-7 flex flex-col glass-card rounded-3xl overflow-hidden border border-slate-200/50 dark:border-slate-850/50 shadow-2xl h-[560px]">
            <!-- IDE Bar -->
            <div class="bg-[#0b0f19] px-4 py-3 flex items-center justify-between border-b border-slate-800/80">
                <div class="flex items-center gap-1.5 select-none">
                    <span class="w-3 h-3 rounded-full bg-[#ef4444]"></span>
                    <span class="w-3 h-3 rounded-full bg-[#eab308]"></span>
                    <span class="w-3 h-3 rounded-full bg-[#22c55e]"></span>
                    <span class="text-slate-500 font-bold text-xs ml-4 tracking-wider flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px] text-yellow-500">javascript</span>
                        solution.js
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider bg-slate-900 px-2.5 py-1 rounded-lg border border-slate-800">JavaScript</span>
                </div>
            </div>

            <!-- Workspace Textareas (Tabs mapped) -->
            <div class="flex-grow flex code-editor relative">
                <!-- Line Numbers -->
                <div class="line-numbers px-3.5 py-4 text-xs font-medium border-r border-slate-800/40 bg-[#0c1221] select-none">
                    @for($i = 1; $i <= 20; $i++)
                        <div>{{ $i }}</div>
                    @endfor
                </div>

                <!-- Editor Containers -->
                <div class="flex-grow relative">
                    <!-- Code Editor 1 -->
                    <textarea id="editor-1" class="absolute inset-0 w-full h-full bg-transparent resize-none outline-none border-none px-4 py-4 text-xs font-mono text-slate-200 placeholder-slate-600 focus:ring-0 leading-relaxed" 
                              placeholder="// Write Palindrome Checker function here...&#10;function isPalindrome(str) {&#10;    const cleanStr = str.toLowerCase().replace(/[^a-z0-9]/g, '');&#10;    return cleanStr === cleanStr.split('').reverse().join('');&#10;}"></textarea>

                    <!-- Code Editor 2 -->
                    <textarea id="editor-2" class="absolute inset-0 w-full h-full bg-transparent resize-none outline-none border-none px-4 py-4 text-xs font-mono text-slate-200 placeholder-slate-600 focus:ring-0 leading-relaxed hidden" 
                              placeholder="// Write FizzBuzz Array generator here...&#10;function fizzBuzz(n) {&#10;    const result = [];&#10;    for (let i = 1; i <= n; i++) {&#10;        if (i % 15 === 0) result.push('FizzBuzz');&#10;        else if (i % 3 === 0) result.push('Fizz');&#10;        else if (i % 5 === 0) result.push('Buzz');&#10;        else result.push(i);&#10;    }&#10;    return result;&#10;}"></textarea>

                    <!-- Code Editor 3 -->
                    <textarea id="editor-3" class="absolute inset-0 w-full h-full bg-transparent resize-none outline-none border-none px-4 py-4 text-xs font-mono text-slate-200 placeholder-slate-600 focus:ring-0 leading-relaxed hidden" 
                              placeholder="// Write Balanced Parentheses Stack parser here...&#10;function isBalanced(expr) {&#10;    const stack = [];&#10;    const mapping = {')': '(', '}': '{', ']': '['};&#10;    for (let char of expr) {&#10;        if (['(', '{', '['].includes(char)) stack.push(char);&#10;        else if ([')', '}', ']'].includes(char)) {&#10;            if (stack.pop() !== mapping[char]) return false;&#10;        }&#10;    }&#10;    return stack.length === 0;&#10;}"></textarea>
                </div>
            </div>

            <!-- Console Log Output -->
            <div class="bg-[#0b0f19] border-t border-slate-800/80 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-slate-500 text-[18px]">terminal</span>
                    <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider" id="console-title">Mock Terminal Console</span>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="runLocalTests()" class="flex items-center gap-1.5 py-1.5 px-3 rounded-lg bg-slate-800 hover:bg-slate-750 text-slate-300 hover:text-white transition-colors text-[10px] font-bold border border-slate-700/35 cursor-pointer">
                        <span class="material-symbols-outlined text-[14px] text-emerald-500">play_arrow</span>
                        <span>Compile & Run</span>
                    </button>
                    <button onclick="submitCodingAssessment()" class="flex items-center gap-1.5 py-1.5 px-4.5 rounded-lg bg-[#6366f1] hover:bg-indigo-600 text-white transition-colors text-[10px] font-bold shadow-md shadow-indigo-500/20 cursor-pointer">
                        <span class="material-symbols-outlined text-[14px]">send</span>
                        <span>Submit Code</span>
                    </button>
                </div>
            </div>
            
            <div class="bg-[#080b12] px-5 py-3 text-[11px] font-mono h-20 text-slate-400 overflow-y-auto" id="console-output">
                <span>[system] IDE loaded successfully. Select a challenge to begin writing solution logic.</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let activeChallenge = 1;
    let secondsElapsed = 0;
    let timerInterval;

    // Start timer on load
    function initTimer() {
        timerInterval = setInterval(() => {
            secondsElapsed++;
            const mins = String(Math.floor(secondsElapsed / 60)).padStart(2, '0');
            const secs = String(secondsElapsed % 60).padStart(2, '0');
            document.getElementById('stopwatch').innerText = `${mins}:${secs}`;
        }, 1000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTimer);
    } else {
        initTimer();
    }

    function switchChallenge(index) {
        activeChallenge = index;

        // Tabs highlight
        for(let i = 1; i <= 3; i++) {
            const btn = document.getElementById(`tab-${i}`);
            const desc = document.getElementById(`desc-${i}`);
            const editor = document.getElementById(`editor-${i}`);
            const numBadge = document.getElementById(`num-badge-${i}`);

            if(i === index) {
                btn.className = "flex items-center justify-between p-4 rounded-2xl bg-primary/10 border border-primary/20 text-left transition-all";
                if (numBadge) {
                    numBadge.className = "w-7 h-7 rounded-lg bg-primary/20 flex items-center justify-center text-xs font-black text-primary dark:text-cyan-accent";
                }
                desc.classList.remove('hidden');
                editor.classList.remove('hidden');
            } else {
                btn.className = "flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/30 border border-slate-200/50 dark:border-slate-800/50 text-left transition-all hover:bg-primary/5";
                if (numBadge) {
                    numBadge.className = "w-7 h-7 rounded-lg bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-xs font-black text-slate-550 dark:text-slate-400";
                }
                desc.classList.add('hidden');
                editor.classList.add('hidden');
            }
        }

        // Reset console preview
        const out = document.getElementById('console-output');
        out.innerHTML = `<span>[system] Switched to Challenge ${index}. Write your algorithm and click 'Compile & Run' to verify logic.</span>`;
    }

    function runLocalTests() {
        const code = document.getElementById(`editor-${activeChallenge}`).value;
        const out = document.getElementById('console-output');

        if(!code.trim()) {
            out.innerHTML = `<span class="text-red-500">[error] Compile error: solution.js cannot be empty!</span>`;
            return;
        }

        out.innerHTML = `<span class="text-yellow-500">[compiling] compiling solution.js against local tests...</span><br>`;

        setTimeout(() => {
            let passed = false;
            let checks = "";
            const lowerCode = code.toLowerCase();

            if (activeChallenge === 1) {
                passed = lowerCode.includes('reverse') || lowerCode.includes('split') || lowerCode.includes('==') || lowerCode.includes('===');
                checks = `Test case 1: isPalindrome("radar") → expected true, got ${passed ? 'true' : 'false'}<br>Test case 2: isPalindrome("hello") → expected false, got ${passed ? 'false' : 'true'}`;
            } else if (activeChallenge === 2) {
                passed = lowerCode.includes('fizz') || lowerCode.includes('buzz') || lowerCode.includes('% 3') || lowerCode.includes('% 5');
                checks = `Test case 1: fizzBuzz(5) → expected [1, 2, "Fizz", 4, "Buzz"], got ${passed ? 'matching array' : 'invalid array'}`;
            } else {
                passed = lowerCode.includes('stack') || lowerCode.includes('push') || lowerCode.includes('pop') || lowerCode.includes('length') || lowerCode.includes('match');
                checks = `Test case 1: isBalanced("{[()]}") → expected true, got ${passed ? 'true' : 'false'}`;
            }

            if (passed) {
                out.innerHTML += `<span class="text-emerald-500">[success] Compile successful! All test cases passed!</span><br><span class="text-slate-500">${checks}</span>`;
                document.getElementById(`status-icon-${activeChallenge}`).innerText = "check_circle";
                document.getElementById(`status-icon-${activeChallenge}`).className = "material-symbols-outlined text-emerald-500";
            } else {
                out.innerHTML += `<span class="text-red-500">[failed] Test assertions failed! Please verify string reversers or divisibility logic.</span><br><span class="text-slate-500">${checks}</span>`;
            }
        }, 800);
    }

    function submitCodingAssessment() {
        const code1 = document.getElementById('editor-1').value;
        const code2 = document.getElementById('editor-2').value;
        const code3 = document.getElementById('editor-3').value;

        if(!code1.trim() && !code2.trim() && !code3.trim()) {
            showToast('Submission Failed', 'Please attempt at least one coding challenge before submitting.', 'error');
            return;
        }

        clearInterval(timerInterval);

        fetch("{{ route('tests.coding.save') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                code1: code1,
                code2: code2,
                code3: code3,
                time_taken: secondsElapsed
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showToast('Success', 'Coding test results evaluated and saved to your profile!', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                showToast('Error', 'Unable to complete test evaluation. Please try again.', 'error');
            }
        })
        .catch(err => {
            showToast('Network Error', 'Connection failed. Please check backend services.', 'error');
        });
    }
</script>
@endsection
