<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\DailyLogController;
use App\Http\Controllers\UserGoalController;
use App\Http\Controllers\BiometricController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\MealPlanController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Nutrition Tracker
|--------------------------------------------------------------------------
| 
| Routes organized by feature:
| - Dashboard: Main overview page
| - Ingredients: Manage food items with nutrition facts
| - Recipes: Cooking instructions that use ingredients
| - Daily Logs: Track what user ate each day
| - User Goals: Set health targets (calories, protein, etc)
| - Biometrics: Track body measurements
| - Nutrition: View nutrition summary
| - Meal Plan: Suggest meals based on calorie target
|
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (handled by Laravel Breeze)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/meal-plan/generate', [MealPlanController::class, 'generate'])->name('meal-plan.generate');

    // Ingredient Routes
    Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
    Route::get('/ingredients/create', [IngredientController::class, 'create'])->name('ingredients.create');
    Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::get('/ingredients/{ingredient}', [IngredientController::class, 'show'])->name('ingredients.show');
    Route::get('/ingredients/{ingredient}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
    Route::put('/ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');
    
    // Recipe Routes
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    
    // Daily Log Routes (Meal Logging)
    Route::get('/meals', [DailyLogController::class, 'index'])->name('daily-logs.index');
    Route::get('/meals/create', [DailyLogController::class, 'create'])->name('daily-logs.create');
    Route::post('/meals', [DailyLogController::class, 'store'])->name('daily-logs.store');
    Route::get('/meals/{dailyLog}', [DailyLogController::class, 'show'])->name('daily-logs.show');
    Route::get('/meals/{dailyLog}/edit', [DailyLogController::class, 'edit'])->name('daily-logs.edit');
    Route::put('/meals/{dailyLog}', [DailyLogController::class, 'update'])->name('daily-logs.update');
    Route::delete('/meals/{dailyLog}', [DailyLogController::class, 'destroy'])->name('daily-logs.destroy');
    
    // User Goals Routes
    Route::get('/goals', [UserGoalController::class, 'index'])->name('user-goals.index');
    Route::get('/goals/create', [UserGoalController::class, 'create'])->name('user-goals.create');
    Route::post('/goals', [UserGoalController::class, 'store'])->name('user-goals.store');
    Route::get('/goals/{userGoal}', [UserGoalController::class, 'show'])->name('user-goals.show');
    Route::get('/goals/{userGoal}/edit', [UserGoalController::class, 'edit'])->name('user-goals.edit');
    Route::put('/goals/{userGoal}', [UserGoalController::class, 'update'])->name('user-goals.update');
    Route::delete('/goals/{userGoal}', [UserGoalController::class, 'destroy'])->name('user-goals.destroy');
    
    // Biometric Routes
    Route::get('/biometrics', [BiometricController::class, 'index'])->name('biometrics.index');
    Route::get('/biometrics/create', [BiometricController::class, 'create'])->name('biometrics.create');
    Route::post('/biometrics', [BiometricController::class, 'store'])->name('biometrics.store');
    Route::get('/biometrics/{biometric}', [BiometricController::class, 'show'])->name('biometrics.show');
    Route::get('/biometrics/{biometric}/edit', [BiometricController::class, 'edit'])->name('biometrics.edit');
    Route::put('/biometrics/{biometric}', [BiometricController::class, 'update'])->name('biometrics.update');
    Route::delete('/biometrics/{biometric}', [BiometricController::class, 'destroy'])->name('biometrics.destroy');
    
    // Nutrition Summary Routes
    Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
    Route::get('/nutrition/{date}', [NutritionController::class, 'show'])->name('nutrition.show');
});

require __DIR__.'/auth.php';
