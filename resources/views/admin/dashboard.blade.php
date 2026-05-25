@extends('layouts.app')

@section('title', 'Admin Console | Evaluating Academic Potential')

@section('content')
<div class="p-6 lg:p-8 max-w-7xl mx-auto flex flex-col gap-6">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-6 mt-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100">Admin Control Panel</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Aggregated metrics, active predictions registry, and system audit logs.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-4 py-2 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-400/50 text-emerald-800 dark:text-emerald-300 rounded-xl text-xs font-bold tracking-wide flex items-center gap-1.5">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                MongoDB Atlas Connected
            </span>
        </div>
    </header>

    <!-- KPI Widgets Grid -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-2">
        <!-- Total System Users -->
        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 border border-slate-200/50 dark:border-slate-800/50 hover:shadow-lg transition-all duration-300">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-primary/10 dark:bg-primary/20 rounded-lg text-primary dark:text-cyan-accent">
                    <span class="material-symbols-outlined text-[24px]">group</span>
                </span>
                <span class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Users</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-medium">Total registered accounts</span>
                <span class="text-3xl font-black text-slate-800 dark:text-slate-100 block mt-1" data-target="{{ $totalUsers }}">{{ $totalUsers }}</span>
            </div>
        </div>

        <!-- Total System Evaluations -->
        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 border border-slate-200/50 dark:border-slate-800/50 hover:shadow-lg transition-all duration-300">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-cyan-500/10 dark:bg-cyan-500/20 rounded-lg text-cyan-600 dark:text-cyan-400">
                    <span class="material-symbols-outlined text-[24px]">analytics</span>
                </span>
                <span class="text-cyan-500 text-xs font-bold uppercase tracking-wider">Evaluations</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-medium">Evaluations calculated</span>
                <span class="text-3xl font-black text-slate-800 dark:text-slate-100 block mt-1" data-target="{{ $totalEvaluations }}">{{ $totalEvaluations }}</span>
            </div>
        </div>

        <!-- High-Potential Students Count -->
        <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 border border-slate-200/50 dark:border-slate-800/50 hover:shadow-lg transition-all duration-300">
            <div class="flex justify-between items-start">
                <span class="p-3 bg-purple-500/10 dark:bg-purple-500/20 rounded-lg text-purple-600 dark:text-purple-400">
                    <span class="material-symbols-outlined text-[24px]">verified_user</span>
                </span>
                <span class="text-purple-500 text-xs font-bold uppercase tracking-wider">Top Tier</span>
            </div>
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-medium">High / Elite potential candidates</span>
                <span class="text-3xl font-black text-slate-800 dark:text-slate-100 block mt-1" data-target="{{ $highPotentialCount }}">{{ $highPotentialCount }}</span>
            </div>
        </div>
    </section>

    <!-- Grid: Evaluations Registry & System Activity Logs -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Evaluations Registry -->
        <section class="glass-card rounded-2xl overflow-hidden shadow-md border border-slate-200/50 dark:border-slate-800/50 flex flex-col">
            <div class="p-6 border-b border-slate-200/40 dark:border-slate-800/40">
                <h3 class="text-lg text-slate-800 dark:text-slate-100 font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary dark:text-cyan-accent">assignment_ind</span>
                    Recent Predictions Registry
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Cross-system diagnostic records stored in MongoDB predictions collection.</p>
            </div>
            
            <div class="overflow-x-auto flex-grow">
                @if (count($evaluations) > 0)
                    <table class="w-full border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-600 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase border-b border-slate-200/30 dark:border-slate-800/30">Candidate</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase border-b border-slate-200/30 dark:border-slate-800/30">Classification</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase border-b border-slate-200/30 dark:border-slate-800/30">ANN score</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/30">
                            @foreach ($evaluations as $candidate)
                                <tr class="hover:bg-primary/5 transition-colors cursor-pointer" onclick="window.location='{{ route('evaluation.results', $candidate->id) }}'">
                                    <td class="px-4 py-3.5">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $candidate->student_name }}</p>
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $candidate->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        @if ($candidate->potential_class === 'Elite Potential')
                                            <span class="px-2.5 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-[10px] font-bold">ELITE</span>
                                        @elseif ($candidate->potential_class === 'High Potential')
                                            <span class="px-2.5 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-[10px] font-bold">HIGH</span>
                                        @elseif ($candidate->potential_class === 'Moderate Potential')
                                            <span class="px-2.5 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full text-[10px] font-bold">MODERATE</span>
                                        @else
                                            <span class="px-2.5 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full text-[10px] font-bold">DEVELOPING</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-right text-sm font-bold text-slate-700 dark:text-slate-300">
                                        {{ $candidate->probability_score }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-12 text-center text-slate-400 dark:text-slate-600">
                        <span class="material-symbols-outlined text-[48px] block mb-2">query_stats</span>
                        <span class="text-sm">No evaluation prediction registry entries found.</span>
                    </div>
                @endif
            </div>
        </section>

        <!-- System Activity Logs -->
        <section class="glass-card rounded-2xl overflow-hidden shadow-md border border-slate-200/50 dark:border-slate-800/50 flex flex-col">
            <div class="p-6 border-b border-slate-200/40 dark:border-slate-800/40">
                <h3 class="text-lg text-slate-800 dark:text-slate-100 font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-cyan-accent">history</span>
                    System Activity Audit Logs
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Audit logs generated by actions (e.g. PDF report generation and exports) stored in MongoDB.</p>
            </div>
            
            <div class="overflow-y-auto max-h-[480px] flex-grow">
                @if (count($logs) > 0)
                    <div class="divide-y divide-slate-100 dark:divide-slate-800/30">
                        @foreach ($logs as $log)
                            @php
                                $logArray = (array)$log;
                            @endphp
                            <div class="p-4 hover:bg-slate-50/50 dark:hover:bg-slate-900/20 transition-all flex items-start justify-between gap-4">
                                <div class="flex items-start gap-3">
                                    <span class="p-2 bg-slate-100 dark:bg-slate-850 rounded-xl text-slate-500 dark:text-slate-400 block mt-0.5">
                                        @if (($logArray['action'] ?? '') === 'report_downloaded')
                                            <span class="material-symbols-outlined text-[18px]">download_for_offline</span>
                                        @else
                                            <span class="material-symbols-outlined text-[18px]">info</span>
                                        @endif
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            @if (($logArray['action'] ?? '') === 'report_downloaded')
                                                Report downloaded for <strong class="text-cyan-accent font-semibold">{{ $logArray['candidate'] ?? 'Candidate' }}</strong>
                                            @else
                                                {{ ucfirst(str_replace('_', ' ', $logArray['action'] ?? 'Unknown Action')) }}
                                            @endif
                                        </p>
                                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">
                                            User ID: {{ $logArray['user_id'] ?? 'System' }} | ID: {{ $logArray['_id'] ?? '' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-lg">
                                    {{ \Carbon\Carbon::parse($logArray['timestamp'] ?? now())->diffForHumans() }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center text-slate-400 dark:text-slate-600">
                        <span class="material-symbols-outlined text-[48px] block mb-2">database</span>
                        <span class="text-sm">No system activity log audits recorded yet.</span>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // KPI widgets Count-Up Animation
    (function() {
        const counters = document.querySelectorAll('[data-target]');
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-target'));
            if (isNaN(target)) return;
            let current = 0;
            const duration = 1000; // 1s
            const steps = 30;
            const stepVal = target / steps;
            let step = 0;
            
            const interval = setInterval(() => {
                current += stepVal;
                step++;
                
                counter.innerText = Math.floor(current);
                
                if (step >= steps) {
                    clearInterval(interval);
                    counter.innerText = target;
                }
            }, duration / steps);
        });
    })();
</script>
@endsection
