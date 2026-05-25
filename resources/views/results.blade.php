@extends('layouts.app')

@section('title', 'Academic Potential - Evaluation Result')

@section('styles')
<style>
    .radar-grid {
        stroke: rgba(148, 163, 184, 0.2);
        stroke-width: 1;
        fill: none;
    }
    .dark .radar-grid {
        stroke: rgba(255, 255, 255, 0.08);
    }
    .radar-area {
        fill: rgba(99, 102, 241, 0.15);
        stroke: #6366f1;
        stroke-width: 2.5;
        filter: drop-shadow(0 0 8px rgba(99, 102, 241, 0.5));
    }
    .dark .radar-area {
        fill: rgba(6, 182, 212, 0.15);
        stroke: #06b6d4;
        filter: drop-shadow(0 0 8px rgba(6, 182, 212, 0.5));
    }
</style>
@endsection

@section('content')
@php
    // Calculate dynamic radar coordinates
    $s1 = $evaluation->data_synthesis;       // Technical Proficiency
    $s2 = $evaluation->cognitive_agility;     // Analytical Depth
    $s3 = $evaluation->problem_decomposition; // Leadership
    $s4 = $evaluation->academic_influence;    // Adaptability
    $s5 = $evaluation->communication_rating;  // Communication

    // V1 (Top): Technical Proficiency (center 100,100 upwards to y=20)
    $v1_x = 100;
    $v1_y = 100 - (80 * ($s1 / 10));

    // V2 (Left): Analytical Depth (dx max -80, dy max -20)
    $v2_x = 100 - (80 * ($s2 / 10));
    $v2_y = 100 - (20 * ($s2 / 10));

    // V3 (Bottom-Left): Adaptability (dx max -50, dy max +70)
    $v3_x = 100 - (50 * ($s4 / 10));
    $v3_y = 100 + (70 * ($s4 / 10));

    // V4 (Bottom-Right): Leadership (dx max +50, dy max +70)
    $v4_x = 100 + (50 * ($s3 / 10));
    $v4_y = 100 + (70 * ($s3 / 10));

    // V5 (Right): Communication (dx max +80, dy max -20)
    $v5_x = 100 + (80 * ($s5 / 10));
    $v5_y = 100 - (20 * ($s5 / 10));

    $radar_points = "{$v1_x},{$v1_y} {$v2_x},{$v2_y} {$v3_x},{$v3_y} {$v4_x},{$v4_y} {$v5_x},{$v5_y}";

    // Retrieve sub-document collections with robust default fallbacks
    $aiData = $evaluation->ai ?? [];
    $strengths = $aiData['strengths'] ?? ['Grade stability', 'Aptitude benchmarks'];
    $weaknesses = $aiData['weaknesses'] ?? ['Lacks active capstone projects', 'Fewer verified tech skills'];
    $recommendations = $aiData['recommendations'] ?? ['Deploy an open-source tool on GitHub', 'Engage in corporate internships'];

    // 3-Year academic performance mapping
    $acadHistory = $evaluation->academic_history ?? [];
    $hasHistory = !empty($acadHistory) && count($acadHistory) === 3;
    
    // Default mock data if empty
    $h1 = $hasHistory ? $acadHistory[0] : ['year' => 'Class 9th', 'subjects' => [['subject'=>'Math','marks'=>80],['subject'=>'Science','marks'=>82],['subject'=>'Humanities','marks'=>78]]];
    $h2 = $hasHistory ? $acadHistory[1] : ['year' => 'Class 10th', 'subjects' => [['subject'=>'Math','marks'=>84],['subject'=>'Science','marks'=>86],['subject'=>'Humanities','marks'=>82]]];
    $h3 = $hasHistory ? $acadHistory[2] : ['year' => 'Class 11th', 'subjects' => [['subject'=>'Math','marks'=>88],['subject'=>'Science','marks'=>89],['subject'=>'Humanities','marks'=>85]]];

    $y1_name = $h1['year'] ?? 'Year 1';
    $y2_name = $h2['year'] ?? 'Year 2';
    $y3_name = $h3['year'] ?? 'Year 3';

    // Helper function to safely extract marks
    $getMarks = function($h, $subject) {
        $subs = $h['subjects'] ?? [];
        foreach ($subs as $s) {
            if (isset($s['subject']) && strtolower($s['subject']) === strtolower($subject)) {
                return (int)$s['marks'];
            }
        }
        return 80; // default fallback
    };

    $m1_math = $getMarks($h1, 'Math');
    $m1_sci = $getMarks($h1, 'Science');
    $m1_hum = $getMarks($h1, 'Humanities');

    $m2_math = $getMarks($h2, 'Math');
    $m2_sci = $getMarks($h2, 'Science');
    $m2_hum = $getMarks($h2, 'Humanities');

    $m3_math = $getMarks($h3, 'Math');
    $m3_sci = $getMarks($h3, 'Science');
    $m3_hum = $getMarks($h3, 'Humanities');

    // Map 0-100 to y coordinates: y = 140 - (marks * 1.1)
    $math_pts = "50," . (140 - ($m1_math * 1.1)) . " 200," . (140 - ($m2_math * 1.1)) . " 350," . (140 - ($m3_math * 1.1));
    $sci_pts = "50," . (140 - ($m1_sci * 1.1)) . " 200," . (140 - ($m2_sci * 1.1)) . " 350," . (140 - ($m3_sci * 1.1));
    $hum_pts = "50," . (140 - ($m1_hum * 1.1)) . " 200," . (140 - ($m2_hum * 1.1)) . " 350," . (140 - ($m3_hum * 1.1));

    // Sectional Aptitude scores
    $hasAptitudeDetails = !empty($evaluation->aptitude) && isset($evaluation->aptitude['quant']);
    $aptDetails = $evaluation->aptitude ?? [];

    // Verified Reading scores from profile
    $readingDetails = Auth::user()->reading_test_score ?? null;
