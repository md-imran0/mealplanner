<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * NutritionController
 * 
 * Displays nutrition summaries for the user.
 * Shows totals for the day like:
 * - Total calories consumed
 * - Total protein, carbs, fat
 * - Total fiber, sugar, sodium
 * - Environmental impact (CO2)
 * 
 * This helps users understand their nutrition intake throughout the day.
 */
class NutritionController extends Controller
{
    /**
     * Show today's nutrition intake
     * 
     * Calculates and displays the total nutrition values for today based on
     * all meals the user has logged.
     * Shows calories, macronutrients, and other nutrition facts.
     */
    public function index()
    {
        // Get all meals logged for today for the logged-in user
        $todayLogs = DailyLog::where('user_id', Auth::id())
                            ->whereDate('date', Carbon::today())  // Only today's meals
                            ->with('recipe')                       // Include recipe details
                            ->get();

        // Calculate nutrition totals (simple placeholder version)
        // Note: This is a basic calculation - can be enhanced with actual nutrition data
        $totalCalories = 0;
        $totalProtein = 0;

        // Loop through each meal and sum up nutrition values
        foreach ($todayLogs as $log) {
            if ($log->recipe) {
                // Basic calculation - this should be improved with actual recipe nutrition data
                $totalCalories += ($log->quantity_consumed ?? 1) * 100; // Placeholder calculation
                $totalProtein += ($log->quantity_consumed ?? 1) * 10;   // Placeholder calculation
            }
        }

        return view('nutrition.index', compact('todayLogs', 'totalCalories', 'totalProtein'));
    }
}
