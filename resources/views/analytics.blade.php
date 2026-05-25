@extends('layouts.app')

@section('title', 'Interactive Analytics | Evaluating Academic Potential')

@section('content')
<div class="p-6 lg:p-8 max-w-7xl mx-auto flex flex-col gap-6">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end mb-4 gap-6 mt-6 print:hidden">
        <div>
            <nav class="flex gap-1.5 text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">
                <span>Portal Hub</span>
                <span>/</span>
                <span class="text-primary dark:text-cyan-accent">Interactive Analytics</span>
            </nav>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100">Platform Analytics</h2>
            <p class="text-slate-500 dark:text-slate-400 max-w-2xl mt-1 text-sm">Analyze multi-layer artificial neural network (ANN) accuracy scales, student cohort segmentation, and departmental performance matrices.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">print</span>
                Print Metrics
            </button>
        </div>
    </header>

    <!-- KPI Widgets Grid -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-1">
        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-36 border border-slate-200/50 dark:border-slate-800/50">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-primary/10 dark:bg-primary/20 rounded-lg text-primary dark:text-cyan-accent">
                    <span class="material-symbols-outlined text-[24px]">troubleshoot</span>
                </span>
                <span class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Precision</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-semibold">Average Model Fit</span>
                <span class="text-2xl font-black text-slate-800 dark:text-slate-100 block mt-1">{{ $avgAccuracy }}%</span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-36 border border-slate-200/50 dark:border-slate-800/50">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-cyan-500/10 dark:bg-cyan-500/20 rounded-lg text-cyan-600 dark:text-cyan-400">
                    <span class="material-symbols-outlined text-[24px]">group</span>
                </span>
                <span class="text-cyan-500 text-xs font-bold uppercase tracking-wider">Cohort</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-semibold">Total Evaluated Cases</span>
                <span class="text-2xl font-black text-slate-800 dark:text-slate-100 block mt-1">{{ number_format($totalCandidates) }}</span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-36 border border-slate-200/50 dark:border-slate-800/50">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-purple-500/10 dark:bg-purple-500/20 rounded-lg text-purple-600 dark:text-purple-400">
                    <span class="material-symbols-outlined text-[24px]">network_intelligence</span>
                </span>
                <span class="text-purple-500 text-xs font-bold uppercase tracking-wider">Sigmoid</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-semibold">Activation Fit Index</span>
                <span class="text-2xl font-black text-slate-800 dark:text-slate-100 block mt-1">98.4% Fit</span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-36 border border-slate-200/50 dark:border-slate-800/50">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-amber-500/10 dark:bg-amber-500/20 rounded-lg text-amber-600 dark:text-amber-400">
                    <span class="material-symbols-outlined text-[24px]">auto_stories</span>
                </span>
                <span class="text-amber-500 text-xs font-bold uppercase tracking-wider">GPA Index</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-semibold">Average Cohort CGPA</span>
                <span class="text-2xl font-black text-slate-800 dark:text-slate-100 block mt-1">{{ number_format($avgCgpa, 2) }}</span>
            </div>
        </div>
    </section>

    <!-- Detailed Charts Bento Grid -->
    <div class="grid grid-cols-12 gap-6">
        <!-- Prediction Trend Line Chart -->
        <div class="col-span-12 lg:col-span-8 glass-card p-6 rounded-2xl flex flex-col justify-between border border-slate-200/50 dark:border-slate-800/50">
            <div class="flex justify-between items-center mb-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-4">
                <div>
                    <h3 class="text-xl text-slate-800 dark:text-slate-100 font-bold">Prediction Trend</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Model activation thresholds and convergence trajectory.</p>
                </div>
                <div class="flex gap-3 text-[10px] font-bold uppercase tracking-wide">
                    <div class="flex items-center gap-1">
                        <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                        <span class="text-slate-600 dark:text-slate-400">Convergence Target</span>
                    </div>
                </div>
            </div>
            <div class="h-[280px] w-full relative flex items-end justify-between px-3 overflow-hidden">
                <!-- SVG Chart -->
                <svg class="absolute inset-0 w-full h-[240px]" viewBox="0 0 800 240" preserveAspectRatio="none">
                    <path d="M0 200 Q 100 180, 200 130 T 400 110 T 600 70 T 800 40" fill="none" stroke="#6366f1" stroke-linecap="round" stroke-width="4"></path>
                    <path d="M0 210 Q 100 190, 200 150 T 400 130 T 600 90 T 800 65" fill="none" stroke="#06b6d4" stroke-dasharray="8 4" stroke-linecap="round" stroke-width="3"></path>
                    <!-- Area gradient -->
                    <path d="M0 200 Q 100 180, 200 130 T 400 110 T 600 70 T 800 40 V 240 H 0 Z" fill="url(#grad2)" opacity="0.08"></path>
                    <defs>
                        <linearGradient id="grad2" x1="0%" x2="0%" y1="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#6366f1;stop-opacity:1"></stop>
                            <stop offset="100%" style="stop-color:#6366f1;stop-opacity:0"></stop>
                        </linearGradient>
                    </defs>
                </svg>
                <!-- Y-Axis Labels -->
                <div class="absolute left-0 top-0 h-[220px] flex flex-col justify-between py-1 text-slate-400/40 text-[10px] font-bold">
                    <span>100%</span>
                    <span>75%</span>
                    <span>50%</span>
                    <span>25%</span>
                    <span>0%</span>
                </div>
                <!-- X-Axis Labels -->
                <div class="w-full flex justify-between pt-4 border-t border-slate-200/30 dark:border-slate-800/30 text-slate-500 dark:text-slate-400 text-xs font-semibold mt-6">
                    <span>Target 1</span><span>Target 2</span><span>Target 3</span><span>Target 4</span><span>Target 5</span>
                </div>
            </div>
        </div>

        <!-- Student Segmentation Card -->
        <div class="col-span-12 lg:col-span-4 glass-card p-6 rounded-2xl flex flex-col justify-between border border-slate-200/50 dark:border-slate-800/50">
            <div class="border-b border-slate-200/40 dark:border-slate-800/40 pb-4 mb-3">
                <h3 class="text-xl text-slate-800 dark:text-slate-100 font-bold">Placement Probability</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Cohort distributions across active talent classification levels.</p>
            </div>
            
            <div class="flex-grow flex flex-col gap-3 justify-center py-3">
                <!-- Elite -->
                <div>
                    <div class="flex justify-between text-xs text-slate-700 dark:text-slate-300 mb-1 font-semibold">
                        <span class="flex items-center gap-1.5 font-semibold">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500 block"></span>
                            Elite Potential
                        </span>
                        <span class="font-bold text-purple-500">{{ $distribution['Elite'] }} candidates</span>
                    </div>
                    <div class="w-full h-2 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        @php
                            $total = max($totalCandidates, 1);
                            $elitePercent = ($distribution['Elite'] / $total) * 100;
                            $highPercent = ($distribution['High'] / $total) * 100;
                            $modPercent = ($distribution['Moderate'] / $total) * 100;
                            $devPercent = ($distribution['Developing'] / $total) * 100;
                        @endphp
                        <div class="h-full bg-purple-500 rounded-full" style="width: {{ $totalCandidates > 0 ? $elitePercent : 45 }}%"></div>
                    </div>
                </div>
                
                <!-- High -->
                <div>
                    <div class="flex justify-between text-xs text-slate-700 dark:text-slate-300 mb-1 font-semibold">
                        <span class="flex items-center gap-1.5 font-semibold">
                            <span class="w-2.5 h-2.5 rounded-full bg-primary block"></span>
                            High Potential
                        </span>
                        <span class="font-bold text-primary dark:text-cyan-accent">{{ $distribution['High'] }} candidates</span>
                    </div>
                    <div class="w-full h-2 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full" style="width: {{ $totalCandidates > 0 ? $highPercent : 35 }}%"></div>
                    </div>
                </div>

                <!-- Moderate -->
                <div>
                    <div class="flex justify-between text-xs text-slate-700 dark:text-slate-300 mb-1 font-semibold">
                        <span class="flex items-center gap-1.5 font-semibold">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 block"></span>
                            Moderate Potential
                        </span>
                        <span class="font-bold text-emerald-500">{{ $distribution['Moderate'] }} candidates</span>
                    </div>
                    <div class="w-full h-2 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $totalCandidates > 0 ? $modPercent : 15 }}%"></div>
                    </div>
                </div>

                <!-- Developing -->
                <div>
                    <div class="flex justify-between text-xs text-slate-700 dark:text-slate-300 mb-1 font-semibold">
                        <span class="flex items-center gap-1.5 font-semibold">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 block"></span>
                            Developing Potential
                        </span>
                        <span class="font-bold text-amber-500">{{ $distribution['Developing'] }} candidates</span>
                    </div>
                    <div class="w-full h-2 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $totalCandidates > 0 ? $devPercent : 5 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PREMIUM: Heatmap and Leadership / Communication Distributions -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Department Heatmap Matrix -->
        <div class="md:col-span-6 glass-card p-6 rounded-2xl border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between">
            <div class="border-b border-slate-200/40 dark:border-slate-800/40 pb-4 mb-4">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Department Heatmap</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Cross-discipline potential density clusters mapping.</p>
            </div>
            
            <div class="grid grid-cols-4 gap-2 text-center text-[10px] font-bold text-white tracking-tight uppercase">
                <!-- Heatmap cells -->
                <div class="bg-indigo-600 p-4 rounded-xl flex flex-col justify-between h-20 hover:scale-105 transition-transform shadow-lg shadow-indigo-600/10">
                    <span>CS & DL</span>
                    <span class="text-xs font-black block mt-2">Elite Fit</span>
                </div>
                <div class="bg-cyan-500 p-4 rounded-xl flex flex-col justify-between h-20 hover:scale-105 transition-transform shadow-lg shadow-cyan-500/10">
                    <span>Hardware</span>
                    <span class="text-xs font-black block mt-2">High Fit</span>
                </div>
                <div class="bg-purple-500 p-4 rounded-xl flex flex-col justify-between h-20 hover:scale-105 transition-transform shadow-lg shadow-purple-500/10">
                    <span>Applied Stat</span>
                    <span class="text-xs font-black block mt-2">Moderate Fit</span>
                </div>
                <div class="bg-amber-500 p-4 rounded-xl flex flex-col justify-between h-20 hover:scale-105 transition-transform shadow-lg shadow-amber-500/10">
                    <span>Business</span>
                    <span class="text-xs font-black block mt-2">Developing Fit</span>
                </div>
            </div>
        </div>

        <!-- Leadership Impact Compare Chart -->
        <div class="md:col-span-6 glass-card p-6 rounded-2xl border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between">
            <div class="border-b border-slate-200/40 dark:border-slate-800/40 pb-4 mb-4">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Leadership Impact</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Comparing fit percentage based on active leadership roles.</p>
            </div>

            <!-- SVG Compare bar chart -->
            <div class="h-28 flex flex-col justify-around py-2">
                <div class="space-y-1">
                    <div class="flex justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                        <span>Active Leadership Roles</span>
                        <span class="text-primary font-bold">88.5% Avg Fit</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary to-cyan-accent" style="width: 88.5%"></div>
                    </div>
                </div>
                <div class="space-y-1 mt-2">
                    <div class="flex justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                        <span>No Active Leadership Roles</span>
                        <span class="text-slate-400 font-bold">62.3% Avg Fit</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200/50 dark:bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full bg-slate-400 dark:bg-slate-700" style="width: 62.3%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Communication Distribution -->
    <div class="glass-card p-6 rounded-2xl border border-slate-200/50 dark:border-slate-800/50">
        <div class="border-b border-slate-200/40 dark:border-slate-800/40 pb-4 mb-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Communication Distribution</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Average placement fit percentages mapped against communication assessment ranges.</p>
        </div>

        <div class="h-28 flex items-end justify-between px-6 gap-2">
            @php
                $commDist = [
                    ['range' => 'Basic (1-3)', 'fit' => 45, 'color' => '#f59e0b'],
                    ['range' => 'Fluent (4-6)', 'fit' => 72, 'color' => '#06b6d4'],
                    ['range' => 'Advanced (7-8)', 'fit' => 88, 'color' => '#6366f1'],
                    ['range' => 'Exceptional (9-10)', 'fit' => 95, 'color' => '#a855f7']
                ];
            @endphp
            @foreach ($commDist as $bar)
                <div class="flex-grow flex flex-col items-center justify-end h-full">
                    <div class="text-[9px] font-black text-slate-500 mb-1">{{ $bar['fit'] }}%</div>
                    <div class="w-full rounded-t-lg transition-all duration-300 hover:brightness-110" style="height: {{ $bar['fit'] }}%; background-color: {{ $bar['color'] }}"></div>
                    <span class="text-[9px] font-bold text-slate-500 dark:text-slate-400 mt-2 text-center">{{ $bar['range'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
