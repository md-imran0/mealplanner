<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the Biometrics table
     * 
     * This table stores body measurements that users track over time.
     * Users can record their physical measurements to track fitness progress.
     * 
     * Examples of biometric records:
     * - User: John, Date: 2025-12-01, Measurement: weight, Value: 80 kg
     * - User: John, Date: 2025-12-08, Measurement: weight, Value: 78 kg (progress!)
     * - User: John, Date: 2025-12-08, Measurement: body_fat_percentage, Value: 22 %
     * 
     * This helps users see if they're making progress towards their fitness goals.
     */
    public function up(): void
    {
        Schema::create('biometrics', function (Blueprint $table) {
            $table->id();                                              // Primary key
            $table->foreignId('user_id')
                  ->constrained()                                     // Foreign key to users table
                  ->onDelete('cascade');                              // Delete measurements if user is deleted
            
            // What type of measurement is this?
            $table->enum('measurement_type', [
                'weight',                    // Body weight
                'blood_pressure_systolic',   // Top number in blood pressure
                'blood_pressure_diastolic',  // Bottom number in blood pressure
                'heart_rate',                // Beats per minute
                'body_fat_percentage',       // Percentage of body that is fat
                'muscle_mass',               // Amount of muscle
                'bmi'                        // Body Mass Index
            ]);
            
            $table->float('value', 8, 2);                             // The measurement value (e.g., 80)
            $table->string('unit', 10);                               // Unit of measurement (kg, lbs, mmHg, bpm, %, etc)
            
            $table->datetime('measured_at');                          // When was this measurement taken?
            $table->text('notes')->nullable();                        // Optional notes
            
            $table->timestamps();                                     // created_at and updated_at
            
            // Indexes for time-series queries (useful for tracking changes over time)
            $table->index(['user_id', 'measurement_type', 'measured_at']);  // Find measurements of a type for a user
            $table->index(['user_id', 'measured_at']);                      // Find all measurements for a user at a time
            $table->index('measurement_type');                              // Find all measurements of a specific type
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biometrics');
    }
};
