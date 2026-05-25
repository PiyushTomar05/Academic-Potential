@extends('layouts.app')

@section('title', 'Student Achievement Portfolio')

@section('content')
<div class="p-6 lg:p-8 max-w-5xl mx-auto flex flex-col gap-8">
    
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-6 mt-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent text-[32px]">workspace_premium</span>
                Student Achievement Portfolio
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Manage and display your verified achievements, hackathons, sports, research papers, and NCC certificates.</p>
        </div>
        <div>
            <button onclick="toggleSubmissionDrawer(true)" class="px-5 py-3 bg-primary hover:bg-primary-hover text-white rounded-xl text-sm font-semibold transition-all shadow-lg shadow-primary/20 flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Log New Achievement</span>
            </button>
        </div>
    </header>

    <!-- Slide-in Submission Drawer Overlay -->
    <div id="drawer-overlay" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-50 transition-all duration-300 hidden items-center justify-end">
        <div class="w-full max-w-md h-full bg-white dark:bg-slate-900 shadow-2xl p-6 flex flex-col gap-6 relative border-l border-slate-200/50 dark:border-slate-800/50">
            <button onclick="toggleSubmissionDrawer(false)" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 material-symbols-outlined cursor-pointer">close</button>
            
            <div class="mt-4 border-b border-slate-200/40 dark:border-slate-800/40 pb-3">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">emoji_events</span>
                    <span>Log Achievement</span>
                </h3>
                <p class="text-xs text-slate-450 mt-1">Record Olympiad rank, sports levels, NCC certificates, or research papers.</p>
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

    <!-- Active achievements grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" id="achievements-card-grid">
        
        <!-- Standard dynamically claimed test center certificates (Aptitude, Coding, etc.) -->
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

        <!-- Claimed Certificates -->
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

    <!-- Empty Slate (shown if absolutely nothing active) -->
    @if(count($claimedTests) === 0 && empty($user->achievements))
        <div class="flex flex-col items-center justify-center py-24 text-center space-y-4 glass-card rounded-3xl border border-slate-200/50 dark:border-slate-800/50">
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
@endsection

@section('scripts')
<script>
    function toggleSubmissionDrawer(open) {
        const overlay = document.getElementById('drawer-overlay');
        if (open) {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            document.getElementById('title').focus();
        } else {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }
    }

    // Handle form submit via AJAX
    document.getElementById('add-achievement-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const form = document.getElementById('add-achievement-form');
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
                btn.innerHTML = `
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span>Submit & Log Achievement</span>
                `;
            }
        })
        .catch(err => {
            showToast('Network Error', 'Connection failed. Check server status.', 'error');
            btn.disabled = false;
            btn.innerHTML = `
                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                <span>Submit & Log Achievement</span>
            `;
        });
    });
</script>
@endsection
