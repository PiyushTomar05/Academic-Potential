@extends('layouts.app')

@section('title', 'General Preferences | Evaluating Academic Potential')

@section('content')
<div class="p-6 lg:p-8 max-w-5xl mx-auto flex flex-col gap-6">
    <!-- Page Header -->
    <div class="mb-8 mt-6">
        <h3 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-100">General Preferences</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Manage your account settings, dark mode preferences, and security credentials.</p>
    </div>

    <!-- Alert Status -->
    @if (session('status'))
        <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-400 text-emerald-800 dark:text-emerald-300 p-6 rounded-2xl mb-1.5 flex items-center gap-4">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <span class="text-sm font-semibold">{{ session('status') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-950/20 border border-red-400 text-red-800 dark:text-red-300 p-6 rounded-2xl mb-1.5">
            <div class="flex items-center gap-4 mb-1.5 font-bold">
                <span class="material-symbols-outlined text-[20px]">warning</span>
                <span>Error Submitting Request</span>
            </div>
            <ul class="list-disc pl-6 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Settings Grid -->
    <div class="grid grid-cols-1 gap-6">
        <!-- Profile Update Section -->
        <section class="glass-card rounded-2xl p-6 shadow-md">
            <div class="flex items-center gap-3 mb-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-4">
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent">person_edit</span>
                <h4 class="text-xl text-slate-800 dark:text-slate-100 font-bold">Profile Settings</h4>
            </div>
            
            <form action="{{ route('settings.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Avatar Upload Row -->
                <div class="flex flex-col sm:flex-row items-center gap-6 mb-6 pb-6 border-b border-slate-200/40 dark:border-slate-800/40">
                    <div class="relative w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-800 border-2 border-primary/30 flex items-center justify-center overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover" id="avatar-preview">
                        @else
                            <span class="material-symbols-outlined text-slate-400 text-[48px]" id="avatar-icon">account_circle</span>
                            <img src="" alt="Avatar" class="w-full h-full object-cover hidden" id="avatar-preview">
                        @endif
                    </div>
                    <div class="space-y-1.5 flex-grow">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold">Profile Avatar Image</label>
                        <input type="file" name="avatar" id="avatar-input" accept="image/*" class="text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary dark:file:text-cyan-accent dark:file:bg-cyan-accent/10 hover:file:bg-primary/20 cursor-pointer">
                        <span class="text-[10px] text-slate-400 dark:text-slate-500 block">Accepted formats: PNG, JPG, JPEG, GIF. Maximum size: 2MB.</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold" for="name">Full Name</label>
                        <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                               type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', Auth::user()->name) }}" 
                               required/>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold" for="email">Email Address</label>
                        <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                               type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', Auth::user()->email) }}" 
                               required/>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold" for="institution">Institution Name</label>
                        <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                               type="text" 
                               name="institution" 
                               id="institution" 
                               placeholder="e.g. Stanford University"
                               value="{{ old('institution', Auth::user()->institution) }}"/>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold" for="department">Department / Discipline</label>
                        <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                               type="text" 
                               name="department" 
                               id="department" 
                               placeholder="e.g. Computer Science"
                               value="{{ old('department', Auth::user()->department) }}"/>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold" for="github">GitHub Profile Link</label>
                        <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                               type="url" 
                               name="github" 
                               id="github" 
                               placeholder="https://github.com/username"
                               value="{{ old('github', Auth::user()->github) }}"/>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold" for="linkedin">LinkedIn Profile Link</label>
                        <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                               type="url" 
                               name="linkedin" 
                               id="linkedin" 
                               placeholder="https://linkedin.com/in/username"
                               value="{{ old('linkedin', Auth::user()->linkedin) }}"/>
                    </div>

                    <div class="space-y-1.5 md:col-span-2">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold" for="skills">Skills Tags (Comma-separated)</label>
                        <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                               type="text" 
                               name="skills" 
                               id="skills" 
                               placeholder="e.g. Python, Machine Learning, Data Structures, SQL"
                               value="{{ old('skills', is_array(Auth::user()->skills) ? implode(', ', Auth::user()->skills) : Auth::user()->skills) }}"/>
                    </div>

                    <!-- Portfolio Accomplishments -->
                    <div class="space-y-4 md:col-span-2 pt-4 border-t border-slate-200/40 dark:border-slate-800/40">
                        <strong class="text-xs font-black text-primary dark:text-cyan-accent uppercase tracking-widest block">Portfolio Accomplishments</strong>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="space-y-1.5">
                                <label class="text-xs text-slate-600 dark:text-slate-400 font-bold uppercase tracking-wider" for="projects_done">Projects Completed</label>
                                <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                                       type="number" 
                                       name="projects_done" 
                                       id="projects_done" 
                                       min="0" 
                                       value="{{ old('projects_done', Auth::user()->projects_done ?? 0) }}"/>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs text-slate-600 dark:text-slate-400 font-bold uppercase tracking-wider" for="internships_count">Internships Completed</label>
                                <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                                       type="number" 
                                       name="internships_count" 
                                       id="internships_count" 
                                       min="0" 
                                       value="{{ old('internships_count', Auth::user()->internships_count ?? 0) }}"/>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs text-slate-600 dark:text-slate-400 font-bold uppercase tracking-wider" for="certifications_count">Certifications</label>
                                <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none" 
                                       type="number" 
                                       name="certifications_count" 
                                       id="certifications_count" 
                                       min="0" 
                                       value="{{ old('certifications_count', Auth::user()->certifications_count ?? 0) }}"/>
                            </div>
                            <div class="space-y-1.5 flex flex-col justify-end pb-1.5 select-none">
                                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:bg-primary/5 dark:hover:bg-cyan-accent/5 cursor-pointer transition-all">
                                    <input class="text-primary dark:text-cyan-accent focus:ring-primary rounded" 
                                           type="checkbox" 
                                           name="leadership_role" 
                                           value="1" 
                                           {{ old('leadership_role', Auth::user()->leadership_role) ? 'checked' : '' }}/>
                                    <span class="text-xs text-slate-700 dark:text-slate-350 font-bold uppercase tracking-wider">Leadership Role</span>
                                </label>
                            </div>
                        </div>

                    <!-- Resume Upload Section -->
                    <div class="space-y-1.5 md:col-span-2 pt-4 border-t border-slate-200/40 dark:border-slate-800/40">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold">Academic/Professional Resume (PDF)</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <input type="file" name="resume" accept=".pdf" class="text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary dark:file:text-cyan-accent dark:file:bg-cyan-accent/10 hover:file:bg-primary/20 cursor-pointer">
                            @if(Auth::user()->resume)
                                <a href="{{ asset('storage/' . Auth::user()->resume) }}" target="_blank" class="text-xs text-cyan-accent font-semibold flex items-center gap-1 hover:underline">
                                    <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span>
                                    View Current Resume PDF
                                </a>
                            @endif
                        </div>
                        <span class="text-[10px] text-slate-400 dark:text-slate-500 block">Accepted format: PDF only. Maximum size: 5MB.</span>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 py-3 rounded-xl text-sm font-semibold transition-all active:scale-95 shadow-lg shadow-primary/20">
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </section>

        <!-- Theme Switch Section -->
        <section class="glass-card rounded-2xl p-6 shadow-md">
            <div class="flex items-center gap-3 mb-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-4">
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent">palette</span>
                <h4 class="text-xl text-slate-800 dark:text-slate-100 font-bold">Visual Themes</h4>
            </div>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div class="max-w-md">
                    <p class="text-sm text-slate-800 dark:text-slate-200 font-bold mb-1">Visual Appearance</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Switch between light and dark modes for optimal viewing comfort during analysis.</p>
                </div>
                <div class="flex bg-slate-100 dark:bg-slate-800 p-1.5 rounded-full border border-slate-200 dark:border-slate-700">
                    <button class="flex items-center gap-1 px-6 py-3 rounded-full text-slate-600 dark:text-slate-400 hover:text-slate-800 transition-all font-semibold" id="theme-light" onclick="toggleTheme('light')">
                        <span class="material-symbols-outlined">light_mode</span>
                        <span class="text-sm font-semibold">Light</span>
                    </button>
                    <button class="flex items-center gap-1 px-6 py-3 rounded-full text-slate-600 dark:text-slate-400 hover:text-slate-800 transition-all font-semibold" id="theme-dark" onclick="toggleTheme('dark')">
                        <span class="material-symbols-outlined">dark_mode</span>
                        <span class="text-sm font-semibold">Dark</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Password Change Section -->
        <section class="glass-card rounded-2xl p-6 shadow-md">
            <div class="flex items-center gap-3 mb-6 border-b border-slate-200/40 dark:border-slate-800/40 pb-4">
                <span class="material-symbols-outlined text-primary dark:text-cyan-accent">lock_reset</span>
                <h4 class="text-xl text-slate-800 dark:text-slate-100 font-bold">Security Credentials</h4>
            </div>
            
            <form action="{{ route('settings.save') }}" method="POST">
                @csrf
                <!-- Pass name and email to avoid overwriting them back to old values -->
                <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold" for="password">New Password</label>
                        <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none animate-none" 
                               type="password" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••"/>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm text-slate-600 dark:text-slate-400 block font-semibold" for="password_confirmation">Confirm New Password</label>
                        <input class="w-full rounded-xl px-4 py-3 focus:ring-2 outline-none animate-none" 
                               type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="••••••••"/>
                    </div>
                </div>
                
                <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-1 text-slate-400 dark:text-slate-500 text-xs font-bold">
                        <span class="material-symbols-outlined text-[16px]">info</span>
                        <span>Password must be at least 8 characters. Leave blank if unchanged.</span>
                    </div>
                    <button type="submit" class="w-full sm:w-auto border-2 border-primary text-primary hover:bg-primary/5 dark:border-cyan-accent dark:text-cyan-accent dark:hover:bg-cyan-accent/5 px-8 py-3 rounded-xl text-sm font-bold transition-all active:scale-95">
                        Update Security Key
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Set active button styling on page load based on current class of documentElement
    document.addEventListener('DOMContentLoaded', () => {
        const isDark = document.documentElement.classList.contains('dark');
        const lightBtn = document.getElementById('theme-light');
        const darkBtn = document.getElementById('theme-dark');
        
        if (isDark) {
            darkBtn.classList.add('bg-slate-900', 'text-white', 'dark:bg-slate-700', 'shadow-md');
            darkBtn.classList.remove('text-slate-600', 'dark:text-slate-400');
            lightBtn.classList.remove('bg-white', 'text-primary', 'shadow-md');
            lightBtn.classList.add('text-slate-600', 'dark:text-slate-400');
        } else {
            lightBtn.classList.add('bg-white', 'text-primary', 'shadow-md');
            lightBtn.classList.remove('text-slate-600', 'dark:text-slate-400');
            darkBtn.classList.remove('bg-slate-900', 'text-white', 'dark:bg-slate-700', 'shadow-md');
            darkBtn.classList.add('text-slate-600', 'dark:text-slate-400');
        }

        // Real-time Avatar Preview
        const avatarInput = document.getElementById('avatar-input');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarIcon = document.getElementById('avatar-icon');

        if (avatarInput) {
            avatarInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (avatarPreview) {
                            avatarPreview.src = e.target.result;
                            avatarPreview.classList.remove('hidden');
                        }
                        if (avatarIcon) {
                            avatarIcon.classList.add('hidden');
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    function toggleTheme(mode) {
        const html = document.documentElement;
        const lightBtn = document.getElementById('theme-light');
        const darkBtn = document.getElementById('theme-dark');
        
        if (mode === 'dark') {
            html.classList.add('dark');
            html.classList.remove('light');
            localStorage.setItem('theme', 'dark');
            
            // Dynamic highlights
            darkBtn.classList.add('bg-slate-900', 'text-white', 'dark:bg-slate-700', 'shadow-md');
            darkBtn.classList.remove('text-slate-600', 'dark:text-slate-400');
            lightBtn.classList.remove('bg-white', 'text-primary', 'shadow-md');
            lightBtn.classList.add('text-slate-600', 'dark:text-slate-400');
        } else {
            html.classList.remove('dark');
            html.classList.add('light');
            localStorage.setItem('theme', 'light');
            
            // Dynamic highlights
            lightBtn.classList.add('bg-white', 'text-primary', 'shadow-md');
            lightBtn.classList.remove('text-slate-600', 'dark:text-slate-400');
            darkBtn.classList.remove('bg-slate-900', 'text-white', 'dark:bg-slate-700', 'shadow-md');
            darkBtn.classList.add('text-slate-600', 'dark:text-slate-400');
        }
    }
</script>
@endsection