@endphp

<div class="p-6 lg:p-8 max-w-7xl mx-auto">
    <!-- Header Section with Print/Action buttons -->
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-6 mt-6 print:hidden">
        <div>
            <nav class="flex gap-1.5 text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">
                <span>Portal Hub</span>
                <span>/</span>
                <span>Predictions</span>
                <span>/</span>
                <span class="text-primary dark:text-cyan-accent">Result Report</span>
            </nav>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100">Prediction Report</h2>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">print</span>
                Print Report
            </button>
            <a href="{{ route('evaluation.report.download', $evaluation->id) }}" target="_blank" class="px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                Download PDF
            </a>
            <button onclick="shareResult()" class="px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5 shadow-sm relative">
                <span class="material-symbols-outlined text-[18px]">share</span>
                Share Result
                <span id="shareToast" class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] px-2 py-1 rounded hidden font-bold">Link Copied!</span>
            </button>
            <a href="{{ route('evaluation.form') }}" class="px-5 py-2.5 bg-primary hover:bg-primary-hover text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:opacity-90 transition-all flex items-center gap-1.5 shadow-lg shadow-primary/20 active:scale-95">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                New Evaluation
            </a>
        </div>
    </header>

    <!-- Hero Stats Bento -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        <!-- Radial Probability Gauge Card -->
        <div class="lg:col-span-4 glass-card rounded-2xl p-6 flex flex-col justify-between items-center text-center min-h-[260px] border border-slate-200/50 dark:border-slate-800/50">
            <div class="w-full text-left">
                <span class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-widest block">Model Output classification</span>
                <h3 class="text-xl sm:text-2xl mt-1 text-primary dark:text-cyan-accent font-black tracking-tight">{{ $evaluation->potential_class }}</h3>
            </div>
            
            <!-- Radial Gauge -->
            <div class="relative w-36 h-36 my-4 flex items-center justify-center">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="40" fill="none" stroke="rgba(148, 163, 184, 0.08)" stroke-width="8"></circle>
                    @php
                        $dashArray = 2 * pi() * 40;
                        $dashOffset = $dashArray - ($dashArray * ($evaluation->probability_score / 100));
                    @endphp
                    <circle cx="50" cy="50" r="40" fill="none" stroke="url(#radialGlow)" stroke-width="8" stroke-dasharray="{{ $dashArray }}" stroke-dashoffset="{{ $dashOffset }}" stroke-linecap="round" class="transition-all duration-1000"></circle>
                    <defs>
                        <linearGradient id="radialGlow" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#6366f1"></stop>
                            <stop offset="100%" stop-color="#06b6d4"></stop>
                        </linearGradient>
                    </defs>
                </svg>
                <div class="absolute flex flex-col items-center justify-center">
                    <span class="text-3xl font-black text-slate-800 dark:text-slate-100">{{ $evaluation->probability_score }}%</span>
                    <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mt-0.5">FIT INDEX</span>
                </div>
            </div>
        </div>

        <!-- AI Explanation Section & Confidence Meter -->
        <div class="lg:col-span-8 glass-card rounded-2xl p-6 flex flex-col justify-between min-h-[260px] border border-slate-200/50 dark:border-slate-800/50 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-primary/5 dark:bg-cyan-accent/5 rounded-full blur-3xl pointer-events-none"></div>
            <div>
                <h4 class="text-lg text-slate-800 dark:text-slate-100 font-bold mb-3">AI Diagnostic Summary</h4>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm">
                    Candidate <strong>{{ $evaluation->candidate_name }}</strong> has been mapped through multi-layered neural synapse propagation matrices. 
                    The external FastAPI predictive model processed all variables (CGPA: {{ number_format($evaluation->cgpa, 2) }}, Aptitude: {{ $evaluation->aptitude_score }}%) and converging on a target match in the <strong>{{ $evaluation->recommended_track }}</strong> segment.
                </p>
            </div>

            <!-- Confidence Meter -->
            <div class="mt-6 border-t border-slate-200/30 dark:border-slate-800/30 pt-4 w-full">
                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest block mb-2">ANN Model Confidence Meter</span>
                <div class="grid grid-cols-4 gap-2">
                    <div class="h-2 rounded-full {{ $evaluation->probability_score >= 30 ? 'bg-amber-500' : 'bg-slate-200 dark:bg-slate-800' }}"></div>
                    <div class="h-2 rounded-full {{ $evaluation->probability_score >= 50 ? 'bg-cyan-500' : 'bg-slate-200 dark:bg-slate-800' }}"></div>
                    <div class="h-2 rounded-full {{ $evaluation->probability_score >= 75 ? 'bg-primary' : 'bg-slate-200 dark:bg-slate-800' }}"></div>
                    <div class="h-2 rounded-full {{ $evaluation->probability_score >= 90 ? 'bg-purple-500' : 'bg-slate-200 dark:bg-slate-800' }}"></div>
                </div>
                <div class="flex justify-between text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-1.5">
                    <span>Developing</span><span>Moderate</span><span>High</span><span>Elite FIT</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi-Year Performance & Verified Diagnostic Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- 3-Year Academic Growth Trend (SVG Line Graph) -->
        <div class="glass-card rounded-2xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between">
            <div>
                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary dark:text-cyan-accent">trending_up</span>
                    3-Year Academic Performance History Logs
                </h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    @if($hasHistory)
                        Subject marks recorded for {{ $y1_name }}, {{ $y2_name }}, and {{ $y3_name }}.
                    @else
                        Mock baseline trend calculated. Take evaluations with historical data for dynamic trends.
                    @endif
                </p>
            </div>
            
            <div class="relative h-[180px] flex items-center justify-center mt-4">
                <svg class="w-full h-full max-w-[380px]" viewBox="0 0 400 180">
                    <!-- Grid Lines -->
                    <line x1="50" y1="30" x2="350" y2="30" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1" stroke-dasharray="4 4"></line>
                    <line x1="50" y1="85" x2="350" y2="85" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1" stroke-dasharray="4 4"></line>
                    <line x1="50" y1="140" x2="350" y2="140" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1"></line>
                    
                    <!-- Vertical grid lines -->
                    <line x1="50" y1="30" x2="50" y2="140" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1"></line>
                    <line x1="200" y1="30" x2="200" y2="140" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1" stroke-dasharray="2 2"></line>
                    <line x1="350" y1="30" x2="350" y2="140" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1"></line>
                    
                    <!-- Polyline Trends -->
                    <!-- Math (indigo) -->
                    <polyline fill="none" stroke="#6366f1" stroke-width="3" stroke-linecap="round" points="{{ $math_pts }}"></polyline>
                    <!-- Science (cyan) -->
                    <polyline fill="none" stroke="#06b6d4" stroke-width="3" stroke-linecap="round" points="{{ $sci_pts }}"></polyline>
                    <!-- Humanities (purple) -->
                    <polyline fill="none" stroke="#a855f7" stroke-width="3" stroke-linecap="round" points="{{ $hum_pts }}"></polyline>
                    
                    <!-- Points Math -->
                    <circle cx="50" cy="{{ 140 - ($m1_math * 1.1) }}" r="4" fill="#6366f1"></circle>
                    <circle cx="200" cy="{{ 140 - ($m2_math * 1.1) }}" r="4" fill="#6366f1"></circle>
                    <circle cx="350" cy="{{ 140 - ($m3_math * 1.1) }}" r="4" fill="#6366f1"></circle>
                    
                    <!-- Points Science -->
                    <circle cx="50" cy="{{ 140 - ($m1_sci * 1.1) }}" r="4" fill="#06b6d4"></circle>
                    <circle cx="200" cy="{{ 140 - ($m2_sci * 1.1) }}" r="4" fill="#06b6d4"></circle>
                    <circle cx="350" cy="{{ 140 - ($m3_sci * 1.1) }}" r="4" fill="#06b6d4"></circle>
                    
                    <!-- Points Humanities -->
                    <circle cx="50" cy="{{ 140 - ($m1_hum * 1.1) }}" r="4" fill="#a855f7"></circle>
                    <circle cx="200" cy="{{ 140 - ($m2_hum * 1.1) }}" r="4" fill="#a855f7"></circle>
                    <circle cx="350" cy="{{ 140 - ($m3_hum * 1.1) }}" r="4" fill="#a855f7"></circle>
                    
                    <!-- Text Labels -->
                    <text x="50" y="160" text-anchor="middle" font-size="9" font-weight="bold" fill="#94a3b8">{{ $y1_name }}</text>
                    <text x="200" y="160" text-anchor="middle" font-size="9" font-weight="bold" fill="#94a3b8">{{ $y2_name }}</text>
                    <text x="350" y="160" text-anchor="middle" font-size="9" font-weight="bold" fill="#94a3b8">{{ $y3_name }}</text>
                    
                    <text x="45" y="33" text-anchor="end" font-size="8" font-weight="bold" fill="#94a3b8">100%</text>
                    <text x="45" y="88" text-anchor="end" font-size="8" font-weight="bold" fill="#94a3b8">50%</text>
                    <text x="45" y="143" text-anchor="end" font-size="8" font-weight="bold" fill="#94a3b8">0%</text>
                </svg>
            </div>
            <div class="flex justify-center gap-4 text-[9px] font-bold uppercase tracking-wider mt-4">
                <span class="flex items-center gap-1.5 text-[#6366f1]"><span class="w-2 rounded-full h-2 bg-[#6366f1]"></span> Mathematics</span>
                <span class="flex items-center gap-1.5 text-[#06b6d4]"><span class="w-2 rounded-full h-2 bg-[#06b6d4]"></span> Science & Tech</span>
                <span class="flex items-center gap-1.5 text-[#a855f7]"><span class="w-2 rounded-full h-2 bg-[#a855f7]"></span> Humanities</span>
            </div>
        </div>

        <!-- Sectional Aptitude & Verified Diagnostic Details -->
        <div class="glass-card rounded-2xl p-6 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between">
            <div>
                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary dark:text-cyan-accent">verified_user</span>
                    Verified Profile Test Diagnostics
                </h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Cross-referenced scores from active profile assessments.</p>
            </div>
            
            <div class="space-y-4 flex-grow mt-4">
                <!-- 1. Aptitude details -->
                @if($hasAptitudeDetails)
                    <div class="space-y-2">
                        <strong class="text-xs font-black text-indigo-500 uppercase tracking-wider block">Verified Sectional Cognitive Reasoning</strong>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="bg-indigo-500/5 dark:bg-indigo-500/10 p-3 rounded-xl border border-indigo-500/10 text-center">
                                <span class="text-[9px] text-slate-400 font-bold block uppercase">Quantitative</span>
                                <strong class="text-base text-slate-800 dark:text-slate-200 font-black">{{ $aptDetails['quant'] }}%</strong>
                            </div>
                            <div class="bg-indigo-500/5 dark:bg-indigo-500/10 p-3 rounded-xl border border-indigo-500/10 text-center">
                                <span class="text-[9px] text-slate-400 font-bold block uppercase">Logical</span>
                                <strong class="text-base text-slate-800 dark:text-slate-200 font-black">{{ $aptDetails['logical'] }}%</strong>
                            </div>
                            <div class="bg-indigo-500/5 dark:bg-indigo-500/10 p-3 rounded-xl border border-indigo-500/10 text-center">
                                <span class="text-[9px] text-slate-400 font-bold block uppercase">Verbal</span>
                                <strong class="text-base text-slate-800 dark:text-slate-200 font-black">{{ $aptDetails['verbal'] }}%</strong>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-3 bg-indigo-500/5 dark:bg-indigo-500/10 rounded-xl border border-indigo-500/10 text-[11px] text-slate-400 font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-indigo-500">lock_open</span>
                        Cognitive Aptitude sectional details not yet synced from the Test Center.
                    </div>
                @endif

                <!-- 2. Reading Test details -->
                @if($readingDetails)
                    <div class="p-4 bg-cyan-500/5 dark:bg-cyan-500/10 rounded-xl border border-cyan-550/15 flex justify-between items-center gap-4">
                        <div>
                            <span class="text-[10px] text-cyan-600 dark:text-cyan-400 font-black uppercase tracking-wider block">Verified Information Intake Speed</span>
                            <strong class="text-lg text-slate-800 dark:text-slate-250 font-black block mt-0.5">{{ $readingDetails['wpm'] }} WPM</strong>
                            <span class="text-[9px] text-slate-400 font-bold uppercase block mt-0.5">Comprehension accuracy: {{ $readingDetails['accuracy'] }}%</span>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-cyan-500/15 flex items-center justify-center text-cyan-500">
                            <span class="material-symbols-outlined">speed</span>
                        </div>
                    </div>
                @else
                    <div class="p-3 bg-cyan-500/5 dark:bg-cyan-500/10 rounded-xl border border-cyan-500/10 text-[11px] text-slate-400 font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-cyan-500">lock_open</span>
                        Reading Stopwatch Speed metrics not yet synced from the Test Center.
                    </div>
                @endif

                <!-- 3. Stress details -->
                @if($evaluation->user && $evaluation->user->stress_survey_score)
                    @php $stress = $evaluation->user->stress_survey_score; @endphp
                    <div class="p-4 bg-emerald-500/5 dark:bg-emerald-500/10 rounded-xl border border-emerald-500/15 flex justify-between items-center gap-4">
                        <div>
                            <span class="text-[10px] text-emerald-650 dark:text-emerald-450 font-black uppercase tracking-wider block">Verified Workload Coping Efficacy</span>
                            <strong class="text-lg text-slate-800 dark:text-slate-250 font-black block mt-0.5">Coping Wellness: {{ $stress['pressure'] }}%</strong>
                            <span class="text-[9px] text-slate-400 font-bold uppercase block mt-0.5">Academic Readiness Index: {{ $stress['readiness'] }}%</span>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-emerald-500/15 flex items-center justify-center text-emerald-500">
                            <span class="material-symbols-outlined">psychiatry</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recommended Career Tracks Bento Banner -->
    <div class="glass-card rounded-2xl p-6 border border-slate-200/50 dark:border-slate-800/50 mb-6 bg-gradient-to-r from-cyan-500/5 to-indigo-500/5">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-primary dark:text-cyan-accent text-[28px]">explore</span>
            <div>
                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100">Recommended Professional Alignment Mappings</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">Top career tracks calculated from cognitive, academic, and portfolio parameters.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @php
                $careers = $evaluation->career_recommendations ?? ['Software Developer / Engineer', 'Technical Analyst'];
            @endphp
            @foreach($careers as $career)
                <div class="p-5 rounded-2xl bg-white/40 dark:bg-slate-900/40 border border-slate-200/30 dark:border-slate-800/30 hover:border-primary/30 transition-all flex items-start gap-4 hover:shadow-lg group">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary dark:text-cyan-accent group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">work</span>
                    </div>
                    <div>
                        <strong class="text-sm font-bold text-slate-800 dark:text-slate-250 block group-hover:text-primary transition-colors">{{ $career }}</strong>
                        <p class="text-[11px] text-slate-500 dark:text-slate-450 mt-1">Excellent job growth prospectus matching dynamic skills indices.</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Analysis Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Radar Chart Card -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between border border-slate-200/50 dark:border-slate-800/50">
            <div class="flex justify-between items-center mb-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-4">
                <div>
                    <h4 class="text-xl text-slate-800 dark:text-slate-100 font-bold">Cognitive Skill Map</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">5-axis vector output representation.</p>
                </div>
                <span class="material-symbols-outlined text-slate-400 dark:text-slate-500 text-[24px]">radar</span>
            </div>
            
            <div class="relative h-[300px] flex items-center justify-center mt-6">
                <!-- SVG Radar Chart -->
                <svg class="w-full h-full max-w-[280px]" viewBox="0 0 200 200">
                    <!-- Grid Polygons -->
                    <polygon class="radar-grid" points="100,20 180,80 150,170 50,170 20,80"></polygon>
                    <polygon class="radar-grid" points="100,40 160,85 140,150 60,150 40,85"></polygon>
                    <polygon class="radar-grid" points="100,60 140,90 125,130 75,130 60,90"></polygon>
                    <polygon class="radar-grid" points="100,80 120,95 112,115 88,115 80,95"></polygon>
                    
                    <!-- Axes -->
                    <line class="radar-grid" x1="100" x2="100" y1="100" y2="20"></line>
                    <line class="radar-grid" x1="100" x2="20" y1="100" y2="80"></line>
                    <line class="radar-grid" x1="100" x2="50" y1="100" y2="170"></line>
                    <line class="radar-grid" x1="100" x2="150" y1="100" y2="170"></line>
                    <line class="radar-grid" x1="100" x2="180" y1="100" y2="80"></line>
                    
                    <!-- Dynamic Area -->
                    <polygon class="radar-area" points="{{ $radar_points }}"></polygon>
                </svg>
                
                <!-- Axis Labels -->
                <div class="absolute inset-0 flex flex-col justify-between p-1 text-[9px] font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-wide pointer-events-none">
                    <div class="text-center">Technical Proficiency</div>
                    <div class="flex justify-between px-1">
                        <span>Analytical Depth</span>
                        <span>Communication</span>
                    </div>
                    <div class="flex justify-around mb-8 px-4">
                        <span>Adaptability</span>
                        <span>Leadership</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between border border-slate-200/50 dark:border-slate-800/50">
            <div class="flex justify-between items-center mb-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-4">
                <div>
                    <h4 class="text-xl text-slate-800 dark:text-slate-100 font-bold">Calculated Indices</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Detailed scale metrics evaluated from models.</p>
                </div>
                <span class="material-symbols-outlined text-slate-400 dark:text-slate-500 text-[24px]">bar_chart</span>
            </div>
            
            <div class="space-y-3 flex-grow flex flex-col justify-center py-3">
                <div>
                    <div class="flex justify-between mb-1 text-slate-700 dark:text-slate-300 text-sm font-semibold">
                        <span>Cognitive Agility (GPA & Aptitude)</span>
                        <span class="text-primary dark:text-cyan-accent font-bold">{{ number_format($evaluation->cognitive_agility, 1) }} / 10.0</span>
                    </div>
                    <div class="h-2.5 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary to-cyan-accent rounded-full" style="width: {{ $evaluation->cognitive_agility * 10 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1 text-slate-700 dark:text-slate-300 text-sm font-semibold">
                        <span>Data Synthesis (Skills & Certs)</span>
                        <span class="text-primary dark:text-cyan-accent font-bold">{{ number_format($evaluation->data_synthesis, 1) }} / 10.0</span>
                    </div>
                    <div class="h-2.5 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary to-cyan-accent rounded-full" style="width: {{ $evaluation->data_synthesis * 10 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1 text-slate-700 dark:text-slate-300 text-sm font-semibold">
                        <span>Problem Decomposition (Projects & Internships)</span>
                        <span class="text-primary dark:text-cyan-accent font-bold">{{ number_format($evaluation->problem_decomposition, 1) }} / 10.0</span>
                    </div>
                    <div class="h-2.5 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary to-cyan-accent rounded-full" style="width: {{ $evaluation->problem_decomposition * 10 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1 text-slate-700 dark:text-slate-300 text-sm font-semibold">
                        <span>Academic Influence (Extracurricular & Leadership)</span>
                        <span class="text-primary dark:text-cyan-accent font-bold">{{ number_format($evaluation->academic_influence, 1) }} / 10.0</span>
                    </div>
                    <div class="h-2.5 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary to-cyan-accent rounded-full" style="width: {{ $evaluation->academic_influence * 10 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Strengths & Growth Areas Bento -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Strengths Card -->
        <div class="bg-primary/5 dark:bg-primary/10 rounded-2xl p-6 border border-primary/20 shadow-sm">
            <h5 class="text-xs text-primary dark:text-cyan-accent mb-6 flex items-center gap-2 font-black uppercase tracking-widest">
                <span class="material-symbols-outlined text-[20px] font-bold">verified</span>
                STRENGTH ARCHITECTURE
            </h5>
            <ul class="space-y-4 text-sm text-slate-600 dark:text-slate-300">
                @foreach ($strengths as $strength)
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-primary dark:text-cyan-accent text-[18px] mt-0.5">check_circle</span>
                        <p class="font-medium">{{ $strength }}</p>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Growth Areas Card -->
        <div class="bg-purple-accent/5 dark:bg-purple-accent/10 rounded-2xl p-6 border border-purple-accent/20 shadow-sm">
            <h5 class="text-xs text-purple-600 dark:text-purple-400 mb-6 flex items-center gap-2 font-black uppercase tracking-widest">
                <span class="material-symbols-outlined text-[20px] font-bold">warning</span>
                GROWTH OPPORTUNITIES
            </h5>
            <ul class="space-y-4 text-sm text-slate-600 dark:text-slate-300">
                @foreach ($weaknesses as $weakness)
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-[18px] mt-0.5">info</span>
                        <p class="font-medium">{{ $weakness }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Skill Improvement Roadmap & Actionable Strategy -->
    <div class="glass-card rounded-2xl p-6 mb-8 border border-slate-200/50 dark:border-slate-800/50">
        <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary dark:text-cyan-accent">map</span>
            Skill Improvement Roadmap & Recommendations
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($recommendations as $index => $rec)
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200/30 dark:border-slate-800/30 flex flex-col gap-2 relative">
                    <span class="absolute top-2 right-4 text-3xl font-black text-slate-200 dark:text-slate-800/60 pointer-events-none">0{{ $index + 1 }}</span>
                    <span class="material-symbols-outlined text-primary dark:text-cyan-accent text-[28px] mb-1">auto_awesome</span>
                    <h6 class="text-xs text-slate-400 font-extrabold uppercase tracking-wider">Action Step</h6>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-semibold leading-relaxed">{{ $rec }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function shareResult() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            const toast = document.getElementById('shareToast');
            if (toast) {
                toast.classList.remove('hidden');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 2000);
            }
        }).catch(err => {
            console.error('Clipboard copy error', err);
        });
    }
</script>
@endsection
