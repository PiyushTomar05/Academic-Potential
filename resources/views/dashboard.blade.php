@extends('layouts.app')

@section('title', 'Evaluating Academic Potential - Dashboard')

@section('content')
<div class="p-6 lg:p-8 max-w-7xl mx-auto">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6 mt-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100">Welcome back, <span class="text-primary dark:text-cyan-accent font-bold">{{ Auth::user()->name }}</span></h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Real-time predictive insights powered by FastAPI ANN diagnostics.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('prediction.final') }}" class="px-5 py-3 bg-primary hover:bg-primary-hover text-white rounded-xl text-sm font-semibold transition-all shadow-lg shadow-primary/20 flex items-center gap-2 active:scale-95">
                <span class="material-symbols-outlined text-[18px]">auto_awesome</span>
                New Prediction
            </a>
        </div>
    </header>

    <!-- Profile Completeness Widget -->
    @php
        $completeness = 0;
        $missing = [];
        $user = Auth::user();
        
        if ($user->name) $completeness += 15;
        else $missing[] = 'Full name';
        
        if ($user->avatar) $completeness += 15;
        else $missing[] = 'Avatar image';
        
        if ($user->institution || $user->department) $completeness += 20;
        else $missing[] = 'Institution/Department credentials';
        
        if ($user->github || $user->linkedin) $completeness += 20;
        else $missing[] = 'GitHub/LinkedIn links';
        
        if (!empty($user->skills)) $completeness += 30;
        else $missing[] = 'Skills tags';
    @endphp

    @if ($completeness < 100)
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 shadow-xl mb-8 bg-gradient-to-r from-primary/5 via-cyan-accent/5 to-transparent flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2 flex-grow">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-500 animate-pulse">lock_open</span>
                    <h3 class="text-sm font-black text-slate-800 dark:text-slate-100 uppercase tracking-wider">Complete Your Profile Portfolio ({{ $completeness }}%)</h3>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-2xl font-medium">
                    To maximize the precision of your AI career potential forecasts, please fill out your profile details: 
                    <strong class="text-primary dark:text-cyan-accent">{{ implode(', ', $missing) }}</strong>.
                </p>
                <!-- Modern Progress Bar -->
                <div class="w-full max-w-md bg-slate-200 dark:bg-slate-800 h-2 rounded-full overflow-hidden mt-2">
                    <div class="bg-gradient-to-r from-primary to-cyan-accent h-full rounded-full transition-all duration-500" style="width: {{ $completeness }}%"></div>
                </div>
            </div>
            <a href="{{ route('settings') }}" class="flex items-center gap-1.5 py-3 px-5 rounded-xl bg-slate-800 hover:bg-slate-750 dark:bg-slate-900 dark:hover:bg-slate-850 text-white text-xs font-bold transition-all border border-slate-700/40 shadow-md">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span>Configure Profile</span>
            </a>
        </div>
    @endif

    <!-- Gamified Diagnostic Journey Stepper -->
    @php
        $user = Auth::user();
        
        // Phase 1: Base Profile & Readiness
        $hasHistory = !empty($user->academic_history);
        $hasStress = !empty($user->psychometric_test_score);
        $p1Score = 0;
        if ($hasHistory) $p1Score += 50;
        if ($hasStress) $p1Score += 50;
        
        if ($p1Score === 100) $p1Status = 'completed';
        elseif ($p1Score > 0) $p1Status = 'in_progress';
        else $p1Status = 'not_started';

        // Phase 2: Cognitive Foundations
        $hasAptitude = !empty($user->aptitude_test_score);
        $hasCore = !empty($user->core_subject_score);
        $p2Score = 0;
        if ($hasAptitude) $p2Score += 50;
        if ($hasCore) $p2Score += 50;
        
        if ($p1Status === 'completed') {
            if ($p2Score === 100) $p2Status = 'completed';
            elseif ($p2Score > 0) $p2Status = 'in_progress';
            else $p2Status = 'not_started';
        } else {
            $p2Status = 'locked';
        }

        // Phase 3: Language & Verbal Fluency
        $hasEnglish = !empty($user->english_test_score);
        $hasSpeaking = !empty($user->speaking_test_score);
        $hasReading = !empty($user->reading_test_score);
        $hasWritten = !empty($user->written_test_score);
        $p3Score = 0;
        if ($hasEnglish) $p3Score += 25;
        if ($hasSpeaking) $p3Score += 25;
        if ($hasReading) $p3Score += 25;
        if ($hasWritten) $p3Score += 25;
        
        if ($p2Status === 'completed') {
            if ($p3Score === 100) $p3Status = 'completed';
            elseif ($p3Score > 0) $p3Status = 'in_progress';
            else $p3Status = 'not_started';
        } else {
            $p3Status = 'locked';
        }

        // Phase 4: Applied Technical Skills
        $hasCoding = !empty($user->coding_test_score);
        $p4Score = $hasCoding ? 100 : 0;
        
        if ($p3Status === 'completed') {
            if ($p4Score === 100) $p4Status = 'completed';
            else $p4Status = 'not_started';
        } else {
            $p4Status = 'locked';
        }
    @endphp

    <section class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 shadow-xl mb-8 bg-gradient-to-b from-slate-50/50 to-white dark:from-slate-900/40 dark:to-slate-950/40">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary dark:text-cyan-accent">map</span>
                    <span>Your Diagnostic Journey Map</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Complete each milestones to unlock your high-fidelity potential forecasts.</p>
            </div>
            <a href="{{ route('tests.index') }}" class="text-xs font-bold text-primary dark:text-cyan-accent hover:underline flex items-center gap-1.5 uppercase tracking-wider">
                <span>Go to Test Center</span>
                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
            </a>
        </div>

        <!-- Stepper Container -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
            <!-- Phase 1 Card -->
            <div class="relative p-5 rounded-2xl border transition-all duration-300 flex flex-col justify-between group overflow-hidden
                {{ $p1Status === 'completed' ? 'bg-emerald-500/5 border-emerald-500/20 dark:border-emerald-500/10' : '' }}
                {{ $p1Status === 'in_progress' ? 'bg-primary/5 border-primary/20 dark:border-primary/10 ring-1 ring-primary/20' : '' }}
                {{ $p1Status === 'not_started' ? 'bg-slate-50/50 border-slate-200 dark:bg-slate-900/10 dark:border-slate-800' : '' }}">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shadow-md
                        {{ $p1Status === 'completed' ? 'bg-emerald-500 text-white shadow-emerald-500/25' : '' }}
                        {{ $p1Status === 'in_progress' ? 'bg-primary text-white shadow-primary/25 animate-pulse' : '' }}
                        {{ $p1Status === 'not_started' ? 'bg-slate-200 dark:bg-slate-800 text-slate-650 dark:text-slate-400' : '' }}">
                        @if($p1Status === 'completed')
                            <span class="material-symbols-outlined text-[20px]">check</span>
                        @else
                            <span>1</span>
                        @endif
                    </div>
                    <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full border
                        {{ $p1Status === 'completed' ? 'text-emerald-600 bg-emerald-500/10 border-emerald-500/20' : '' }}
                        {{ $p1Status === 'in_progress' ? 'text-primary bg-primary/10 border-primary/20' : '' }}
                        {{ $p1Status === 'not_started' ? 'text-slate-500 bg-slate-100 border-slate-200 dark:bg-slate-800 dark:border-slate-750' : '' }}">
                        {{ str_replace('_', ' ', $p1Status) }}
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-250">Base & Readiness</h4>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Establish base performance markers and coping capacity.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex flex-col gap-2">
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] {{ $hasHistory ? 'text-emerald-500' : 'text-slate-450' }}">history_edu</span>
                            Academic History
                        </span>
                        @if($hasHistory)
                            <span class="material-symbols-outlined text-[14px] text-emerald-500 font-bold">check_circle</span>
                        @else
                            <a href="{{ route('tests.history') }}" class="text-primary dark:text-cyan-accent hover:underline font-bold text-[10px]">START</a>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] {{ $hasStress ? 'text-emerald-500' : 'text-slate-450' }}">psychology_alt</span>
                            Psychometric Stress
                        </span>
                        @if($hasStress)
                            <span class="material-symbols-outlined text-[14px] text-emerald-500 font-bold">check_circle</span>
                        @else
                            <a href="{{ route('tests.psychometric') }}" class="text-primary dark:text-cyan-accent hover:underline font-bold text-[10px]">START</a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Phase 2 Card -->
            <div class="relative p-5 rounded-2xl border transition-all duration-300 flex flex-col justify-between group overflow-hidden
                {{ $p2Status === 'completed' ? 'bg-emerald-500/5 border-emerald-500/20 dark:border-emerald-500/10' : '' }}
                {{ $p2Status === 'in_progress' ? 'bg-primary/5 border-primary/20 dark:border-primary/10 ring-1 ring-primary/20' : '' }}
                {{ $p2Status === 'not_started' ? 'bg-slate-50/50 border-slate-200 dark:bg-slate-900/10 dark:border-slate-800' : '' }}
                {{ $p2Status === 'locked' ? 'bg-slate-100/30 border-slate-200/50 dark:bg-slate-950/20 dark:border-slate-800/40 opacity-60' : '' }}">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shadow-md
                        {{ $p2Status === 'completed' ? 'bg-emerald-500 text-white shadow-emerald-500/25' : '' }}
                        {{ $p2Status === 'in_progress' ? 'bg-primary text-white shadow-primary/25 animate-pulse' : '' }}
                        {{ $p2Status === 'not_started' ? 'bg-slate-200 dark:bg-slate-800 text-slate-650 dark:text-slate-400' : '' }}
                        {{ $p2Status === 'locked' ? 'bg-slate-200/60 dark:bg-slate-800/60 text-slate-450' : '' }}">
                        @if($p2Status === 'completed')
                            <span class="material-symbols-outlined text-[20px]">check</span>
                        @elseif($p2Status === 'locked')
                            <span class="material-symbols-outlined text-[18px]">lock</span>
                        @else
                            <span>2</span>
                        @endif
                    </div>
                    <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full border
                        {{ $p2Status === 'completed' ? 'text-emerald-600 bg-emerald-500/10 border-emerald-500/20' : '' }}
                        {{ $p2Status === 'in_progress' ? 'text-primary bg-primary/10 border-primary/20' : '' }}
                        {{ $p2Status === 'not_started' ? 'text-slate-500 bg-slate-100 border-slate-200 dark:bg-slate-800 dark:border-slate-750' : '' }}
                        {{ $p2Status === 'locked' ? 'text-slate-400 bg-slate-50 border-slate-200/50 dark:bg-slate-900 dark:border-slate-800/40' : '' }}">
                        {{ str_replace('_', ' ', $p2Status) }}
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-250">Cognitive Foundations</h4>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Map logic indices and specific streams database competence.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex flex-col gap-2">
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] {{ $hasAptitude ? 'text-emerald-500' : 'text-slate-450' }}">calculate</span>
                            Cognitive Aptitude
                        </span>
                        @if($hasAptitude)
                            <span class="material-symbols-outlined text-[14px] text-emerald-500 font-bold">check_circle</span>
                        @elseif($p2Status !== 'locked')
                            <a href="{{ route('tests.aptitude') }}" class="text-primary dark:text-cyan-accent hover:underline font-bold text-[10px]">START</a>
                        @else
                            <span class="material-symbols-outlined text-[14px] text-slate-400">lock</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] {{ $hasCore ? 'text-emerald-500' : 'text-slate-450' }}">menu_book</span>
                            Core Subject quiz
                        </span>
                        @if($hasCore)
                            <span class="material-symbols-outlined text-[14px] text-emerald-500 font-bold">check_circle</span>
                        @elseif($p2Status !== 'locked')
                            <a href="{{ route('tests.core') }}" class="text-primary dark:text-cyan-accent hover:underline font-bold text-[10px]">START</a>
                        @else
                            <span class="material-symbols-outlined text-[14px] text-slate-400">lock</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Phase 3 Card -->
            <div class="relative p-5 rounded-2xl border transition-all duration-300 flex flex-col justify-between group overflow-hidden
                {{ $p3Status === 'completed' ? 'bg-emerald-500/5 border-emerald-500/20 dark:border-emerald-500/10' : '' }}
                {{ $p3Status === 'in_progress' ? 'bg-primary/5 border-primary/20 dark:border-primary/10 ring-1 ring-primary/20' : '' }}
                {{ $p3Status === 'not_started' ? 'bg-slate-50/50 border-slate-200 dark:bg-slate-900/10 dark:border-slate-800' : '' }}
                {{ $p3Status === 'locked' ? 'bg-slate-100/30 border-slate-200/50 dark:bg-slate-950/20 dark:border-slate-800/40 opacity-60' : '' }}">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shadow-md
                        {{ $p3Status === 'completed' ? 'bg-emerald-500 text-white shadow-emerald-500/25' : '' }}
                        {{ $p3Status === 'in_progress' ? 'bg-primary text-white shadow-primary/25 animate-pulse' : '' }}
                        {{ $p3Status === 'not_started' ? 'bg-slate-200 dark:bg-slate-800 text-slate-650 dark:text-slate-400' : '' }}
                        {{ $p3Status === 'locked' ? 'bg-slate-200/60 dark:bg-slate-800/60 text-slate-450' : '' }}">
                        @if($p3Status === 'completed')
                            <span class="material-symbols-outlined text-[20px]">check</span>
                        @elseif($p3Status === 'locked')
                            <span class="material-symbols-outlined text-[18px]">lock</span>
                        @else
                            <span>3</span>
                        @endif
                    </div>
                    <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full border
                        {{ $p3Status === 'completed' ? 'text-emerald-600 bg-emerald-500/10 border-emerald-500/20' : '' }}
                        {{ $p3Status === 'in_progress' ? 'text-primary bg-primary/10 border-primary/20' : '' }}
                        {{ $p3Status === 'not_started' ? 'text-slate-500 bg-slate-100 border-slate-200 dark:bg-slate-800 dark:border-slate-750' : '' }}
                        {{ $p3Status === 'locked' ? 'text-slate-400 bg-slate-50 border-slate-200/50 dark:bg-slate-900 dark:border-slate-800/40' : '' }}">
                        {{ str_replace('_', ' ', $p3Status) }}
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-250">Expression & Language</h4>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Map fluency, reading pace, written grammar and composition.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex flex-col gap-1.5">
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[12px] {{ $hasEnglish ? 'text-emerald-500' : 'text-slate-450' }}">text_fields</span>
                            English Quiz
                        </span>
                        @if($hasEnglish)
                            <span class="material-symbols-outlined text-[12px] text-emerald-500 font-bold">check</span>
                        @elseif($p3Status !== 'locked')
                            <a href="{{ route('tests.english') }}" class="text-primary dark:text-cyan-accent hover:underline font-bold text-[9px]">START</a>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[12px] {{ $hasSpeaking ? 'text-emerald-500' : 'text-slate-450' }}">volume_up</span>
                            Speaking Test
                        </span>
                        @if($hasSpeaking)
                            <span class="material-symbols-outlined text-[12px] text-emerald-500 font-bold">check</span>
                        @elseif($p3Status !== 'locked')
                            <a href="{{ route('tests.speaking') }}" class="text-primary dark:text-cyan-accent hover:underline font-bold text-[9px]">START</a>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[12px] {{ $hasReading ? 'text-emerald-500' : 'text-slate-450' }}">chrome_reader_mode</span>
                            Speed Reading
                        </span>
                        @if($hasReading)
                            <span class="material-symbols-outlined text-[12px] text-emerald-500 font-bold">check</span>
                        @elseif($p3Status !== 'locked')
                            <a href="{{ route('tests.reading') }}" class="text-primary dark:text-cyan-accent hover:underline font-bold text-[9px]">START</a>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[12px] {{ $hasWritten ? 'text-emerald-500' : 'text-slate-450' }}">edit_note</span>
                            Written Essay
                        </span>
                        @if($hasWritten)
                            <span class="material-symbols-outlined text-[12px] text-emerald-500 font-bold">check</span>
                        @elseif($p3Status !== 'locked')
                            <a href="{{ route('tests.written') }}" class="text-primary dark:text-cyan-accent hover:underline font-bold text-[9px]">START</a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Phase 4 Card -->
            <div class="relative p-5 rounded-2xl border transition-all duration-300 flex flex-col justify-between group overflow-hidden
                {{ $p4Status === 'completed' ? 'bg-emerald-500/5 border-emerald-500/20 dark:border-emerald-500/10' : '' }}
                {{ $p4Status === 'in_progress' ? 'bg-primary/5 border-primary/20 dark:border-primary/10 ring-1 ring-primary/20' : '' }}
                {{ $p4Status === 'not_started' ? 'bg-slate-50/50 border-slate-200 dark:bg-slate-900/10 dark:border-slate-800' : '' }}
                {{ $p4Status === 'locked' ? 'bg-slate-100/30 border-slate-200/50 dark:bg-slate-950/20 dark:border-slate-800/40 opacity-60' : '' }}">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shadow-md
                        {{ $p4Status === 'completed' ? 'bg-emerald-500 text-white shadow-emerald-500/25' : '' }}
                        {{ $p4Status === 'in_progress' ? 'bg-primary text-white shadow-primary/25 animate-pulse' : '' }}
                        {{ $p4Status === 'not_started' ? 'bg-slate-200 dark:bg-slate-800 text-slate-650 dark:text-slate-400' : '' }}
                        {{ $p4Status === 'locked' ? 'bg-slate-200/60 dark:bg-slate-800/60 text-slate-450' : '' }}">
                        @if($p4Status === 'completed')
                            <span class="material-symbols-outlined text-[20px]">check</span>
                        @elseif($p4Status === 'locked')
                            <span class="material-symbols-outlined text-[18px]">lock</span>
                        @else
                            <span>4</span>
                        @endif
                    </div>
                    <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full border
                        {{ $p4Status === 'completed' ? 'text-emerald-600 bg-emerald-500/10 border-emerald-500/20' : '' }}
                        {{ $p4Status === 'in_progress' ? 'text-primary bg-primary/10 border-primary/20' : '' }}
                        {{ $p4Status === 'not_started' ? 'text-slate-500 bg-slate-100 border-slate-200 dark:bg-slate-800 dark:border-slate-750' : '' }}
                        {{ $p4Status === 'locked' ? 'text-slate-400 bg-slate-50 border-slate-200/50 dark:bg-slate-900 dark:border-slate-800/40' : '' }}">
                        {{ str_replace('_', ' ', $p4Status) }}
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-250">Practical Technical Skills</h4>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Submit algortihmic snippets validating development capacity.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex flex-col gap-2">
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] {{ $hasCoding ? 'text-emerald-500' : 'text-slate-450' }}">code</span>
                            Coding Assessment
                        </span>
                        @if($hasCoding)
                            <span class="material-symbols-outlined text-[14px] text-emerald-500 font-bold">check_circle</span>
                        @elseif($p4Status !== 'locked')
                            <a href="{{ route('tests.coding') }}" class="text-primary dark:text-cyan-accent hover:underline font-bold text-[10px]">START</a>
                        @else
                            <span class="material-symbols-outlined text-[14px] text-slate-400">lock</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Action Cards Section -->
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- New Prediction -->
        <a href="{{ route('prediction.final') }}" class="glass-card p-6 rounded-2xl border border-slate-200/50 dark:border-slate-800/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-4 group">
            <div class="p-3 bg-primary/10 rounded-xl text-primary dark:text-cyan-accent group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-[24px]">psychology</span>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">New Prediction</h4>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Run Predictor</p>
            </div>
        </a>
        <!-- Analytics -->
        <a href="{{ route('analytics') }}" class="glass-card p-6 rounded-2xl border border-slate-200/50 dark:border-slate-800/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-4 group">
            <div class="p-3 bg-cyan-500/10 rounded-xl text-cyan-600 dark:text-cyan-400 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-[24px]">monitoring</span>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">Analytics</h4>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Interactive Data</p>
            </div>
        </a>
        <!-- Export Report -->
        <button onclick="window.print()" class="glass-card p-6 rounded-2xl border border-slate-200/50 dark:border-slate-800/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-4 group text-left w-full">
            <div class="p-3 bg-purple-500/10 rounded-xl text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-[24px]">picture_as_pdf</span>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">Print / PDF</h4>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Export Matrix</p>
            </div>
        </button>
        <!-- History -->
        <a href="{{ route('history') }}" class="glass-card p-6 rounded-2xl border border-slate-200/50 dark:border-slate-800/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-4 group">
            <div class="p-3 bg-amber-500/10 rounded-xl text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-[24px]">history_edu</span>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">History</h4>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Logged Metrics</p>
            </div>
        </a>
    </section>

    <!-- KPI Widgets Grid -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 border border-slate-200/50 dark:border-slate-800/50 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-primary/10 dark:bg-primary/20 rounded-lg text-primary dark:text-cyan-accent">
                    <span class="material-symbols-outlined text-[24px]">assessment</span>
                </span>
                <span class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Predictions</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-medium">Your Evaluations Taken</span>
                <span class="text-2xl font-black text-slate-800 dark:text-slate-100 block mt-1" data-target="{{ $totalCandidates }}">{{ $totalCandidates }}</span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 border border-slate-200/50 dark:border-slate-800/50 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-cyan-500/10 dark:bg-cyan-500/20 rounded-lg text-cyan-600 dark:text-cyan-400">
                    <span class="material-symbols-outlined text-[24px]">trending_up</span>
                </span>
                <span class="text-cyan-500 text-xs font-bold uppercase tracking-wider">Average Fit</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-medium">Your Peak Placement Fit</span>
                <span class="text-2xl font-black text-slate-800 dark:text-slate-100 block mt-1"><span data-target="{{ $avgAccuracy }}">{{ $avgAccuracy }}</span>%</span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 border border-slate-200/50 dark:border-slate-800/50 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-purple-500/10 dark:bg-purple-500/20 rounded-lg text-purple-600 dark:text-purple-400">
                    <span class="material-symbols-outlined text-[24px]">verified_user</span>
                </span>
                <span class="text-purple-500 text-xs font-bold uppercase tracking-wider">Elite / High</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-medium">Elite & High Classes</span>
                <span class="text-2xl font-black text-slate-800 dark:text-slate-100 block mt-1" data-target="{{ $distribution['Elite'] + $distribution['High'] }}">{{ $distribution['Elite'] + $distribution['High'] }}</span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 border border-slate-200/50 dark:border-slate-800/50 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-amber-500/10 dark:bg-amber-500/20 rounded-lg text-amber-600 dark:text-amber-400">
                    <span class="material-symbols-outlined text-[24px]">school</span>
                </span>
                <span class="text-amber-500 text-xs font-bold uppercase tracking-wider">Grades</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-medium">Average CGPA Index</span>
                <span class="text-2xl font-black text-slate-800 dark:text-slate-100 block mt-1" data-target="{{ $avgCgpa }}">{{ number_format($avgCgpa, 2) }}</span>
            </div>
        </div>
    </section>

    <!-- Achievements & Placement Readiness Overview Bento Widget -->
    @php
        $user = Auth::user();
        $atsScore = $user->resume_analysis['ats_score'] ?? null;
        
        $academicWeight = 0;
        if (!empty($user->academic_history) && isset($user->academic_history[2])) {
            $h3 = $user->academic_history[2];
            $math = $h3['subjects'][0]['marks'] ?? 80;
            $sci = $h3['subjects'][1]['marks'] ?? 80;
            $hum = $h3['subjects'][2]['marks'] ?? 80;
            $academicWeight = (($math + $sci + $hum) / 3);
        } else {
            $academicWeight = 75;
        }

        $aptitudeScore = $user->aptitude_test_score['total'] ?? 65;
        $englishScore = $user->english_test_score['total'] ?? 70;
        $codingScore = $user->coding_test_score['total'] ?? 65;
        $speakingScore = $user->speaking_test_score['total'] ?? 70;
        $stressScore = $user->psychometric_test_score['total'] ?? 75;
        $resumeScore = $atsScore ?? 70;
        $projectsCount = $user->projects_done ?? 2;
        $portfolioWeight = min(100, $projectsCount * 25);

        $readinessIndex = round(
            ($academicWeight * 0.15) +
            ($aptitudeScore * 0.15) +
            ($englishScore * 0.10) +
            ($codingScore * 0.20) +
            ($speakingScore * 0.15) +
            ($stressScore * 0.05) +
            ($resumeScore * 0.10) +
            ($portfolioWeight * 0.10)
        );
        $readinessIndex = max(30, min(100, $readinessIndex));
        
        if ($readinessIndex >= 90) {
            $level = 'Excellent';
            $levelColor = 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20';
        } elseif ($readinessIndex >= 75) {
            $level = 'Good';
            $levelColor = 'text-cyan-500 bg-cyan-500/10 border-cyan-500/20';
        } elseif ($readinessIndex >= 60) {
            $level = 'Moderate';
            $levelColor = 'text-amber-500 bg-amber-500/10 border-amber-500/20';
        } else {
            $level = 'Needs Improvement';
            $levelColor = 'text-red-500 bg-red-500/10 border-red-500/20';
        }
    @endphp

    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Achievements Portfolio Card -->
        <div class="glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-lg flex flex-col justify-between h-48 bg-gradient-to-br from-primary/5 to-transparent">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-primary/10 rounded-xl text-primary dark:text-cyan-accent">
                    <span class="material-symbols-outlined text-[22px]">workspace_premium</span>
                </div>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest">Achievements</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-semibold">Total Logged Credentials</span>
                @php
                    $achievementsCount = count($user->achievements ?? []);
                @endphp
                <strong class="text-3xl font-black text-slate-800 dark:text-slate-100 block mt-1">{{ $achievementsCount }}</strong>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 font-medium truncate">
                    @if($achievementsCount > 0)
                        Latest: {{ end($user->achievements)['title'] }}
                    @else
                        No achievements added to portfolio yet.
                    @endif
                </p>
            </div>
            <div class="flex justify-between items-center text-[10px] font-extrabold text-slate-400 mt-2 uppercase tracking-wide">
                <a href="{{ route('career.portfolio') }}" class="text-primary dark:text-cyan-accent hover:underline flex items-center gap-1">
                    <span>Manage Portfolio</span>
                    <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                </a>
                <span>Credentials Vault</span>
            </div>
        </div>

        <!-- ATS Resume intelligence Overview -->
        <div class="glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-lg flex flex-col justify-between h-48 bg-gradient-to-br from-purple-500/5 to-transparent">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-purple-500/10 rounded-xl text-purple-600 dark:text-purple-400">
                    <span class="material-symbols-outlined text-[22px]">badge</span>
                </div>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest">ATS Resume Score</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-semibold">Current ATS Standard</span>
                @if($atsScore)
                    <strong class="text-3xl font-black text-purple-650 dark:text-purple-400 block mt-1">{{ $atsScore }}%</strong>
                    <p class="text-[10px] text-slate-450 dark:text-slate-555 mt-1 font-medium truncate">Extracted {{ count($user->resume_analysis['extracted_skills'] ?? []) }} skills from {{ $user->resume_analysis['filename'] }}</p>
                @else
                    <strong class="text-lg font-bold text-slate-400 dark:text-slate-500 block mt-1">Not Analyzed Yet</strong>
                    <p class="text-[10px] text-slate-450 dark:text-slate-555 mt-1 font-medium">Upload PDF resume for placement optimization.</p>
                @endif
            </div>
            <div class="flex justify-between items-center text-[10px] font-extrabold text-slate-400 mt-2 uppercase tracking-wide">
                <a href="{{ route('career.resume') }}" class="text-purple-600 dark:text-purple-450 hover:underline flex items-center gap-1">
                    <span>{{ $atsScore ? 'Re-Evaluate ATS' : 'Upload Resume' }}</span>
                    <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                </a>
                <span>ATS Quality</span>
            </div>
        </div>

        <!-- Overall Placement Readiness Score Card -->
        <div class="glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-lg flex flex-col justify-between h-48 bg-gradient-to-br from-emerald-500/5 to-transparent">
            <div class="flex justify-between items-start">
                <div class="p-2.5 bg-emerald-500/10 rounded-xl text-emerald-650 dark:text-emerald-450">
                    <span class="material-symbols-outlined text-[22px]">verified</span>
                </div>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest">Placement Index</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-semibold">Placement Readiness Level</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <strong class="text-3xl font-black text-slate-800 dark:text-slate-100">{{ $readinessIndex }}%</strong>
                    <span class="px-2 py-0.5 rounded-full border text-[10px] font-bold {{ $levelColor }}">{{ $level }}</span>
                </div>
                <p class="text-[10px] text-slate-450 dark:text-slate-555 mt-1 font-medium">Aggregated across academics, coding & communication.</p>
            </div>
            <div class="flex justify-between items-center text-[10px] font-extrabold text-slate-400 mt-2 uppercase tracking-wide">
                <a href="{{ route('career.readiness') }}" class="text-emerald-600 dark:text-emerald-450 hover:underline flex items-center gap-1">
                    <span>View AI Report</span>
                    <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                </a>
                <span>Readiness Scale</span>
            </div>
        </div>
    </section>



    <!-- Recent Predictions Table -->
    <section class="glass-card rounded-2xl overflow-hidden mb-8 shadow-md border border-slate-200/50 dark:border-slate-800/50">
        <div class="p-6 flex justify-between items-center border-b border-slate-200/40 dark:border-slate-800/40">
            <div>
                <h3 class="text-xl text-slate-800 dark:text-slate-100 font-bold">Recent Predictions</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Latest diagnostic assessments passing through synaptic structures.</p>
            </div>
            <a href="{{ route('history') }}" class="text-primary dark:text-cyan-accent font-semibold text-sm hover:underline decoration-2">View Full Log Matrix</a>
        </div>
        
        <div class="overflow-x-auto">
            @if ($recentCandidates->count() > 0)
                <table class="w-full border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-600 dark:text-slate-400">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">Evaluation Run / Focus</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">Academic Score</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">Classification</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">ANN Fit Score</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/30">
                        @foreach ($recentCandidates as $index => $candidate)
                            <tr class="hover:bg-primary/5 transition-colors cursor-pointer group" onclick="window.location='{{ route('evaluation.results', $candidate->id) }}'">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary/20 to-cyan-accent/20 flex items-center justify-center text-primary dark:text-cyan-accent font-bold">
                                            #{{ $recentCandidates->count() - $index }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                                {{ !empty($candidate->career_recommendations) ? $candidate->career_recommendations[0] : ($candidate->ai['potential'] ?? 'General Potential Analysis') }}
                                            </p>
                                            <p class="text-[12px] text-slate-500 dark:text-slate-400">
                                                {{ count($candidate->academic_history ?? []) }} Years Mapped &bull; {{ $candidate->softskills['skills'] ?? 0 }} Skills Evaluated
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">{{ number_format($candidate->cgpa, 2) }} / 10.0</td>
                                <td class="px-6 py-4">
                                    @if ($candidate->potential_class === 'Elite Potential')
                                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-[11px] font-bold tracking-wide">ELITE</span>
                                    @elseif ($candidate->potential_class === 'High Potential')
                                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-[11px] font-bold tracking-wide">HIGH</span>
                                    @elseif ($candidate->potential_class === 'Moderate Potential')
                                        <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full text-[11px] font-bold tracking-wide">MODERATE</span>
                                    @else
                                        <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full text-[11px] font-bold tracking-wide">DEVELOPING</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <div class="flex-grow h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden w-24">
                                            <div class="h-full bg-gradient-to-r from-primary to-cyan-accent" style="width: {{ $candidate->probability_score }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $candidate->probability_score }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right" onclick="event.stopPropagation();">
                                    <a href="{{ route('evaluation.results', $candidate->id) }}" class="text-primary dark:text-cyan-accent font-semibold hover:underline flex items-center justify-end gap-1.5 transition-transform group-hover:translate-x-1">
                                        View Details
                                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-12 text-center flex flex-col items-center justify-center gap-3">
                    <span class="material-symbols-outlined text-[64px] text-slate-300 dark:text-slate-700">query_stats</span>
                    <h4 class="text-lg text-slate-800 dark:text-slate-200 font-semibold">No Predictions Recorded Yet</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 max-w-md">Get started by running the neural evaluation network against a candidate's credentials.</p>
                    <a href="{{ route('prediction.final') }}" class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-xl text-sm font-semibold hover:opacity-90 shadow-lg flex items-center gap-1.5 mt-3 active:scale-95 transition-all">
                        <span class="material-symbols-outlined">psychology</span>
                        Run First Evaluation
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    // Count-Up Animations for KPI Widgets
    (function() {
        const counters = document.querySelectorAll('[data-target]');
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-target'));
            let current = 0;
            const duration = 1200; // 1.2s
            const steps = 40;
            const stepVal = target / steps;
            let step = 0;
            
            const interval = setInterval(() => {
                current += stepVal;
                step++;
                
                if (target % 1 !== 0) {
                    counter.innerText = current.toFixed(2);
                } else {
                    counter.innerText = Math.floor(current);
                }
                
                if (step >= steps) {
                    clearInterval(interval);
                    counter.innerText = target % 1 !== 0 ? target.toFixed(2) : target;
                }
            }, duration / steps);
        });
    })();
</script>
@endsection
