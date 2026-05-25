@extends('layouts.app')

@section('title', 'Assessment Center Hub | Evaluating Academic Potential')

@section('content')
<div class="p-6 lg:p-8 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6 mt-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100 mb-1">Independent Assessment Center</h2>
            <p class="text-slate-550 dark:text-slate-400 text-sm">Assess independent dimensions to dynamically compile a multi-layered diagnostic profile.</p>
        </div>
        <div class="glass-card px-6 py-3 rounded-2xl flex items-center gap-3 border border-indigo-500/20 bg-indigo-500/5 dark:bg-indigo-500/10">
            <span class="material-symbols-outlined text-indigo-500 dark:text-indigo-400">verified</span>
            <span class="text-sm text-indigo-600 dark:text-indigo-400 font-bold">INDEPENDENT ASSESSMENT FLOW</span>
        </div>
    </div>

    <!-- Status Overview Widget -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50 shadow-xl mb-8 bg-white/40 dark:bg-slate-900/30 backdrop-blur-xl">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Assessment Suite Progress Status</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-xl">
                    Complete the separate modules below. Each module records its own attempt details, scores, and issue digital gold verification certificates. Run the **Final Prediction** at any time once major parameters are synced.
                </p>
            </div>
            
            @php
                $completedCount = 0;
                if ($user->academic_history) $completedCount++;
                if ($user->aptitude_test_score) $completedCount++;
                if ($user->english_test_score) $completedCount++;
                if ($user->speaking_test_score) $completedCount++;
                if ($user->reading_test_score) $completedCount++;
                if ($user->written_test_score) $completedCount++;
                if ($user->core_subject_score) $completedCount++;
                if ($user->psychometric_test_score) $completedCount++;
                if ($user->coding_test_score) $completedCount++;
                
                $totalModules = 9;
                $progressPercent = round(($completedCount / $totalModules) * 100);
            @endphp
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-20 h-20 flex-shrink-0">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-slate-200 dark:text-slate-800" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="text-indigo-500 dark:text-indigo-400 transition-all duration-500" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" stroke-dasharray="{{ $progressPercent }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-lg font-extrabold text-slate-800 dark:text-slate-100">{{ $progressPercent }}%</span>
                    </div>
                </div>
                <div>
                    <span class="text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-widest block">SUITE COMPLETENESS</span>
                    <strong class="text-slate-800 dark:text-slate-100 font-extrabold text-base">{{ $completedCount }} of {{ $totalModules }} Modules Completed</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- 1. Academic History Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-2xl hover:border-[#6366f1]/30 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-[#6366f1]/10 flex items-center justify-center text-[#6366f1] group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">history_edu</span>
                    </div>
                    @if($user->academic_history)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] font-black uppercase tracking-wider flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-[12px]">check</span> Sync Active
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 text-[10px] font-black uppercase tracking-wider">
                            Pending Logs
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-[#6366f1] transition-colors">3-Year Academic History</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                        Input dynamic subject-specific school grades (Class 9/10/11) or college semester marks.
                    </p>
                </div>
                @if($user->academic_history)
                    <div class="bg-indigo-500/5 dark:bg-indigo-500/10 rounded-2xl p-4 border border-indigo-500/10 text-xs text-slate-400 font-semibold space-y-1">
                        <div>Level: <strong class="text-slate-250 font-extrabold uppercase">{{ $user->academic_history[0]['level'] ?? 'school' }}</strong></div>
                        <div>Logged Years: <strong class="text-slate-250 font-bold">{{ count($user->academic_history) }} years</strong></div>
                    </div>
                @endif
            </div>
            <div class="mt-6">
                <a href="{{ route('tests.history') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-800 hover:bg-[#6366f1] dark:bg-slate-900 dark:hover:bg-[#6366f1] text-white text-xs font-bold transition-all shadow-md group-hover:shadow-[#6366f1]/25">
                    <span>{{ $user->academic_history ? 'Configure Records' : 'Begin Input Logs' }}</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- 2. Aptitude Test Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-2xl hover:border-indigo-500/30 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">psychology_alt</span>
                    </div>
                    @if($user->aptitude_test_score)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] font-black uppercase tracking-wider flex items-center gap-0.5">
                            Score: {{ $user->aptitude_test_score['total'] }}%
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 text-[10px] font-black uppercase tracking-wider">
                            Pending Test
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-indigo-500 transition-colors">Cognitive Aptitude</h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 mt-1 leading-relaxed">
                        Quantitative reasoning, logic series patterns, and vocabulary tenses diagnostic.
                    </p>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                @if($user->aptitude_test_score)
                    @php
                        $score = $user->aptitude_test_score['total'] ?? 0;
                    @endphp
                    @if($score >= 50)
                        <a href="{{ route('tests.certificate', 'aptitude') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-amber-500/30 text-amber-500 font-extrabold text-xs bg-amber-500/5 hover:bg-amber-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            Claim Gold Certificate
                        </a>
                    @else
                        <a href="{{ route('tests.certificate', 'aptitude') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-500/30 text-slate-400 font-extrabold text-xs bg-slate-500/5 hover:bg-slate-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">card_membership</span>
                            Claim Participation Certificate
                        </a>
                    @endif
                @endif
                <a href="{{ route('tests.aptitude') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-800 hover:bg-indigo-600 dark:bg-slate-900 dark:hover:bg-indigo-500 text-white text-xs font-bold transition-all shadow-md group-hover:shadow-indigo-500/25">
                    <span>{{ $user->aptitude_test_score ? 'Retake Assessment' : 'Begin Assessment' }}</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- 3. English Test Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-2xl hover:border-emerald-500/30 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">abc</span>
                    </div>
                    @if($user->english_test_score)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] font-black uppercase tracking-wider flex items-center gap-0.5">
                            Score: {{ $user->english_test_score['total'] }}%
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 text-[10px] font-black uppercase tracking-wider">
                            Pending Test
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-emerald-500 transition-colors">English Language Test</h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 mt-1 leading-relaxed">
                        Evaluates grammar rules, syntax sentence correction, tenses, and synonyms.
                    </p>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                @if($user->english_test_score)
                    @php
                        $score = $user->english_test_score['total'] ?? 0;
                    @endphp
                    @if($score >= 50)
                        <a href="{{ route('tests.certificate', 'english') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-amber-500/30 text-amber-500 font-extrabold text-xs bg-amber-500/5 hover:bg-amber-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            Claim Gold Certificate
                        </a>
                    @else
                        <a href="{{ route('tests.certificate', 'english') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-500/30 text-slate-400 font-extrabold text-xs bg-slate-500/5 hover:bg-slate-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">card_membership</span>
                            Claim Participation Certificate
                        </a>
                    @endif
                @endif
                <a href="{{ route('tests.english') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-800 hover:bg-emerald-600 dark:bg-slate-900 dark:hover:bg-emerald-500 text-white text-xs font-bold transition-all shadow-md group-hover:shadow-emerald-500/25">
                    <span>{{ $user->english_test_score ? 'Retake Assessment' : 'Begin Assessment' }}</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- 4. Speaking Test Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-2xl hover:border-pink-500/30 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-pink-500/10 flex items-center justify-center text-pink-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">mic</span>
                    </div>
                    @if($user->speaking_test_score)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] font-black uppercase tracking-wider flex items-center gap-0.5">
                            Score: {{ $user->speaking_test_score['total'] }}%
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 text-[10px] font-black uppercase tracking-wider">
                            Pending Test
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-pink-500 transition-colors">Vocal Fluency Test</h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 mt-1 leading-relaxed">
                        Speak online using microphone. Evaluates pronunciation accuracy, communication confidence, and fluency.
                    </p>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                @if($user->speaking_test_score)
                    @php
                        $score = $user->speaking_test_score['total'] ?? 0;
                    @endphp
                    @if($score >= 50)
                        <a href="{{ route('tests.certificate', 'speaking') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-amber-500/30 text-amber-500 font-extrabold text-xs bg-amber-500/5 hover:bg-amber-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            Claim Gold Certificate
                        </a>
                    @else
                        <a href="{{ route('tests.certificate', 'speaking') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-500/30 text-slate-400 font-extrabold text-xs bg-slate-500/5 hover:bg-slate-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">card_membership</span>
                            Claim Participation Certificate
                        </a>
                    @endif
                @endif
                <a href="{{ route('tests.speaking') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-800 hover:bg-pink-600 dark:bg-slate-900 dark:hover:bg-pink-500 text-white text-xs font-bold transition-all shadow-md group-hover:shadow-pink-500/25">
                    <span>{{ $user->speaking_test_score ? 'Retake Assessment' : 'Begin Assessment' }}</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- 5. Reading Comprehension Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-2xl hover:border-cyan-500/30 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">menu_book</span>
                    </div>
                    @if($user->reading_test_score)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] font-black uppercase tracking-wider flex items-center gap-0.5">
                            WPM: {{ $user->reading_test_score['wpm'] }}
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 text-[10px] font-black uppercase tracking-wider">
                            Pending Test
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-cyan-500 transition-colors">Reading Comprehension</h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 mt-1 leading-relaxed">
                        Measures reading speed (WPM) stopwatch parameters and textual comprehension accuracy index.
                    </p>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                @if($user->reading_test_score)
                    @php
                        $score = $user->reading_test_score['total'] ?? $user->reading_test_score['accuracy'] ?? 0;
                    @endphp
                    @if($score >= 50)
                        <a href="{{ route('tests.certificate', 'reading') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-amber-500/30 text-amber-500 font-extrabold text-xs bg-amber-500/5 hover:bg-amber-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            Claim Gold Certificate
                        </a>
                    @else
                        <a href="{{ route('tests.certificate', 'reading') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-500/30 text-slate-400 font-extrabold text-xs bg-slate-500/5 hover:bg-slate-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">card_membership</span>
                            Claim Participation Certificate
                        </a>
                    @endif
                @endif
                <a href="{{ route('tests.reading') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-800 hover:bg-cyan-600 dark:bg-slate-900 dark:hover:bg-cyan-500 text-white text-xs font-bold transition-all shadow-md group-hover:shadow-cyan-500/25">
                    <span>{{ $user->reading_test_score ? 'Retake Assessment' : 'Begin Assessment' }}</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- 6. Written English Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-2xl hover:border-purple-500/30 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">edit_note</span>
                    </div>
                    @if($user->written_test_score)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] font-black uppercase tracking-wider flex items-center gap-0.5">
                            Score: {{ $user->written_test_score['total'] }}%
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 text-[10px] font-black uppercase tracking-wider">
                            Pending Test
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-purple-500 transition-colors">Written English Test</h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 mt-1 leading-relaxed">
                        Technical essay composition evaluated for structural vocabulary, grammar accuracy, and word lengths.
                    </p>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                @if($user->written_test_score)
                    @php
                        $score = $user->written_test_score['total'] ?? 0;
                    @endphp
                    @if($score >= 50)
                        <a href="{{ route('tests.certificate', 'written') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-amber-500/30 text-amber-500 font-extrabold text-xs bg-amber-500/5 hover:bg-amber-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            Claim Gold Certificate
                        </a>
                    @else
                        <a href="{{ route('tests.certificate', 'written') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-500/30 text-slate-400 font-extrabold text-xs bg-slate-500/5 hover:bg-slate-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">card_membership</span>
                            Claim Participation Certificate
                        </a>
                    @endif
                @endif
                <a href="{{ route('tests.written') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-800 hover:bg-purple-600 dark:bg-slate-900 dark:hover:bg-purple-500 text-white text-xs font-bold transition-all shadow-md group-hover:shadow-purple-500/25">
                    <span>{{ $user->written_test_score ? 'Retake Assessment' : 'Begin Assessment' }}</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- 7. Core Subject Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-2xl hover:border-amber-500/30 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">terminal</span>
                    </div>
                    @if($user->core_subject_score)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] font-black uppercase tracking-wider flex items-center gap-0.5">
                            Score: {{ $user->core_subject_score['total'] }}%
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 text-[10px] font-black uppercase tracking-wider">
                            Pending Test
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-amber-500 transition-colors">Core Subject Quiz</h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 mt-1 leading-relaxed">
                        Dynamic subject-specific tests covering CS (DSA, OS, DBMS), Science (Physics/Math), or Commerce (Accounts).
                    </p>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                @if($user->core_subject_score)
                    @php
                        $score = $user->core_subject_score['total'] ?? 0;
                    @endphp
                    @if($score >= 50)
                        <a href="{{ route('tests.certificate', 'core') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-amber-500/30 text-amber-500 font-extrabold text-xs bg-amber-500/5 hover:bg-amber-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            Claim Gold Certificate
                        </a>
                    @else
                        <a href="{{ route('tests.certificate', 'core') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-500/30 text-slate-400 font-extrabold text-xs bg-slate-500/5 hover:bg-slate-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">card_membership</span>
                            Claim Participation Certificate
                        </a>
                    @endif
                @endif
                <a href="{{ route('tests.core') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-800 hover:bg-amber-600 dark:bg-slate-900 dark:hover:bg-amber-500 text-white text-xs font-bold transition-all shadow-md group-hover:shadow-amber-500/25">
                    <span>{{ $user->core_subject_score ? 'Retake Assessment' : 'Begin Assessment' }}</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- 8. Psychometric Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-2xl hover:border-[#ec4899]/30 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-[#ec4899]/10 flex items-center justify-center text-[#ec4899] group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">ecg_heart</span>
                    </div>
                    @if($user->psychometric_test_score)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] font-black uppercase tracking-wider flex items-center gap-0.5">
                            Readiness: {{ $user->psychometric_test_score['readiness'] }}%
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 text-[10px] font-black uppercase tracking-wider">
                            Pending Survey
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-[#ec4899] transition-colors">Psychometric Test</h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 mt-1 leading-relaxed">
                        Evaluates academic readiness, study workload pressure thresholds, and time management skills.
                    </p>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                @if($user->psychometric_test_score)
                    @php
                        $score = $user->psychometric_test_score['total'] ?? $user->psychometric_test_score['readiness'] ?? 0;
                    @endphp
                    @if($score >= 50)
                        <a href="{{ route('tests.certificate', 'psychometric') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-amber-500/30 text-amber-500 font-extrabold text-xs bg-amber-500/5 hover:bg-amber-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            Claim Gold Certificate
                        </a>
                    @else
                        <a href="{{ route('tests.certificate', 'psychometric') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-500/30 text-slate-400 font-extrabold text-xs bg-slate-500/5 hover:bg-slate-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">card_membership</span>
                            Claim Participation Certificate
                        </a>
                    @endif
                @endif
                <a href="{{ route('tests.psychometric') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-800 hover:bg-[#ec4899] dark:bg-slate-900 dark:hover:bg-[#ec4899] text-white text-xs font-bold transition-all shadow-md group-hover:shadow-[#ec4899]/25">
                    <span>{{ $user->psychometric_test_score ? 'Retake Assessment' : 'Begin Assessment' }}</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- 9. Interactive Coding Card -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-2xl hover:border-primary/30 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary dark:text-cyan-accent group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px]">terminal</span>
                    </div>
                    @if($user->coding_test_score)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] font-black uppercase tracking-wider flex items-center gap-0.5">
                            Score: {{ $user->coding_test_score['total'] }}%
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 text-[10px] font-black uppercase tracking-wider">
                            Pending Test
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-primary dark:group-hover:text-cyan-accent transition-colors">Coding & Algorithms</h3>
                    <p class="text-xs text-slate-550 dark:text-slate-400 mt-1 leading-relaxed">
                        Practical computational workspace solving palindrome checkers, FizzBuzz arrays, and bracket balances.
                    </p>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                @if($user->coding_test_score)
                    @php
                        $score = $user->coding_test_score['total'] ?? 0;
                    @endphp
                    @if($score >= 50)
                        <a href="{{ route('tests.certificate', 'coding') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-amber-500/30 text-amber-500 font-extrabold text-xs bg-amber-500/5 hover:bg-amber-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
                            Claim Gold Certificate
                        </a>
                    @else
                        <a href="{{ route('tests.certificate', 'coding') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-500/30 text-slate-400 font-extrabold text-xs bg-slate-500/5 hover:bg-slate-500/10 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">card_membership</span>
                            Claim Participation Certificate
                        </a>
                    @endif
                @endif
                <a href="{{ route('tests.coding') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-800 hover:bg-primary dark:bg-slate-900 dark:hover:bg-primary text-white text-xs font-bold transition-all shadow-md group-hover:shadow-primary/25">
                    <span>{{ $user->coding_test_score ? 'Retake Workspace' : 'Begin IDE Workspace' }}</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Big Aggregator Prediction Box -->
    <div class="mt-10 glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 bg-gradient-to-r from-primary/5 to-cyan-accent/5 dark:from-primary/10 dark:to-cyan-accent/5 text-center flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-left col-span-2">
            <h4 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Compile Score Aggregation & Prediction</h4>
            <p class="text-xs text-slate-550 dark:text-slate-400 mt-1">Combine academic history, 8 diagnostic tests, and portfolio achievements to run potential classification.</p>
        </div>
        <a href="{{ route('prediction.final') }}" class="flex items-center gap-2 px-8 py-3.5 rounded-xl bg-gradient-to-r from-primary to-cyan-accent text-white text-xs font-bold shadow-lg hover:shadow-primary/20 transition-all hover:scale-[1.02] active:scale-95">
            <span class="material-symbols-outlined text-[18px]">auto_awesome</span>
            <span>Final Potential Predictor</span>
        </a>
    </div>
</div>
@endsection
