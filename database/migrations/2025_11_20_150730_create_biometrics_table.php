<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biometrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('measurement_type', [
                'weight',
                'blood_pressure_systolic',
                'blood_pressure_diastolic',
                'heart_rate',
                'body_fat_percentage',
                'muscle_mass',
                'bmi'
            ]);
            $table->float('value', 8, 2);
            $table->string('unit', 10); // kg, lbs, mmHg, bpm, %
            $table->datetime('measured_at');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for time-series queries
            $table->index(['user_id', 'measurement_type', 'measured_at']);
            $table->index(['user_id', 'measured_at']);
            $table->index('measurement_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biometrics');
    }
};
