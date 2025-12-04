<!DOCTYPE html>
<html>
<head>
    <title>Your Meal Plan</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .header { background: white; padding: 30px; border-radius: 10px; text-align: center; margin-bottom: 20px; }
        .meal-section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
        .meal-title { font-size: 20px; font-weight: bold; color: #333; margin-bottom: 15px; }
        .recipe-item { padding: 10px; background: #f8f9fa; border-radius: 5px; margin-bottom: 10px; display: flex; justify-content: space-between; }
        .calories { color: #28a745; font-weight: bold; }
        .summary { background: #e7f3ff; padding: 20px; border-radius: 10px; text-align: center; }
        .btn { background: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 5px; text-decoration: none; display: inline-block; margin: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍽️ Your Daily Meal Plan</h1>
            <p>Target: {{ $mealPlan['target_calories'] }} calories | Planned: {{ $mealPlan['total_calories'] }} calories</p>
        </div>

        <!-- Breakfast -->
        <div class="meal-section">
            <div class="meal-title">🌅 Breakfast</div>
            @if($mealPlan['breakfast'])
                <div class="recipe-item">
                    <span>{{ $mealPlan['breakfast']['recipe']->name }}</span>
                    <span class="calories">{{ $mealPlan['breakfast']['calories'] }} cal</span>
                </div>
            @else
                <p><em>No breakfast recipe found. Try adding lighter recipes!</em></p>
            @endif
        </div>

        <!-- Lunch -->
        <div class="meal-section">
            <div class="meal-title">🌞 Lunch</div>
            @if($mealPlan['lunch'])
                <div class="recipe-item">
                    <span>{{ $mealPlan['lunch']['recipe']->name }}</span>
                    <span class="calories">{{ $mealPlan['lunch']['calories'] }} cal</span>
                </div>
            @else
                <p><em>No lunch recipe found. Try adding more recipes!</em></p>
            @endif
        </div>

        <!-- Dinner -->
        <div class="meal-section">
            <div class="meal-title">🌙 Dinner</div>
            @if($mealPlan['dinner'])
                <div class="recipe-item">
                    <span>{{ $mealPlan['dinner']['recipe']->name }}</span>
                    <span class="calories">{{ $mealPlan['dinner']['calories'] }} cal</span>
                </div>
            @else
                <p><em>No dinner recipe found. Try adding more recipes!</em></p>
            @endif
        </div>

        <!-- Snacks -->
        @if(count($mealPlan['snacks']) > 0)
        <div class="meal-section">
            <div class="meal-title">🍎 Snacks</div>
            @foreach($mealPlan['snacks'] as $snack)
                <div class="recipe-item">
                    <span>{{ $snack['recipe']->name }}</span>
                    <span class="calories">{{ $snack['calories'] }} cal</span>
                </div>
            @endforeach
        </div>
        @endif

        <div class="summary">
            <h3>Daily Summary</h3>
            <p><strong>Total Planned Calories: {{ $mealPlan['total_calories'] }}</strong></p>
            <p>Target: {{ $mealPlan['target_calories'] }} calories</p>
            
            @if($mealPlan['total_calories'] < $mealPlan['target_calories'])
                <p style="color: orange;">⚠️ Under target by {{ $mealPlan['target_calories'] - $mealPlan['total_calories'] }} calories</p>
            @else
                <p style="color: green;">✅ Great! You're within your calorie target.</p>
            @endif
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('dashboard') }}" class="btn">Generate New Plan</a>
            <a href="{{ route('recipes.index') }}" class="btn" style="background: #28a745;">Add More Recipes</a>
        </div>
    </div>
</body>
</html>
