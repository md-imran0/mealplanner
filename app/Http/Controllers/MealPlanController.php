<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * MealPlanController
 * 
 * Generates automatic meal plans based on user's calorie targets.
 * This helps users plan meals for the day while staying within their calorie budget.
 * 
 * The algorithm:
 * - Takes a max calorie target for the day
 * - Splits calories: 25% breakfast, 35% lunch, 35% dinner, 5% snacks
 * - Finds recipes that fit within these targets
 * - Returns a suggested meal plan
 */
class MealPlanController extends Controller
{
    /**
     * Generate a daily meal plan based on calorie target
     * 
     * Takes the user's target calories and suggests breakfast, lunch, dinner,
     * and snacks that fit within that budget while maintaining nutritional balance.
     * 
     * The meal plan is randomized to provide variety.
     */
    public function generate(Request $request)
    {
        // Validate the calorie target
        $request->validate([
            'max_calories' => 'required|integer|min:500|max:5000'  // Daily calorie target
        ]);

        $maxCalories = $request->max_calories;
        
        // Get ALL recipes from database (recipes are global, not user-specific)
        $allRecipes = Recipe::all();
        
        // Check if there are recipes to work with
        if ($allRecipes->isEmpty()) {
            return redirect()->route('dashboard')
                           ->with('error', 'No recipes found! Please add some recipes first.');
        }

        // Generate the meal plan using our algorithm
        $mealPlan = $this->generateMealPlan($allRecipes, $maxCalories);
        
        return view('meal-plan.result', compact('mealPlan', 'maxCalories'));
    }
    
    /**
     * Generate meal plan algorithm
     * 
     * Creates a meal plan by:
     * 1. Allocating calories to each meal (breakfast, lunch, dinner, snacks)
     * 2. Shuffling recipes for variety
     * 3. Selecting recipes that fit the calorie targets
     * 4. Returning the complete plan
     * 
     * @param Collection $recipes All available recipes
     * @param int $maxCalories Total daily calorie target
     * @return array The generated meal plan with all meals
     */
    private function generateMealPlan($recipes, $maxCalories)
    {
        // Initialize the meal plan structure
        $plan = [
            'breakfast' => null,    // Morning meal
            'lunch' => null,        // Midday meal
            'dinner' => null,       // Evening meal
            'snacks' => []          // Light snacks throughout the day
        ];
        
        $usedCalories = 0;
        // Randomize recipes to provide variety each time
        $availableRecipes = $recipes->shuffle();
        
        // Calorie distribution strategy:
        // Breakfast: 25% of total (lighter meal)
        // Lunch: 35% of total (substantial meal)
        // Dinner: 35% of total (substantial meal)
        // Snacks: 5% of total (light snacks)
        $breakfastTarget = $maxCalories * 0.25;
        $lunchTarget = $maxCalories * 0.35;
        $dinnerTarget = $maxCalories * 0.35;
        $snackTarget = $maxCalories * 0.05;
        
        // Try to find suitable recipes for each meal type
        foreach ($availableRecipes as $recipe) {
            // Estimate the calories in this recipe
            $estimatedCalories = $this->estimateRecipeCalories($recipe);
            
            // BREAKFAST: Find a recipe around breakfast target (25% of daily total)
            if (!$plan['breakfast'] && $estimatedCalories <= $breakfastTarget * 1.2) {
                $plan['breakfast'] = [
                    'recipe' => $recipe,
                    'calories' => $estimatedCalories
                ];
                $usedCalories += $estimatedCalories;
                continue;
            }
            
            // LUNCH: Find a recipe around lunch target (35% of daily total)
            if (!$plan['lunch'] && $estimatedCalories <= $lunchTarget * 1.2) {
                $plan['lunch'] = [
                    'recipe' => $recipe,
                    'calories' => $estimatedCalories
                ];
                $usedCalories += $estimatedCalories;
                continue;
            }
            
            // DINNER: Find a recipe around dinner target (35% of daily total)
            if (!$plan['dinner'] && $estimatedCalories <= $dinnerTarget * 1.2) {
                $plan['dinner'] = [
                    'recipe' => $recipe,
                    'calories' => $estimatedCalories
                ];
                $usedCalories += $estimatedCalories;
                continue;
            }
            
            // SNACKS: Add remaining recipes as snacks if under budget
            if ($usedCalories < $maxCalories && $estimatedCalories <= $snackTarget * 2) {
                $plan['snacks'][] = [
                    'recipe' => $recipe,
                    'calories' => $estimatedCalories
                ];
                $usedCalories += $estimatedCalories;
            }
            
            // Stop when we're close enough to the calorie target (within 95%)
            if ($usedCalories >= $maxCalories * 0.95) break;
        }
        
        // Add totals to the plan
        $plan['total_calories'] = $usedCalories;
        $plan['target_calories'] = $maxCalories;
        
        return $plan;
    }
    
    /**
     * Estimate recipe calories
     * 
     * Provides a rough estimate of calories based on recipe name.
     * This is a simple heuristic since we don't have detailed nutrition data per recipe.
     * 
     * @param Recipe $recipe The recipe to estimate
     * @return int Estimated calories in the recipe
     */
    private function estimateRecipeCalories($recipe)
    {
        // Convert recipe name to lowercase for comparison
        $name = strtolower($recipe->name);
        
        // Simple estimation based on recipe type
        if (str_contains($name, 'salad')) return 200;        // Light meal
        if (str_contains($name, 'soup')) return 250;         // Light meal
        if (str_contains($name, 'sandwich')) return 400;     // Medium meal
        if (str_contains($name, 'pasta')) return 500;        // Substantial meal
        if (str_contains($name, 'rice')) return 450;         // Substantial meal
        if (str_contains($name, 'chicken')) return 350;      // Protein-heavy
        if (str_contains($name, 'fish')) return 300;         // Lighter protein
        if (str_contains($name, 'smoothie')) return 150;     // Light drink/snack
        if (str_contains($name, 'oatmeal')) return 300;      // Breakfast staple
        if (str_contains($name, 'toast')) return 200;        // Light breakfast
        
        // Default estimation for unknown recipes
        return 350;
    }
}
