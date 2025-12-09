<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nutrition Tracker</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; margin: 0; }
        .header { background: white; padding: 20px 40px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; color: #2d3748; }
        .nav { display: flex; gap: 20px; }
        .nav a { color: #4299e1; text-decoration: none; padding: 8px 16px; border-radius: 4px; }
        .nav a:hover { background: #ebf8ff; }
        .logout-form { display: inline; }
        .logout-btn { background: #e53e3e; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; }
        .logout-btn:hover { background: #c53030; }
        .container { max-width: 1200px; margin: 0 auto; padding: 40px; }
        
        /* Meal Planner Styles */
        .meal-planner { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            padding: 40px; 
            border-radius: 15px; 
            text-align: center; 
            margin-bottom: 40px; 
            color: white; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .meal-planner h2 { margin: 0 0 15px 0; font-size: 2rem; }
        .meal-planner p { margin-bottom: 25px; font-size: 1.1rem; opacity: 0.9; }
        .planner-form { display: flex; justify-content: center; align-items: center; gap: 15px; flex-wrap: wrap; }
        .calorie-input { 
            padding: 12px 18px; 
            font-size: 16px; 
            border: none; 
            border-radius: 8px; 
            width: 200px; 
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .calorie-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(255,255,255,0.3); }
        .generate-btn { 
            background: #28a745; 
            color: white; 
            padding: 12px 25px; 
            font-size: 16px; 
            font-weight: bold;
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .generate-btn:hover { 
            background: #218838; 
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        
        /* Original Card Styles */
        .welcome { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card h3 { margin-top: 0; color: #2d3748; }
        .btn { display: inline-block; padding: 10px 20px; background: #4299e1; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .btn:hover { background: #3182ce; }
        .success { background: #c6f6d5; color: #276749; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .error { background: #fed7d7; color: #9b2c2c; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <!-- Your Original Header -->
    <div class="header">
        <h1> Nutrition Tracker</h1>
        <div class="nav">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('ingredients.index') }}">Ingredients</a>
            <a href="{{ route('recipes.index') }}">Recipes</a>
            <a href="{{ route('daily-logs.index') }}">Meals</a>
            <a href="{{ route('user-goals.index') }}">Goals</a>
            <a href="{{ route('biometrics.index') }}">Biometrics</a>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        
        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <!-- NEW: Meal Planner Section -->
        <div class="meal-planner">
            <h2> Daily Meal Planner</h2>
            <p>Enter your daily calorie target and get personalized meal suggestions from your recipes!</p>
            
            <form method="POST" action="{{ route('meal-plan.generate') }}" class="planner-form">
                @csrf
                <input type="number" 
                       name="max_calories" 
                       class="calorie-input"
                       placeholder="Enter calories (e.g. 2000)" 
                       required 
                       min="500" 
                       max="5000" 
                       step="50"
                       value="{{ old('max_calories') }}">
                       
                <button type="submit" class="generate-btn">
                    Generate Meal Plan
                </button>
            </form>
        </div>

        <!-- Your Original Welcome Section -->
        <div class="welcome">
            <h2>Welcome back, {{ Auth::user()->name }}! 👋</h2>
            <p>Track your nutrition, manage recipes, and achieve your health goals.</p>
        </div>

        <!-- Your Original Cards Section -->
        <div class="cards">
            <div class="card">
                <h3> Ingredients</h3>
                <p>Manage nutritional information for ingredients with detailed macro and micro nutrients.</p>
                <a href="{{ route('ingredients.index') }}" class="btn">View Ingredients</a>
            </div>

            <div class="card">
                <h3> Recipes</h3>
                <p>Create and manage your favorite recipes with automatic nutrition calculations.</p>
                <a href="{{ route('recipes.index') }}" class="btn">View Recipes</a>
            </div>

            <div class="card">
                <h3> Daily Meals</h3>
                <p>Log your daily meals and track your nutritional intake throughout the day.</p>
                <a href="{{ route('daily-logs.index') }}" class="btn">View Meals</a>
            </div>

            <div class="card">
                <h3> Goals</h3>
                <p>Set and monitor your nutrition goals for calories, protein, fiber, and more.</p>
                <a href="{{ route('user-goals.index') }}" class="btn">View Goals</a>
            </div>

            <div class="card">
                <h3> Biometrics</h3>
                <p>Track your body measurements and health metrics over time.</p>
                <a href="{{ route('biometrics.index') }}" class="btn">View Biometrics</a>
            </div>

            <div class="card">
                <h3> Today's Summary</h3>
                <p>Quick overview of today's nutrition and meal logs.</p>
                <a href="{{ route('nutrition.index') }}" class="btn">View Nutrition</a>
            </div>
        </div>
    </div>
</body>
</html>
