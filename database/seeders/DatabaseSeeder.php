<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\UserGoal;
use App\Models\DailyLog;
use App\Models\Biometric;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Create a test user first with explicit password hashing
            $testUser = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
            ]);

            $this->command->info('Test user created successfully: ' . $testUser->email);

            // Create additional users
            $users = User::factory(4)->create(); // Reduced from 5 to 4
            $allUsers = $users->push($testUser);

            $this->command->info('Created ' . $allUsers->count() . ' users total');

            // Create ingredients - reduced to match our predefined list
            $this->command->info('Creating ingredients...');
            $ingredients = Ingredient::factory(45)->create(); // Reduced from 50 to 45
            $this->command->info('Created ' . $ingredients->count() . ' ingredients');

            // Create recipes
            $this->command->info('Creating recipes...');
            $recipes = Recipe::factory(25)->create(); // Reduced from 30 to 25
            $this->command->info('Created ' . $recipes->count() . ' recipes');

            // Attach ingredients to recipes with amounts
            $this->command->info('Linking recipes with ingredients...');
            foreach ($recipes as $recipe) {
                $recipeIngredients = $ingredients->random(rand(3, 6)); // Reduced max from 8 to 6
                
                foreach ($recipeIngredients as $ingredient) {
                    $recipe->ingredients()->attach($ingredient->id, [
                        'amount_grams' => rand(50, 400), // Reduced max from 500 to 400
                    ]);
                }
            }

            // Create user goals for each user
            $this->command->info('Creating user goals...');
            $goalCount = 0;
            foreach ($allUsers as $user) {
                $goalTypes = ['calories', 'protein', 'fiber', 'co2', 'sugar', 'sodium'];
                $userGoalTypes = collect($goalTypes)->random(rand(3, 4)); // Reduced max from 5 to 4
                
                foreach ($userGoalTypes as $goalType) {
                    UserGoal::factory()->create([
                        'user_id' => $user->id,
                        'metric_name' => $goalType,
                    ]);
                    $goalCount++;
                }
            }
            $this->command->info('Created ' . $goalCount . ' user goals');

            // Create daily logs for each user
            $this->command->info('Creating daily logs...');
            $logCount = 0;
            foreach ($allUsers as $user) {
                for ($i = 0; $i < 21; $i++) { // Reduced from 30 to 21 days
                    $date = now()->subDays($i)->format('Y-m-d');
                    
                    $mealsPerDay = rand(2, 4);
                    $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
                    $dailyMeals = collect($mealTypes)->random($mealsPerDay);
                    
                    foreach ($dailyMeals as $mealType) {
                        DailyLog::factory()->create([
                            'user_id' => $user->id,
                            'recipe_id' => $recipes->random()->id,
                            'date' => $date,
                            'meal_type' => $mealType,
                        ]);
                        $logCount++;
                    }
                }
            }
            $this->command->info('Created ' . $logCount . ' daily logs');

            // Create biometric data for each user
            $this->command->info('Creating biometric data...');
            $biometricCount = 0;
            foreach ($allUsers as $user) {
                // Weight measurements - reduced frequency
                for ($i = 0; $i < 8; $i++) { // Reduced from 12 to 8
                    Biometric::factory()->weight()->create([
                        'user_id' => $user->id,
                        'measured_at' => now()->subWeeks($i),
                    ]);
                    $biometricCount++;
                }

                // Blood pressure measurements - reduced frequency
                for ($i = 0; $i < 4; $i++) { // Reduced from 6 to 4
                    Biometric::factory()->create([
                        'user_id' => $user->id,
                        'measurement_type' => 'blood_pressure_systolic',
                        'value' => rand(90, 140),
                        'unit' => 'mmHg',
                        'measured_at' => now()->subMonths($i),
                    ]);
                    
                    Biometric::factory()->create([
                        'user_id' => $user->id,
                        'measurement_type' => 'blood_pressure_diastolic',
                        'value' => rand(60, 90),
                        'unit' => 'mmHg',
                        'measured_at' => now()->subMonths($i),
                    ]);
                    $biometricCount += 2;
                }

                // Random other measurements - reduced count
                $otherMeasurements = Biometric::factory(6)->create([ // Reduced from 10 to 6
                    'user_id' => $user->id,
                ]);
                $biometricCount += $otherMeasurements->count();
            }
            $this->command->info('Created ' . $biometricCount . ' biometric records');

            $this->command->info('');
            $this->command->info('✅ Database seeded successfully!');
            $this->command->info('📧 Test user: test@example.com / password');
            $this->command->info('🥗 Ingredients: ' . $ingredients->count());
            $this->command->info('🍽️ Recipes: ' . $recipes->count());
            $this->command->info('👥 Users: ' . $allUsers->count());
            $this->command->info('🎯 Goals: ' . $goalCount);
            $this->command->info('📊 Daily logs: ' . $logCount);
            $this->command->info('⚖️ Biometrics: ' . $biometricCount);

        } catch (\Exception $e) {
            $this->command->error('❌ Seeding failed: ' . $e->getMessage());
            $this->command->error('File: ' . $e->getFile() . ':' . $e->getLine());
            throw $e;
        }
    }
}
