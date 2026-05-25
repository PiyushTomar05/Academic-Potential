@extends('layouts.app')

@section('title', 'ATS Resume Intelligence')

@section('content')
<div class="p-6 lg:p-8 max-w-5xl mx-auto flex flex-col gap-8">
    
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-6 mt-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2.5">
                <span class="material-symbols-outlined text-purple-500 text-[32px]">badge</span>
                ATS Resume Intelligence
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Verify your resume compatibility score against industrial Applicant Tracking Systems (ATS).</p>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        
        <!-- Left: Upload zone -->
        <div class="md:col-span-5 flex flex-col gap-6">
            
            <div class="glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-md">
                <strong class="text-xs font-black text-purple-600 dark:text-purple-400 uppercase tracking-widest block mb-4">Upload PDF resume</strong>
                
                <form id="resume-upload-form" class="space-y-4">
                    @csrf
                    <div class="border-2 border-dashed border-slate-250/20 dark:border-slate-800/60 hover:border-purple-500/50 dark:hover:border-purple-500/40 rounded-2xl p-8 text-center cursor-pointer transition-colors" onclick="document.getElementById('resume_file').click()">
                        <span class="material-symbols-outlined text-[36px] text-slate-400 mb-2">cloud_upload</span>
                        <strong class="text-xs text-slate-700 dark:text-slate-200 block">Drag & Drop Resume here</strong>
                        <span class="text-[10px] text-slate-400 block mt-1 font-semibold">Supports PDF, DOC, DOCX formats (max 5MB)</span>
                        <input type="file" id="resume_file" name="resume_file" class="hidden" accept=".pdf,.doc,.docx" onchange="handleResumeFileSelected(this)">
                    </div>

                    <div id="selected-file-details" class="hidden bg-slate-50 dark:bg-slate-900/40 p-3 rounded-xl border border-slate-200/20 flex items-center gap-2">
                        <span class="material-symbols-outlined text-purple-500 text-[18px]">insert_drive_file</span>
                        <span class="text-xs font-bold text-slate-750 dark:text-slate-305 truncate flex-grow" id="file-name-label">resume.pdf</span>
                        <span class="material-symbols-outlined text-emerald-500 text-[16px]">check_circle</span>
                    </div>

                    <button type="submit" id="submit-resume-btn" class="w-full py-3.5 bg-purple-600 hover:bg-purple-500 text-white font-extrabold text-xs rounded-xl shadow-lg hover:shadow-purple-500/20 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50" disabled>
                        <span class="material-symbols-outlined text-[16px]">analytics</span>
                        <span>Analyze Resume ATS Score</span>
                    </button>
                </form>
            </div>

            <!-- Current standard KPI stats -->
            @if(isset($user->resume_analysis))
                <div class="glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-md text-center flex flex-col items-center justify-center gap-4 relative overflow-hidden bg-gradient-to-br from-purple-500/5 via-transparent to-transparent">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">ATS Compatibility Score</span>
                    
                    <div class="relative w-36 h-36 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90">
                            <circle cx="72" cy="72" r="62" stroke="rgba(148, 163, 184, 0.1)" stroke-width="8" fill="transparent"></circle>
                            <circle cx="72" cy="72" r="62" stroke="#a855f7" stroke-width="8" fill="transparent" stroke-dasharray="390" stroke-dashoffset="{{ 390 - (390 * $user->resume_analysis['ats_score']) / 100 }}" stroke-linecap="round" class="transition-all duration-1000"></circle>
                        </svg>
                        <div class="absolute flex flex-col items-center justify-center">
                            <span class="text-3xl font-black text-slate-800 dark:text-slate-100">{{ $user->resume_analysis['ats_score'] }}%</span>
                            <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mt-0.5">ATS Index</span>
                        </div>
                    </div>

                    <div class="px-4 py-1.5 rounded-full border text-[10px] font-black uppercase tracking-wider {{ $user->resume_analysis['ats_score'] >= 80 ? 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20' : 'text-amber-500 bg-amber-500/10 border-amber-500/20' }}">
                        {{ $user->resume_analysis['ats_score'] >= 80 ? 'Placement Grade standard' : 'Needs Structural Upgrades' }}
                    </div>
                </div>
            @endif

        </div>

        <!-- Right: Keywords & Recommendations -->
        <div class="md:col-span-7 flex flex-col gap-6">
            
            <div class="glass-card p-6 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 shadow-md flex-grow">
                <h3 class="text-sm font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest mb-6 flex items-center gap-2 border-b border-slate-200/40 dark:border-slate-800/40 pb-3">
                    <span class="material-symbols-outlined text-[18px] text-purple-500">checklist</span>
                    <span>Evaluation Matrix & Keywords</span>
                </h3>

                @if(isset($user->resume_analysis))
                    <div class="space-y-6">
                        <!-- Score Details -->
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="bg-slate-100/40 dark:bg-slate-900/40 p-3 rounded-2xl border border-slate-200/20">
                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block">Grammar Standard</span>
                                <strong class="text-lg font-black text-slate-800 dark:text-slate-100 mt-1 block">{{ $user->resume_analysis['grammar_score'] }}%</strong>
                            </div>
                            <div class="bg-slate-100/40 dark:bg-slate-900/40 p-3 rounded-2xl border border-slate-200/20">
                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block">Structure Rating</span>
                                <strong class="text-lg font-black text-slate-800 dark:text-slate-100 mt-1 block">{{ $user->resume_analysis['structure_rating'] }}%</strong>
                            </div>
                            <div class="bg-slate-100/40 dark:bg-slate-900/40 p-3 rounded-2xl border border-slate-200/20">
                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block">Action Verbs</span>
                                <strong class="text-lg font-black text-slate-800 dark:text-slate-100 mt-1 block">{{ $user->resume_analysis['action_verbs_count'] }}</strong>
                            </div>
                        </div>

                        <!-- Extracted Skills -->
                        <div class="space-y-2">
                            <span class="text-[10px] text-slate-400 font-black uppercase tracking-wider block">Extracted Profile Skills</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($user->resume_analysis['extracted_skills'] as $skill)
                                    <span class="px-2.5 py-1 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-650 dark:text-purple-400 text-xs font-bold">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Missing Core Keywords -->
                        <div class="space-y-2">
                            <span class="text-[10px] text-red-500 font-black uppercase tracking-wider block">Missing Core Tech Keywords</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($user->resume_analysis['missing_keywords'] as $kw)
                                    <span class="px-2.5 py-1 rounded-xl bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 text-xs font-bold">{{ $kw }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Structural Recommendations -->
                        <div class="space-y-3 pt-4 border-t border-slate-200/20">
                            <span class="text-[10px] text-purple-600 dark:text-purple-400 font-black uppercase tracking-wider block">ATS Quality Actions</span>
                            <ul class="space-y-2">
                                @foreach($user->resume_analysis['recommendations'] as $rec)
                                    <li class="flex items-start gap-2.5 text-xs text-slate-655 dark:text-slate-350 leading-relaxed font-semibold">
                                        <span class="material-symbols-outlined text-[16px] text-purple-500 mt-0.5">offline_pin</span>
                                        <span>{{ $rec }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-20 text-center space-y-4">
                        <span class="material-symbols-outlined text-[64px] text-slate-300 dark:text-slate-750">post_add</span>
                        <div class="max-w-sm">
                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-300">No Resume Analysis Data</h4>
                            <p class="text-xs text-slate-450 dark:text-slate-555 mt-1 font-semibold leading-relaxed">
                                Please upload your standard professional curriculum vitae on the left panel to trigger Applicants Tracking Systems compatibility diagnostics.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    function handleResumeFileSelected(input) {
        const file = input.files[0];
        const details = document.getElementById('selected-file-details');
        const fileLabel = document.getElementById('file-name-label');
        const submitBtn = document.getElementById('submit-resume-btn');

        if(file) {
            fileLabel.innerText = file.name;
            details.classList.remove('hidden');
            submitBtn.disabled = false;
            showToast('File Selected', `Ready to evaluate: ${file.name}`, 'info');
        } else {
            details.classList.add('hidden');
            submitBtn.disabled = true;
        }
    }

    document.getElementById('resume-upload-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const form = document.getElementById('resume-upload-form');
        const btn = document.getElementById('submit-resume-btn');

        btn.disabled = true;
        btn.innerHTML = `
            <span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
            Evaluating syntax matching...
        `;

        const formData = new FormData(form);
        fetch("{{ route('career.resume.analyze') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showToast('Evaluation Successful!', 'ATS grammar, keywords, and layout evaluated.', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                showToast('Error', 'Unable to complete ATS analysis.', 'error');
                btn.disabled = false;
                btn.innerHTML = `
                    <span class="material-symbols-outlined text-[16px]">analytics</span>
                    <span>Analyze Resume ATS Score</span>
                `;
            }
        })
        .catch(err => {
            showToast('Network Error', 'Connection failed. Verify server status.', 'error');
            btn.disabled = false;
            btn.innerHTML = `
                <span class="material-symbols-outlined text-[16px]">analytics</span>
                <span>Analyze Resume ATS Score</span>
            `;
        });
    });
</script>
@endsection
