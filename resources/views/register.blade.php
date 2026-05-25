@extends('layouts.guest')

@section('title', 'Register | Evaluating Academic Potential')

@section('content')
<main class="flex-grow flex items-center justify-center relative overflow-hidden py-12">
    <div class="w-full max-w-[1200px] px-6 grid md:grid-cols-2 gap-12 items-center mx-auto mt-6">
        <!-- Branding/Visual Side -->
        <div class="hidden md:flex flex-col gap-6">
            <div class="flex items-center gap-4">
                <span class="bg-primary/10 dark:bg-primary/20 text-primary dark:text-cyan-accent px-3 py-1 rounded-full text-xs uppercase tracking-wider font-extrabold border border-primary/20">AI Platform Gateway</span>
            </div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-800 dark:text-slate-100 leading-tight">
                Unlock Strategic <span class="ai-gradient-text">Career Tracks</span> in Seconds.
            </h2>
            <p class="text-base text-slate-500 dark:text-slate-400 max-w-[480px] leading-relaxed">
                Register to evaluate individual academic potential across any field, or manage institutional student cohorts.
            </p>
            <div class="mt-8 flex gap-6">
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-primary dark:text-cyan-accent font-extrabold">100%</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Data Sovereignty</span>
                </div>
                <div class="w-[1px] bg-slate-200 dark:bg-slate-800 h-12"></div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-primary dark:text-cyan-accent font-extrabold">SQLite</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Local Storage</span>
                </div>
            </div>
        </div>
        
        <!-- Register Card -->
        <div class="w-full max-w-[480px] mx-auto relative z-20">
            <div class="glass-card rounded-2xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50">
                <div class="mb-8">
                    <h3 class="text-lg sm:text-xl font-bold text-slate-800 dark:text-slate-100 mb-1.5">Register Account</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Create a secure account to begin forecasting potential.</p>
                </div>
                
                <form class="flex flex-col gap-6" action="{{ route('register.post') }}" method="POST">
                    @csrf
                    
                    <!-- Display Errors -->
                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-950/20 border border-red-400 text-red-800 dark:text-red-300 p-4 rounded-xl text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Input Group -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-slate-600 dark:text-slate-400 ml-1" for="name">Full Name / Organization</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">badge</span>
                            <input class="w-full pl-12 pr-4 py-3 rounded-xl focus:ring-2 outline-none text-sm" 
                                   placeholder="e.g. Elena Smith" 
                                   type="text" 
                                   id="name"
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus/>
                        </div>
                    </div>
                    
                    <!-- Input Group -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-slate-600 dark:text-slate-400 ml-1" for="email">Email Address</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">alternate_email</span>
                            <input class="w-full pl-12 pr-4 py-3 rounded-xl focus:ring-2 outline-none text-sm" 
                                   placeholder="elena@stanford.edu" 
                                   type="email" 
                                   id="email"
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required/>
                        </div>
                    </div>
                    
                    <!-- Input Group -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-slate-600 dark:text-slate-400 ml-1" for="password">Security Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">vpn_key</span>
                            <input class="w-full pl-12 pr-4 py-3 rounded-xl focus:ring-2 outline-none text-sm" 
                                   placeholder="••••••••" 
                                   type="password" 
                                   id="password"
                                   name="password" 
                                   required/>
                        </div>
                    </div>
 
                    <!-- Input Group -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-slate-600 dark:text-slate-400 ml-1" for="password_confirmation">Confirm Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">vpn_key</span>
                            <input class="w-full pl-12 pr-4 py-3 rounded-xl focus:ring-2 outline-none text-sm" 
                                   placeholder="••••••••" 
                                   type="password" 
                                   id="password_confirmation"
                                   name="password_confirmation" 
                                   required/>
                        </div>
                    </div>
                    
                    <!-- Action -->
                    <button class="ai-btn-gradient text-on-primary w-full py-3 rounded-xl text-sm shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex justify-center items-center gap-4 mt-4 font-bold uppercase tracking-wider" type="submit">
                        Register and Enter Portal
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>
                
                <p class="text-center mt-8 text-sm text-slate-500 dark:text-slate-400">
                    Already have an account? <a class="text-primary dark:text-cyan-accent font-bold hover:underline" href="{{ route('login') }}">Login here</a>
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
