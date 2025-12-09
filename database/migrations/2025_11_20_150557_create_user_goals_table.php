<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the User Goals table
     * 
     * Each user can set multiple health goals to track their progress.
     * Examples of goals:
     * - "Get 2000 calories per day" (min - at least 2000)
     * - "Don't exceed 1500mg sodium per day" (max - at most 1500)
     * - "Get at least 100g protein per day" (min - at least 100)
     * - "Keep carbs under 150g per day" (max - at most 150)
     * 
     * The app checks daily if the user is meeting each active goal.
     */
    public function up(): void
    {
        Schema::create('user_goals', function (Blueprint $table) {
            $table->id();                                              // Primary key
            $table->foreignId('user_id')
                  ->constrained()                                     // Foreign key to users table
                  ->onDelete('cascade');                              // Delete goals if user is deleted
            
            // Which metric is this goal tracking?
            $table->enum('metric_name', [
                'calories',      // Energy intake
                'co2',           // Environmental impact
                'protein',       // Protein intake
                'fiber',         // Dietary fiber
                'carbs',         // Carbohydrate intake
                'fat',           // Fat intake
                'sugar',         // Sugar intake
                'sodium'         // Sodium/salt intake
            ]);
            
            $table->float('target_value', 8, 2);                      // The goal amount (e.g., 2000 calories)
            
            // Direction: "min" means "at least this much", "max" means "not more than this much"
            $table->enum('direction', ['min', 'max']);
            
            $table->boolean('is_active')->default(true);              // Is this goal currently active?
            $table->text('notes')->nullable();                        // Optional notes about the goal
            
            $table->timestamps();                                     // created_at and updated_at
            
            // One active goal per metric per user (can't have two calorie goals at same time)
            $table->unique(['user_id', 'metric_name']);
            
            // Indexes for faster queries
            $table->index(['user_id', 'is_active']);  // Find all active goals for a user
            $table->index('metric_name');              // Find all goals by metric type
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_goals');
    }
};
