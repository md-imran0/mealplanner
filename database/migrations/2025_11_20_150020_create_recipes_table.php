<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * Create the Recipes table
 * 
 * The recipes table stores cooking recipes.
 * Each recipe has:
 * - A name and cooking instructions
 * - Serving size (how many people it feeds)
 * - Preparation and cooking times
 * - Difficulty level
 * 
 * Recipes are global data that all users can see and use.
 * Recipes are linked to ingredients through the recipe_ingredients table.
 * 
 * Example recipe:
 * - Name: "Grilled Chicken with Rice"
 * - Instructions: "Season chicken, grill 6 minutes per side, serve with rice"
 * - Servings: 2
 * - Prep time: 10 minutes
 * - Cook time: 15 minutes
 * - Difficulty: medium
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();                                                          // Primary key
            $table->string('name');                                               // Recipe name
            $table->text('instructions');                                         // Step-by-step cooking instructions
            $table->integer('servings')->default(1);                              // Number of servings this recipe makes
            $table->integer('prep_time_minutes')->nullable();                     // Minutes to prepare ingredients
            $table->integer('cook_time_minutes')->nullable();                     // Minutes to cook
            $table->enum('difficulty', ['easy', 'medium', 'hard'])
                  ->default('medium');                                            // Difficulty level
            
            $table->timestamps();                                                 // created_at and updated_at
            
            // Indexes for faster searching and filtering
            $table->index('name');         // Search recipes by name
            $table->index('difficulty');   // Filter by difficulty level
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
