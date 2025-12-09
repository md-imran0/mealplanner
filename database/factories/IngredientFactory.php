<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Comprehensive list of unique ingredients
        static $ingredientData = [
            // Fruits
            ['name' => 'Apple', 'calories' => 52, 'co2' => 0.3, 'protein' => 0.3, 'fiber' => 2.4],
            ['name' => 'Banana', 'calories' => 89, 'co2' => 0.7, 'protein' => 1.1, 'fiber' => 2.6],
            ['name' => 'Orange', 'calories' => 47, 'co2' => 0.3, 'protein' => 0.9, 'fiber' => 2.4],
            ['name' => 'Strawberry', 'calories' => 32, 'co2' => 0.3, 'protein' => 0.7, 'fiber' => 2.0],
            ['name' => 'Blueberry', 'calories' => 57, 'co2' => 0.8, 'protein' => 0.7, 'fiber' => 2.4],
            ['name' => 'Mango', 'calories' => 60, 'co2' => 1.2, 'protein' => 0.8, 'fiber' => 1.6],
            ['name' => 'Pineapple', 'calories' => 50, 'co2' => 0.9, 'protein' => 0.5, 'fiber' => 1.4],
            ['name' => 'Grape', 'calories' => 62, 'co2' => 0.4, 'protein' => 0.6, 'fiber' => 0.9],
            ['name' => 'Peach', 'calories' => 39, 'co2' => 0.4, 'protein' => 0.9, 'fiber' => 1.5],
            ['name' => 'Pear', 'calories' => 57, 'co2' => 0.3, 'protein' => 0.4, 'fiber' => 3.1],
            
            // Vegetables
            ['name' => 'Broccoli', 'calories' => 34, 'co2' => 2.0, 'protein' => 2.8, 'fiber' => 2.6],
            ['name' => 'Spinach', 'calories' => 23, 'co2' => 2.0, 'protein' => 2.9, 'fiber' => 2.2],
            ['name' => 'Carrot', 'calories' => 41, 'co2' => 0.4, 'protein' => 0.9, 'fiber' => 2.8],
            ['name' => 'Bell Pepper', 'calories' => 31, 'co2' => 2.0, 'protein' => 1.9, 'fiber' => 2.5],
            ['name' => 'Tomato', 'calories' => 18, 'co2' => 2.3, 'protein' => 0.9, 'fiber' => 1.2],
            ['name' => 'Cucumber', 'calories' => 16, 'co2' => 0.3, 'protein' => 0.7, 'fiber' => 0.5],
            ['name' => 'Lettuce', 'calories' => 15, 'co2' => 0.5, 'protein' => 1.4, 'fiber' => 1.3],
            ['name' => 'Onion', 'calories' => 40, 'co2' => 0.3, 'protein' => 1.1, 'fiber' => 1.7],
            ['name' => 'Garlic', 'calories' => 149, 'co2' => 0.4, 'protein' => 6.4, 'fiber' => 2.1],
            ['name' => 'Sweet Potato', 'calories' => 86, 'co2' => 0.3, 'protein' => 1.6, 'fiber' => 3.0],
            
            // Proteins
            ['name' => 'Chicken Breast', 'calories' => 165, 'co2' => 6.9, 'protein' => 31.0, 'fiber' => 0.0],
            ['name' => 'Salmon', 'calories' => 208, 'co2' => 6.0, 'protein' => 20.0, 'fiber' => 0.0],
            ['name' => 'Tuna', 'calories' => 184, 'co2' => 5.8, 'protein' => 30.0, 'fiber' => 0.0],
            ['name' => 'Tofu', 'calories' => 76, 'co2' => 2.0, 'protein' => 8.0, 'fiber' => 1.9],
            ['name' => 'Black Beans', 'calories' => 132, 'co2' => 0.4, 'protein' => 9.0, 'fiber' => 8.7],
            ['name' => 'Chickpeas', 'calories' => 164, 'co2' => 0.4, 'protein' => 8.9, 'fiber' => 7.6],
            ['name' => 'Lentils', 'calories' => 116, 'co2' => 0.4, 'protein' => 9.0, 'fiber' => 7.9],
            ['name' => 'Eggs', 'calories' => 155, 'co2' => 4.2, 'protein' => 13.0, 'fiber' => 0.0],
            ['name' => 'Greek Yogurt', 'calories' => 59, 'co2' => 9.0, 'protein' => 10.0, 'fiber' => 0.0],
            ['name' => 'Cottage Cheese', 'calories' => 98, 'co2' => 8.5, 'protein' => 11.1, 'fiber' => 0.0],
            
            // Grains & Starches
            ['name' => 'Brown Rice', 'calories' => 111, 'co2' => 2.7, 'protein' => 2.6, 'fiber' => 1.8],
            ['name' => 'White Rice', 'calories' => 130, 'co2' => 2.7, 'protein' => 2.7, 'fiber' => 0.4],
            ['name' => 'Quinoa', 'calories' => 120, 'co2' => 1.6, 'protein' => 4.4, 'fiber' => 2.8],
            ['name' => 'Oats', 'calories' => 389, 'co2' => 2.5, 'protein' => 16.9, 'fiber' => 10.6],
            ['name' => 'Whole Wheat Bread', 'calories' => 247, 'co2' => 1.6, 'protein' => 13.2, 'fiber' => 6.3],
            ['name' => 'Pasta', 'calories' => 131, 'co2' => 1.1, 'protein' => 5.0, 'fiber' => 1.8],
            ['name' => 'Barley', 'calories' => 123, 'co2' => 1.2, 'protein' => 2.3, 'fiber' => 15.6],
            ['name' => 'Bulgur', 'calories' => 83, 'co2' => 1.0, 'protein' => 3.1, 'fiber' => 4.5],
            
            // Nuts & Seeds
            ['name' => 'Almonds', 'calories' => 579, 'co2' => 9.3, 'protein' => 21.2, 'fiber' => 12.5],
            ['name' => 'Walnuts', 'calories' => 654, 'co2' => 2.6, 'protein' => 15.2, 'fiber' => 6.7],
            ['name' => 'Chia Seeds', 'calories' => 486, 'co2' => 1.4, 'protein' => 17.0, 'fiber' => 34.4],
            ['name' => 'Flax Seeds', 'calories' => 534, 'co2' => 1.2, 'protein' => 18.3, 'fiber' => 27.3],
            ['name' => 'Pumpkin Seeds', 'calories' => 559, 'co2' => 1.8, 'protein' => 30.2, 'fiber' => 6.0],
            
            // Dairy & Alternatives
            ['name' => 'Milk (2%)', 'calories' => 50, 'co2' => 3.2, 'protein' => 3.4, 'fiber' => 0.0],
            ['name' => 'Almond Milk', 'calories' => 17, 'co2' => 0.7, 'protein' => 0.6, 'fiber' => 0.4],
            ['name' => 'Cheese (Cheddar)', 'calories' => 403, 'co2' => 13.5, 'protein' => 24.9, 'fiber' => 0.0],
            ['name' => 'Mozzarella', 'calories' => 280, 'co2' => 11.2, 'protein' => 22.2, 'fiber' => 0.0],
            
            // Oils & Fats
            ['name' => 'Olive Oil', 'calories' => 884, 'co2' => 3.2, 'protein' => 0.0, 'fiber' => 0.0],
            ['name' => 'Coconut Oil', 'calories' => 862, 'co2' => 3.8, 'protein' => 0.0, 'fiber' => 0.0],
            ['name' => 'Avocado', 'calories' => 160, 'co2' => 0.9, 'protein' => 2.0, 'fiber' => 6.7],
            
            // Herbs & Spices
            ['name' => 'Basil', 'calories' => 22, 'co2' => 0.1, 'protein' => 3.2, 'fiber' => 1.6],
            ['name' => 'Cilantro', 'calories' => 23, 'co2' => 0.1, 'protein' => 2.1, 'fiber' => 2.8],
            ['name' => 'Parsley', 'calories' => 36, 'co2' => 0.1, 'protein' => 3.0, 'fiber' => 3.3],
        ];

        // Keep track of used ingredients to ensure uniqueness
        static $usedIngredients = [];

        // Filter out already used ingredients
        $availableIngredients = array_filter($ingredientData, function($ingredient) use (&$usedIngredients) {
            return !in_array($ingredient['name'], $usedIngredients);
        });

        // If we've run out of predefined ingredients, reset the list
        if (empty($availableIngredients)) {
            $usedIngredients = [];
            $availableIngredients = $ingredientData;
        }

        // Select a random available ingredient
        $selectedIngredient = $this->faker->randomElement($availableIngredients);
        
        // Mark this ingredient as used
        $usedIngredients[] = $selectedIngredient['name'];

        return [
            'name' => $selectedIngredient['name'],
            'calories_per_100g' => $selectedIngredient['calories'] + $this->faker->numberBetween(-5, 5),
            'co2_per_100g' => max(0, $selectedIngredient['co2'] + $this->faker->randomFloat(1, -0.2, 0.2)),
            'protein_per_100g' => max(0, $selectedIngredient['protein'] + $this->faker->randomFloat(1, -0.5, 0.5)),
            'fiber_per_100g' => max(0, $selectedIngredient['fiber'] + $this->faker->randomFloat(1, -0.2, 0.2)),
            'carbs_per_100g' => $this->faker->randomFloat(2, 0, 80),
            'fat_per_100g' => $this->faker->randomFloat(2, 0, 30),
            'sugar_per_100g' => $this->faker->randomFloat(2, 0, 20),
            'sodium_per_100g' => $this->faker->randomFloat(2, 0, 2000),
        ];
    }

    /**
     * Create specific ingredient types
     */
    public function fruit(): static
    {
        return $this->state(fn (array $attributes) => [
            'calories_per_100g' => $this->faker->numberBetween(30, 90),
            'co2_per_100g' => $this->faker->randomFloat(2, 0.2, 1.5),
            'protein_per_100g' => $this->faker->randomFloat(2, 0.3, 2.0),
            'fiber_per_100g' => $this->faker->randomFloat(2, 1.0, 4.0),
            'carbs_per_100g' => $this->faker->randomFloat(2, 8, 25),
            'fat_per_100g' => $this->faker->randomFloat(2, 0.1, 1.0),
        ]);
    }

    public function protein(): static
    {
        return $this->state(fn (array $attributes) => [
            'calories_per_100g' => $this->faker->numberBetween(100, 300),
            'co2_per_100g' => $this->faker->randomFloat(2, 1.0, 10.0),
            'protein_per_100g' => $this->faker->randomFloat(2, 15.0, 35.0),
            'fiber_per_100g' => $this->faker->randomFloat(2, 0, 5.0),
            'carbs_per_100g' => $this->faker->randomFloat(2, 0, 10),
            'fat_per_100g' => $this->faker->randomFloat(2, 1, 25),
        ]);
    }

    public function vegetable(): static
    {
        return $this->state(fn (array $attributes) => [
            'calories_per_100g' => $this->faker->numberBetween(15, 60),
            'co2_per_100g' => $this->faker->randomFloat(2, 0.3, 3.0),
            'protein_per_100g' => $this->faker->randomFloat(2, 0.5, 5.0),
            'fiber_per_100g' => $this->faker->randomFloat(2, 1.0, 8.0),
            'carbs_per_100g' => $this->faker->randomFloat(2, 2, 20),
            'fat_per_100g' => $this->faker->randomFloat(2, 0.1, 1.0),
        ]);
    }
}
