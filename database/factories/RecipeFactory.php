<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $recipeNames = [
            'Grilled Chicken Salad',
            'Vegetable Stir Fry',
            'Quinoa Buddha Bowl',
            'Salmon with Roasted Vegetables',
            'Mediterranean Pasta',
            'Green Smoothie Bowl',
            'Lentil Curry',
            'Avocado Toast',
            'Chicken and Rice Bowl',
            'Vegetarian Chili',
            'Greek Yogurt Parfait',
            'Tuna Salad Wrap',
            'Sweet Potato and Black Bean Bowl',
            'Oatmeal with Berries',
            'Caprese Salad',
            'Turkey Meatballs',
            'Roasted Vegetable Soup',
            'Protein Pancakes',
            'Asian Lettuce Wraps',
            'Stuffed Bell Peppers'
        ];

        $instructions = [
            "1. Preheat oven to 375°F (190°C).\n2. Prepare all ingredients and wash vegetables.\n3. Season proteins with salt and pepper.\n4. Cook according to recipe specifications.\n5. Serve hot and enjoy!",
            "1. Heat oil in a large pan over medium heat.\n2. Add aromatics and cook until fragrant.\n3. Add main ingredients and cook thoroughly.\n4. Season to taste.\n5. Garnish and serve immediately.",
            "1. Prepare all ingredients by chopping and measuring.\n2. Cook grains or proteins as needed.\n3. Combine all ingredients in serving bowl.\n4. Add dressing or sauce.\n5. Mix well and serve fresh.",
            "1. Marinate proteins for at least 30 minutes.\n2. Prepare vegetables by cutting into even pieces.\n3. Cook proteins until done.\n4. Roast or sauté vegetables.\n5. Combine and serve warm."
        ];

        return [
            'name' => $this->faker->randomElement($recipeNames),
            'instructions' => $this->faker->randomElement($instructions),
            'servings' => $this->faker->numberBetween(1, 6),
            'prep_time_minutes' => $this->faker->numberBetween(5, 60),
            'cook_time_minutes' => $this->faker->numberBetween(10, 90),
            'difficulty' => $this->faker->randomElement(['easy', 'medium', 'hard']),
        ];
    }

    /**
     * Quick and easy recipes
     */
    public function quick(): static
    {
        return $this->state(fn (array $attributes) => [
            'prep_time_minutes' => $this->faker->numberBetween(5, 15),
            'cook_time_minutes' => $this->faker->numberBetween(5, 20),
            'difficulty' => 'easy',
        ]);
    }

    /**
     * Complex recipes for advanced cooking
     */
    public function advanced(): static
    {
        return $this->state(fn (array $attributes) => [
            'prep_time_minutes' => $this->faker->numberBetween(30, 120),
            'cook_time_minutes' => $this->faker->numberBetween(45, 180),
            'difficulty' => 'hard',
        ]);
    }
}
