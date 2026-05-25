@extends('layouts.app')

@section('title', 'Stress & Academic Readiness Survey | Test Center')

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
                <span class="material-symbols-outlined text-emerald-500">ecg_heart</span>
                Stress & Readiness Survey
            </h2>
            <p class="text-xs text-slate-555 dark:text-slate-400">Structured diagnostic survey calculating emotional readiness indices.</p>
        </div>
    </div>

    <!-- Questions Form -->
    <form id="stress-form" class="space-y-6">
        @csrf

        <!-- Q1: Study Pressure -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-650 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider">Question 1: Academic Workload Pressure</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                How often do you feel completely overwhelmed by the volume of your academic assignments, lab schedules, and examination deadlines?
            </h3>
            <div class="grid grid-cols-1 gap-2.5 mt-4">
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q1" value="1" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Always (Extremely High Pressure & Frequent Exhaustion)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q1" value="2" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Frequently (Heavy study workload pressure)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q1" value="3" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Sometimes (Moderate, manageable pressure levels)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q1" value="4" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Rarely (Seldom feel overwhelmed or stressed)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q1" value="5" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Never (Completely calm, balanced, and relaxed)</span>
                </label>
            </div>
        </div>

        <!-- Q2: Time Management -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-650 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider">Question 2: Time Management</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                Do you maintain a planned study calendar or daily task schedule and consistently adhere to it on a weekly basis?
            </h3>
            <div class="grid grid-cols-1 gap-2.5 mt-4">
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q2" value="1" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Never (Highly disorganized, reactive study patterns)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q2" value="2" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Rarely (Occasionally make plans but struggle to stick to them)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q2" value="3" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Sometimes (Plan major releases or exams, but inconsistent)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q2" value="4" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Frequently (Maintain structured schedules and adhere closely)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q2" value="5" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Always (Extremely well-planned study logs and perfect adherence)</span>
                </label>
            </div>
        </div>

        <!-- Q3: Peer or Mentor Support -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-650 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider">Question 3: Peer & Mentoring Collaboration</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                Do you have access to peers, classmates, or academic advisors you can comfortably discuss subject blockages or technical career choices with?
            </h3>
            <div class="grid grid-cols-1 gap-2.5 mt-4">
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q3" value="1" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">No support at all (Feel completely isolated academically)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q3" value="2" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Limited support (Can occasionally ask peers basic questions)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q3" value="3" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Adequate group (Have a reliable circle of classmates)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q3" value="4" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Very strong support network (Collaborative peers + active seniors)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q3" value="5" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Elite mentoring (Direct active industry guides + deep group collaboration)</span>
                </label>
            </div>
        </div>

        <!-- Q4: Sleep Index -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-650 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider">Question 4: Rest & Physical Wellness</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                On average, how many hours of high-quality sleep do you get during crucial project release deadlines or critical examination weeks?
            </h3>
            <div class="grid grid-cols-1 gap-2.5 mt-4">
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q4" value="1" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Under 4 hours (Extremely sleep deprived and fatigued)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q4" value="2" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">4 - 5 hours (Slightly sleep deprived, heavy caffeine reliance)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q4" value="3" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">5 - 6 hours (Moderate sleep, acceptable but fatigued)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q4" value="4" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">6 - 7 hours (Good quality, highly balanced rest)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q4" value="5" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">7+ hours (Well rested, exceptional cognitive recovery)</span>
                </label>
            </div>
        </div>

        <!-- Q5: Goal Clarity -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200/50 dark:border-slate-800/50 space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-650 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider">Question 5: Future Goal Clarity</span>
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mt-2">
                How clear are you about your desired post-academic career tracks, industry specializations, or postgraduate plans?
            </h3>
            <div class="grid grid-cols-1 gap-2.5 mt-4">
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q5" value="1" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Completely undecided / highly confused about options</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q5" value="2" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Vaguely interested in a few broad domains</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q5" value="3" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Decided on a general field (e.g. software development, finance)</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q5" value="4" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Highly clear on a specific technology stack or business domain</span>
                </label>
                <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-emerald-500/5 dark:hover:bg-emerald-500/5 cursor-pointer transition-all">
                    <input class="text-emerald-500 focus:ring-emerald-500" type="radio" name="q5" value="5" required/>
                    <span class="text-sm text-slate-700 dark:text-slate-350 font-semibold">Elite clarity (Targeted specific companies, mapped roles, or PG tracks)</span>
                </label>
            </div>
        </div>

        <!-- Submit Panel -->
        <div class="flex justify-between items-center py-6">
            <a href="{{ route('tests.index') }}" class="px-6 py-3 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-bold rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                Cancel Survey
            </a>
            <button type="submit" id="submit-btn" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-400 text-white font-bold rounded-2xl shadow-lg hover:shadow-emerald-500/25 transition-all">
                Submit Survey Results
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('stress-form');
        const submitBtn = document.getElementById('submit-btn');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
                Processing...
            `;

            const formData = new FormData(form);
            fetch('{{ route('tests.psychometric.save') }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Survey Logged!', data.message, 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    showToast('Error', 'Failed to save results. Please try again.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Submit Survey Results';
                }
            })
            .catch(err => {
                showToast('Network Error', 'A communications error occurred. Check server status.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerText = 'Submit Survey Results';
            });
        });
    });
</script>
@endsection
