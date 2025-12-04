<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. This is the Ingredient Table in our relational database. 
     */
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->float('calories_per_100g', 8, 2);
            $table->float('co2_per_100g', 8, 4); // Higher precision for CO2
            $table->float('protein_per_100g', 8, 2);
            $table->float('fiber_per_100g', 8, 2);
            $table->float('carbs_per_100g', 8, 2)->nullable();
            $table->float('fat_per_100g', 8, 2)->nullable();
            $table->float('sugar_per_100g', 8, 2)->nullable();
            $table->float('sodium_per_100g', 8, 2)->nullable();
            $table->timestamps();
            
            // Add index for better search performance
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
