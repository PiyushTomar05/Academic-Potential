<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verified Diagnostic Certificate</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Geist:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <!-- Tailwind CSS (Vite build style baseline helper) -->
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Geist', sans-serif;
            background: #020617;
            margin: 0;
            padding: 0;
        }
        .cert-container {
            font-family: 'Geist', sans-serif;
        }
        .cinzel-font {
            font-family: 'Cinzel', serif;
        }
        
        /* Print rules */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .no-print {
                display: none !important;
            }
            .cert-card {
                box-shadow: none !important;
                border: 4px solid #b45309 !important;
                background: #ffffff !important;
            }
            .glow-glow {
                display: none !important;
            }
        }
    </style>
</head>
@php
    $score = $testScore['total'] ?? 0;
    if (isset($testScore['readiness'])) {
        $score = $testScore['readiness'];
    }
    if ($type === 'reading') {
        $score = $testScore['accuracy'] ?? 100;
    }

    $isExcellence = $score >= 50;
    
    $glowClass1 = $isExcellence ? 'bg-amber-500/10' : 'bg-slate-500/10';
    $glowClass2 = $isExcellence ? 'bg-indigo-500/10' : 'bg-blue-500/10';
    $borderClass = $isExcellence ? 'border-amber-500/30' : 'border-slate-500/40';
    $innerBorderClass = $isExcellence ? 'border-amber-500/10' : 'border-slate-500/10';
    $sealGradient = $isExcellence ? 'from-amber-600 to-yellow-400 shadow-amber-500/20' : 'from-slate-600 to-slate-400 shadow-slate-500/20';
    $ribbonLeft = $isExcellence ? 'bg-amber-600' : 'bg-slate-600';
    $ribbonRight = $isExcellence ? 'bg-amber-700' : 'bg-slate-700';
    $ornamentClass = $isExcellence ? 'text-amber-500/20' : 'text-slate-500/20';
    $accentText = $isExcellence ? 'text-amber-500' : 'text-slate-400';
    $primaryAccent = $isExcellence ? 'text-amber-400' : 'text-slate-300';
    
    $certTypeLabel = $isExcellence ? 'VERIFIED CERTIFICATE OF EXCELLENCE' : 'VERIFIED CERTIFICATE OF PARTICIPATION';
    $certTitle = $isExcellence ? 'Certificate of Achievement' : 'Certificate of Participation';
    $certScoreLabel = $isExcellence ? 'diagnostic grade' : 'participation grade';
    $certGradeValue = $type === 'reading' ? ($testScore['wpm'] . ' WPM') : (($testScore['total'] ?? $testScore['readiness'] ?? 0) . '%');
    
    $sigClass = $isExcellence ? 'text-amber-500/70' : 'text-slate-450/70';
    $printBtnClass = $isExcellence ? 'bg-amber-600 hover:bg-amber-500 shadow-amber-500/20' : 'bg-slate-700 hover:bg-slate-600 shadow-slate-550/20';
@endphp

