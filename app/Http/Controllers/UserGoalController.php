<?php

namespace App\Http\Controllers;

use App\Models\UserGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * UserGoalController
 * 
 * Manages user health goals like calorie targets, protein goals, weight loss targets, etc.
 * Each user can set multiple active goals to track their progress.
 * 
 * Users can:
 * - Create new health goals
 * - View all their goals
 * - Edit goal targets
 * - Deactivate/delete goals
 * - See their progress towards each goal
 */
class UserGoalController extends Controller
{
    /**
     * Show all user's goals
     * 
     * Displays a list of all health goals for the logged-in user,
     * including active and inactive goals, sorted by most recent first.
     */
    public function index()
    {
        // Get all goals for the logged-in user
        $userGoals = UserGoal::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')  // Most recent first
                            ->get();
        
        return view('user-goals.index', compact('userGoals'));
    }

    /**
     * Show form to create a new goal
     * 
     * Displays a form where users can set up a new health goal with:
     * - Goal type (calories, protein, weight loss, etc)
     * - Target value (e.g., 2000 calories per day)
     * - Start date (optional)
     */
    public function create()
    {
        return view('user-goals.create');
    }

    /**
     * Save a new goal to the database
     * 
     * Creates a new user goal that will be tracked daily.
     * The app will check if the user meets this goal each day.
     */
    public function store(Request $request)
    {
        // Validate the goal details
        $request->validate([
            'goal_type' => 'required|string',              // Type of goal (calorie, protein, etc)
            'target_value' => 'required|numeric|min:0',    // Target amount
            'start_date' => 'nullable|date',               // When to start tracking (optional)
        ]);

        
        // Create the goal record
        UserGoal::create([
            'user_id' => Auth::id(),              // Goal belongs to logged-in user
            'goal_type' => $request->goal_type,
            'target_value' => $request->target_value,
            'start_date' => $request->start_date,
            'is_active' => true,                  // Activate immediately
        ]);

        return redirect()->route('user-goals.index')
                        ->with('success', 'Goal created successfully!');
    }

    /**
     * Show details of a single goal
     * 
     * Displays the goal details and shows the user's progress towards this goal.
     */
    public function show(UserGoal $userGoal)
    {
        return view('user-goals.show', compact('userGoal'));
    }

    /**
     * Show form to edit a goal
     * 
     * Allows user to change the target value or goal type.
     */
    public function edit(UserGoal $userGoal)
    {
        return view('user-goals.edit', compact('userGoal'));
    }

    /**
     * Update a goal
     * 
     * Saves any changes made to the goal details.
     */
    public function update(Request $request, UserGoal $userGoal)
    {
        // Validate the goal details
        $request->validate([
            'goal_type' => 'required|string',
            'target_value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
        ]);

        // Update the goal record
        $userGoal->update($request->all());

        return redirect()->route('user-goals.show', $userGoal)
                        ->with('success', 'Goal updated successfully!');
    }


    /**
     * Delete a goal
     * 
     * Removes a goal from the user's goal list.
     * The user can always create the goal again later.
     */
    public function destroy(UserGoal $userGoal)
    {
        // Delete the goal
        $userGoal->delete();
        return redirect()->route('user-goals.index')
                        ->with('success', 'Goal deleted successfully!');
    }
}
