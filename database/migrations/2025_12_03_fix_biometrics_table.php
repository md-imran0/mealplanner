<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('biometrics');
        
        Schema::create('biometrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('measurement_date');
            $table->float('weight', 8, 2)->nullable(); // in kg
            $table->float('height', 8, 2)->nullable(); // in cm
            $table->float('body_fat_percentage', 5, 2)->nullable(); // percentage
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'measurement_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biometrics');
    }
};
