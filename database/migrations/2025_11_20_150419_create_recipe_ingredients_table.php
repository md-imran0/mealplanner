<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    Recipe ingredients table in Relational database

*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->float('amount_grams', 8, 2);
            $table->timestamps();
            
            // Ensure unique combination - no duplicate ingredients in same recipe
            $table->unique(['recipe_id', 'ingredient_id']);
            
            // Indexes for performance
            $table->index('recipe_id');
            $table->index('ingredient_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
