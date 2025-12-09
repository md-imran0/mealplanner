<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyLog>
 */
class DailyLogFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'recipe_id' => Recipe::factory(),
            'date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'meal_type' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner', 'snack']),
            'servings' => $this->faker->randomFloat(1, 0.5, 3.0),
            'notes' => $this->faker->optional(0.3)->sentence(),
        ];
    }

    /**
     * Recent logs (last 7 days)
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => $this->faker->dateTimeBetween('-7 days', 'now')->format('Y-m-d'),
        ]);
    }

    /**
     * Today's meals
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => Carbon::today()->format('Y-m-d'),
        ]);
    }

    /**
     * Yesterday's meals
     */
    public function yesterday(): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => Carbon::yesterday()->format('Y-m-d'),
        ]);
    }

    /**
     * Breakfast specific
     */
    public function breakfast(): static
    {
        return $this->state(fn (array $attributes) => [
            'meal_type' => 'breakfast',
            'servings' => $this->faker->randomFloat(1, 0.8, 2.0),
        ]);
    }

    /**
     * Lunch specific
     */
    public function lunch(): static
    {
        return $this->state(fn (array $attributes) => [
            'meal_type' => 'lunch',
            'servings' => $this->faker->randomFloat(1, 1.0, 2.5),
        ]);
    }

    /**
     * Dinner specific
     */
    public function dinner(): static
    {
        return $this->state(fn (array $attributes) => [
            'meal_type' => 'dinner',
            'servings' => $this->faker->randomFloat(1, 1.0, 3.0),
        ]);
    }

    /**
     * Snack specific
     */
    public function snack(): static
    {
        return $this->state(fn (array $attributes) => [
            'meal_type' => 'snack',
            'servings' => $this->faker->randomFloat(1, 0.3, 1.5),
        ]);
    }
}
