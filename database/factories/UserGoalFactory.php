<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserGoal>
 */
class UserGoalFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $goalTemplates = [
            'calories' => ['min' => 1200, 'max' => 2500, 'direction' => 'max'],
            'protein' => ['min' => 50, 'max' => 150, 'direction' => 'max'],
            'fiber' => ['min' => 20, 'max' => 40, 'direction' => 'max'],
            'co2' => ['min' => 2, 'max' => 10, 'direction' => 'min'],
            'sugar' => ['min' => 10, 'max' => 50, 'direction' => 'min'],
            'sodium' => ['min' => 1000, 'max' => 2300, 'direction' => 'min'],
        ];

        $metric = $this->faker->randomElement(array_keys($goalTemplates));
        $template = $goalTemplates[$metric];

        $notes = [
            'calories' => 'Daily calorie target for weight management',
            'protein' => 'Protein goal for muscle maintenance',
            'fiber' => 'Fiber intake for digestive health',
            'co2' => 'Carbon footprint reduction goal',
            'sugar' => 'Sugar limit for better health',
            'sodium' => 'Sodium restriction for heart health',
        ];

        return [
            'user_id' => User::factory(),
            'metric_name' => $metric,
            'target_value' => $this->faker->numberBetween($template['min'], $template['max']),
            'direction' => $template['direction'],
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
            'notes' => $this->faker->randomElement([$notes[$metric], null, 'Custom goal set by user']),
        ];
    }

    /**
     * Weight loss focused goals
     */
    public function weightLoss(): static
    {
        return $this->state(fn (array $attributes) => [
            'metric_name' => 'calories',
            'target_value' => $this->faker->numberBetween(1200, 1800),
            'direction' => 'max',
            'notes' => 'Calorie deficit for weight loss',
        ]);
    }

    /**
     * High protein goals
     */
    public function highProtein(): static
    {
        return $this->state(fn (array $attributes) => [
            'metric_name' => 'protein',
            'target_value' => $this->faker->numberBetween(100, 200),
            'direction' => 'max',
            'notes' => 'High protein for muscle building',
        ]);
    }

    /**
     * Low carbon footprint goals
     */
    public function lowCarbon(): static
    {
        return $this->state(fn (array $attributes) => [
            'metric_name' => 'co2',
            'target_value' => $this->faker->numberBetween(2, 5),
            'direction' => 'min',
            'notes' => 'Sustainable eating goal',
        ]);
    }
}
