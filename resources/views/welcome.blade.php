<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nutrition Tracker</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f8fafc; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2d3748; text-align: center; margin-bottom: 30px; }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0; }
        .feature { background: #f7fafc; padding: 20px; border-radius: 8px; border-left: 4px solid #4299e1; }
        .feature h3 { margin-top: 0; color: #2d3748; }
        .buttons { text-align: center; margin: 30px 0; }
        .btn { display: inline-block; padding: 12px 24px; margin: 0 10px; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .btn-primary { background: #4299e1; color: white; }
        .btn-secondary { background: #edf2f7; color: #4a5568; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="container">
        <h1> Nutrition Tracker</h1>
        <p style="text-align: center; color: #718096; font-size: 18px;">Track your nutrition, manage recipes, and achieve your health goals!</p>
        
        <div class="features">
            <div class="feature">
                <h3> Ingredients</h3>
                <p>Manage nutritional information for ingredients with detailed macro and micro nutrients.</p>
            </div>
            <div class="feature">
                <h3> Recipes</h3>
                <p>Create and manage your favorite recipes with automatic nutrition calculations.</p>
            </div>
            <div class="feature">
                <h3> Daily Logs</h3>
                <p>Log your daily meals and track your nutritional intake throughout the day.</p>
            </div>
            <div class="feature">
                <h3> Goals</h3>
                <p>Set and monitor your nutrition goals for calories, protein, fiber, and more.</p>
            </div>
            <div class="feature">
                <h3> Biometrics</h3>
                <p>Track your body measurements and health metrics over time.</p>
            </div>
            <div class="feature">
                <h3> Carbon Footprint</h3>
                <p>Monitor the environmental impact of your food choices.</p>
            </div>
        </div>

        <div class="buttons">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
            @endauth
        </div>
    </div>
</body>
</html>
