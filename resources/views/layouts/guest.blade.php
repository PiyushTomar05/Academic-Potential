<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Evaluating Academic Potential')</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Geist:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Inline Render-Blocking Theme Check -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        } else {
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('styles')
</head>
<body class="min-h-screen relative overflow-x-hidden flex flex-col">
    <!-- Dynamic Toast Notification -->
    <div id="toast-notification" class="fixed top-20 right-6 z-50 transform translate-x-[150%] transition-transform duration-500 max-w-sm w-full bg-white dark:bg-slate-900 border-l-4 rounded-2xl shadow-2xl p-4 flex items-start gap-3 border-primary backdrop-blur-xl">
        <span id="toast-icon" class="material-symbols-outlined text-[24px] mt-0.5">info</span>
        <div>
            <h5 id="toast-title" class="text-sm font-bold text-slate-800 dark:text-slate-100">Notification</h5>
            <p id="toast-message" class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Details of the session events.</p>
        </div>
        <button onclick="hideToast()" class="ml-auto material-symbols-outlined text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-[18px]">close</button>
    </div>

    <!-- Global Background Glow Blobs -->
    <div class="fixed top-[-15%] right-[-10%] w-[600px] h-[600px] rounded-full bg-primary/5 dark:bg-primary/10 blur-[130px] pointer-events-none -z-10 transition-all duration-500"></div>
    <div class="fixed bottom-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-cyan-accent/5 dark:bg-cyan-accent/10 blur-[120px] pointer-events-none -z-10 transition-all duration-500"></div>

    <!-- Top Floating Navigation Bar Capsule -->
    <div class="fixed top-4 w-full z-50 px-6">
        <nav class="max-w-[1200px] mx-auto bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl border border-slate-200/50 dark:border-slate-800/50 shadow-lg rounded-2xl transition-all duration-300" id="top-nav">
            <div class="px-6 py-3 flex justify-between items-center h-16">
                <a href="{{ route('landing') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-primary to-cyan-accent flex items-center justify-center shadow-md">
                        <span class="material-symbols-outlined text-white text-[18px]">school</span>
                    </div>
                    <span class="font-bold text-sm sm:text-lg text-slate-800 dark:text-slate-100 tracking-tight">Academic AI</span>
                </a>
                
                <div class="hidden md:flex items-center gap-6">
                    <a class="font-medium text-sm {{ request()->routeIs('landing') ? 'text-primary dark:text-cyan-accent font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-primary' }} transition-colors" href="{{ route('landing') }}">Home Page</a>
                    <a class="font-medium text-sm text-slate-600 dark:text-slate-300 hover:text-primary transition-colors" href="{{ request()->routeIs('landing') ? '#features' : route('landing') . '#features' }}">Platform Features</a>
                    <a class="font-medium text-sm text-slate-600 dark:text-slate-300 hover:text-primary transition-colors" href="{{ request()->routeIs('landing') ? '#workflow' : route('landing') . '#workflow' }}">How it Works</a>
                </div>
                
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm bg-primary text-white rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 transition-all font-semibold active:scale-95">Go to Portal</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all font-semibold">Sign In</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm bg-primary text-white rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 transition-all font-semibold active:scale-95">Register</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>

    <!-- Render Page Content -->
    <main class="flex-grow flex flex-col pt-24">
        @yield('content')
    </main>

    <!-- Unified Sleek Footer -->
    <footer class="w-full py-10 border-t border-slate-200/50 dark:border-slate-800/50 bg-white/40 dark:bg-slate-950/40 backdrop-blur-xl mt-8">
        <div class="max-w-[1200px] mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-col items-center md:items-start gap-2">
                <span class="text-lg font-bold text-slate-800 dark:text-slate-100 tracking-tight">Academic AI Portal</span>
                <span class="text-xs text-slate-500 dark:text-slate-400">© 2026 Evaluating Academic Potential. Built with premium neural algorithms.</span>
            </div>
            <div class="flex gap-6 text-sm">
                <a class="text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-primary transition-colors" href="#">Research labs</a>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('top-nav');
            if (window.scrollY > 20) {
                nav.classList.add('shadow-xl', 'bg-white/95', 'dark:bg-slate-900/95', 'border-primary/10');
                nav.classList.remove('bg-white/70', 'dark:bg-slate-900/70');
            } else {
                nav.classList.remove('shadow-xl', 'bg-white/95', 'dark:bg-slate-900/95', 'border-primary/10');
                nav.classList.add('bg-white/70', 'dark:bg-slate-900/70');
            }
        });
    </script>
    <script>
        // Global Toast Notification Helper
        let toastTimeout;
        function showToast(title, message, type = 'info') {
            const toast = document.getElementById('toast-notification');
            const icon = document.getElementById('toast-icon');
            const titleEl = document.getElementById('toast-title');
            const msgEl = document.getElementById('toast-message');
            
            if (!toast) return;

            // Reset classes
            toast.className = "fixed top-20 right-6 z-50 transform transition-transform duration-500 max-w-sm w-full bg-white dark:bg-slate-900 border-l-4 rounded-2xl shadow-2xl p-4 flex items-start gap-3 backdrop-blur-xl transition-all duration-300";
            
            if (type === 'success') {
                toast.classList.add('border-emerald-500');
                icon.innerText = "check_circle";
                icon.className = "material-symbols-outlined text-[24px] mt-0.5 text-emerald-500";
            } else if (type === 'error') {
                toast.classList.add('border-red-500');
                icon.innerText = "warning";
                icon.className = "material-symbols-outlined text-[24px] mt-0.5 text-red-500";
            } else if (type === 'warning') {
                toast.classList.add('border-amber-500');
                icon.innerText = "report_problem";
                icon.className = "material-symbols-outlined text-[24px] mt-0.5 text-amber-500";
            } else {
                toast.classList.add('border-primary');
                icon.innerText = "info";
                icon.className = "material-symbols-outlined text-[24px] mt-0.5 text-primary";
            }

            titleEl.innerText = title;
            msgEl.innerText = message;

            // Slide in
            toast.classList.remove('translate-x-[150%]');

            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(hideToast, 5000);
        }

        function hideToast() {
            const toast = document.getElementById('toast-notification');
            if (toast) {
                toast.classList.add('translate-x-[150%]');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Laravel session flash triggers
            @if(session('status'))
                showToast('Success', "{{ session('status') }}", 'success');
            @endif
            @if(session('error'))
                showToast('Error', "{{ session('error') }}", 'error');
            @endif
            @if($errors->any())
                showToast('Validation Error', "Please review form inputs and try again.", 'error');
            @endif
        });
    </script>
    @yield('scripts')
</body>
</html>
