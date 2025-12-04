<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('metric_name', [
                'calories', 
                'co2', 
                'protein', 
                'fiber', 
                'carbs', 
                'fat', 
                'sugar', 
                'sodium'
            ]);
            $table->float('target_value', 8, 2);
            $table->enum('direction', ['min', 'max']);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // One active goal per metric per user
            $table->unique(['user_id', 'metric_name']);
            
            // Indexes
            $table->index(['user_id', 'is_active']);
            $table->index('metric_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_goals');
    }
};
