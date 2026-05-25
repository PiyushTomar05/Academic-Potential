@extends('layouts.app')

@section('title', '3-Year Academic History | Test Center')

@section('content')
<div class="p-6 lg:p-8 max-w-4xl mx-auto">
    <!-- Breadcrumb return navigation -->
    <div class="mb-4 mt-6">
        <a href="{{ route('tests.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-cyan-accent font-bold text-xs transition-colors select-none">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Return to Assessment Center</span>
        </a>
    </div>

    <!-- Header -->
    <div class="sticky top-16 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl z-20 py-4 px-6 rounded-3xl border border-slate-200/40 dark:border-slate-800/40 flex justify-between items-center mb-8 shadow-lg">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#6366f1]">history_edu</span>
                3-Year Academic History Logs
            </h2>
            <p class="text-xs text-slate-555 dark:text-slate-400">Record subject-specific marks across three years to map grade progress charts.</p>
        </div>
    </div>

    <!-- Main Card Form -->
    <form id="academic-history-form" class="space-y-6">
        @csrf
        
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-6">
            <div class="flex flex-col gap-1.5">
                <label class="text-xs text-slate-650 dark:text-slate-400 font-black uppercase tracking-wider" for="education_level">Select Education Level</label>
                <select id="education_level" name="education_level" class="w-full md:w-1/3 rounded-xl p-3 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-850 focus:ring-2 focus:ring-primary outline-none text-sm font-semibold" onchange="updateHistoryLabels()">
                    <option value="school">School Student (Class 9th, 10th, 11th)</option>
                    <option value="college">College Student (Semester 1, 2, 3)</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                <!-- Year 1 -->
                <div class="bg-slate-100/30 dark:bg-slate-900/30 p-4 rounded-2xl border border-slate-200/20 space-y-4">
                    <strong class="text-xs font-black text-indigo-500 uppercase tracking-widest block" id="label_yr1">Class 9th Marks</strong>
                    <input type="hidden" name="yr1_name" id="name_yr1" value="Class 9th">
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] text-slate-500 font-bold uppercase">Mathematics (0-100)</label>
                        <input class="w-full rounded-xl p-2 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-[#6366f1] outline-none text-xs font-semibold score-input" 
                               name="yr1_math" type="number" min="0" max="100" placeholder="e.g. 80" value="80" required/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] text-slate-500 font-bold uppercase">Science / Tech (0-100)</label>
                        <input class="w-full rounded-xl p-2 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-[#6366f1] outline-none text-xs font-semibold score-input" 
                               name="yr1_sci" type="number" min="0" max="100" placeholder="e.g. 85" value="82" required/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] text-slate-500 font-bold uppercase">Humanities (0-100)</label>
                        <input class="w-full rounded-xl p-2 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-[#6366f1] outline-none text-xs font-semibold score-input" 
                               name="yr1_hum" type="number" min="0" max="100" placeholder="e.g. 75" value="78" required/>
                    </div>
                </div>

                <!-- Year 2 -->
                <div class="bg-slate-100/30 dark:bg-slate-900/30 p-4 rounded-2xl border border-slate-200/20 space-y-4">
                    <strong class="text-xs font-black text-indigo-500 uppercase tracking-widest block" id="label_yr2">Class 10th Marks</strong>
                    <input type="hidden" name="yr2_name" id="name_yr2" value="Class 10th">
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] text-slate-500 font-bold uppercase">Mathematics (0-100)</label>
                        <input class="w-full rounded-xl p-2 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-[#6366f1] outline-none text-xs font-semibold score-input" 
                               name="yr2_math" type="number" min="0" max="100" placeholder="e.g. 85" value="84" required/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] text-slate-500 font-bold uppercase">Science / Tech (0-100)</label>
                        <input class="w-full rounded-xl p-2 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-[#6366f1] outline-none text-xs font-semibold score-input" 
                               name="yr2_sci" type="number" min="0" max="100" placeholder="e.g. 88" value="86" required/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] text-slate-500 font-bold uppercase">Humanities (0-100)</label>
                        <input class="w-full rounded-xl p-2 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-[#6366f1] outline-none text-xs font-semibold score-input" 
                               name="yr2_hum" type="number" min="0" max="100" placeholder="e.g. 80" value="82" required/>
                    </div>
                </div>

                <!-- Year 3 -->
                <div class="bg-slate-100/30 dark:bg-slate-900/30 p-4 rounded-2xl border border-slate-200/20 space-y-4">
                    <strong class="text-xs font-black text-indigo-500 uppercase tracking-widest block" id="label_yr3">Class 11th Marks</strong>
                    <input type="hidden" name="yr3_name" id="name_yr3" value="Class 11th">
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] text-slate-500 font-bold uppercase">Mathematics (0-100)</label>
                        <input class="w-full rounded-xl p-2 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-[#6366f1] outline-none text-xs font-semibold score-input" 
                               name="yr3_math" type="number" min="0" max="100" placeholder="e.g. 90" value="88" required/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] text-slate-500 font-bold uppercase">Science / Tech (0-100)</label>
                        <input class="w-full rounded-xl p-2 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-[#6366f1] outline-none text-xs font-semibold score-input" 
                               name="yr3_sci" type="number" min="0" max="100" placeholder="e.g. 92" value="89" required/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] text-slate-500 font-bold uppercase">Humanities (0-100)</label>
                        <input class="w-full rounded-xl p-2 bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-[#6366f1] outline-none text-xs font-semibold score-input" 
                               name="yr3_hum" type="number" min="0" max="100" placeholder="e.g. 85" value="85" required/>
                    </div>
                </div>
            </div>
        </div>

        <!-- SVG Live Preview graph -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <h4 class="text-sm font-bold text-slate-850 dark:text-slate-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#6366f1]">monitoring</span>
                Live Trend Preview Graph
            </h4>
            
            <div class="relative h-[200px] flex items-center justify-center">
                <svg class="w-full h-full max-w-[420px]" viewBox="0 0 400 180" id="live-svg-graph">
                    <!-- Grid Lines -->
                    <line x1="50" y1="30" x2="350" y2="30" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1" stroke-dasharray="4 4"></line>
                    <line x1="50" y1="85" x2="350" y2="85" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1" stroke-dasharray="4 4"></line>
                    <line x1="50" y1="140" x2="350" y2="140" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1"></line>
                    
                    <!-- Vertical grid lines -->
                    <line x1="50" y1="30" x2="50" y2="140" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1"></line>
                    <line x1="200" y1="30" x2="200" y2="140" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1" stroke-dasharray="2 2"></line>
                    <line x1="350" y1="30" x2="350" y2="140" stroke="rgba(148, 163, 184, 0.15)" stroke-width="1"></line>
                    
                    <!-- Trends -->
                    <polyline fill="none" stroke="#6366f1" stroke-width="3" stroke-linecap="round" points="50,100 200,80 350,60" id="line-math"></polyline>
                    <polyline fill="none" stroke="#06b6d4" stroke-width="3" stroke-linecap="round" points="50,90 200,75 350,55" id="line-sci"></polyline>
                    <polyline fill="none" stroke="#a855f7" stroke-width="3" stroke-linecap="round" points="50,110 200,95 350,70" id="line-hum"></polyline>
                    
                    <!-- Text Labels -->
                    <text x="50" y="160" text-anchor="middle" font-size="9" font-weight="bold" fill="#94a3b8" id="svg_yr1_lbl">Class 9th</text>
                    <text x="200" y="160" text-anchor="middle" font-size="9" font-weight="bold" fill="#94a3b8" id="svg_yr2_lbl">Class 10th</text>
                    <text x="350" y="160" text-anchor="middle" font-size="9" font-weight="bold" fill="#94a3b8" id="svg_yr3_lbl">Class 11th</text>
                    
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

        <!-- Action Panel -->
        <div class="flex justify-between items-center py-6">
            <a href="{{ route('tests.index') }}" class="px-6 py-3 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-bold rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                Cancel
            </a>
            <button type="submit" id="submit-btn" class="px-8 py-3 bg-[#6366f1] hover:bg-indigo-650 text-white font-bold rounded-2xl shadow-lg hover:shadow-indigo-500/25 transition-all">
                Save Academic History
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('academic-history-form');
        const submitBtn = document.getElementById('submit-btn');

        window.updateHistoryLabels = () => {
            const level = document.getElementById('education_level').value;
            const label1 = document.getElementById('label_yr1');
            const label2 = document.getElementById('label_yr2');
            const label3 = document.getElementById('label_yr3');
            
            const name1 = document.getElementById('name_yr1');
            const name2 = document.getElementById('name_yr2');
            const name3 = document.getElementById('name_yr3');

            const svg1 = document.getElementById('svg_yr1_lbl');
            const svg2 = document.getElementById('svg_yr2_lbl');
            const svg3 = document.getElementById('svg_yr3_lbl');

            if (level === 'school') {
                label1.innerText = "Class 9th Marks";
                label2.innerText = "Class 10th Marks";
                label3.innerText = "Class 11th Marks";
                name1.value = "Class 9th";
                name2.value = "Class 10th";
                name3.value = "Class 11th";
                svg1.textContent = "Class 9th";
                svg2.textContent = "Class 10th";
                svg3.textContent = "Class 11th";
            } else {
                label1.innerText = "Semester 1 Marks";
                label2.innerText = "Semester 2 Marks";
                label3.innerText = "Semester 3 Marks";
                name1.value = "Semester 1";
                name2.value = "Semester 2";
                name3.value = "Semester 3";
                svg1.textContent = "Sem 1";
                svg2.textContent = "Sem 2";
                svg3.textContent = "Sem 3";
            }
        };

        // Live SVG points calculator
        function updateSvgLive() {
            const getVal = (name) => {
                const el = form.querySelector(`[name="${name}"]`);
                return el ? parseInt(el.value || 0) : 80;
            };

            const yr1_m = getVal('yr1_math');
            const yr1_s = getVal('yr1_sci');
            const yr1_h = getVal('yr1_hum');

            const yr2_m = getVal('yr2_math');
            const yr2_s = getVal('yr2_sci');
            const yr2_h = getVal('yr2_hum');

            const yr3_m = getVal('yr3_math');
            const yr3_s = getVal('yr3_sci');
            const yr3_h = getVal('yr3_hum');

            // map formula: y = 140 - (marks * 1.1)
            document.getElementById('line-math').setAttribute('points', `50,${140 - yr1_m * 1.1} 200,${140 - yr2_m * 1.1} 350,${140 - yr3_m * 1.1}`);
            document.getElementById('line-sci').setAttribute('points', `50,${140 - yr1_s * 1.1} 200,${140 - yr2_s * 1.1} 350,${140 - yr3_s * 1.1}`);
            document.getElementById('line-hum').setAttribute('points', `50,${140 - yr1_h * 1.1} 200,${140 - yr2_h * 1.1} 350,${140 - yr3_h * 1.1}`);
        }

        // Attach listeners for live update
        form.querySelectorAll('.score-input').forEach(input => {
            input.addEventListener('input', updateSvgLive);
        });

        // Submit handler
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
                Saving Logs...
            `;

            const formData = new FormData(form);
            fetch('{{ route('tests.history.save') }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Academic Logs Saved!', data.message, 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    showToast('Error', 'Failed to save academic records.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Save Academic History';
                }
            })
            .catch(err => {
                showToast('Network Error', 'An error occurred. Check DB connection.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerText = 'Save Academic History';
            });
        });

        // Initialize preview
        updateHistoryLabels();
        updateSvgLive();
    });
</script>
@endsection
