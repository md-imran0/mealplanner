<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DailyLog;
use App\Models\UserGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard page backend
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get today's meals
        $todayMeals = DailyLog::where('user_id', $user->id)
            ->whereDate('date', today())
            ->with('recipe')
            ->get();

        // Get user's goals
        $goals = UserGoal::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        return view('dashboard', compact('todayMeals', 'goals'));
    }
}
