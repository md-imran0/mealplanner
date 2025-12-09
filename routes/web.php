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
| Web Routes - Nutrition Tracker Application
|--------------------------------------------------------------------------
| 
| This file defines all the web routes (URLs) for the nutrition tracker app.
| 
| Routes are organized by feature:
| - Dashboard: Main overview page showing today's meals and goals
| - Ingredients: Manage food items with nutrition facts
| - Recipes: Create and manage cooking recipes using ingredients
| - Daily Logs (Meals): Track what user ate each day
| - User Goals: Set health targets (calories, protein, weight loss, etc)
| - Biometrics: Track body measurements (weight, height, body fat %)
| - Nutrition: View nutrition summary and analysis
| - Meal Plan: Suggest meals based on calorie target
|
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Dashboard - Main page (requires authentication)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// All routes below require the user to be authenticated (logged in)
Route::middleware('auth')->group(function () {
    
    // ==================== PROFILE ROUTES ====================
    // Allow users to view and edit their profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Meal Plan Generation - Generate a meal plan based on calorie target
    Route::post('/meal-plan/generate', [MealPlanController::class, 'generate'])->name('meal-plan.generate');

    // ==================== INGREDIENT ROUTES ====================
    // Manage food ingredients (basic food items with nutrition facts)
    Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
    Route::get('/ingredients/create', [IngredientController::class, 'create'])->name('ingredients.create');
    Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::get('/ingredients/{ingredient}', [IngredientController::class, 'show'])->name('ingredients.show');
    Route::get('/ingredients/{ingredient}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
    Route::put('/ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');
    
    // ==================== RECIPE ROUTES ====================
    // Manage recipes (cooking instructions using multiple ingredients)
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    
    // ==================== DAILY LOG ROUTES (Meal Logging) ====================
    // Log what meals the user ate each day
    Route::get('/meals', [DailyLogController::class, 'index'])->name('daily-logs.index');
    Route::get('/meals/create', [DailyLogController::class, 'create'])->name('daily-logs.create');
    Route::post('/meals', [DailyLogController::class, 'store'])->name('daily-logs.store');
    Route::get('/meals/{dailyLog}', [DailyLogController::class, 'show'])->name('daily-logs.show');
    Route::get('/meals/{dailyLog}/edit', [DailyLogController::class, 'edit'])->name('daily-logs.edit');
    Route::put('/meals/{dailyLog}', [DailyLogController::class, 'update'])->name('daily-logs.update');
    Route::delete('/meals/{dailyLog}', [DailyLogController::class, 'destroy'])->name('daily-logs.destroy');
    
    // ==================== USER GOALS ROUTES ====================
    // Set and track health goals (calorie targets, protein goals, etc)
    Route::get('/goals', [UserGoalController::class, 'index'])->name('user-goals.index');
    Route::get('/goals/create', [UserGoalController::class, 'create'])->name('user-goals.create');
    Route::post('/goals', [UserGoalController::class, 'store'])->name('user-goals.store');
    Route::get('/goals/{userGoal}', [UserGoalController::class, 'show'])->name('user-goals.show');
    Route::get('/goals/{userGoal}/edit', [UserGoalController::class, 'edit'])->name('user-goals.edit');
    Route::put('/goals/{userGoal}', [UserGoalController::class, 'update'])->name('user-goals.update');
    Route::delete('/goals/{userGoal}', [UserGoalController::class, 'destroy'])->name('user-goals.destroy');
    
    // ==================== BIOMETRIC ROUTES ====================
    // Track body measurements (weight, height, body fat percentage)
    Route::get('/biometrics', [BiometricController::class, 'index'])->name('biometrics.index');
    Route::get('/biometrics/create', [BiometricController::class, 'create'])->name('biometrics.create');
    Route::post('/biometrics', [BiometricController::class, 'store'])->name('biometrics.store');
    Route::get('/biometrics/{biometric}', [BiometricController::class, 'show'])->name('biometrics.show');
    Route::get('/biometrics/{biometric}/edit', [BiometricController::class, 'edit'])->name('biometrics.edit');
    Route::put('/biometrics/{biometric}', [BiometricController::class, 'update'])->name('biometrics.update');
    Route::delete('/biometrics/{biometric}', [BiometricController::class, 'destroy'])->name('biometrics.destroy');
    
    // ==================== NUTRITION SUMMARY ROUTES ====================
    // View nutrition analysis and summaries
    Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
    Route::get('/nutrition/{date}', [NutritionController::class, 'show'])->name('nutrition.show');
});

// Authentication Routes (handled by Laravel Breeze - login, register, password reset)
require __DIR__.'/auth.php';
