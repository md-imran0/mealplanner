<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

/**
 * IngredientController
 * 
 * Manages ingredients in the nutrition tracker database.
 * Ingredients are the basic food items with nutrition facts per 100g.
 * Examples: Chicken, Rice, Broccoli, Olive Oil, etc.
 * 
 * Users can:
 * - View all ingredients
 * - Add new ingredients
 * - Edit ingredient nutrition facts
 * - Delete ingredients
 * 
 * These ingredients are then used to create recipes.
 */
class IngredientController extends Controller
{
    /**
     * Show all ingredients
     * 
     * Displays a paginated list of all food ingredients in the database.
     * Each ingredient shows nutrition facts per 100g.
     */
    public function index()
    {
        // Get all ingredients, sorted alphabetically, 20 per page
        $ingredients = Ingredient::orderBy('name')->paginate(20);
        
        return view('ingredients.index', compact('ingredients'));
    }

    /**
     * Show form to create a new ingredient
     * 
     * Displays a form where users can enter:
     * - Ingredient name
     * - Nutrition facts per 100g (calories, protein, carbs, fat, fiber, etc)
     * - CO2 environmental impact per 100g
     */
    public function create()
    {
        return view('ingredients.create');
    }

    /**
     * Save a new ingredient to the database
     * 
     * Creates a new ingredient record with nutrition information.
     * All nutrition values are stored per 100g for standardization.
     */
    public function store(Request $request)
    {
        // Validate required nutrition fields
        $request->validate([
            'name' => 'required|unique:ingredients',              // Ingredient name (must be unique)
            'calories_per_100g' => 'required|numeric',            // Energy content per 100g
            'co2_per_100g' => 'required|numeric',                 // Environmental impact per 100g
            'protein_per_100g' => 'required|numeric',             // Protein content per 100g
            'fiber_per_100g' => 'required|numeric',               // Dietary fiber per 100g
        ]);

        // Create the ingredient record
        Ingredient::create([
            'name' => $request->name,
            'calories_per_100g' => $request->calories_per_100g,
            'co2_per_100g' => $request->co2_per_100g,
            'protein_per_100g' => $request->protein_per_100g,
            'fiber_per_100g' => $request->fiber_per_100g,
            'carbs_per_100g' => $request->carbs_per_100g ?? 0,           // Optional carbs
            'fat_per_100g' => $request->fat_per_100g ?? 0,               // Optional fat
            'sugar_per_100g' => $request->sugar_per_100g ?? 0,           // Optional sugar
            'sodium_per_100g' => $request->sodium_per_100g ?? 0,         // Optional sodium
        ]);

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient created successfully!');
    }

    /**
     * Show details of a single ingredient
     * 
     * Displays all nutrition information for the ingredient
     * and shows which recipes use this ingredient.
     */
    public function show(Ingredient $ingredient)
    {
        return view('ingredients.show', compact('ingredient'));
    }

    /**
     * Show form to edit an ingredient
     * 
     * Allows user to update nutrition facts if they were entered incorrectly.
     */
    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    /**
     * Update an ingredient's nutrition facts
     * 
     * Saves changes made to nutrition information for an ingredient.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        // Validate the nutrition fields
        $request->validate([
            'name' => 'required|unique:ingredients,name,' . $ingredient->id,  // Name must be unique (except this ingredient)
            'calories_per_100g' => 'required|numeric',
            'co2_per_100g' => 'required|numeric',
            'protein_per_100g' => 'required|numeric',
            'fiber_per_100g' => 'required|numeric',
        ]);

        // Update the ingredient record
        $ingredient->update([
            'name' => $request->name,
            'calories_per_100g' => $request->calories_per_100g,
            'co2_per_100g' => $request->co2_per_100g,
            'protein_per_100g' => $request->protein_per_100g,
            'fiber_per_100g' => $request->fiber_per_100g,
            'carbs_per_100g' => $request->carbs_per_100g ?? 0,
            'fat_per_100g' => $request->fat_per_100g ?? 0,
            'sugar_per_100g' => $request->sugar_per_100g ?? 0,
            'sodium_per_100g' => $request->sodium_per_100g ?? 0,
        ]);

        return redirect()->route('ingredients.show', $ingredient)
            ->with('success', 'Ingredient updated successfully!');
    }

    /**
     * Delete an ingredient
     * 
     * Removes an ingredient from the database.
     * Note: This will also delete it from any recipes that use it.
     */
    public function destroy(Ingredient $ingredient)
    {
        // Delete the ingredient
        $ingredient->delete();
        
        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient deleted successfully!');
    }
}
