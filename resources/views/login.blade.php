@extends('layouts.guest')

@section('title', 'Sign In | Evaluating Academic Potential')

@section('content')
<main class="flex-grow flex items-center justify-center relative overflow-hidden py-12">
    <div class="w-full max-w-[1200px] px-6 grid md:grid-cols-2 gap-12 items-center mx-auto mt-6">
        <!-- Branding/Visual Side -->
        <div class="hidden md:flex flex-col gap-6">
            <div class="flex items-center gap-4">
                <span class="bg-primary/10 dark:bg-primary/20 text-primary dark:text-cyan-accent px-3 py-1 rounded-full text-xs uppercase tracking-wider font-extrabold border border-primary/20">AI Engine Ready</span>
            </div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-800 dark:text-slate-100 leading-tight">
                Empowering Minds with <span class="ai-gradient-text">Predictive Potential</span> Intelligence.
            </h2>
            <p class="text-base text-slate-500 dark:text-slate-400 max-w-[480px] leading-relaxed">
                Log in to predict your career potential, run academic evaluations, or manage student cohort profiles.
            </p>
            <div class="mt-8 flex gap-6">
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold text-primary dark:text-cyan-accent">98.4%</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Prediction accuracy</span>
                </div>
                <div class="w-[1px] bg-slate-200 dark:bg-slate-800 h-12"></div>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold text-primary dark:text-cyan-accent">&lt;0.2s</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Model Latency</span>
                </div>
            </div>
        </div>
        
        <!-- Login Card -->
        <div class="w-full max-w-[480px] mx-auto relative z-20">
            <div class="glass-card rounded-2xl p-6 md:p-8 border border-slate-200/50 dark:border-slate-800/50">
                <div class="mb-8">
                    <h3 class="text-lg sm:text-xl font-bold text-slate-800 dark:text-slate-100 mb-1.5 font-bold">Welcome Back</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Please enter your credentials to access the portal.</p>
                </div>
                
                <form class="flex flex-col gap-6" action="{{ route('login.post') }}" method="POST">
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
                        <label class="text-sm font-semibold text-slate-600 dark:text-slate-400 ml-1" for="email">Email Address</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">alternate_email</span>
                            <input class="w-full pl-12 pr-4 py-3 rounded-xl focus:ring-2 outline-none text-sm" 
                                   placeholder="elena@stanford.edu" 
                                   type="email" 
                                   id="email"
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus/>
                        </div>
                    </div>
                    
                    <!-- Input Group -->
                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-sm font-semibold text-slate-600 dark:text-slate-400" for="password">Security Password</label>
                        </div>
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
                    
                    <!-- Action -->
                    <button class="ai-btn-gradient text-on-primary w-full py-3 rounded-xl text-sm shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex justify-center items-center gap-4 mt-4 font-bold uppercase tracking-wider" type="submit">
                        Sign In to Portal
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>
                
                <p class="text-center mt-8 text-sm text-slate-500 dark:text-slate-400">
                    Don't have an account? <a class="text-primary dark:text-cyan-accent font-bold hover:underline" href="{{ route('register') }}">Register here</a>
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
