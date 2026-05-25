@extends('layouts.guest')

@section('title', 'Academic AI | Next-Gen Potential Predictions')

@section('content')
<main class="flex-grow relative">
    <!-- Hero Canvas Background -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden min-h-[900px]">
        <canvas id="neuralCanvas" class="w-full h-full opacity-60 dark:opacity-40"></canvas>
    </div>

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-36 pb-20 md:pt-48 md:pb-28 px-6 z-10">
        <div class="max-w-[1200px] mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="space-y-6 relative z-20 transform hover:-translate-y-1 transition-transform duration-500">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary/10 dark:bg-primary/20 text-primary dark:text-cyan-accent border border-primary/20 rounded-full text-xs uppercase tracking-wider font-bold animate-pulse">
                    <span class="material-symbols-outlined text-[16px] font-bold">psychology</span>
                    Deep Multi-Layer Perceptrons v4.0
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight text-slate-800 dark:text-slate-100 leading-[1.05]">
                    Evaluating Academic <span class="ai-gradient-text">Potential</span>
                </h1>
                <p class="text-base text-slate-500 dark:text-slate-400 max-w-xl leading-relaxed">
                    A premium AI-powered employment potential forecast engine mapping student academic portfolios and skill milestones dynamically. Unlock predictive analytics with deep ANN/MLP intelligence.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="ai-btn-gradient px-8 py-4 text-sm rounded-xl flex items-center gap-2 font-semibold shadow-lg shadow-primary/25 hover:shadow-xl active:scale-95 transition-all">
                            Go to Portal Hub
                            <span class="material-symbols-outlined font-bold">arrow_forward</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="ai-btn-gradient px-8 py-4 text-sm rounded-xl flex items-center gap-2 font-semibold shadow-lg shadow-primary/25 hover:shadow-xl active:scale-95 transition-all">
                            Check Your Potential
                            <span class="material-symbols-outlined font-bold">arrow_forward</span>
                        </a>
                        <a href="{{ route('register') }}" class="px-8 py-4 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm rounded-xl transition-all font-semibold active:scale-95">
                            Create Free Account
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Dynamic Glowing Network Grid Section -->
            <div class="relative flex items-center justify-center min-h-[300px] z-20 group">
                <div class="absolute inset-0 bg-primary/5 dark:bg-cyan-accent/5 rounded-full blur-[80px] group-hover:scale-110 transition-transform duration-700"></div>
                <!-- Interactive SVG Neural Convergence Grid -->
                <svg class="w-full h-full max-w-[420px] max-h-[340px] transform group-hover:scale-105 transition-transform duration-500" viewBox="0 0 200 200">
                    <!-- Connection Lines -->
                    <line x1="20" y1="100" x2="80" y2="40" stroke="rgba(99, 102, 241, 0.2)" stroke-width="1.5" class="animate-pulse"></line>
                    <line x1="20" y1="100" x2="80" y2="100" stroke="rgba(99, 102, 241, 0.2)" stroke-width="1.5"></line>
                    <line x1="20" y1="100" x2="80" y2="160" stroke="rgba(99, 102, 241, 0.2)" stroke-width="1.5" class="animate-pulse"></line>
                    
                    <line x1="80" y1="40" x2="140" y2="60" stroke="rgba(6, 182, 212, 0.2)" stroke-width="1.5"></line>
                    <line x1="80" y1="100" x2="140" y2="60" stroke="rgba(6, 182, 212, 0.2)" stroke-width="1.5" class="animate-pulse"></line>
                    <line x1="80" y1="100" x2="140" y2="140" stroke="rgba(6, 182, 212, 0.2)" stroke-width="1.5"></line>
                    <line x1="80" y1="160" x2="140" y2="140" stroke="rgba(6, 182, 212, 0.2)" stroke-width="1.5" class="animate-pulse"></line>
                    
                    <line x1="140" y1="60" x2="180" y2="100" stroke="rgba(168, 85, 247, 0.2)" stroke-width="2"></line>
                    <line x1="140" y1="140" x2="180" y2="100" stroke="rgba(168, 85, 247, 0.2)" stroke-width="2"></line>
                    
                    <!-- Nodes (Input Layer) -->
                    <circle cx="20" cy="100" r="6" fill="#6366f1"></circle>
                    <!-- Nodes (Hidden Layer) -->
                    <circle cx="80" cy="40" r="7" fill="#06b6d4"></circle>
                    <circle cx="80" cy="100" r="7" fill="#06b6d4"></circle>
                    <circle cx="80" cy="160" r="7" fill="#06b6d4"></circle>
                    <!-- Nodes (Output Layer) -->
                    <circle cx="140" cy="60" r="8" fill="#a855f7"></circle>
                    <circle cx="140" cy="140" r="8" fill="#a855f7"></circle>
                    
                    <circle cx="180" cy="100" r="10" fill="#6366f1" filter="drop-shadow(0 0 6px #6366f1)"></circle>
                </svg>
                
                <!-- Floating Data Card -->
                <div class="absolute -bottom-2 -left-2 glass-card p-6 rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-800/50 flex items-center gap-3 transform hover:rotate-3 transition-transform duration-300">
                    <div class="p-2 bg-primary/10 dark:bg-primary/20 rounded-lg text-primary dark:text-cyan-accent">
                        <span class="material-symbols-outlined font-bold text-[20px]">trending_up</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">Model Accuracy</p>
                        <p class="text-xl text-primary dark:text-cyan-accent font-black">98.4%</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section (Floating Suspended Bento Panel) -->
    <section class="max-w-[1200px] mx-auto px-6 mb-20 relative z-10">
        <div class="glass-card rounded-[2rem] p-8 shadow-2xl border border-slate-200/40 dark:border-slate-800/40">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 divide-y md:divide-y-0 md:divide-x divide-slate-200/30 dark:divide-slate-800/30">
                <div class="text-center p-6 flex flex-col justify-center items-center">
                    <p class="text-4xl md:text-5xl font-black text-primary dark:text-cyan-accent mb-1.5" data-target="500000">0</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold mt-1">Students Assessed</p>
                </div>
                <div class="text-center p-6 flex flex-col justify-center items-center pt-6 md:pt-0">
                    <p class="text-4xl md:text-5xl font-black text-primary dark:text-cyan-accent mb-1.5" data-target="120">0</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold mt-1">Research Hubs</p>
                </div>
                <div class="text-center p-6 flex flex-col justify-center items-center pt-6 md:pt-0">
                    <p class="text-4xl md:text-5xl font-black text-primary dark:text-cyan-accent mb-1.5" data-target="0.18">0</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold mt-1">ANN Speed (s)</p>
                </div>
                <div class="text-center p-6 flex flex-col justify-center items-center pt-6 md:pt-0">
                    <p class="text-4xl md:text-5xl font-black text-primary dark:text-cyan-accent mb-1.5" data-target="98.4">0</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold mt-1">Classification Fit %</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PREMIUM: How AI Prediction Works -->
    <section class="py-16 px-6 relative z-10 bg-slate-50/50 dark:bg-slate-900/30 border-y border-slate-200/50 dark:border-slate-800/50 backdrop-blur-md">
        <div class="max-w-[1200px] mx-auto">
            <div class="text-center mb-16">
                <span class="text-xs text-primary dark:text-cyan-accent font-bold uppercase tracking-widest block mb-2">Architectural Logic</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">How AI Prediction Works</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-2xl mx-auto font-medium mt-2">Our backend channels student statistics through continuous multi-layered neural configurations to render diagnostic employment trends.</p>
            </div>

            <!-- Workflow Timeline Stepper Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Timeline Connecting line (Hidden on mobile) -->
                <div class="hidden md:block absolute top-1/4 left-[12%] right-[12%] h-[3px] bg-gradient-to-r from-primary via-cyan-accent to-purple-500 -z-10 opacity-30"></div>

                <!-- Step 1 -->
                <div class="glass-card p-6 rounded-2xl relative border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute -top-6 left-6 w-12 h-12 rounded-2xl bg-primary flex items-center justify-center text-white font-extrabold shadow-lg shadow-primary/30 text-lg">01</div>
                    <div class="pt-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2">Input Academic Metrics</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Inputs like CGPA, certified portfolio counts, certifications, and communication scores are ingested and validated.</p>
                    </div>
                    <div class="mt-6 flex items-center gap-2 text-primary dark:text-cyan-accent">
                        <span class="material-symbols-outlined text-[18px]">rule_folder</span>
                        <span class="text-[11px] font-bold uppercase tracking-wider">Vector Normalization</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="glass-card p-6 rounded-2xl relative border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute -top-6 left-6 w-12 h-12 rounded-2xl bg-cyan-accent flex items-center justify-center text-white font-extrabold shadow-lg shadow-cyan-accent/30 text-lg">02</div>
                    <div class="pt-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2">ANN Processing</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">The model propagates data vectors through deep multi-layer nodes, computing activation maps to weight capabilities.</p>
                    </div>
                    <div class="mt-6 flex items-center gap-2 text-cyan-500 dark:text-cyan-accent">
                        <span class="material-symbols-outlined text-[18px]">schema</span>
                        <span class="text-[11px] font-bold uppercase tracking-wider">Synaptic Processing</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="glass-card p-6 rounded-2xl relative border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute -top-6 left-6 w-12 h-12 rounded-2xl bg-purple-500 flex items-center justify-center text-white font-extrabold shadow-lg shadow-purple-500/30 text-lg">03</div>
                    <div class="pt-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2">Employment Prediction</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Our FastAPI server provides high-accuracy, real-time classifications with custom fit placement metrics.</p>
                    </div>
                    <div class="mt-6 flex items-center gap-2 text-purple-500 dark:text-purple-400">
                        <span class="material-symbols-outlined text-[18px]">troubleshoot</span>
                        <span class="text-[11px] font-bold uppercase tracking-wider">Classification FIT</span>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="glass-card p-6 rounded-2xl relative border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute -top-6 left-6 w-12 h-12 rounded-2xl bg-slate-800 dark:bg-slate-700 flex items-center justify-center text-white font-extrabold shadow-lg shadow-slate-500/30 text-lg">04</div>
                    <div class="pt-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2">Recommendations</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Dynamic roadmap diagnostics mapping structural strengths, weaknesses, and skill enhancement path outlines.</p>
                    </div>
                    <div class="mt-6 flex items-center gap-2 text-slate-600 dark:text-slate-300">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                        <span class="text-[11px] font-bold uppercase tracking-wider">Actionable Strategy</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive CTA Section -->
    <section class="py-20 px-6 relative z-10 text-center">
        <div class="max-w-[800px] mx-auto glass-card rounded-[2.5rem] p-10 md:p-16 border border-slate-200/40 dark:border-slate-800/40 shadow-2xl relative overflow-hidden group">
            <div class="absolute top-[-30%] left-[-20%] w-[350px] h-[350px] bg-primary/10 dark:bg-primary/20 rounded-full blur-[100px] group-hover:scale-110 transition-transform duration-700"></div>
            <div class="absolute bottom-[-30%] right-[-20%] w-[350px] h-[350px] bg-cyan-accent/10 dark:bg-cyan-accent/20 rounded-full blur-[100px] group-hover:scale-110 transition-transform duration-700"></div>
            
            <h2 class="text-3xl sm:text-5xl font-black text-slate-800 dark:text-slate-100 mb-4 tracking-tight">Evaluate Your Fit In Seconds</h2>
            <p class="text-sm md:text-base text-slate-500 dark:text-slate-400 max-w-xl mx-auto leading-relaxed mb-8">
                Instantly map your academic records to standard industrial recruitment indexes via external FastAPI deep synapses.
            </p>
            <div class="flex justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="ai-btn-gradient px-10 py-5 rounded-2xl text-sm font-bold shadow-xl shadow-primary/20 active:scale-95 transition-all">
                        Launch Dashboard Portal
                    </a>
                @else
                    <a href="{{ route('register') }}" class="ai-btn-gradient px-10 py-5 rounded-2xl text-sm font-bold shadow-xl shadow-primary/20 active:scale-95 transition-all">
                        Register Account Now
                    </a>
                @endauth
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    // 1. Interactive Neural Canvas Background script
    (function() {
        const canvas = document.getElementById('neuralCanvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let width = canvas.width = canvas.offsetWidth;
        let height = canvas.height = canvas.offsetHeight;
        
        const dots = [];
        const maxDots = Math.min(60, Math.floor(width / 20));
        
        class Dot {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.vx = (Math.random() - 0.5) * 0.4;
                this.vy = (Math.random() - 0.5) * 0.4;
                this.r = Math.random() * 2.5 + 1.5;
            }
            update() {
                this.x += this.vx;
                this.y += this.vy;
                if (this.x < 0 || this.x > width) this.vx *= -1;
                if (this.y < 0 || this.y > height) this.vy *= -1;
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
                ctx.fillStyle = document.documentElement.classList.contains('dark') ? '#06b6d4' : '#6366f1';
                ctx.shadowBlur = 8;
                ctx.shadowColor = ctx.fillStyle;
                ctx.fill();
            }
        }
        
        for (let i = 0; i < maxDots; i++) {
            dots.push(new Dot());
        }
        
        function animate() {
            ctx.clearRect(0, 0, width, height);
            ctx.shadowBlur = 0; // reset shadow for lines
            
            // Draw connections
            for (let i = 0; i < dots.length; i++) {
                dots[i].update();
                dots[i].draw();
                
                for (let j = i + 1; j < dots.length; j++) {
                    const dx = dots[i].x - dots[j].x;
                    const dy = dots[i].y - dots[j].y;
                    const dist = Math.sqrt(dx*dx + dy*dy);
                    
                    if (dist < 130) {
                        ctx.beginPath();
                        ctx.moveTo(dots[i].x, dots[i].y);
                        ctx.lineTo(dots[j].x, dots[j].y);
                        const alpha = (1 - (dist / 130)) * 0.15;
                        ctx.strokeStyle = document.documentElement.classList.contains('dark') 
                            ? `rgba(6, 182, 212, ${alpha})` 
                            : `rgba(99, 102, 241, ${alpha})`;
                        ctx.lineWidth = 1;
                        ctx.stroke();
                    }
                }
            }
            requestAnimationFrame(animate);
        }
        
        window.addEventListener('resize', () => {
            if (canvas) {
                width = canvas.width = canvas.offsetWidth;
                height = canvas.height = canvas.offsetHeight;
            }
        });
        
        animate();
    })();

    // 2. Statistics Counter Up Animation
    (function() {
        const counters = document.querySelectorAll('[data-target]');
        
        const options = {
            threshold: 0.1,
            rootMargin: '0px'
        };
        
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseFloat(counter.getAttribute('data-target'));
                    let current = 0;
                    const duration = 2000; // 2 seconds
                    const steps = 60;
                    const stepValue = target / steps;
                    let step = 0;
                    
                    const interval = setInterval(() => {
                        current += stepValue;
                        step++;
                        
                        if (target >= 1000) {
                            counter.innerText = Math.floor(current / 1000) + 'k+';
                        } else if (target % 1 !== 0) {
                            counter.innerText = current.toFixed(2);
                        } else {
                            counter.innerText = Math.floor(current) + '+';
                        }
                        
                        if (step >= steps) {
                            clearInterval(interval);
                            if (target >= 1000) {
                                counter.innerText = (target / 1000) + 'k+';
                            } else if (target % 1 !== 0) {
                                counter.innerText = target;
                            } else {
                                counter.innerText = target + '+';
                            }
                        }
                    }, duration / steps);
                    
                    observer.unobserve(counter);
                }
            });
        }, options);
        
        counters.forEach(counter => {
            observer.observe(counter);
        });
    })();
</script>
@endsection
