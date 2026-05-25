@extends('layouts.app')

@section('title', 'Final Score Aggregation & Prediction | Evaluating Academic Potential')

@section('content')
<div class="p-6 lg:p-8 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6 mt-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100 mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent text-[32px] animate-pulse">psychology</span>
                Final Potential Predictor
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Aggregate all diagnostic scores and portfolio achievements to compile the Final Academic Potential Index.</p>
        </div>
        <div class="glass-card px-6 py-3 rounded-2xl flex items-center gap-3 border border-primary/20 bg-primary/5 dark:bg-primary/10">
            <span class="material-symbols-outlined text-primary dark:text-cyan-accent">auto_awesome</span>
            <span class="text-sm text-primary dark:text-cyan-accent font-bold uppercase tracking-wider">Stanford-Style Scoring</span>
        </div>
    </div>

    <form id="prediction-form" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        
        <!-- Left Panel: Diagnostic Checklist & Status (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="glass-card rounded-3xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50 shadow-xl bg-white/40 dark:bg-slate-900/30 backdrop-blur-xl space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-500">task_alt</span>
                        Diagnostic Suite Completeness
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Review your completed independent evaluations below. The predictive engine will merge these indicators with your portfolio variables to classify your potential.
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

                <!-- Progress Ring Widget -->
                <div class="flex items-center gap-4 bg-slate-100/40 dark:bg-slate-950/20 p-4 rounded-2xl border border-slate-200/20">
                    <div class="relative w-16 h-16 flex-shrink-0">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-slate-200 dark:text-slate-800" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-indigo-500 dark:text-indigo-400 transition-all duration-500" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" stroke-dasharray="{{ $progressPercent }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-sm font-extrabold text-slate-800 dark:text-slate-100">{{ $progressPercent }}%</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-[10px] font-black text-indigo-500 dark:text-indigo-400 uppercase tracking-widest block">COMPLETENESS RATIO</span>
                        <strong class="text-slate-800 dark:text-slate-100 font-extrabold text-sm">{{ $completedCount }} of {{ $totalModules }} Modules Sync'd</strong>
                    </div>
                </div>

                <!-- Interactive Checklist Cards -->
                <div class="space-y-3 max-h-[380px] overflow-y-auto pr-1 custom-scrollbar">
                    
                    <!-- 1. Academic History -->
                    <div class="p-3.5 rounded-2xl border border-slate-200/30 dark:border-slate-800/30 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/20 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ $user->academic_history ? 'text-emerald-500' : 'text-slate-400' }}">history_edu</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-350">Academic History</h4>
                                <p class="text-[10px] text-slate-400">3-Year subject tenses logs</p>
                            </div>
                        </div>
                        @if($user->academic_history)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[9px] font-black uppercase tracking-wider flex items-center gap-0.5">
                                <span class="material-symbols-outlined text-[12px]">check</span> Sync'd
                            </span>
                        @else
                            <a href="{{ route('tests.history') }}" class="px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 border border-amber-500/20 text-[9px] font-black uppercase tracking-wider transition-colors">
                                Add Logs
                            </a>
                        @endif
                    </div>

                    <!-- 2. Cognitive Aptitude -->
                    <div class="p-3.5 rounded-2xl border border-slate-200/30 dark:border-slate-800/30 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/20 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ $user->aptitude_test_score ? 'text-emerald-500' : 'text-slate-400' }}">psychology_alt</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-350">Cognitive Aptitude</h4>
                                <p class="text-[10px] text-slate-400">Logical & math diagnostic</p>
                            </div>
                        </div>
                        @if($user->aptitude_test_score)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[9px] font-black uppercase tracking-wider flex items-center gap-0.5">
                                Score: {{ $user->aptitude_test_score['total'] }}%
                            </span>
                        @else
                            <a href="{{ route('tests.aptitude') }}" class="px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 border border-amber-500/20 text-[9px] font-black uppercase tracking-wider transition-colors">
                                Start Quiz
                            </a>
                        @endif
                    </div>

                    <!-- 3. English Language -->
                    <div class="p-3.5 rounded-2xl border border-slate-200/30 dark:border-slate-800/30 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/20 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ $user->english_test_score ? 'text-emerald-500' : 'text-slate-400' }}">abc</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-350">English Language</h4>
                                <p class="text-[10px] text-slate-400">Grammar & syntax quiz</p>
                            </div>
                        </div>
                        @if($user->english_test_score)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[9px] font-black uppercase tracking-wider flex items-center gap-0.5">
                                Score: {{ $user->english_test_score['total'] }}%
                            </span>
                        @else
                            <a href="{{ route('tests.english') }}" class="px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 border border-amber-500/20 text-[9px] font-black uppercase tracking-wider transition-colors">
                                Start Quiz
                            </a>
                        @endif
                    </div>

                    <!-- 4. Vocal Fluency -->
                    <div class="p-3.5 rounded-2xl border border-slate-200/30 dark:border-slate-800/30 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/20 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ $user->speaking_test_score ? 'text-emerald-500' : 'text-slate-400' }}">mic</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-350">Vocal Fluency</h4>
                                <p class="text-[10px] text-slate-400">Verbal pronunciation audio</p>
                            </div>
                        </div>
                        @if($user->speaking_test_score)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[9px] font-black uppercase tracking-wider flex items-center gap-0.5">
                                Score: {{ $user->speaking_test_score['total'] }}%
                            </span>
                        @else
                            <a href="{{ route('tests.speaking') }}" class="px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 border border-amber-500/20 text-[9px] font-black uppercase tracking-wider transition-colors">
                                Record
                            </a>
                        @endif
                    </div>

                    <!-- 5. Reading Comprehension -->
                    <div class="p-3.5 rounded-2xl border border-slate-200/30 dark:border-slate-800/30 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/20 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ $user->reading_test_score ? 'text-emerald-500' : 'text-slate-400' }}">menu_book</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-350">Reading Comprehension</h4>
                                <p class="text-[10px] text-slate-400">Speed (WPM) & comprehension</p>
                            </div>
                        </div>
                        @if($user->reading_test_score)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[9px] font-black uppercase tracking-wider flex items-center gap-0.5">
                                WPM: {{ $user->reading_test_score['wpm'] }}
                            </span>
                        @else
                            <a href="{{ route('tests.reading') }}" class="px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 border border-amber-500/20 text-[9px] font-black uppercase tracking-wider transition-colors">
                                Start Quiz
                            </a>
                        @endif
                    </div>

                    <!-- 6. Written Composition -->
                    <div class="p-3.5 rounded-2xl border border-slate-200/30 dark:border-slate-800/30 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/20 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ $user->written_test_score ? 'text-emerald-500' : 'text-slate-400' }}">edit_note</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-350">Written Composition</h4>
                                <p class="text-[10px] text-slate-400">Word count & connector structures</p>
                            </div>
                        </div>
                        @if($user->written_test_score)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[9px] font-black uppercase tracking-wider flex items-center gap-0.5">
                                Score: {{ $user->written_test_score['total'] }}%
                            </span>
                        @else
                            <a href="{{ route('tests.written') }}" class="px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 border border-amber-500/20 text-[9px] font-black uppercase tracking-wider transition-colors">
                                Start Essay
                            </a>
                        @endif
                    </div>

                    <!-- 7. Core Subject Quiz -->
                    <div class="p-3.5 rounded-2xl border border-slate-200/30 dark:border-slate-800/30 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/20 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ $user->core_subject_score ? 'text-emerald-500' : 'text-slate-400' }}">terminal</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-350">Core Subject Quiz</h4>
                                <p class="text-[10px] text-slate-400">Stream specific exam parameters</p>
                            </div>
                        </div>
                        @if($user->core_subject_score)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[9px] font-black uppercase tracking-wider flex items-center gap-0.5">
                                Score: {{ $user->core_subject_score['total'] }}%
                            </span>
                        @else
                            <a href="{{ route('tests.core') }}" class="px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 border border-amber-500/20 text-[9px] font-black uppercase tracking-wider transition-colors">
                                Start Quiz
                            </a>
                        @endif
                    </div>

                    <!-- 8. Psychometric Survey -->
                    <div class="p-3.5 rounded-2xl border border-slate-200/30 dark:border-slate-800/30 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/20 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ $user->psychometric_test_score ? 'text-emerald-500' : 'text-slate-400' }}">ecg_heart</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-350">Psychometric Survey</h4>
                                <p class="text-[10px] text-slate-400">Academic stress & workload index</p>
                            </div>
                        </div>
                        @if($user->psychometric_test_score)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[9px] font-black uppercase tracking-wider flex items-center gap-0.5">
                                Wellness: {{ $user->psychometric_test_score['total'] }}%
                            </span>
                        @else
                            <a href="{{ route('tests.psychometric') }}" class="px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 border border-amber-500/20 text-[9px] font-black uppercase tracking-wider transition-colors">
                                Take Survey
                            </a>
                        @endif
                    </div>

                    <!-- 9. Practical Coding -->
                    <div class="p-3.5 rounded-2xl border border-slate-200/30 dark:border-slate-800/30 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/20 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ $user->coding_test_score ? 'text-emerald-500' : 'text-slate-400' }}">terminal</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-350">Coding & Algorithms</h4>
                                <p class="text-[10px] text-slate-400">Practical computational workspace</p>
                            </div>
                        </div>
                        @if($user->coding_test_score)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[9px] font-black uppercase tracking-wider flex items-center gap-0.5">
                                Score: {{ $user->coding_test_score['total'] }}%
                            </span>
                        @else
                            <a href="{{ route('tests.coding') }}" class="px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 border border-amber-500/20 text-[9px] font-black uppercase tracking-wider transition-colors">
                                Start IDE
                            </a>
                        @endif
                    </div>
                </div>

                @if($completedCount < 4)
                    <div class="p-4 bg-amber-550/5 dark:bg-amber-500/5 rounded-2xl border border-amber-500/25 flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-amber-500 text-[20px] mt-0.5">warning</span>
                        <p class="text-[10px] text-amber-600 dark:text-amber-400 leading-normal font-semibold">
                            <strong>Note:</strong> We recommend completing at least 4 diagnostic assessments for maximum potential prediction accuracy. Uncompleted evaluations will fall back to average baselines.
                        </p>
                    </div>
                @else
                    <div class="p-4 bg-emerald-500/5 dark:bg-emerald-500/10 rounded-2xl border border-emerald-500/20 flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-500 text-[20px] mt-0.5">verified_user</span>
                        <p class="text-[10px] text-emerald-600 dark:text-emerald-400 leading-normal font-semibold">
                            <strong>Excellent Status:</strong> You have synchronized enough diagnostic metrics for highly accurate classification!
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Panel: Portfolio achievement Inputs & Submit button (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="glass-card rounded-3xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50 shadow-xl bg-white/40 dark:bg-slate-900/30 backdrop-blur-xl space-y-8">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary dark:text-cyan-accent">military_tech</span>
                        Academic Portfolio & Extracurricular Accomplishments
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Supply your real-world credentials. These markers are heavily weighted inside the final evaluation scoring matrices.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Projects Completed -->
                    <div class="space-y-2.5">
                        <label class="text-xs font-black text-slate-655 dark:text-slate-350 uppercase tracking-widest block">Number of Projects Completed</label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="adjustInput('projects_done', -1)" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors select-none">-</button>
                            <input type="number" id="projects_done" name="projects_done" value="{{ $user->projects_done ?? 0 }}" min="0" max="20" readonly class="w-full text-center py-2.5 rounded-xl bg-white/50 dark:bg-slate-950/30 border border-slate-200 dark:border-slate-800 text-sm font-extrabold text-slate-800 dark:text-slate-100 focus:outline-none"/>
                            <button type="button" onclick="adjustInput('projects_done', 1)" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors select-none">+</button>
                        </div>
                        <p class="text-[10px] text-slate-400 font-semibold leading-relaxed">Major engineering, capstones, software apps, research papers, etc.</p>
                    </div>

                    <!-- Internships count -->
                    <div class="space-y-2.5">
                        <label class="text-xs font-black text-slate-655 dark:text-slate-350 uppercase tracking-widest block">Internships Completed</label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="adjustInput('internships_count', -1)" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors select-none">-</button>
                            <input type="number" id="internships_count" name="internships_count" value="{{ $user->internships_count ?? 0 }}" min="0" max="10" readonly class="w-full text-center py-2.5 rounded-xl bg-white/50 dark:bg-slate-950/30 border border-slate-200 dark:border-slate-800 text-sm font-extrabold text-slate-800 dark:text-slate-100 focus:outline-none"/>
                            <button type="button" onclick="adjustInput('internships_count', 1)" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors select-none">+</button>
                        </div>
                        <p class="text-[10px] text-slate-400 font-semibold leading-relaxed">Industrial internship sessions or real workplace gigs completed.</p>
                    </div>

                    <!-- Certified Skills count -->
                    <div class="space-y-2.5">
                        <label class="text-xs font-black text-slate-655 dark:text-slate-350 uppercase tracking-widest block">Number of Certified Skills</label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="adjustInput('skills_count', -1)" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors select-none">-</button>
                            <input type="number" id="skills_count" name="skills_count" value="{{ count($user->skills ?? []) }}" min="0" max="30" readonly class="w-full text-center py-2.5 rounded-xl bg-white/50 dark:bg-slate-950/30 border border-slate-200 dark:border-slate-800 text-sm font-extrabold text-slate-800 dark:text-slate-100 focus:outline-none"/>
                            <button type="button" onclick="adjustInput('skills_count', 1)" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors select-none">+</button>
                        </div>
                        <p class="text-[10px] text-slate-400 font-semibold leading-relaxed">Technical programming, analytical, or core expertise categories.</p>
                    </div>

                    <!-- Professional Certifications count -->
                    <div class="space-y-2.5">
                        <label class="text-xs font-black text-slate-655 dark:text-slate-350 uppercase tracking-widest block">Professional Certifications</label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="adjustInput('certifications_count', -1)" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors select-none">-</button>
                            <input type="number" id="certifications_count" name="certifications_count" value="{{ $user->certifications_count ?? 0 }}" min="0" max="15" readonly class="w-full text-center py-2.5 rounded-xl bg-white/50 dark:bg-slate-950/30 border border-slate-200 dark:border-slate-800 text-sm font-extrabold text-slate-800 dark:text-slate-100 focus:outline-none"/>
                            <button type="button" onclick="adjustInput('certifications_count', 1)" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors select-none">+</button>
                        </div>
                        <p class="text-[10px] text-slate-400 font-semibold leading-relaxed">AWS, Google Cloud, Oracle, CFA, Scrum, or verified educational credentials.</p>
                    </div>
                </div>

                <!-- Leadership Role toggle switch -->
                <div class="p-5 bg-indigo-500/5 dark:bg-indigo-500/10 rounded-3xl border border-indigo-500/10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="space-y-1">
                        <h4 class="text-sm font-bold text-slate-850 dark:text-slate-200 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-indigo-500 text-[20px]">groups</span>
                            Leadership Position / Representative
                        </h4>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold">
                            Have you served as a Student President, Club Lead, Class Rep, or sports captain?
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" id="leadership_role" name="leadership_role" class="sr-only peer" {{ $user->leadership_role ? 'checked' : '' }}>
                        <div class="w-14 h-8 bg-slate-200 dark:bg-slate-850 rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-500/30 dark:peer-focus:ring-indigo-500/10 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500"></div>
                    </label>
                </div>

                <!-- Big Convergence Launch Button -->
                <div class="pt-6 border-t border-slate-200/50 dark:border-slate-800/50 flex flex-col gap-4">
                    <div class="text-center">
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
                            Launching this process compiles a persistent Stanford potential record
                        </p>
                    </div>
                    <button type="submit" id="launch-btn" class="w-full flex items-center justify-center gap-3 py-4.5 rounded-2xl bg-gradient-to-r from-primary to-cyan-accent text-white font-extrabold text-sm shadow-xl shadow-primary/20 hover:shadow-primary/30 transition-all hover:scale-[1.01] hover:brightness-110 active:scale-[0.99] select-none">
                        <span class="material-symbols-outlined text-[20px] animate-bounce">auto_awesome</span>
                        <span>LAUNCH POTENTIAL AGGREGATOR</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Adjust numeric values with +/- buttons helper
    function adjustInput(id, delta) {
        const input = document.getElementById(id);
        if (!input) return;
        
        let value = parseInt(input.value) || 0;
        let min = parseInt(input.getAttribute('min')) ?? 0;
        let max = parseInt(input.getAttribute('max')) ?? 100;
        
        let newValue = Math.max(min, Math.min(max, value + delta));
        input.value = newValue;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('prediction-form');
        const launchBtn = document.getElementById('launch-btn');

        // Submit via AJAX
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            // Disable button during calculation to show progress indicators
            launchBtn.disabled = true;
            launchBtn.className = "w-full flex items-center justify-center gap-3 py-4.5 rounded-2xl bg-slate-600 cursor-not-allowed text-white/80 font-extrabold text-sm select-none shadow-md";
            launchBtn.innerHTML = `
                <span class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
                AGGREGATING PORTFOLIO METRICS & CALCULATING INDEX...
            `;

            // Prepare payload
            const projectsDone = parseInt(document.getElementById('projects_done').value) || 0;
            const internshipsCount = parseInt(document.getElementById('internships_count').value) || 0;
            const skillsCount = parseInt(document.getElementById('skills_count').value) || 0;
            const certificationsCount = parseInt(document.getElementById('certifications_count').value) || 0;
            const leadershipRole = document.getElementById('leadership_role').checked ? 1 : 0;

            const formData = new FormData();
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('projects_done', projectsDone);
            formData.append('internships_count', internshipsCount);
            formData.append('skills_count', skillsCount);
            formData.append('certifications_count', certificationsCount);
            formData.append('leadership_role', leadershipRole);

            fetch('{{ route('prediction.final.save') }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server returned error response');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('Potential Calculated!', 'Merging diagnostic suite indicators complete. Redirecting to evaluation report...', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1800);
                } else {
                    showToast('Calculation Failed', 'An error occurred while scoring your potential profile. Please review fields.', 'error');
                    resetLaunchButton();
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Network Error', 'Prediction server could not be reached. Please check Laravel setup.', 'error');
                resetLaunchButton();
            });
        });

        function resetLaunchButton() {
            launchBtn.disabled = false;
            launchBtn.className = "w-full flex items-center justify-center gap-3 py-4.5 rounded-2xl bg-gradient-to-r from-primary to-cyan-accent text-white font-extrabold text-sm shadow-xl shadow-primary/20 hover:shadow-primary/30 transition-all hover:scale-[1.01] hover:brightness-110 active:scale-[0.99] select-none";
            launchBtn.innerHTML = `
                <span class="material-symbols-outlined text-[20px] animate-bounce">auto_awesome</span>
                <span>LAUNCH POTENTIAL AGGREGATOR</span>
            `;
        }
    });
</script>
@endsection
