<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);
            $table->float('servings', 8, 2)->default(1.0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for common queries
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'date', 'meal_type']);
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_logs');
    }
};
