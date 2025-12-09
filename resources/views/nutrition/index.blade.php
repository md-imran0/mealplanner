<!DOCTYPE html>
<html>
<head>
    <title>Nutrition Summary</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { color: white; font-size: 28px; }
        .nav-link { color: white; text-decoration: none; padding: 10px 20px; background: rgba(255,255,255,0.2); border-radius: 5px; transition: 0.3s; display: inline-block; }
        .nav-link:hover { background: rgba(255,255,255,0.3); }
        h2 { color: white; font-size: 20px; margin-top: 30px; margin-bottom: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; }
        .stat-card .label { color: #666; font-size: 14px; font-weight: 500; margin-bottom: 10px; }
        .stat-card .value { color: #667eea; font-size: 32px; font-weight: bold; }
        .table-container { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8f9fa; }
        th { padding: 15px; text-align: left; font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6; }
        td { padding: 15px; border-bottom: 1px solid #dee2e6; }
        tr:hover { background: #f8f9fa; }
        .empty-msg { text-align: center; padding: 40px; color: #666; }
        .log-btn { background: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; display: inline-block; }
        .log-btn:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🥗 Nutrition Summary</h1>
            <a href="{{ route('dashboard') }}" class="nav-link">← Dashboard</a>
        </div>

        <h2>Today's Intake</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="label">Total Calories</div>
                <div class="value">{{ $totalCalories }}</div>
                <div style="font-size: 12px; color: #999;">kcal</div>
            </div>
            <div class="stat-card">
                <div class="label">Protein</div>
                <div class="value">{{ $totalProtein }}</div>
                <div style="font-size: 12px; color: #999;">g</div>
            </div>
            <div class="stat-card">
                <div class="label">Carbs</div>
                <div class="value">0</div>
                <div style="font-size: 12px; color: #999;">g</div>
            </div>
            <div class="stat-card">
                <div class="label">Fat</div>
                <div class="value">0</div>
                <div style="font-size: 12px; color: #999;">g</div>
            </div>
        </div>

        <h2>Today's Meals</h2>
        @if($todayLogs->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Meal Type</th>
                            <th>Recipe</th>
                            <th>Servings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todayLogs as $log)
                        <tr>
                            <td><strong>{{ ucfirst($log->meal_type ?? 'N/A') }}</strong></td>
                            <td>{{ $log->recipe->name ?? 'Unknown' }}</td>
                            <td>{{ $log->servings ?? '1' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table-container">
                <div class="empty-msg">
                    <h3>No meals logged for today</h3>
                    <p style="margin-top: 10px;">Start logging your meals to see your nutrition summary!</p>
                </div>
            </div>
        @endif

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('daily-logs.create') }}" class="log-btn">+ Log a Meal</a>
        </div>
    </div>
</body>
</html>
