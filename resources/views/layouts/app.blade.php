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
    
    <style>
        .sidebar-active {
            border-left: 4px solid #06b6d4;
            background: rgba(99, 102, 241, 0.15);
            color: #f8fafc !important;
            font-weight: 700;
        }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen relative overflow-x-hidden">
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
    <div class="fixed top-[-10%] left-[-10%] w-[600px] h-[600px] rounded-full bg-primary/5 dark:bg-primary/10 blur-[130px] pointer-events-none -z-10 transition-all duration-500"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-cyan-accent/5 dark:bg-cyan-accent/10 blur-[120px] pointer-events-none -z-10 transition-all duration-500"></div>
    <div class="fixed top-[30%] left-[40%] w-[400px] h-[400px] rounded-full bg-purple-accent/5 dark:bg-purple-accent/5 blur-[100px] pointer-events-none -z-10 transition-all duration-500"></div>

    <!-- Sidebar Navigation -->
    <aside class="fixed left-0 top-0 h-full w-64 bg-slate-900 dark:bg-slate-950 flex flex-col shadow-2xl z-40 hidden md:flex border-r border-slate-800/50">
        <div class="px-6 py-10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary to-cyan-accent flex items-center justify-center shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-white text-[24px]">school</span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white tracking-tight">Academic AI</h1>
                <p class="text-slate-400 text-[11px] uppercase tracking-wider font-bold">Portal Hub</p>
            </div>
        </div>
        
        <nav class="flex-1 flex flex-col mt-6">
            <a class="flex items-center gap-3 px-6 py-3 text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all duration-200 {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                <span class="text-sm font-semibold">Dashboard</span>
            </a>
            
            <a class="flex items-center gap-3 px-6 py-3 text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all duration-200 {{ request()->routeIs('tests.*') ? 'sidebar-active' : '' }}" href="{{ route('tests.index') }}">
                <span class="material-symbols-outlined text-[20px]">quiz</span>
                <span class="text-sm font-semibold">Assessment Center</span>
            </a>
            
            <a class="flex items-center gap-3 px-6 py-3 text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all duration-200 {{ request()->routeIs('prediction.final') || request()->routeIs('evaluation.results') ? 'sidebar-active' : '' }}" href="{{ route('prediction.final') }}">
                <span class="material-symbols-outlined text-[20px]">psychology</span>
                <span class="text-sm font-semibold">Final Prediction</span>
            </a>
            
            <a class="flex items-center gap-3 px-6 py-3 text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all duration-200 {{ request()->routeIs('analytics') ? 'sidebar-active' : '' }}" href="{{ route('analytics') }}">
                <span class="material-symbols-outlined text-[20px]">monitoring</span>
                <span class="text-sm font-semibold">Interactive Analytics</span>
            </a>

            <a class="flex items-center gap-3 px-6 py-3 text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all duration-200 {{ request()->routeIs('career.*') ? 'sidebar-active' : '' }}" href="{{ route('career.index') }}">
                <span class="material-symbols-outlined text-[20px]">verified</span>
                <span class="text-sm font-semibold">Placement & Career Hub</span>
            </a>
            
            @if(Auth::check() && Auth::user()->is_admin)
            <a class="flex items-center gap-3 px-6 py-3 text-slate-300 hover:bg-slate-800/50 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
                <span class="text-sm font-semibold">Admin Panel</span>
            </a>
            @endif
            
            <!-- Premium Profile Widget Section -->
            <div class="mt-auto border-t border-slate-800/80 p-4 relative">
                <!-- Profile Info Card (Static) -->
                <div class="w-full flex items-center gap-3 px-3 py-2.5 rounded-2xl border border-slate-800/50 bg-slate-950/40">
                    <div class="w-9 h-9 rounded-full bg-slate-850 border border-slate-700/60 overflow-hidden flex items-center justify-center flex-shrink-0">
                        @if(Auth::check() && Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-slate-450 text-[20px]">account_circle</span>
                        @endif
                    </div>
                    <div class="flex-grow min-w-0">
                        <span class="text-xs font-bold text-slate-200 block truncate">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-slate-500 block truncate">{{ Auth::user()->email }}</span>
                    </div>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Main Content Canvas -->
    <main class="md:ml-64 min-h-screen flex flex-col">
        <!-- Top App Bar -->
        <header class="fixed top-0 right-0 left-0 md:left-64 bg-white/70 dark:bg-slate-950/70 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800/50 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-3 h-16">
                <div class="flex items-center gap-3">
                    <button class="md:hidden p-2 material-symbols-outlined text-slate-700 dark:text-slate-200" id="mobile-menu-toggle">menu</button>
                    <span class="text-lg font-bold text-slate-800 dark:text-slate-200 hidden sm:inline-block">Evaluating Academic Potential</span>
                    <span class="text-lg font-bold text-slate-800 dark:text-slate-200 sm:hidden">Academic AI</span>
                </div>
                
                <div class="flex items-center gap-6">
                    <!-- Real-time Service Status Indicators -->
                    <div class="flex items-center gap-2 mr-2 text-[10px] font-bold uppercase tracking-wider">
                        <!-- MongoDB Status Badge -->
                        <span id="mongo-status-badge" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-400 dark:text-slate-500 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400" id="mongo-status-dot"></span>
                            DB
                        </span>
                        <!-- FastAPI Status Badge -->
                        <span id="fastapi-status-badge" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-400 dark:text-slate-500 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400" id="fastapi-status-dot"></span>
                            ANN
                        </span>
                    </div>

                    <!-- Sleek Navbar Profile Dropdown -->
                    <div class="relative">
                        <button id="navbar-profile-trigger" class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden border-2 border-primary/20 hover:border-primary/50 transition-all flex items-center justify-center focus:outline-none shadow-sm cursor-pointer">
                            @if(Auth::check() && Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-slate-550 dark:text-slate-400 font-bold text-[20px]">account_circle</span>
                            @endif
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="navbar-profile-dropdown" class="absolute right-0 mt-2.5 w-56 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl shadow-2xl p-2 z-50 flex flex-col gap-1 transition-all duration-200 transform scale-95 opacity-0 pointer-events-none backdrop-blur-xl">
                            <div class="px-3 py-2 border-b border-slate-200 dark:border-slate-800/50 mb-1">
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block truncate">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-slate-500 block truncate">{{ Auth::user()->email }}</span>
                            </div>
                            <a href="{{ route('settings') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/60 transition-colors text-xs font-semibold">
                                <span class="material-symbols-outlined text-[18px]">settings</span>
                                <span>General Preferences</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="w-full m-0">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-red-500 hover:text-red-650 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors text-xs font-semibold text-left cursor-pointer">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    <span>Logout Session</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Drawer Navigation -->
        <div id="mobile-sidebar" class="fixed inset-0 z-50 bg-black/60 hidden md:hidden backdrop-blur-sm transition-all duration-300">
            <div class="w-64 h-full bg-slate-900 flex flex-col p-6 shadow-2xl relative">
                <button class="absolute top-2 right-2 text-white material-symbols-outlined" id="mobile-menu-close">close</button>
                <div class="py-8 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-primary to-cyan-accent flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-[18px]">school</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">Academic AI</h1>
                        <p class="text-slate-400 text-xs">Potentials Evaluation</p>
                    </div>
                </div>
                <nav class="flex-grow flex flex-col gap-2">
                    <a class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 rounded-lg {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 rounded-lg {{ request()->routeIs('tests.*') ? 'sidebar-active' : '' }}" href="{{ route('tests.index') }}">
                        <span class="material-symbols-outlined">quiz</span>
                        <span class="text-sm font-semibold">Assessment Center</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 rounded-lg {{ request()->routeIs('prediction.final') || request()->routeIs('evaluation.results') ? 'sidebar-active' : '' }}" href="{{ route('prediction.final') }}">
                        <span class="material-symbols-outlined">psychology</span>
                        <span class="text-sm font-semibold">Final Prediction</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 rounded-lg {{ request()->routeIs('analytics') ? 'sidebar-active' : '' }}" href="{{ route('analytics') }}">
                        <span class="material-symbols-outlined">monitoring</span>
                        <span class="text-sm font-semibold">Interactive Analytics</span>
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 rounded-lg {{ request()->routeIs('career.*') ? 'sidebar-active' : '' }}" href="{{ route('career.index') }}">
                        <span class="material-symbols-outlined">verified</span>
                        <span class="text-sm font-semibold">Placement & Career Hub</span>
                    </a>

                    @if(Auth::check() && Auth::user()->is_admin)
                    <a class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <span class="material-symbols-outlined">admin_panel_settings</span>
                        <span class="text-sm font-semibold">Admin Panel</span>
                    </a>
                    @endif
                    <!-- Premium Mobile Profile Widget Section -->
                    <div class="mt-auto border-t border-slate-800/80 p-4 relative">
                        <!-- Profile Info Card (Static) -->
                        <div class="w-full flex items-center gap-3 px-3 py-2.5 rounded-2xl border border-slate-800/50 bg-slate-950/40">
                            <div class="w-9 h-9 rounded-full bg-slate-855 border border-slate-700/60 overflow-hidden flex items-center justify-center flex-shrink-0">
                                @if(Auth::check() && Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-slate-450 text-[20px]">account_circle</span>
                                @endif
                            </div>
                            <div class="flex-grow min-w-0">
                                <span class="text-xs font-bold text-slate-200 block truncate">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-slate-500 block truncate">{{ Auth::user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Render Content -->
        <div class="flex-grow pt-24 pb-8">
            @yield('content')
        </div>
    </main>

    <script>
        // Mobile menu drawer toggle
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const closeBtn = document.getElementById('mobile-menu-close');
        const mobileSidebar = document.getElementById('mobile-sidebar');

        if (toggleBtn && closeBtn && mobileSidebar) {
            toggleBtn.addEventListener('click', () => {
                mobileSidebar.classList.remove('hidden');
            });
            closeBtn.addEventListener('click', () => {
                mobileSidebar.classList.add('hidden');
            });
            mobileSidebar.addEventListener('click', (e) => {
                if (e.target === mobileSidebar) {
                    mobileSidebar.classList.add('hidden');
                }
            });
        }

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

        // Real-time Service Status Checker
        function checkServiceStatuses() {
            fetch('{{ route('system.status') }}')
                .then(response => response.json())
                .then(data => {
                    updateStatusBadge('mongo', data.mongodb === 'online');
                    updateStatusBadge('fastapi', data.fastapi === 'online');
                })
                .catch(err => {
                    updateStatusBadge('mongo', false);
                    updateStatusBadge('fastapi', false);
                });
        }

        function updateStatusBadge(service, isOnline) {
            const badge = document.getElementById(`${service}-status-badge`);
            const dot = document.getElementById(`${service}-status-dot`);
            
            if (!badge || !dot) return;

            if (isOnline) {
                badge.className = "px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-400/30 text-emerald-700 dark:text-emerald-400 rounded-full flex items-center gap-1 transition-all";
                dot.className = "w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse";
            } else {
                badge.className = "px-2.5 py-1 bg-red-50 dark:bg-red-950/20 border border-red-400/30 text-red-700 dark:text-red-400 rounded-full flex items-center gap-1 transition-all";
                dot.className = "w-1.5 h-1.5 rounded-full bg-red-500";
                
                // Alert if it is a transition to offline
                if (badge.dataset.status === 'online') {
                    showToast(
                        `${service === 'mongo' ? 'Database' : 'ANN Predictor'} Offline`,
                        `The ${service === 'mongo' ? 'MongoDB Atlas cloud database' : 'FastAPI ANN predictive service'} is currently unreachable.`,
                        'error'
                    );
                }
            }
            badge.dataset.status = isOnline ? 'online' : 'offline';
        }

        // Run checks and handle session flashes on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            // Check statuses immediately
            checkServiceStatuses();
            // Poll statuses every 30 seconds
            setInterval(checkServiceStatuses, 30000);

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

        // Interactive Profile Menu event listener logic removed (replaced by premium static metadata profile card)

        // Interactive Navbar Profile Dropdown Menu
        const navbarProfileTrigger = document.getElementById('navbar-profile-trigger');
        const navbarProfileDropdown = document.getElementById('navbar-profile-dropdown');

        if (navbarProfileTrigger && navbarProfileDropdown) {
            navbarProfileTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = !navbarProfileDropdown.classList.contains('pointer-events-none');
                if (isOpen) {
                    closeNavbarProfileDropdown();
                } else {
                    openNavbarProfileDropdown();
                }
            });
        }

        function openNavbarProfileDropdown() {
            navbarProfileDropdown.classList.remove('pointer-events-none', 'scale-95', 'opacity-0');
            navbarProfileDropdown.classList.add('scale-100', 'opacity-100');
        }

        function closeNavbarProfileDropdown() {
            navbarProfileDropdown.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
            navbarProfileDropdown.classList.remove('scale-100', 'opacity-100');
        }

        // Click away listener
        document.addEventListener('click', (e) => {
            if (navbarProfileDropdown && !navbarProfileTrigger.contains(e.target) && !navbarProfileDropdown.contains(e.target)) {
                closeNavbarProfileDropdown();
            }
        });

        // Floating Theme Toggle Logic
        function toggleTheme() {
            const html = document.documentElement;
            const icon = document.getElementById('theme-toggle-icon');
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                html.classList.add('light');
                localStorage.setItem('theme', 'light');
                if (icon) icon.innerText = "dark_mode";
                showToast('Light Mode', 'Switched to clean light interface theme.', 'info');
            } else {
                html.classList.remove('light');
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (icon) icon.innerText = "light_mode";
                showToast('Dark Mode', 'Switched to sleek premium dark interface theme.', 'info');
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            const icon = document.getElementById('theme-toggle-icon');
            if (icon) {
                icon.innerText = document.documentElement.classList.contains('dark') ? "light_mode" : "dark_mode";
            }
        });
    </script>
    @yield('scripts')

    <!-- Floating Premium Glassmorphic Theme Switcher -->
    <button onclick="toggleTheme()" class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-slate-200 dark:border-slate-800 shadow-2xl flex items-center justify-center text-slate-700 dark:text-slate-200 hover:scale-110 active:scale-95 transition-all z-50 cursor-pointer group" id="theme-toggle-floating" title="Switch Theme">
        <span class="material-symbols-outlined transition-transform duration-500 group-hover:rotate-45" id="theme-toggle-icon">dark_mode</span>
    </button>
</body>
</html>
