<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\DailyLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NutritionCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_ingredient_nutrition_calculation()
    {
        $ingredient = Ingredient::create([
            'name' => 'Chicken Breast',
            'calories_per_100g' => 165,
            'protein_per_100g' => 31,
            'carbs_per_100g' => 0,
            'fat_per_100g' => 3.6,
            'fiber_per_100g' => 0,
            'sugar_per_100g' => 0,
            'sodium_per_100g' => 74,
            'co2_per_100g' => 6.7,
        ]);

        // Calculate nutrition for 200g
        $nutrition = $ingredient->calculateNutrition(200);

        $this->assertEquals(330, $nutrition['calories']); // 165 * 2
        $this->assertEquals(62, $nutrition['protein']); // 31 * 2
        $this->assertEquals(13.4, $nutrition['co2']); // 6.7 * 2
    }

    public function test_recipe_nutrition_calculation()
    {
        $chicken = Ingredient::create([
            'name' => 'Chicken',
            'calories_per_100g' => 165,
            'protein_per_100g' => 31,
            'carbs_per_100g' => 0,
            'fat_per_100g' => 3.6,
            'fiber_per_100g' => 0,
            'sugar_per_100g' => 0,
            'sodium_per_100g' => 74,
            'co2_per_100g' => 6.7,
        ]);

        $rice = Ingredient::create([
            'name' => 'Rice',
            'calories_per_100g' => 130,
            'protein_per_100g' => 2.7,
            'carbs_per_100g' => 28,
            'fat_per_100g' => 0.3,
            'fiber_per_100g' => 0.4,
            'sugar_per_100g' => 0.1,
            'sodium_per_100g' => 1,
            'co2_per_100g' => 2.7,
        ]);

        $recipe = Recipe::create([
            'name' => 'Chicken Rice',
            'instructions' => 'Cook chicken and rice',
            'servings' => 2,
            'prep_time_minutes' => 10,
            'cook_time_minutes' => 30,
            'difficulty' => 'easy',
        ]);

        $recipe->ingredients()->attach($chicken->id, ['amount_grams' => 200]);
        $recipe->ingredients()->attach($rice->id, ['amount_grams' => 200]);

        $totalNutrition = $recipe->calculateTotalNutrition();
        
        // Check total calories: (165*2) + (130*2) = 590
        $this->assertEquals(590, $totalNutrition['calories']);
        
        // Check per serving: 590 / 2 = 295
        $perServing = $recipe->calculateNutritionPerServing();
        $this->assertEquals(295, $perServing['calories']);

        // Check for 1.5 servings: 295 * 1.5 = 442.5
        $forServings = $recipe->calculateNutritionForServings(1.5);
        $this->assertEquals(442.5, $forServings['calories']);
    }

    public function test_daily_log_nutrition_calculation()
    {
        $user = User::factory()->create();

        $ingredient = Ingredient::create([
            'name' => 'Apple',
            'calories_per_100g' => 52,
            'protein_per_100g' => 0.3,
            'carbs_per_100g' => 14,
            'fat_per_100g' => 0.2,
            'fiber_per_100g' => 2.4,
            'sugar_per_100g' => 10,
            'sodium_per_100g' => 2,
            'co2_per_100g' => 0.4,
        ]);

        $recipe = Recipe::create([
            'name' => 'Apple',
            'instructions' => 'Eat apple',
            'servings' => 1,
            'prep_time_minutes' => 0,
            'cook_time_minutes' => 0,
            'difficulty' => 'easy',
        ]);

        $recipe->ingredients()->attach($ingredient->id, ['amount_grams' => 182]);

        $dailyLog = DailyLog::create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
            'date' => today(),
            'servings' => 2,
            'meal_type' => 'breakfast',
        ]);

        $nutrition = $dailyLog->calculateNutrition();
        
        // Total: 52 * 1.82 * 2 = 189.28 calories
        $this->assertGreaterThan(180, $nutrition['calories']);
        $this->assertLessThan(200, $nutrition['calories']);
    }

    public function test_user_daily_nutrition_totals()
    {
        $user = User::factory()->create();

        $ingredient = Ingredient::create([
            'name' => 'Banana',
            'calories_per_100g' => 89,
            'protein_per_100g' => 1.1,
            'carbs_per_100g' => 23,
            'fat_per_100g' => 0.3,
            'fiber_per_100g' => 2.6,
            'sugar_per_100g' => 12,
            'sodium_per_100g' => 1,
            'co2_per_100g' => 0.9,
        ]);

        $recipe = Recipe::create([
            'name' => 'Banana',
            'instructions' => 'Eat',
            'servings' => 1,
            'prep_time_minutes' => 0,
            'cook_time_minutes' => 0,
            'difficulty' => 'easy',
        ]);

        $recipe->ingredients()->attach($ingredient->id, ['amount_grams' => 118]);

        // Create 3 logs for today
        for ($i = 0; $i < 3; $i++) {
            DailyLog::create([
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
                'date' => today(),
                'servings' => 1,
                'meal_type' => 'snack',
            ]);
        }

        $dailyTotals = $user->getDailyNutrition(today()->toDateString());

        // Should have 3x the nutrition of one banana
        $singleNutrition = $recipe->calculateNutritionForServings(1);
        $this->assertGreaterThan($singleNutrition['calories'] * 2.5, $dailyTotals['calories']);
        $this->assertLessThan($singleNutrition['calories'] * 3.5, $dailyTotals['calories']);
    }
}
