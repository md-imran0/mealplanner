<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Create the Ingredients table
     * 
     * The ingredients table stores all basic food items with their nutrition facts.
     * All nutrition values are stored per 100g for standardization.
     * 
     * Examples of ingredients:
     * - Chicken (protein-rich)
     * - Rice (carbs)
     * - Broccoli (vitamins, fiber)
     * - Olive Oil (fat)
     * 
     * These ingredients are then combined into recipes.
     */
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();                                           // Primary key
            $table->string('name')->unique();                       // Ingredient name (must be unique)
            
            // Nutrition facts per 100g of ingredient
            $table->float('calories_per_100g', 8, 2);              // Energy content
            $table->float('co2_per_100g', 8, 4);                   // Environmental impact (higher precision)
            $table->float('protein_per_100g', 8, 2);               // Protein content
            $table->float('fiber_per_100g', 8, 2);                 // Dietary fiber
            $table->float('carbs_per_100g', 8, 2)->nullable();     // Carbohydrates (optional)
            $table->float('fat_per_100g', 8, 2)->nullable();       // Fat content (optional)
            $table->float('sugar_per_100g', 8, 2)->nullable();     // Sugar content (optional)
            $table->float('sodium_per_100g', 8, 2)->nullable();    // Sodium content (optional)
            
            $table->timestamps();                                   // created_at and updated_at
            
            // Add index on name for faster searching by ingredient name
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations - Drop the ingredients table
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
