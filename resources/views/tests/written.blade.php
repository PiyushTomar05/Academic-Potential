@extends('layouts.app')

@section('title', 'Written English Test | Test Center')

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
                <span class="material-symbols-outlined text-purple-500">edit_note</span>
                Written English Test
            </h2>
            <p class="text-xs text-slate-555 dark:text-slate-400">Independent writing assessment scoring grammar, vocabulary, structure, and length.</p>
        </div>
    </div>

    <!-- Written Board Bento Card -->
    <form id="written-form" class="space-y-6">
        @csrf
        
        <div class="glass-card rounded-3xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50 shadow-xl space-y-6">
            <!-- Prompt instructions -->
            <div class="bg-purple-500/5 dark:bg-purple-500/10 border border-purple-500/15 rounded-2xl p-6 space-y-3">
                <strong class="text-sm font-bold text-purple-650 dark:text-purple-450 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">menu_book</span>
                    Writing Prompt: Professional Ambitions & Achievements
                </strong>
                <p class="text-xs text-slate-600 dark:text-slate-350 leading-relaxed font-semibold">
                    "Please describe your core professional goals and how your major course of study aligns with the target industry. Discuss your key technical achievements and capstone projects. Polish your structure and try to use connective vocabulary to present cohesive logical arguments."
                </p>
            </div>

            <!-- Gamified Connector Checklist -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div id="connector-however" class="p-3 bg-slate-100/50 dark:bg-slate-950/40 rounded-xl border border-slate-200/20 flex items-center gap-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider transition-colors duration-300">
                    <span class="material-symbols-outlined text-[14px]">cancel</span>
                    <span>Connector: "However"</span>
                </div>
                <div id="connector-therefore" class="p-3 bg-slate-100/50 dark:bg-slate-950/40 rounded-xl border border-slate-200/20 flex items-center gap-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider transition-colors duration-300">
                    <span class="material-symbols-outlined text-[14px]">cancel</span>
                    <span>Connector: "Therefore"</span>
                </div>
                <div id="connector-furthermore" class="p-3 bg-slate-100/50 dark:bg-slate-950/40 rounded-xl border border-slate-200/20 flex items-center gap-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider transition-colors duration-300">
                    <span class="material-symbols-outlined text-[14px]">cancel</span>
                    <span>Connector: "Furthermore"</span>
                </div>
            </div>

            <!-- Textarea Box -->
            <div class="flex flex-col gap-2">
                <textarea id="essay-input" name="essay" class="w-full h-64 rounded-3xl p-5 bg-white/40 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-purple-500 outline-none text-sm font-semibold leading-relaxed" placeholder="Write your professional ambitions essay here... (Minimum 50 words required)"></textarea>
                
                <!-- Word and Char counts -->
                <div class="flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-widest px-2 mt-1">
                    <span id="word-count-badge" class="px-3 py-1 bg-slate-100/50 dark:bg-slate-950/30 rounded-full border border-slate-200/10">0 Words</span>
                    <span id="char-count-badge" class="px-3 py-1 bg-slate-100/50 dark:bg-slate-950/30 rounded-full border border-slate-200/10">0 Characters</span>
                </div>
            </div>
        </div>

        <!-- Action Panel -->
        <div class="flex justify-between items-center py-6">
            <a href="{{ route('tests.index') }}" class="px-6 py-3 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-bold rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                Cancel Test
            </a>
            <button type="submit" id="submit-btn" class="px-8 py-3 bg-purple-600 hover:bg-purple-500 dark:bg-purple-500 dark:hover:bg-purple-400 text-white font-bold rounded-2xl shadow-lg hover:shadow-purple-500/25 transition-all">
                Submit Written Essay
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const essayInput = document.getElementById('essay-input');
        const wordBadge = document.getElementById('word-count-badge');
        const charBadge = document.getElementById('char-count-badge');
        
        const cHowever = document.getElementById('connector-however');
        const cTherefore = document.getElementById('connector-therefore');
        const cFurthermore = document.getElementById('connector-furthermore');
        
        const form = document.getElementById('written-form');
        const submitBtn = document.getElementById('submit-btn');

        // Dynamic word, character, and connector checklist tracker
        essayInput.addEventListener('input', () => {
            const text = essayInput.value;
            const charCount = text.length;
            const wordCount = text.split(/\s+/).filter(w => w.length > 0).length;

            wordBadge.innerText = `${wordCount} Words`;
            charBadge.innerText = `${charCount} Characters`;

            // Score check warning colors
            if (wordCount < 50) {
                wordBadge.className = "px-3 py-1 bg-red-500/10 text-red-500 border border-red-500/20 rounded-full font-black";
            } else {
                wordBadge.className = "px-3 py-1 bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 rounded-full font-black";
            }

            // Checklist keywords
            const checkKeyword = (word, badge) => {
                if (new RegExp('\\b' + word + '\\b', 'i').test(text)) {
                    badge.className = "p-3 bg-emerald-500/10 border border-emerald-500/25 text-emerald-650 dark:text-emerald-400 rounded-xl flex items-center gap-2 text-[10px] font-black uppercase tracking-wider transition-all duration-300";
                    badge.querySelector('span.material-symbols-outlined').innerText = "check_circle";
                } else {
                    badge.className = "p-3 bg-slate-100/50 dark:bg-slate-950/40 rounded-xl border border-slate-200/20 flex items-center gap-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider transition-all duration-300";
                    badge.querySelector('span.material-symbols-outlined').innerText = "cancel";
                }
            };

            checkKeyword('however', cHowever);
            checkKeyword('therefore', cTherefore);
            checkKeyword('furthermore', cFurthermore);
        });

        // Submit via AJAX
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const text = essayInput.value;
            const wordCount = text.split(/\s+/).filter(w => w.length > 0).length;

            if (wordCount < 50) {
                showToast('Minimum Word Limit', 'Please expand your essay to at least 50 words to meet evaluation criteria.', 'warning');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin inline-block mr-2 align-middle"></span>
                Evaluating writing variables...
            `;

            const formData = new FormData(form);
            fetch('{{ route('tests.written.save') }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Evaluation Complete!', 'Essay vocabulary richness, lengths, and connectors analyzed successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1800);
                } else {
                    showToast('Error', 'Failed to save essay analysis.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Submit Written Essay';
                }
            })
            .catch(err => {
                showToast('Network Error', 'Essay evaluation failed. Please check server connection.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerText = 'Submit Written Essay';
            });
        });
    });
</script>
@endsection
