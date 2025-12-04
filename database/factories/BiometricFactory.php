<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Biometric>
 */
class BiometricFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $measurementTypes = [
            'weight' => ['value' => [50, 120], 'unit' => 'kg'],
            'blood_pressure_systolic' => ['value' => [90, 140], 'unit' => 'mmHg'],
            'blood_pressure_diastolic' => ['value' => [60, 90], 'unit' => 'mmHg'],
            'heart_rate' => ['value' => [60, 100], 'unit' => 'bpm'],
            'body_fat_percentage' => ['value' => [10, 35], 'unit' => '%'],
            'muscle_mass' => ['value' => [30, 80], 'unit' => 'kg'],
            'bmi' => ['value' => [18.5, 30], 'unit' => 'kg/m²'],
        ];

        $type = $this->faker->randomElement(array_keys($measurementTypes));
        $config = $measurementTypes[$type];

        return [
            'user_id' => User::factory(),
            'measurement_type' => $type,
            'value' => $this->faker->randomFloat(1, $config['value'][0], $config['value'][1]),
            'unit' => $config['unit'],
            'measured_at' => $this->faker->dateTimeBetween('-90 days', 'now'),
            'notes' => $this->faker->optional(0.2)->sentence(), // 20% chance of having notes
        ];
    }

    /**
     * Weight measurements
     */
    public function weight(): static
    {
        return $this->state(fn (array $attributes) => [
            'measurement_type' => 'weight',
            'value' => $this->faker->randomFloat(1, 50, 120),
            'unit' => 'kg',
        ]);
    }

    /**
     * Blood pressure measurements
     */
    public function bloodPressure(): static
    {
        $systolic = $this->faker->boolean();
        
        return $this->state(fn (array $attributes) => [
            'measurement_type' => $systolic ? 'blood_pressure_systolic' : 'blood_pressure_diastolic',
            'value' => $systolic 
                ? $this->faker->randomFloat(0, 90, 140) 
                : $this->faker->randomFloat(0, 60, 90),
            'unit' => 'mmHg',
        ]);
    }

    /**
     * Recent measurements (last 30 days)
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'measured_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ]);
    }
}
