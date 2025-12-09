<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the Daily Logs table
     * 
     * This is the main meal tracking table.
     * Every time a user logs a meal they ate, a daily_log record is created.
     * 
     * Example daily logs:
     * - Date: 2025-12-08, User: John, Recipe: "Grilled Chicken with Rice", Servings: 1, Meal Type: lunch
     * - Date: 2025-12-08, User: John, Recipe: "Pasta Carbonara", Servings: 0.5, Meal Type: dinner
     * - Date: 2025-12-08, User: John, Recipe: "Apple", Servings: 1, Meal Type: snack
     * 
     * This data is used to:
     * - Calculate daily nutrition intake
     * - Check if user met their health goals
     * - Display meal history
     */
    public function up(): void
    {
        Schema::create('daily_logs', function (Blueprint $table) {
            $table->id();                                              // Primary key
            $table->foreignId('user_id')
                  ->constrained()                                     // Foreign key to users table
                  ->onDelete('cascade');                              // Delete meal logs if user is deleted
            
            $table->foreignId('recipe_id')
                  ->constrained()                                     // Foreign key to recipes table
                  ->onDelete('cascade');                              // Delete meal logs if recipe is deleted
            
            $table->date('date');                                      // What date was this meal eaten?
            
            // What meal of the day was this?
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);
            
            $table->float('servings', 8, 2)->default(1.0);            // How many servings did user eat?
            $table->text('notes')->nullable();                        // Optional notes about the meal
            
            $table->timestamps();                                     // created_at and updated_at
            
            // Indexes for common queries
            $table->index(['user_id', 'date']);              // Find all meals for a user on a specific date
            $table->index(['user_id', 'date', 'meal_type']); // Find meals for a user on a date filtered by type
            $table->index('date');                           // Find all meals eaten on a specific date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_logs');
    }
};
