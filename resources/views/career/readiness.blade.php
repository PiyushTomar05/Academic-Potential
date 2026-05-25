@extends('layouts.app')

@section('title', 'Placement Readiness & AI Report')

@section('styles')
<style>
    @media print {
        /* Hide navbar, sidebars, and uploader buttons during print */
        aside, header, #toast-notification, .sidebar-active, .no-print {
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
        }
    }
</style>
@endsection

@section('content')
<div class="p-6 lg:p-8 max-w-5xl mx-auto flex flex-col gap-8 print-layout">
    
    <!-- Header Section (no-print) -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-6 mt-6 no-print">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-emerald-500 text-[32px]">verified</span>
                Placement Readiness Score & Report
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Verify your synthesized placement index, structural test averages, and export print-friendly final reports.</p>
        </div>
        <div>
            <button onclick="window.print()" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-sm font-semibold transition-all shadow-lg hover:shadow-emerald-500/20 flex items-center gap-2 cursor-pointer no-print">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                <span>Export AI Report</span>
            </button>
        </div>
    </header>

    <!-- Consolidated AI Report Document (Aesthetic, optimized for printing) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50 shadow-2xl space-y-8 bg-gradient-to-br from-emerald-500/5 via-transparent to-transparent print-layout">
        
        <!-- Document Title Header -->
        <div class="flex justify-between items-start border-b border-slate-200 dark:border-slate-800 pb-6">
            <div class="space-y-1">
                <h1 class="text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Placement Readiness & Career Evaluation Report</h1>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest block">Evaluating Academic Potential AI Engine</span>
            </div>
            <div class="text-right">
                <strong class="text-xs font-black text-slate-450 uppercase block">Report Code</strong>
                <span class="text-[10px] text-slate-500 font-bold block truncate max-w-[120px]">{{ md5($user->id . now()->toDateString()) }}</span>
            </div>
        </div>

        <!-- Student Profile Coordinates -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 bg-slate-50 dark:bg-slate-900/30 p-5 rounded-2xl border border-slate-200/20">
            <div>
                <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Candidate Name</span>
                <strong class="text-xs text-slate-800 dark:text-slate-200 block truncate">{{ $user->name }}</strong>
            </div>
            <div>
                <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Email Coordinates</span>
                <strong class="text-xs text-slate-800 dark:text-slate-200 block truncate">{{ $user->email }}</strong>
            </div>
            <div>
                <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Analysis date</span>
                <strong class="text-xs text-slate-800 dark:text-slate-200 block truncate">{{ now()->format('Y-M-d') }}</strong>
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
                <span class="text-[10px] text-slate-450 font-black uppercase tracking-widest block">Readiness parameter Coordinates</span>
                
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

        <!-- Evaluation History logs block -->
        <div class="space-y-4">
            <span class="text-[10px] text-slate-450 font-black uppercase tracking-widest block">Dynamic Prediction Log History</span>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-semibold text-slate-700 dark:text-slate-300">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-800 text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">
                            <th class="py-2.5">Date Checked</th>
                            <th class="py-2.5">Academic standing</th>
                            <th class="py-2.5">Classification Fit</th>
                            <th class="py-2.5">Confidence index</th>
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
@endsection
