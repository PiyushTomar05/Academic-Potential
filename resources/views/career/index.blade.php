@extends('layouts.app')

@section('title', 'Placement & Career Hub | Evaluating Academic Potential')

@section('styles')
<style>
    .tab-pane {
        transition: all 0.3s ease-in-out;
    }
    @media print {
        aside, header, #toast-notification, #theme-toggle-floating, .no-print, .tab-bar-container {
            display: none !important;
        }
        main {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .print-layout {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0 !important;
        }
        .tab-pane {
            display: block !important;
            opacity: 1 !important;
        }
    }
</style>
@endsection

@section('content')
<div class="p-6 lg:p-8 max-w-6xl mx-auto flex flex-col gap-8 print-layout">
    
    <!-- Unified Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-6 mt-6 no-print">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent text-[32px]">verified</span>
                Placement & Career Hub
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Verify your synthesized readiness score, evaluate ATS resumes, and build credentials portfolio.</p>
        </div>
        <div class="flex items-center gap-3 no-print">
            <button onclick="toggleSubmissionDrawer(true)" id="header-log-btn" class="px-5 py-3 bg-primary hover:bg-primary-hover text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-primary/20 flex items-center gap-1.5 cursor-pointer hidden">
                <span class="material-symbols-outlined text-[16px]">add_circle</span>
                <span>Log New Achievement</span>
            </button>
            <button onclick="window.print()" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-lg hover:shadow-emerald-500/20 flex items-center gap-1.5 cursor-pointer">
                <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span>
                <span>Export Report</span>
            </button>
        </div>
    </header>

    <!-- Glassmorphic Horizontal Tab Bar -->
    <div class="tab-bar-container no-print bg-white/40 dark:bg-slate-900/30 border border-slate-200/50 dark:border-slate-800/50 p-2 rounded-2xl flex flex-wrap gap-2 shadow-sm backdrop-blur-xl">
        <button onclick="switchTab('readiness-tab')" data-tab="readiness-tab" class="tab-trigger flex items-center gap-2 px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 rounded-xl transition-all cursor-pointer border-primary text-primary dark:text-cyan-accent">
            <span class="material-symbols-outlined text-[16px]">verified</span>
            <span>Readiness AI Report</span>
        </button>
        <button onclick="switchTab('resume-tab')" data-tab="resume-tab" class="tab-trigger flex items-center gap-2 px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 rounded-xl transition-all cursor-pointer border-transparent text-slate-400">
            <span class="material-symbols-outlined text-[16px]">badge</span>
            <span>ATS Resume Intelligence</span>
        </button>
        <button onclick="switchTab('portfolio-tab')" data-tab="portfolio-tab" class="tab-trigger flex items-center gap-2 px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 rounded-xl transition-all cursor-pointer border-transparent text-slate-400">
            <span class="material-symbols-outlined text-[16px]">workspace_premium</span>
            <span>Achievement Portfolio</span>
        </button>
        <button onclick="switchTab('timeline-tab')" data-tab="timeline-tab" class="tab-trigger flex items-center gap-2 px-5 py-3 text-xs font-bold uppercase tracking-wider border-b-2 rounded-xl transition-all cursor-pointer border-transparent text-slate-400">
            <span class="material-symbols-outlined text-[16px]">timeline</span>
            <span>Growth Timeline</span>
        </button>
    </div>

    <!-- Active Content Panes -->
    <div class="print-layout">
        
        <!-- Tab 1: Placement Readiness AI Report -->
        <div id="readiness-tab" class="tab-pane space-y-8">
            <div class="glass-card rounded-3xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50 shadow-2xl space-y-8 bg-gradient-to-br from-emerald-500/5 via-transparent to-transparent print-layout">
                <!-- Document Title Header -->
                <div class="flex justify-between items-start border-b border-slate-200 dark:border-slate-800 pb-6">
                    <div class="space-y-1">
                        <h1 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Placement Readiness & Career Evaluation Report</h1>
                        <span class="text-[9px] text-slate-450 font-extrabold uppercase tracking-widest block">Evaluating Academic Potential AI Engine</span>
                    </div>
                    <div class="text-right">
                        <strong class="text-xs font-black text-slate-450 uppercase block">Report Code</strong>
                        <span class="text-[9px] text-slate-500 font-bold block truncate max-w-[120px]">{{ md5($user->id . now()->toDateString()) }}</span>
                    </div>
                </div>

                <!-- Student Profile Coordinates -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 bg-slate-50 dark:bg-slate-900/30 p-5 rounded-2xl border border-slate-200/20">
                    <div>
                        <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Candidate Name</span>
                        <strong class="text-xs text-slate-800 dark:text-slate-200 block truncate font-bold">{{ $user->name }}</strong>
                    </div>
                    <div>
                        <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Email Coordinates</span>
                        <strong class="text-xs text-slate-800 dark:text-slate-200 block truncate font-bold">{{ $user->email }}</strong>
                    </div>
                    <div>
                        <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Analysis Date</span>
                        <strong class="text-xs text-slate-800 dark:text-slate-200 block truncate font-bold">{{ now()->format('Y-M-d') }}</strong>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center border-b border-slate-200/40 dark:border-slate-800/40 pb-6">
                    <!-- Left: Aggregate Readiness Circle -->
                    <div class="md:col-span-5 flex flex-col items-center gap-4">
                        <span class="text-[10px] text-slate-450 font-black uppercase tracking-widest">Aggregate Readiness Index</span>
                        
                        <div class="relative w-40 h-40 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="80" cy="80" r="70" stroke="rgba(148, 163, 184, 0.1)" stroke-width="10" fill="transparent"></circle>
                                <circle cx="80" cy="80" r="70" stroke="#10b981" stroke-width="10" fill="transparent" stroke-dasharray="440" stroke-dashoffset="{{ 440 - (440 * $readinessIndex) / 100 }}" stroke-linecap="round" class="transition-all duration-1000"></circle>
                            </svg>
                            <div class="absolute flex flex-col items-center justify-center">
                                <span class="text-4xl font-black text-slate-800 dark:text-slate-100">{{ $readinessIndex }}%</span>
                                <span class="text-[8px] text-emerald-500 font-extrabold uppercase tracking-widest mt-1 px-2.5 py-0.5 rounded-full border {{ $bg }}">{{ $level }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Detailed score layers -->
                    <div class="md:col-span-7 space-y-4">
                        <span class="text-[10px] text-slate-450 font-black uppercase tracking-widest block">Readiness Parameter Coordinates</span>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <div class="flex justify-between items-center text-xs font-bold text-slate-700 dark:text-slate-350">
                                    <span>Quantitative Aptitude</span>
                                    <span>{{ $user->aptitude_test_score['total'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $user->aptitude_test_score['total'] ?? 0 }}%"></div>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <div class="flex justify-between items-center text-xs font-bold text-slate-700 dark:text-slate-350">
                                    <span>English Grammar</span>
                                    <span>{{ $user->english_test_score['total'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $user->english_test_score['total'] ?? 0 }}%"></div>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <div class="flex justify-between items-center text-xs font-bold text-slate-700 dark:text-slate-350">
                                    <span>Algorithms & Coding</span>
                                    <span>{{ $user->coding_test_score['total'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $user->coding_test_score['total'] ?? 0 }}%"></div>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <div class="flex justify-between items-center text-xs font-bold text-slate-700 dark:text-slate-350">
                                    <span>Fluency & Communication</span>
                                    <span>{{ $user->speaking_test_score['total'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $user->speaking_test_score['total'] ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prediction History Logs block -->
                <div class="space-y-4">
                    <span class="text-[10px] text-slate-450 font-black uppercase tracking-widest block">Dynamic Prediction Log History</span>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs font-semibold text-slate-700 dark:text-slate-300">
                            <thead>
                                <tr class="border-b border-slate-200 dark:border-slate-800 text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">
                                    <th class="py-2.5">Date Checked</th>
                                    <th class="py-2.5">Academic Standing</th>
                                    <th class="py-2.5">Classification Fit</th>
                                    <th class="py-2.5">Confidence Index</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-900">
                                @forelse($predictionHistory as $pred)
                                    <tr>
                                        <td class="py-3 font-mono">{{ $pred->created_at ? $pred->created_at->format('Y-M-d') : now()->format('Y-M-d') }}</td>
                                        <td class="py-3">GPA: {{ $pred->cgpa }} | Certifications: {{ $pred->certifications_count }}</td>
                                        <td class="py-3">
                                            <span class="font-bold">{{ $pred->potential_class }}</span>
                                        </td>
                                        <td class="py-3 font-bold text-emerald-600 dark:text-emerald-450">{{ $pred->probability_score }}%</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-slate-450 italic">No prediction records logged yet. Run a potential aggregator prediction.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: ATS Resume Intelligence -->
        <div id="resume-tab" class="tab-pane hidden space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Interactive Drag and Drop Upload Widget -->
                <div class="lg:col-span-5 glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-xl space-y-6">
                    <div class="border-b border-slate-200/40 dark:border-slate-800/40 pb-3">
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">cloud_upload</span>
                            <span>Upload PDF Resume</span>
                        </h3>
                        <p class="text-xs text-slate-450 mt-1 font-medium">Inject your resume coordinates to calculate ATS parsed scoring vectors.</p>
                    </div>

                    <form id="resume-upload-form" class="space-y-4">
                        @csrf
                        <div id="drag-drop-area" class="border-2 border-dashed border-slate-300 dark:border-slate-800 hover:border-primary dark:hover:border-cyan-accent rounded-2xl p-8 flex flex-col items-center justify-center gap-3 cursor-pointer transition-colors bg-slate-50/50 dark:bg-slate-950/20 group">
                            <span class="material-symbols-outlined text-slate-400 group-hover:text-primary transition-colors text-[48px]">upload_file</span>
                            <div class="text-center">
                                <strong class="text-xs font-bold text-slate-700 dark:text-slate-300 block">Drag & Drop Resume</strong>
                                <span class="text-[10px] text-slate-450 mt-0.5 block">or click to browse files (PDF, DOCX up to 5MB)</span>
                            </div>
                            <input type="file" id="resume_file" name="resume_file" class="hidden" accept=".pdf,.doc,.docx" required>
                        </div>
                        
                        <div id="file-info-bar" class="hidden p-3 bg-slate-100 dark:bg-slate-950 border border-slate-200/60 dark:border-slate-800/60 rounded-xl flex justify-between items-center text-xs">
                            <span id="file-name-txt" class="font-bold text-slate-700 dark:text-slate-300 truncate max-w-[200px]">resume.pdf</span>
                            <button type="button" onclick="clearFile()" class="material-symbols-outlined text-red-500 text-[18px]">delete</button>
                        </div>

                        <button type="submit" id="upload-submit-btn" class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-black uppercase tracking-wider rounded-xl shadow-lg hover:shadow-primary/20 transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">sync_saved_locally</span>
                            <span>Run ATS Analyzer</span>
                        </button>
                    </form>
                </div>

                <!-- Right: ATS Analyzer Results -->
                <div class="lg:col-span-7 glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-xl min-h-[300px] flex flex-col justify-center">
                    @if($user->resume_analysis)
                        @php $analysis = $user->resume_analysis; @endphp
                        <div class="space-y-6">
                            <div class="flex justify-between items-center border-b border-slate-200/40 dark:border-slate-800/40 pb-4">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary dark:text-cyan-accent">task_alt</span>
                                        <span>ATS Score Results</span>
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-0.5">Parsed file: <strong class="text-slate-700 dark:text-slate-300 font-bold">{{ $analysis['filename'] }}</strong></p>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] text-slate-400 font-black uppercase tracking-wider block">ATS Score</span>
                                    <strong class="text-3xl font-black text-primary dark:text-cyan-accent block mt-0.5">{{ $analysis['ats_score'] }}%</strong>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="p-4 bg-slate-50 dark:bg-slate-950/40 rounded-2xl border border-slate-200/20">
                                    <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Grammar Rating</span>
                                    <strong class="text-sm font-black text-slate-700 dark:text-slate-300">{{ $analysis['grammar_score'] }}%</strong>
                                </div>
                                <div class="p-4 bg-slate-50 dark:bg-slate-950/40 rounded-2xl border border-slate-200/20">
                                    <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Structure Consistency</span>
                                    <strong class="text-sm font-black text-slate-700 dark:text-slate-300">{{ $analysis['structure_rating'] }}%</strong>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <strong class="text-xs font-black text-primary uppercase tracking-wider block">Extracted Skill Keywords</strong>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($analysis['extracted_skills'] as $skill)
                                        <span class="px-3 py-1 bg-slate-100 dark:bg-slate-900 border border-slate-250 dark:border-slate-800 text-[10px] font-bold rounded-lg text-slate-600 dark:text-slate-300">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-3 bg-purple-500/5 p-5 rounded-2xl border border-purple-500/10">
                                <strong class="text-xs font-black text-purple-600 dark:text-purple-400 uppercase tracking-widest block">Actionable ATS Suggestions</strong>
                                <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-300 leading-normal">
                                    @foreach($analysis['recommendations'] as $rec)
                                        <li class="flex gap-2">
                                            <span class="material-symbols-outlined text-[16px] text-purple-500 font-bold">arrow_right</span>
                                            <p>{{ $rec }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="text-center p-8 flex flex-col items-center gap-3">
                            <span class="material-symbols-outlined text-[64px] text-slate-300 dark:text-slate-700">analytics</span>
                            <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">ATS Analyzer Offline</h4>
                            <p class="text-xs text-slate-450 dark:text-slate-550 max-w-sm leading-relaxed">Please upload your PDF/DOCX resume file on the left and run the analyzer to verify coordinates.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab 3: Achievement Portfolio -->
        <div id="portfolio-tab" class="tab-pane hidden space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Claimed Certificates (standard claimed tests) -->
                @php
                    $claimedTests = [];
                    if(!empty($user->aptitude_test_score) && isset($user->aptitude_test_score['total'])) $claimedTests[] = ['type' => 'Aptitude', 'title' => 'Cognitive Aptitude Assessment', 'score' => $user->aptitude_test_score['total'], 'slug' => 'aptitude'];
                    if(!empty($user->english_test_score) && isset($user->english_test_score['total'])) $claimedTests[] = ['type' => 'English', 'title' => 'English Grammar & Vocabulary', 'score' => $user->english_test_score['total'], 'slug' => 'english'];
                    if(!empty($user->speaking_test_score) && isset($user->speaking_test_score['total'])) $claimedTests[] = ['type' => 'Speaking', 'title' => 'Vocal Fluency Test', 'score' => $user->speaking_test_score['total'], 'slug' => 'speaking'];
                    if(!empty($user->reading_test_score) && isset($user->reading_test_score['total'])) $claimedTests[] = ['type' => 'Reading', 'title' => 'Language & Reading Comprehension', 'score' => $user->reading_test_score['total'], 'slug' => 'reading'];
                    if(!empty($user->written_test_score) && isset($user->written_test_score['total'])) $claimedTests[] = ['type' => 'Writing', 'title' => 'Written English Composition', 'score' => $user->written_test_score['total'], 'slug' => 'written'];
                    if(!empty($user->core_subject_score) && isset($user->core_subject_score['total'])) $claimedTests[] = ['type' => 'Core Stream', 'title' => 'Core Subject Expertise Quiz', 'score' => $user->core_subject_score['total'], 'slug' => 'core'];
                    if(!empty($user->coding_test_score) && isset($user->coding_test_score['total'])) $claimedTests[] = ['type' => 'Algorithms', 'title' => 'Practical Coding & Algorithms', 'score' => $user->coding_test_score['total'], 'slug' => 'coding'];
                @endphp

                <!-- Claimed Certificates list -->
                @foreach($claimedTests as $test)
                    <div class="glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-md flex justify-between items-start h-40 bg-gradient-to-r from-amber-500/5 to-transparent hover:-translate-y-1 transition-all">
                        <div class="space-y-2 flex-grow min-w-0 pr-4">
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/15 text-[9px] font-black uppercase tracking-wider">Claimed Certificate</span>
                            <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate mt-2">{{ $test['title'] }}</h3>
                            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">Secured Score: <strong class="text-amber-500">{{ $test['score'] }}%</strong></p>
                        </div>
                        <a href="{{ route('tests.certificate', $test['slug']) }}" target="_blank" class="flex-shrink-0 w-11 h-11 bg-amber-500/15 text-amber-500 hover:bg-amber-500 hover:text-white rounded-2xl flex items-center justify-center transition-all shadow-md">
                            <span class="material-symbols-outlined text-[20px]">workspace_premium</span>
                        </a>
                    </div>
                @endforeach

                <!-- Custom User logged Achievements -->
                @if(!empty($user->achievements))
                    @foreach($user->achievements as $ach)
                        @php
                            $colors = [
                                'hackathon' => ['label' => 'Technical Contest', 'color' => 'text-primary bg-primary/10 border-primary/15', 'icon' => 'terminal'],
                                'olympiad' => ['label' => 'Olympiad', 'color' => 'text-cyan-500 bg-cyan-500/10 border-cyan-500/15', 'icon' => 'psychology'],
                                'sports' => ['label' => 'Sports', 'color' => 'text-emerald-500 bg-emerald-500/10 border-emerald-500/15', 'icon' => 'directions_run'],
                                'research' => ['label' => 'Research Paper', 'color' => 'text-purple-500 bg-purple-500/10 border-purple-500/15', 'icon' => 'menu_book'],
                                'ncc' => ['label' => 'NCC Services', 'color' => 'text-red-500 bg-red-500/10 border-red-500/15', 'icon' => 'diversity_3'],
                                'certificate' => ['label' => 'Certification', 'color' => 'text-slate-500 bg-slate-500/10 border-slate-500/15', 'icon' => 'school']
                            ];
                            $meta = $colors[$ach['type']] ?? $colors['certificate'];
                        @endphp
                        <div class="glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-md flex justify-between items-start h-40 hover:-translate-y-1 transition-all">
                            <div class="space-y-1.5 flex-grow min-w-0 pr-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider {{ $meta['color'] }}">{{ $meta['label'] }}</span>
                                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate mt-2">{{ $ach['title'] }}</h3>
                                <strong class="text-[10px] text-slate-450 dark:text-slate-555 block font-bold truncate">{{ $ach['role'] }} ({{ $ach['year'] }})</strong>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 line-clamp-1 leading-normal">{{ $ach['description'] }}</p>
                            </div>
                            <span class="flex-shrink-0 w-11 h-11 bg-slate-100/40 dark:bg-slate-900/40 rounded-2xl flex items-center justify-center text-slate-450">
                                <span class="material-symbols-outlined text-[20px]">{{ $meta['icon'] }}</span>
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Empty slate -->
            @if(count($claimedTests) === 0 && empty($user->achievements))
                <div class="flex flex-col items-center justify-center py-20 text-center space-y-4 glass-card rounded-3xl border border-slate-200/50 dark:border-slate-800/50">
                    <span class="material-symbols-outlined text-[64px] text-slate-300 dark:text-slate-750">military_tech</span>
                    <div class="max-w-sm">
                        <h4 class="text-sm font-bold text-slate-800 dark:text-slate-300">Portfolio Vault Empty</h4>
                        <p class="text-xs text-slate-450 dark:text-slate-555 mt-1 font-semibold leading-relaxed">
                            Complete standardized assessments in the Test Center to claim premium gold credentials, or click "Log New Achievement" in the top header to manually save hackathons, papers, or sports awards.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Tab 4: Student Growth Timeline -->
        <div id="timeline-tab" class="tab-pane hidden space-y-8">
            <div class="relative pl-8 border-l-2 border-slate-250/20 dark:border-slate-800/50 space-y-8 max-w-2xl mx-auto py-4">
                @forelse($timelineEvents as $event)
                    @php
                        $catMeta = [
                            'system' => ['color' => 'bg-slate-500 text-white', 'icon' => 'login'],
                            'academic' => ['color' => 'bg-amber-500 text-white', 'icon' => 'school'],
                            'assessment' => ['color' => 'bg-primary text-white', 'icon' => 'quiz'],
                            'career' => ['color' => 'bg-purple-500 text-white', 'icon' => 'explore'],
                            'portfolio' => ['color' => 'bg-emerald-500 text-white', 'icon' => 'workspace_premium']
                        ];
                        $meta = $catMeta[$event['category']] ?? $catMeta['system'];
                        $formattedDate = date('M d, Y - H:i', strtotime($event['date']));
                    @endphp
                    
                    <div class="relative transition-all hover:translate-x-1">
                        <!-- Icon Dot -->
                        <span class="absolute -left-[45px] top-0 w-8 h-8 rounded-full {{ $meta['color'] }} border-4 border-white dark:border-slate-950 flex items-center justify-center shadow-md">
                            <span class="material-symbols-outlined text-[14px] font-black">{{ $meta['icon'] }}</span>
                        </span>
                        
                        <!-- Content Bubble -->
                        <div class="glass-card p-5 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-md space-y-1.5 bg-gradient-to-r from-slate-50/10 to-transparent">
                            <div class="flex justify-between items-center flex-wrap gap-2">
                                <strong class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ $formattedDate }}</strong>
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-900 border border-slate-200/20 text-[8px] font-black uppercase tracking-wider text-slate-500">{{ $event['category'] }}</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 mt-1">{{ $event['title'] }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-normal font-semibold">{{ $event['description'] }}</p>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-20 text-center space-y-4">
                        <span class="material-symbols-outlined text-[48px] text-slate-400">history</span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-350">Timeline Empty</h4>
                            <p class="text-xs text-slate-450 mt-1 font-semibold leading-relaxed">No chronological history logs logged yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<!-- Log Achievement Overlay Drawer -->
<div id="drawer-overlay" class="fixed inset-0 bg-slate-955/40 backdrop-blur-sm z-50 transition-all duration-300 hidden items-center justify-end no-print">
    <div class="w-full max-w-md h-full bg-white dark:bg-slate-900 shadow-2xl p-6 flex flex-col gap-6 relative border-l border-slate-200/50 dark:border-slate-800/50">
        <button onclick="toggleSubmissionDrawer(false)" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 material-symbols-outlined cursor-pointer">close</button>
        
        <div class="mt-4 border-b border-slate-200/40 dark:border-slate-800/40 pb-3">
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">emoji_events</span>
                <span>Log Achievement</span>
            </h3>
            <p class="text-xs text-slate-450 mt-1 font-medium">Record Olympiad rank, sports levels, NCC certificates, or research papers.</p>
        </div>

        <form id="add-achievement-form" class="space-y-4 flex-grow overflow-y-auto pr-1">
            @csrf
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider" for="type">Achievement Type</label>
                <select id="type" name="type" class="w-full rounded-xl p-3 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-850 outline-none text-xs font-semibold" required>
                    <option value="certificate">Certification / Training</option>
                    <option value="hackathon">Hackathon / Technical Competition</option>
                    <option value="olympiad">Olympiad / Academic Contest</option>
                    <option value="sports">Sports / Extracurricular Level</option>
                    <option value="research">Research Publication / Patent</option>
                    <option value="ncc">National Cadet Corps (NCC) / Social Service</option>
                </select>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider" for="title">Title / Name</label>
                <input type="text" id="title" name="title" placeholder="e.g. Smart India Hackathon 2025" class="w-full rounded-xl p-3 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-850 outline-none text-xs font-semibold" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider" for="role">Role / Rank / Award</label>
                    <input type="text" id="role" name="role" placeholder="e.g. Team Lead / Winner / Gold Medalist" class="w-full rounded-xl p-3 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-850 outline-none text-xs font-semibold" required>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider" for="year">Year Secured</label>
                    <input type="number" id="year" name="year" min="2020" max="2030" value="2025" class="w-full rounded-xl p-3 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-850 outline-none text-xs font-semibold" required>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider" for="description">Detailed Description</label>
                <textarea id="description" name="description" placeholder="Briefly summarize your key contributions and outcomes..." class="w-full rounded-xl p-3 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-850 outline-none text-xs font-semibold h-24 resize-none leading-relaxed" required></textarea>
            </div>

            <button type="submit" id="submit-ach-btn" class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white font-extrabold text-xs rounded-xl shadow-lg hover:shadow-primary/20 transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                <span>Submit & Log Achievement</span>
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Sleek and highly responsive Tab Navigation Switcher logic
    function switchTab(tabId) {
        // Hide all panes
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.add('hidden');
        });
        
        // Show selected pane
        const activePane = document.getElementById(tabId);
        if (activePane) {
            activePane.classList.remove('hidden');
        }

        // Handle 'Log New Achievement' header button visibility (Only shown in Portfolio tab)
        const logBtn = document.getElementById('header-log-btn');
        if (logBtn) {
            if (tabId === 'portfolio-tab') {
                logBtn.classList.remove('hidden');
            } else {
                logBtn.classList.add('hidden');
            }
        }

        // Toggle active border-b / text color classes on navigation triggers
        document.querySelectorAll('.tab-trigger').forEach(tab => {
            tab.classList.remove('border-primary', 'text-primary', 'dark:text-cyan-accent', 'border-b-2');
            tab.classList.add('text-slate-400', 'border-transparent');
        });

        const activeTrigger = document.querySelector(`[data-tab="${tabId}"]`);
        if (activeTrigger) {
            activeTrigger.classList.add('border-primary', 'text-primary', 'dark:text-cyan-accent', 'border-b-2');
            activeTrigger.classList.remove('text-slate-400', 'border-transparent');
        }

        // Save active tab selection persistently inside localStorage
        localStorage.setItem('active_career_tab', tabId);
    }

    // Persist tab selector on load
    document.addEventListener('DOMContentLoaded', () => {
        const activeTab = localStorage.getItem('active_career_tab') || 'readiness-tab';
        switchTab(activeTab);
    });

    // Uploader visual drag-and-drop triggers
    const dropArea = document.getElementById('drag-drop-area');
    const fileInput = document.getElementById('resume_file');
    const fileInfoBar = document.getElementById('file-info-bar');
    const fileNameTxt = document.getElementById('file-name-txt');

    if (dropArea && fileInput) {
        dropArea.addEventListener('click', () => fileInput.click());

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('border-primary', 'bg-primary/5');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('border-primary', 'bg-primary/5');
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('border-primary', 'bg-primary/5');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                updateFileInfo();
            }
        });

        fileInput.addEventListener('change', updateFileInfo);
    }

    function updateFileInfo() {
        if (fileInput.files.length) {
            fileNameTxt.innerText = fileInput.files[0].name;
            fileInfoBar.classList.remove('hidden');
        }
    }

    function clearFile() {
        fileInput.value = '';
        fileInfoBar.classList.add('hidden');
    }

    // Handle AJAX Resume analysis form submit
    document.getElementById('resume-upload-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('upload-submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
            Analyzing PDF structure...
        `;

        const formData = new FormData();
        formData.append('resume_file', fileInput.files[0]);

        fetch("{{ route('career.resume.analyze') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Evaluation Complete', data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                showToast('Upload Failure', 'Failed to process PDF structure.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerText = 'Run ATS Analyzer';
            }
        })
        .catch(() => {
            showToast('Network Error', 'Connection failed. Check server status.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerText = 'Run ATS Analyzer';
        });
    });

    // Manually log achievements overlays
    function toggleSubmissionDrawer(open) {
        const overlay = document.getElementById('drawer-overlay');
        if (overlay) {
            if (open) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                document.getElementById('title').focus();
            } else {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }
        }
    }

    // Log achievement via AJAX
    document.getElementById('add-achievement-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const btn = document.getElementById('submit-ach-btn');
        btn.disabled = true;
        btn.innerHTML = `
            <span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
            Logging credentials...
        `;

        fetch("{{ route('career.portfolio.add') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                type: document.getElementById('type').value,
                title: document.getElementById('title').value,
                role: document.getElementById('role').value,
                year: parseInt(document.getElementById('year').value),
                description: document.getElementById('description').value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Achievement Logged!', data.message, 'success');
                toggleSubmissionDrawer(false);
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                showToast('Error', 'Unable to record achievement.', 'error');
                btn.disabled = false;
                btn.innerHTML = 'Submit & Log Achievement';
            }
        })
        .catch(() => {
            showToast('Network Error', 'Connection failed. Check server status.', 'error');
            btn.disabled = false;
            btn.innerHTML = 'Submit & Log Achievement';
        });
    });
</script>
@endsection
