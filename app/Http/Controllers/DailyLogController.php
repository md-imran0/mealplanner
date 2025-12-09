<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * DailyLogController backend
 * 
 * Handles meal logging operations. Users use this controller to:
 * - Log what meals they ate each day
 * - View their complete meal history
 * - Edit previous meal entries
 * - Delete meal logs
 * 
 * This is the main controller for tracking daily food intake.
 */
class DailyLogController extends Controller
{
    /**
     * Show all meal logs for the logged-in user
     * 
     * Displays a complete history of all meals the user has logged,
     * sorted by most recent meals first.
     */
    public function index()
    {
        // Get all meal logs for the current user, including recipe details
        $dailyLogs = DailyLog::where('user_id', Auth::id())
                            ->with('recipe')
                            ->orderBy('date', 'desc')  // Most recent first
                            ->get();
        
        return view('daily-logs.index', compact('dailyLogs'));
    }

    /**
     * Show the form to add a new meal
     * 
     * Displays a form where users select:
     * - Which recipe they ate
     * - How many servings
     * - What date they ate it
     * - Optional meal type (breakfast, lunch, dinner, snack)
     */
    public function create()
    {
        // Get all available recipes so user can choose what they ate
        // Recipes are global (not specific to any user)
        $recipes = Recipe::orderBy('name')->get();
        return view('daily-logs.create', compact('recipes'));
    }

    /**
     * Save a new meal log to the database
     * 
     * Validates the form input and creates a new DailyLog record
     * associated with the logged-in user
     */
    /**
     * Save a new meal log to the database
     * 
     * Validates the form input and creates a new DailyLog record
     * associated with the logged-in user
     */
    public function store(Request $request)
    {
        // Validate that all required fields are provided and correct
        $request->validate([
            'date' => 'required|date',                          // Meal date
            'recipe_id' => 'required|exists:recipes,id',        // Recipe must exist in database
            'meal_type' => 'nullable|string',                   // breakfast, lunch, dinner, snack (optional)
            'servings' => 'required|numeric|min:0.1',           // How many servings eaten (at least 0.1)
            'notes' => 'nullable|string',                       // Optional notes/comments
        ]);

        // Create and save the meal log
        DailyLog::create([
            'user_id' => Auth::id(),                   // Log it for the current logged-in user
            'recipe_id' => $request->recipe_id,        // Which recipe was eaten
            'date' => $request->date,                  // When it was eaten
            'meal_type' => $request->meal_type,        // Meal category (breakfast, lunch, etc)
            'servings' => $request->servings ?? 1,     // How many servings (default to 1 if not provided)
            'notes' => $request->notes,                // Any notes about the meal
        ]);

        return redirect()->route('daily-logs.index')
                        ->with('success', 'Meal log added successfully!');
    }

    /**
     * Show details of a single meal log
     * 
     * Displays:
     * - The recipe that was eaten
     * - Serving size
     * - Date of meal
     * - Complete nutrition information for that meal
     */
    public function show(DailyLog $dailyLog)
    {
        return view('daily-logs.show', compact('dailyLog'));
    }

    /**
     * Show the form to edit an existing meal log
     * 
     * Allows user to change:
     * - Which recipe they ate (in case they made a mistake)
     * - Number of servings
     * - Date of the meal
     * - Meal type or notes
     */
    public function edit(DailyLog $dailyLog)
    {
        // Get all recipes so user can select a different one if needed
        $recipes = Recipe::orderBy('name')->get();
        return view('daily-logs.edit', compact('dailyLog', 'recipes'));
    }

    /**
     * Update an existing meal log
     * 
     * Validates and saves any changes made to a meal log.
     * This allows users to correct mistakes in their meal tracking.
     */
    public function update(Request $request, DailyLog $dailyLog)
    {
        // Validate that all required fields are provided and correct
        $request->validate([
            'date' => 'required|date',
            'recipe_id' => 'required|exists:recipes,id',
            'meal_type' => 'nullable|string',
            'servings' => 'required|numeric|min:0.1',
            'notes' => 'nullable|string',
        ]);

        // Update the meal log with new values
        $dailyLog->update([
            'recipe_id' => $request->recipe_id,
            'date' => $request->date,
            'meal_type' => $request->meal_type,
            'servings' => $request->servings ?? 1,
            'notes' => $request->notes,
        ]);

        return redirect()->route('daily-logs.index')
                        ->with('success', 'Meal log updated successfully!');
    }

    /**
     * Delete a meal log
     * 
     * Removes a meal log from the user's history.
     * This is useful if a meal was logged by mistake.
     */
    public function destroy(DailyLog $dailyLog)
    {
        // Remove the meal log from the database
        $dailyLog->delete();
        return redirect()->route('daily-logs.index')
                        ->with('success', 'Meal log deleted successfully!');
    }
}
