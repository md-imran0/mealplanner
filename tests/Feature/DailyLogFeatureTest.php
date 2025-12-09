<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\DailyLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DailyLogFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_daily_logs_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('daily-logs.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_create_daily_log()
    {
        $user = User::factory()->create();

        $ingredient = Ingredient::create([
            'name' => 'Egg',
            'calories_per_100g' => 155,
            'protein_per_100g' => 13,
            'carbs_per_100g' => 1.1,
            'fat_per_100g' => 11,
            'fiber_per_100g' => 0,
            'sugar_per_100g' => 1.1,
            'sodium_per_100g' => 124,
            'co2_per_100g' => 4.8,
        ]);

        $recipe = Recipe::create([
            'name' => 'Fried Egg',
            'instructions' => 'Fry an egg',
            'servings' => 1,
            'prep_time_minutes' => 2,
            'cook_time_minutes' => 3,
            'difficulty' => 'easy',
        ]);

        $recipe->ingredients()->attach($ingredient->id, ['amount_grams' => 50]);

        $response = $this->actingAs($user)
            ->post(route('daily-logs.store'), [
                'recipe_id' => $recipe->id,
                'date' => today()->toDateString(),
                'meal_type' => 'breakfast',
                'servings' => 1,
                'notes' => 'Delicious',
            ]);

        $response->assertRedirect(route('daily-logs.index'));

        $this->assertDatabaseHas('daily_logs', [
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
            'meal_type' => 'breakfast',
            'servings' => 1,
        ]);
    }

    public function test_user_can_view_created_daily_logs()
    {
        $user = User::factory()->create();

        $ingredient = Ingredient::create([
            'name' => 'Toast',
            'calories_per_100g' => 265,
            'protein_per_100g' => 8.4,
            'carbs_per_100g' => 49,
            'fat_per_100g' => 3.4,
            'fiber_per_100g' => 2.7,
            'sugar_per_100g' => 3.7,
            'sodium_per_100g' => 460,
            'co2_per_100g' => 1.3,
        ]);

        $recipe = Recipe::create([
            'name' => 'Toast',
            'instructions' => 'Toast bread',
            'servings' => 1,
            'prep_time_minutes' => 1,
            'cook_time_minutes' => 2,
            'difficulty' => 'easy',
        ]);

        $recipe->ingredients()->attach($ingredient->id, ['amount_grams' => 30]);

        $dailyLog = DailyLog::create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
            'date' => today(),
            'meal_type' => 'breakfast',
            'servings' => 1,
        ]);

        $response = $this->actingAs($user)
            ->get(route('daily-logs.index'));

        $response->assertStatus(200);
        $response->assertSee('Toast');
    }

    public function test_user_can_edit_daily_log()
    {
        $user = User::factory()->create();

        $ingredient = Ingredient::create([
            'name' => 'Milk',
            'calories_per_100g' => 42,
            'protein_per_100g' => 3.4,
            'carbs_per_100g' => 5,
            'fat_per_100g' => 1,
            'fiber_per_100g' => 0,
            'sugar_per_100g' => 5,
            'sodium_per_100g' => 44,
            'co2_per_100g' => 0.9,
        ]);

        $recipe = Recipe::create([
            'name' => 'Milk',
            'instructions' => 'Drink milk',
            'servings' => 1,
            'prep_time_minutes' => 0,
            'cook_time_minutes' => 0,
            'difficulty' => 'easy',
        ]);

        $recipe->ingredients()->attach($ingredient->id, ['amount_grams' => 100]);

        $dailyLog = DailyLog::create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
            'date' => today(),
            'meal_type' => 'breakfast',
            'servings' => 1,
        ]);

        $response = $this->actingAs($user)
            ->put(route('daily-logs.update', $dailyLog), [
                'recipe_id' => $recipe->id,
                'date' => today()->toDateString(),
                'meal_type' => 'snack',
                'servings' => 2,
                'notes' => 'Changed to snack',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('daily_logs', [
            'id' => $dailyLog->id,
            'meal_type' => 'snack',
            'servings' => 2,
        ]);
    }

    public function test_user_can_delete_daily_log()
    {
        $user = User::factory()->create();

        $ingredient = Ingredient::create([
            'name' => 'Water',
            'calories_per_100g' => 0,
            'protein_per_100g' => 0,
            'carbs_per_100g' => 0,
            'fat_per_100g' => 0,
            'fiber_per_100g' => 0,
            'sugar_per_100g' => 0,
            'sodium_per_100g' => 0,
            'co2_per_100g' => 0,
        ]);

        $recipe = Recipe::create([
            'name' => 'Water',
            'instructions' => 'Drink water',
            'servings' => 1,
            'prep_time_minutes' => 0,
            'cook_time_minutes' => 0,
            'difficulty' => 'easy',
        ]);

        $recipe->ingredients()->attach($ingredient->id, ['amount_grams' => 250]);

        $dailyLog = DailyLog::create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
            'date' => today(),
            'meal_type' => 'breakfast',
            'servings' => 1,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('daily-logs.destroy', $dailyLog));

        $response->assertRedirect();

        $this->assertDatabaseMissing('daily_logs', [
            'id' => $dailyLog->id,
        ]);
    }
}
