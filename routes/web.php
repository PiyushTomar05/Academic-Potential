<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::get('/', [PortalController::class, 'landing'])->name('landing');
Route::get('/login', [PortalController::class, 'loginForm'])->name('login');
Route::post('/login', [PortalController::class, 'authenticate'])->name('login.post');
Route::get('/register', [PortalController::class, 'registerForm'])->name('register');
Route::post('/register', [PortalController::class, 'register'])->name('register.post');
Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('dashboard');
    
    // Evaluations
    Route::get('/evaluation/results/{id}', [PortalController::class, 'results'])->name('evaluation.results');
    Route::get('/evaluation/report/{id}/download', [PortalController::class, 'downloadReport'])->name('evaluation.report.download');
    
    // Logs / History
    Route::get('/history', [PortalController::class, 'history'])->name('history');
    
    // Interactive Analytics
    Route::get('/analytics', [PortalController::class, 'analytics'])->name('analytics');
    
    // User Settings
    Route::get('/settings', [PortalController::class, 'settings'])->name('settings');
    Route::post('/settings', [PortalController::class, 'saveSettings'])->name('settings.save');

    // System Status
    Route::get('/system/status', [PortalController::class, 'systemStatus'])->name('system.status');

    // Test Center Assessments
    Route::get('/tests', [\App\Http\Controllers\TestController::class, 'index'])->name('tests.index');
    Route::get('/tests/coding', [\App\Http\Controllers\TestController::class, 'codingForm'])->name('tests.coding');
    Route::post('/tests/coding', [\App\Http\Controllers\TestController::class, 'saveCoding'])->name('tests.coding.save');
    Route::get('/tests/academic-history', [\App\Http\Controllers\TestController::class, 'academicHistoryForm'])->name('tests.history');
    Route::post('/tests/academic-history', [\App\Http\Controllers\TestController::class, 'saveAcademicHistory'])->name('tests.history.save');
    Route::get('/tests/aptitude', [\App\Http\Controllers\TestController::class, 'aptitudeForm'])->name('tests.aptitude');
    Route::post('/tests/aptitude', [\App\Http\Controllers\TestController::class, 'saveAptitude'])->name('tests.aptitude.save');
    Route::get('/tests/english', [\App\Http\Controllers\TestController::class, 'englishForm'])->name('tests.english');
    Route::post('/tests/english', [\App\Http\Controllers\TestController::class, 'saveEnglish'])->name('tests.english.save');
    Route::get('/tests/speaking', [\App\Http\Controllers\TestController::class, 'speakingForm'])->name('tests.speaking');
    Route::post('/tests/speaking', [\App\Http\Controllers\TestController::class, 'saveSpeaking'])->name('tests.speaking.save');
    Route::get('/tests/reading', [\App\Http\Controllers\TestController::class, 'readingForm'])->name('tests.reading');
    Route::post('/tests/reading', [\App\Http\Controllers\TestController::class, 'saveReading'])->name('tests.reading.save');
    Route::get('/tests/written', [\App\Http\Controllers\TestController::class, 'writtenForm'])->name('tests.written');
    Route::post('/tests/written', [\App\Http\Controllers\TestController::class, 'saveWritten'])->name('tests.written.save');
    Route::get('/tests/core', [\App\Http\Controllers\TestController::class, 'coreForm'])->name('tests.core');
    Route::post('/tests/core', [\App\Http\Controllers\TestController::class, 'saveCore'])->name('tests.core.save');
    Route::get('/tests/psychometric', [\App\Http\Controllers\TestController::class, 'stressForm'])->name('tests.psychometric');
    Route::post('/tests/psychometric', [\App\Http\Controllers\TestController::class, 'saveStress'])->name('tests.psychometric.save');
    Route::get('/tests/{type}/certificate', [\App\Http\Controllers\TestController::class, 'certificate'])->name('tests.certificate');

    // Final Aggregate Potential Prediction
    Route::get('/prediction/final', [\App\Http\Controllers\TestController::class, 'finalPredictionForm'])->name('prediction.final');
    Route::post('/prediction/final', [\App\Http\Controllers\TestController::class, 'saveFinalPrediction'])->name('prediction.final.save');

    // Phase 7: Consolidated Placement & Career Hub
    Route::get('/placement-hub', [\App\Http\Controllers\CareerController::class, 'index'])->name('career.index');
    
    // Asynchronous Actions
    Route::post('/resume-intelligence/analyze', [\App\Http\Controllers\CareerController::class, 'analyzeResume'])->name('career.resume.analyze');
    Route::post('/achievement-portfolio/add', [\App\Http\Controllers\CareerController::class, 'addAchievement'])->name('career.portfolio.add');

    // Backward-Compatibility Aliases
    Route::get('/placement-readiness', function() { return redirect()->route('career.index'); })->name('career.readiness');
    Route::get('/resume-intelligence', function() { return redirect()->route('career.index'); })->name('career.resume');
    Route::get('/achievement-portfolio', function() { return redirect()->route('career.index'); })->name('career.portfolio');
    Route::get('/growth-timeline', function() { return redirect()->route('career.index'); })->name('career.timeline');

    // Admin Panel Console
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    });
});


