@extends('layouts.app')

@section('title', 'Student Growth Timeline')

@section('content')
<div class="p-6 lg:p-8 max-w-4xl mx-auto flex flex-col gap-8">
    
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-6 mt-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent text-[32px]">timeline</span>
                Student Growth Timeline
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Verify your holistic growth timeline mapping diagnostic history, certificates claimed, and career evolution chronologically.</p>
        </div>
    </header>

    <!-- Chronological timeline visualization block -->
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
@endsection
