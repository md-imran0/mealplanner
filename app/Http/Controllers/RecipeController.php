<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;

/**
 * RecipeController
 * 
 * Manages recipes in the nutrition tracker.
 * A recipe is a collection of ingredients with cooking instructions.
 * Users can:
 * - Create new recipes
 * - Browse all recipes
 * - Edit recipe details
 * - Delete recipes
 * 
 * When a user logs a meal, they select a recipe from the list of all recipes.
 */
class RecipeController extends Controller
{
    /**
     * Show all recipes
     * 
     * Displays a paginated list of all recipes in the database.
     * Each recipe shows its name, difficulty level, cooking time, servings, etc.
     */
    public function index()
    {
        // Get all recipes, sorted alphabetically, 12 per page
        $recipes = Recipe::orderBy('name')->paginate(12);
        
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show form to create a new recipe
     * 
     * Displays a form where users can:
     * - Enter recipe name and cooking instructions
     * - Set serving size
     * - Add prep and cooking times
     * - Select ingredients and amounts for each
     * - Set difficulty level
     */
    public function create()
    {
        // Get all available ingredients to choose from
        $ingredients = Ingredient::orderBy('name')->get();
        
        return view('recipes.create', compact('ingredients'));
    }

    /**
     * Save a new recipe to the database
     * 
     * Creates a new recipe record with ingredients and their amounts.
     * This is global data that all users can see and use.
     */
    /**
     * Save a new recipe to the database
     * 
     * Creates a new recipe record with ingredients and their amounts.
     * This is global data that all users can see and use.
     */
    public function store(Request $request)
    {
        // Validate the recipe details
        $request->validate([
            'name' => 'required',                           // Recipe name
            'instructions' => 'required',                   // Cooking instructions
            'servings' => 'required|integer|min:1',         // Number of servings the recipe makes
            'prep_time_minutes' => 'required|integer',      // Minutes to prepare ingredients
            'cook_time_minutes' => 'required|integer',      // Minutes to cook
            'difficulty' => 'required|in:easy,medium,hard', // Difficulty level
            'ingredients' => 'required|array',              // List of ingredient IDs
            'amounts' => 'required|array',                  // Amount in grams for each ingredient
        ]);

        // Create the recipe record
        $recipe = Recipe::create([
            'name' => $request->name,
            'instructions' => $request->instructions,
            'servings' => $request->servings,
            'prep_time_minutes' => $request->prep_time_minutes,
            'cook_time_minutes' => $request->cook_time_minutes,
            'difficulty' => $request->difficulty,
        ]);

        // Add ingredients to the recipe
        // A recipe can have multiple ingredients, each with a specific amount
        foreach ($request->ingredients as $index => $ingredientId) {
            if (!empty($ingredientId) && !empty($request->amounts[$index])) {
                $recipe->ingredients()->attach($ingredientId, [
                    'amount_grams' => $request->amounts[$index]  // Store the amount of this ingredient
                ]);
            }
        }

        return redirect()->route('recipes.index')
            ->with('success', 'Recipe created successfully!');
    }

    /**
     * Show single recipe details
     * 
     * Displays:
     * - Recipe name and instructions
     * - Cooking times and difficulty
     * - List of all ingredients and their amounts
     * - Nutrition information per serving
     */
    public function show(Recipe $recipe)
    {
        // Load all ingredients for this recipe
        $recipe->load('ingredients');
        
        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show form to edit a recipe
     * 
     * Allows user to change:
     * - Recipe name and instructions
     * - Cooking times and difficulty
     * - Add or remove ingredients
     * - Change ingredient amounts
     */
    public function edit(Recipe $recipe)
    {
        // Load all ingredients for this recipe
        $recipe->load('ingredients');
        // Get all available ingredients to choose from
        $allIngredients = Ingredient::orderBy('name')->get();
        
        return view('recipes.edit', compact('recipe', 'allIngredients'));
    }

    /**
     * Update a recipe
     * 
     * Saves all changes made to a recipe.
     * This includes updating ingredients and their amounts.
     */
    public function update(Request $request, Recipe $recipe)
    {
        // Validate the recipe details
        $request->validate([
            'name' => 'required',
            'instructions' => 'required',
            'servings' => 'required|integer|min:1',
            'prep_time_minutes' => 'required|integer',
            'cook_time_minutes' => 'required|integer',
            'difficulty' => 'required|in:easy,medium,hard',
            'ingredients' => 'required|array',
            'amounts' => 'required|array',
        ]);

        // Update the recipe record
        $recipe->update([
            'name' => $request->name,
            'instructions' => $request->instructions,
            'servings' => $request->servings,
            'prep_time_minutes' => $request->prep_time_minutes,
            'cook_time_minutes' => $request->cook_time_minutes,
            'difficulty' => $request->difficulty,
        ]);

        // Remove all old ingredients
        $recipe->ingredients()->detach();

        // Add new ingredients
        foreach ($request->ingredients as $index => $ingredientId) {
            if (!empty($ingredientId) && !empty($request->amounts[$index])) {
                $recipe->ingredients()->attach($ingredientId, [
                    'amount_grams' => $request->amounts[$index]
                ]);
            }
        }

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe updated successfully!');
    }

    /**
     * Delete a recipe
     * 
     * Removes a recipe from the database.
     * Note: This also removes any meal logs that reference this recipe.
     */
    public function destroy(Recipe $recipe)
    {
        // Delete the recipe
        $recipe->delete();
        
        return redirect()->route('recipes.index')
            ->with('success', 'Recipe deleted successfully!');
    }
}
