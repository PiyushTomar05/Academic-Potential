<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evaluation;
use App\Services\PredictionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class PortalController extends Controller
{
    protected $predictionService;

    public function __construct(PredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    /**
     * Public Landing Page.
     */
    public function landing()
    {
        try {
            if (Auth::check()) {
                return redirect()->route('dashboard');
            }
        } catch (\Throwable $e) {
            // Gracefully ignore database connection timeout/refusal for landing visitors
        }
        return view('landing');
    }

    /**
     * Auth: Login View.
     */
    public function loginForm()
    {
        try {
            if (Auth::check()) {
                return redirect()->route('dashboard');
            }
        } catch (\Throwable $e) {
            // Gracefully ignore database connection timeout/refusal
        }
        return view('login');
    }

    /**
     * Auth: Handle Login.
     */
    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials, true)) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => 'Database connection timeout. Please verify that your MONGODB_URI in .env is correctly configured.',
            ]);
        }
    }

    /**
     * Auth: Register View.
     */
    public function registerForm()
    {
        try {
            if (Auth::check()) {
                return redirect()->route('dashboard');
            }
        } catch (\Throwable $e) {
            // Gracefully ignore database connection timeout/refusal
        }
        return view('register');
    }

    /**
     * Auth: Handle Registration.
     */
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            Auth::login($user, true);
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => 'Database connection timeout. Please verify that your MONGODB_URI in .env is correctly configured.',
            ]);
        }
    }

    /**
     * Auth: Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }

    /**
     * Dashboard view with aggregate metrics.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $evaluations = $user->evaluations()->get();
        
        $totalCandidates = $evaluations->count();
        
        // Compute averages utilizing custom model accessors
        $avgAccuracy = round($evaluations->avg('probability_score') ?? 0);
        $avgCgpa = round($evaluations->avg('cgpa') ?? 0, 2);
        
        $avgAnalytical = round($evaluations->avg('problem_decomposition') ?? 7.2, 1) * 10;
        $avgTechnical = round($evaluations->avg('cognitive_agility') ?? 7.5, 1) * 10;
        $avgCommunication = round($evaluations->avg('communication_rating') ?? 6.8, 1) * 10;
        $avgLeadership = round($evaluations->avg('academic_influence') ?? 6.5, 1) * 10;

        // Distribution mapping
        $distribution = [
            'Elite' => $evaluations->where('potential_class', 'Elite Potential')->count(),
            'High' => $evaluations->where('potential_class', 'High Potential')->count(),
            'Moderate' => $evaluations->where('potential_class', 'Moderate Potential')->count(),
            'Developing' => $evaluations->where('potential_class', 'Developing Potential')->count(),
        ];
        
        $recentCandidates = $user->evaluations()->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalCandidates',
            'avgAccuracy',
            'avgCgpa',
            'avgAnalytical',
            'avgTechnical',
            'avgCommunication',
            'avgLeadership',
            'distribution',
            'recentCandidates'
        ));
    }



    /**
     * Render Evaluation Results.
     */
    public function results($id)
    {
        $evaluation = Auth::user()->evaluations()->findOrFail($id);
        return view('results', compact('evaluation'));
    }

    /**
     * Render Printable PDF Evaluation Report.
     */
    public function downloadReport($id)
    {
        $evaluation = Auth::user()->evaluations()->findOrFail($id);
        
        try {
            // Log PDF generation event inside MongoDB logs collection
            DB::connection('mongodb')->table('logs')->insert([
                'user_id' => Auth::id(),
                'action' => 'report_downloaded',
                'evaluation_id' => $id,
                'candidate' => $evaluation->student_name,
                'timestamp' => now()->toIso8601String()
            ]);
        } catch (\Throwable $e) {
            // Silently complete
        }

        return view('report', compact('evaluation'));
    }

    /**
     * Searchable Evaluation History Logs.
     */
    public function history(Request $request)
    {
        $query = Auth::user()->evaluations();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                // Query nested MongoDB structures natively
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class')) {
            $query->where('ai.potential', $request->input('class'));
        }

        $evaluations = $query->latest()->paginate(10)->withQueryString();

        return view('history', compact('evaluations'));
    }

    /**
     * Interactive Analytics Page.
     */
    public function analytics()
    {
        $user = Auth::user();
        $evaluations = $user->evaluations()->get();
        
        $totalCandidates = $evaluations->count();
        $avgAccuracy = round($evaluations->avg('probability_score') ?? 98.4);
        $avgCgpa = round($evaluations->avg('cgpa') ?? 7.82, 2);
        
        // Class distributions
        $eliteCount = $evaluations->where('potential_class', 'Elite Potential')->count();
        $highCount = $evaluations->where('potential_class', 'High Potential')->count();
        $modCount = $evaluations->where('potential_class', 'Moderate Potential')->count();
        $devCount = $evaluations->where('potential_class', 'Developing Potential')->count();
        
        $distribution = [
            'Elite' => $eliteCount,
            'High' => $highCount,
            'Moderate' => $modCount,
            'Developing' => $devCount,
        ];

        // Calculated Indices
        $avgAnalytical = round($evaluations->avg('problem_decomposition') ?? 7.2, 1) * 10;
        $avgTechnical = round($evaluations->avg('cognitive_agility') ?? 7.5, 1) * 10;
        $avgCommunication = round($evaluations->avg('communication_rating') ?? 6.8, 1) * 10;
        $avgLeadership = round($evaluations->avg('academic_influence') ?? 6.5, 1) * 10;

        return view('analytics', compact(
            'totalCandidates',
            'avgAccuracy',
            'avgCgpa',
            'distribution',
            'avgAnalytical',
            'avgTechnical',
            'avgCommunication',
            'avgLeadership',
            'evaluations'
        ));
    }

    /**
     * Profile Settings View.
     */
    public function settings()
    {
        return view('settings');
    }

    /**
     * Update User Settings.
     */
    public function saveSettings(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'resume' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'institution' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'projects_done' => ['nullable', 'integer', 'min:0'],
            'internships_count' => ['nullable', 'integer', 'min:0'],
            'certifications_count' => ['nullable', 'integer', 'min:0'],
            'leadership_role' => ['nullable', 'boolean'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }

        // Handle Avatar File Upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Handle Resume File Upload
        if ($request->hasFile('resume')) {
            // Delete old resume if exists
            if ($user->resume && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->resume)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->resume);
            }
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $user->resume = $resumePath;
        }

        $user->institution = $data['institution'] ?? null;
        $user->department = $data['department'] ?? null;
        $user->github = $data['github'] ?? null;
        $user->linkedin = $data['linkedin'] ?? null;

        // Skills Tags parsing (saving as array)
        if ($request->filled('skills')) {
            $skillsArray = array_filter(array_map('trim', explode(',', $data['skills'])));
            $user->skills = array_values($skillsArray);
        } else {
            $user->skills = [];
        }

        // Portfolio Stats
        $user->projects_done = isset($data['projects_done']) ? (int)$data['projects_done'] : 0;
        $user->internships_count = isset($data['internships_count']) ? (int)$data['internships_count'] : 0;
        $user->certifications_count = isset($data['certifications_count']) ? (int)$data['certifications_count'] : 0;
        $user->leadership_role = $request->boolean('leadership_role');

        $user->save();

        return back()->with('status', 'Profile settings updated successfully.');
    }

    /**
     * Get system status (asynchronously checked by UI).
     */
    public function systemStatus()
    {
        $status = Cache::remember('system_status_indicators', 30, function () {
            $mongoStatus = 'offline';
            try {
                DB::connection('mongodb')->command(['ping' => 1]);
                $mongoStatus = 'online';
            } catch (\Throwable $e) {
                $mongoStatus = 'offline';
            }

            $fastApiStatus = 'offline';
            try {
                if ($this->predictionService->healthCheck()) {
                    $fastApiStatus = 'online';
                }
            } catch (\Throwable $e) {
                $fastApiStatus = 'offline';
            }

            return [
                'mongodb' => $mongoStatus,
                'fastapi' => $fastApiStatus
            ];
        });

        return response()->json($status);
    }
}
