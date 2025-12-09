<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create the Recipe Ingredients table (Many-to-Many relationship)
 * 
 * This is a junction/pivot table that links recipes to their ingredients.
 * 
 * Why do we need this?
 * - A recipe has MANY ingredients
 * - An ingredient can be in MANY recipes
 * - We also store the AMOUNT of each ingredient (in grams)
 * 
 * Example:
 * - "Grilled Chicken with Rice" recipe uses:
 *   - 200g of Chicken
 *   - 150g of Rice
 *   - 30g of Butter
 * 
 * The same Chicken ingredient can be in other recipes too:
 * - "Chicken Salad" recipe uses 150g of Chicken
 * - "Chicken Soup" recipe uses 100g of Chicken
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();                                                  // Primary key
            $table->foreignId('recipe_id')
                  ->constrained()                                         // Foreign key to recipes table
                  ->onDelete('cascade');                                  // Delete recipe ingredients if recipe is deleted
            
            $table->foreignId('ingredient_id')
                  ->constrained()                                         // Foreign key to ingredients table
                  ->onDelete('cascade');                                  // Delete recipe ingredients if ingredient is deleted
            
            $table->float('amount_grams', 8, 2);                          // Amount of this ingredient in grams
            
            $table->timestamps();                                         // created_at and updated_at
            
            // Ensure no duplicate ingredients in the same recipe
            // (Can't have "Chicken" twice in the same recipe)
            $table->unique(['recipe_id', 'ingredient_id']);
            
            // Indexes for faster queries
            $table->index('recipe_id');         // Find all ingredients in a recipe
            $table->index('ingredient_id');     // Find all recipes using an ingredient
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