<body class="min-h-screen flex flex-col justify-center items-center p-6 relative overflow-x-hidden">
    <!-- Glow effects -->
    <div class="fixed top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full {{ $glowClass1 }} blur-[130px] pointer-events-none -z-10 glow-glow"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full {{ $glowClass2 }} blur-[130px] pointer-events-none -z-10 glow-glow"></div>

    <!-- Main Certificate Frame -->
    <div class="w-full max-w-4xl bg-slate-900/60 backdrop-blur-xl border-4 {{ $borderClass }} rounded-[2.5rem] p-8 md:p-12 shadow-2xl relative overflow-hidden cert-card border-double border-spacing-2">
        <!-- Inner Border -->
        <div class="absolute inset-4 border {{ $innerBorderClass }} rounded-[2rem] pointer-events-none"></div>

        <!-- Floating corner ornaments -->
        <div class="absolute top-8 left-8 {{ $ornamentClass }} material-symbols-outlined text-[36px]">filter_retro</div>
        <div class="absolute top-8 right-8 {{ $ornamentClass }} material-symbols-outlined text-[36px]">filter_retro</div>
        <div class="absolute bottom-8 left-8 {{ $ornamentClass }} material-symbols-outlined text-[36px]">filter_retro</div>
        <div class="absolute bottom-8 right-8 {{ $ornamentClass }} material-symbols-outlined text-[36px]">filter_retro</div>

        <!-- Core Certificate Contents -->
        <div class="text-center space-y-6 relative z-10">
            <!-- Seal of Excellence -->
            <div class="flex justify-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-tr {{ $sealGradient }} flex items-center justify-center shadow-lg relative animate-pulse">
                    <span class="material-symbols-outlined text-white text-[44px]">workspace_premium</span>
                    <!-- Ribbon -->
                    <div class="absolute bottom-[-10px] w-6 h-8 {{ $ribbonLeft }} transform rotate-12 skew-x-12 -z-10 rounded-b"></div>
                    <div class="absolute bottom-[-10px] w-6 h-8 {{ $ribbonRight }} transform -rotate-12 -skew-x-12 -z-10 rounded-b"></div>
                </div>
            </div>

            <!-- Header -->
            <div class="space-y-1">
                <span class="text-xs font-black {{ $accentText }} uppercase tracking-[0.25em] block">{{ $certTypeLabel }}</span>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight cinzel-font py-2">{{ $certTitle }}</h1>
            </div>

            <!-- Description -->
            <div class="max-w-2xl mx-auto space-y-4 text-slate-300">
                <p class="text-sm font-medium uppercase tracking-widest text-slate-400">THIS IS PROUDLY PRESENTED TO</p>
                <h2 class="text-2xl md:text-4xl font-black text-white py-1 border-b border-slate-700/50 max-w-lg mx-auto tracking-tight">{{ $user->name }}</h2>
                <p class="text-sm md:text-base leading-relaxed text-slate-400 mt-4">
                    For successfully completing the diagnostic assessment for <br>
                    <strong class="{{ $primaryAccent }} font-extrabold">{{ $title }}</strong> <br>
                    with a verified score of:
                </p>
            </div>

            <!-- Verified Score Badge -->
            <div class="flex justify-center my-6">
                <div class="px-8 py-4 bg-slate-950/60 border border-slate-800/40 rounded-2xl flex flex-col items-center">
                    <span class="text-[10px] text-slate-400 font-extrabold tracking-widest uppercase block mb-1">{{ $certScoreLabel }}</span>
                    <strong class="text-3xl md:text-4xl font-black {{ $primaryAccent }}">{{ $certGradeValue }}</strong>
                </div>
            </div>

            <!-- Bottom Hash Info & Signature -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-800/60 text-xs">
                <!-- System Verification details -->
                <div class="text-left space-y-1.5 md:border-r border-slate-800/60 pr-6">
                    <span class="text-[10px] text-slate-400 font-extrabold tracking-wider uppercase block">VERIFICATION DETAILS</span>
                    <p class="text-slate-400 text-[11px]">System: <strong class="text-slate-200">Academic Potential AI Portal</strong></p>
                    <p class="text-slate-400 text-[11px]">Issued: <strong class="text-slate-250">{{ date('Y-m-d H:i:s', strtotime($testScore['completed_at'])) }}</strong></p>
                    <p class="text-[10px] font-mono text-cyan-400 tracking-wider">HASH: {{ $hash }}</p>
                </div>
                
                <!-- Signatures -->
                <div class="flex justify-around items-center gap-4">
                    <div class="text-center space-y-1">
                        <span class="font-mono {{ $sigClass }} block italic text-sm">Academic AI Engine</span>
                        <div class="h-px w-24 bg-slate-800 mx-auto"></div>
                        <span class="text-[9px] text-slate-450 uppercase tracking-widest block font-bold">Authorized Signatory</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print / Close Actions -->
    <div class="flex items-center gap-4 mt-8 no-print">
        <button onclick="window.print()" class="px-6 py-3 {{ $printBtnClass }} text-white font-extrabold text-xs rounded-xl shadow-lg transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">print</span>
            Print Certificate
        </button>
        <a href="{{ route('tests.index') }}" class="px-6 py-3 bg-slate-900 border border-slate-800 text-slate-450 hover:text-white font-extrabold text-xs rounded-xl transition-all">
            Return to Assessment Center
        </a>
    </div>
</body>
</html>
