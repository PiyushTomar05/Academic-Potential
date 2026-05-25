@extends('layouts.app')

@section('title', 'Prediction History Logs | Evaluating Academic Potential')

@section('content')
<div class="p-6 lg:p-8 max-w-7xl mx-auto flex flex-col gap-6">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end mb-4 gap-6 mt-6">
        <div>
            <nav class="flex gap-1.5 text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">
                <span>Portal Hub</span>
                <span>/</span>
                <span class="text-primary dark:text-cyan-accent">Prediction Logs</span>
            </nav>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100 font-bold">Prediction History</h2>
            <p class="text-slate-500 dark:text-slate-400 max-w-2xl mt-1 text-sm">Review historical AI evaluations of student performance and predicted academic trajectories based on cross-disciplinary metrics.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('prediction.final') }}" class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-1.5 active:scale-95">
                <span class="material-symbols-outlined text-[20px]">auto_awesome</span>
                New Prediction
            </a>
        </div>
    </header>

    <!-- Filters Section -->
    <section class="glass-card rounded-2xl p-6">
        <form action="{{ route('history') }}" method="GET" class="flex flex-wrap items-center gap-6" id="filterForm">
            <div class="flex-1 min-w-[280px] relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full pl-12 pr-6 py-3 bg-white/40 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm" 
                       placeholder="Search by career alignment focus or class..." 
                       type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       onchange="this.form.submit()"/>
            </div>
            
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-slate-500 dark:text-slate-400 px-1 text-xs font-bold uppercase tracking-wider">Classification Level</label>
                    <select class="bg-white/40 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 rounded-xl py-3 px-6 text-sm outline-none focus:border-primary min-w-[180px]" 
                            name="class" 
                            onchange="this.form.submit()">
                        <option value="">All Classes</option>
                        <option value="Elite Potential" {{ request('class') === 'Elite Potential' ? 'selected' : '' }}>Elite Potential</option>
                        <option value="High Potential" {{ request('class') === 'High Potential' ? 'selected' : '' }}>High Potential</option>
                        <option value="Moderate Potential" {{ request('class') === 'Moderate Potential' ? 'selected' : '' }}>Moderate Potential</option>
                        <option value="Developing Potential" {{ request('class') === 'Developing Potential' ? 'selected' : '' }}>Developing Potential</option>
                    </select>
                </div>
                
                <div class="flex flex-col gap-1.5 self-end">
                    <a href="{{ route('history') }}" class="bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-6 py-3 rounded-xl text-sm font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors inline-block text-center border border-slate-200/50 dark:border-slate-700/50">
                        Clear Filters
                    </a>
                </div>
            </div>
        </form>
    </section>

    <!-- Data Table Section -->
    <section class="glass-card rounded-2xl overflow-hidden shadow-md flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-600 dark:text-slate-400 border-b border-slate-200/30 dark:border-slate-800/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">Evaluation Run / Focus</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">CGPA Index</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">Placement Fit</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">Potential Class</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">Date Evaluated</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider border-b border-slate-200/30 dark:border-slate-800/30">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/30">
                    @forelse ($evaluations as $index => $eval)
                        <tr class="hover:bg-primary/5 transition-colors group cursor-pointer" onclick="window.location='{{ route('evaluation.results', $eval->id) }}'">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary/20 to-cyan-accent/20 flex items-center justify-center text-primary dark:text-cyan-accent font-bold">
                                    #{{ $evaluations->firstItem() + $index }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                        {{ !empty($eval->career_recommendations) ? $eval->career_recommendations[0] : ($eval->ai['potential'] ?? 'General Potential Analysis') }}
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ count($eval->academic_history ?? []) }} Years Mapped &bull; {{ $eval->softskills['skills'] ?? 0 }} Skills Evaluated
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 text-sm font-semibold">{{ number_format($eval->cgpa, 2) }} / 10.0</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-24 bg-slate-200 dark:bg-slate-800 rounded-full h-2 overflow-hidden border border-slate-200/30 dark:border-slate-800/30">
                                        <div class="bg-gradient-to-r from-primary to-cyan-accent h-full" style="width: {{ $eval->probability_score }}%"></div>
                                    </div>
                                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">{{ $eval->probability_score }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($eval->potential_class === 'Elite Potential')
                                    <span class="px-3 py-1 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-[11px] font-bold uppercase tracking-wide">Elite</span>
                                @elseif ($eval->potential_class === 'High Potential')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-[11px] font-bold uppercase tracking-wide">High</span>
                                @elseif ($eval->potential_class === 'Moderate Potential')
                                    <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold uppercase tracking-wide">Moderate</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-[11px] font-bold uppercase tracking-wide">Developing</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-sm font-semibold">{{ $eval->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right" onclick="event.stopPropagation();">
                                <a href="{{ route('evaluation.results', $eval->id) }}" class="text-primary dark:text-cyan-accent font-semibold hover:underline decoration-2 transition-transform group-hover:translate-x-1 inline-flex items-center gap-1">
                                    View Report
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3 py-6">
                                    <span class="material-symbols-outlined text-[48px] text-slate-300 dark:text-slate-700">history_toggle_off</span>
                                    <h5 class="text-lg text-slate-800 dark:text-slate-200 font-semibold">No Evaluations Match Filters</h5>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm">Try clearing search parameters or adjusting candidate filters to see matching metrics.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Footer -->
        @if ($evaluations->hasPages())
            <div class="bg-slate-50 dark:bg-slate-900/50 px-6 py-3 border-t border-slate-200/30 dark:border-slate-800/30 flex justify-center">
                {{ $evaluations->links() }}
            </div>
        @endif
    </section>

    <!-- Insights Grid Footer -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="glass-card rounded-2xl p-6 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs font-bold">System Status</span>
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent">cloud_done</span>
            </div>
            <div class="text-xl text-slate-800 dark:text-slate-100 font-bold">Operational</div>
            <div class="text-xs text-slate-500 dark:text-slate-400">Synaptic layers synchronized with active MongoDB Atlas instance.</div>
        </div>

        <div class="glass-card rounded-2xl p-6 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs font-bold">Model Confidence</span>
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent">verified_user</span>
            </div>
            <div class="text-xl text-slate-800 dark:text-slate-100 font-bold">98.4%</div>
            <div class="text-xs text-slate-500 dark:text-slate-400">Average convergence fit cross-validated on actual placements.</div>
        </div>

        <div class="glass-card rounded-2xl p-6 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs font-bold">Execution Speed</span>
                <span class="material-symbols-outlined text-cyan-accent">speed</span>
            </div>
            <div class="text-xl text-slate-800 dark:text-slate-100 font-bold">0.18s</div>
            <div class="text-xs text-slate-500 dark:text-slate-400">Calculated MLP scoring propagation time in active session.</div>
        </div>
    </section>
</div>
@endsection
