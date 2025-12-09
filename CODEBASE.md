# Nutrition Tracker - Codebase Overview

## Project Structure

### Core Components

**Models** (`app/Models/`)
- `User` - Main user account, has goals/meals/biometrics
- `Ingredient` - Basic food items with nutrition per 100g (calories, protein, carbs, fat, fiber, CO2)
- `Recipe` - Cooking instructions that combine multiple ingredients
- `DailyLog` - Records what recipe user ate on a specific date
- `UserGoal` - User's health targets (calories, protein, weight, etc)
- `Biometric` - Body measurements (weight, height, body fat %)

**Controllers** (`app/Http/Controllers/`)
- `IngredientController` - Create/edit/delete ingredients
- `RecipeController` - Manage recipes and their ingredients
- `DailyLogController` - Log meals eaten each day
- `UserGoalController` - Set and track health goals
- `BiometricController` - Track body measurements
- `NutritionController` - Display daily/weekly nutrition summary
- `MealPlanController` - Generate meal suggestions based on calorie target
- `DashboardController` - Main overview page
- `ProfileController` - User account settings

### Database Tables

- `users` - User accounts (email, password, name)
- `ingredients` - Food items with per-100g nutrition facts
- `recipes` - Cooking instructions with prep/cook times
- `recipe_ingredients` - Links recipes to ingredients (many-to-many with amount_grams)
- `daily_logs` - What user ate on each date
- `user_goals` - User's health targets
- `biometrics` - Body measurements with dates

### Key Features

1. **Ingredient Management**
   - Add food items with calories, protein, carbs, fat, fiber, sodium, sugar, CO2 per 100g
   - Edit/delete ingredients
   - View ingredient details

2. **Recipe Creation**
   - Create recipes by combining ingredients with amounts
   - Prevent duplicate ingredients in recipes
   - Auto-calculate total nutrition for recipe
   - Set prep/cook times and difficulty level

3. **Meal Logging**
   - Log what you ate each day
   - Select recipe and number of servings
   - Calculate daily nutrition totals automatically

4. **Nutrition Tracking**
   - View today's calorie and nutrient intake
   - See all meals logged for the day
   - Historical nutrition summaries available

5. **Goal Setting & Progress**
   - Set health goals (calories, protein, weight targets, etc)
   - Track progress towards goals
   - Active/inactive goal management

6. **Body Measurements**
   - Record weight, height, body fat percentage
   - Track measurements over time
   - View measurement history

7. **Meal Planning**
   - Auto-generate meal suggestions based on daily calorie target
   - Distributes calories: 25% breakfast, 35% lunch, 35% dinner, 5% snacks
   - Randomizes recipes for variety

### How It Works

#### Creating a Meal
1. Add ingredients (with nutrition per 100g)
2. Create recipe combining ingredients
3. Log recipe in daily log with date and servings
4. System auto-calculates nutrition for that meal

#### Nutrition Calculation
- Ingredients store nutrition per 100g
- Recipes calculate total nutrition by summing all ingredients
- Daily logs multiply recipe nutrition × number of servings
- Dashboard sums all meals for daily totals

#### Goal Tracking
- User sets goals (e.g., 2000 calories/day)
- System checks daily intake against goals
- Dashboard shows progress percentage

### Views Organization
```
resources/views/
├── dashboard.blade.php          # Main overview
├── layout.blade.php             # Navigation template
├── ingredients/
│   ├── index.blade.php          # List all
│   ├── create.blade.php         # Add new
│   ├── edit.blade.php           # Edit existing
│   └── show.blade.php           # View details
├── recipes/                     # Same structure as ingredients
├── daily-logs/                  # Same structure
├── user-goals/                  # Same structure
├── biometrics/                  # Same structure
├── nutrition/
│   └── index.blade.php          # Daily summary
└── meal-plan/
    └── result.blade.php         # Suggested meals
```

### Authentication
- Uses Laravel Breeze (built-in auth system)
- User registration/login required
- All routes protected except welcome page

### Testing
- `tests/Unit/NutritionCalculationTest.php` - Tests nutrition math
- `tests/Feature/DailyLogFeatureTest.php` - Tests meal logging
- Run tests: `php artisan test`

## Quick Development Tips

- Database queries use Eloquent ORM
- Routes in `routes/web.php` - organized by controller
- Validation in controllers (store/update methods)
- Relationships defined in models (e.g., `$user->goals()`)
- Views use Blade templating (Laravel's template engine)
- Mass assignment controlled by `$fillable` in models
