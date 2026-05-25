<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // 1. Total users count
        $totalUsers = User::count();

        // 2. Total evaluations count
        $totalEvaluations = Evaluation::count();

        // 3. High-potential students count (Elite Potential or High Potential)
        $highPotentialCount = Evaluation::whereIn('ai.potential', ['Elite Potential', 'High Potential'])->count();

        // 4. Aggregated system logs list (using 'logs' collection)
        $logs = [];
        try {
            $logs = DB::connection('mongodb')
                ->table('logs')
                ->orderBy('timestamp', 'desc')
                ->take(50)
                ->get()
                ->toArray();
        } catch (\Throwable $e) {
            // Silence log queries if collection is empty or connection fails
        }

        // 5. Fetch all evaluations for display
        $evaluations = Evaluation::latest()->take(50)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEvaluations',
            'highPotentialCount',
            'logs',
            'evaluations'
        ));
    }
}
