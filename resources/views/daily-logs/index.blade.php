<!DOCTYPE html>
<html>
<head>
    <title>Daily Meal Logs</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { color: white; font-size: 28px; }
        .nav-links { display: flex; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; padding: 10px 20px; background: rgba(255,255,255,0.2); border-radius: 5px; transition: 0.3s; }
        .nav-links a:hover { background: rgba(255,255,255,0.3); }
        .add-btn { background: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; }
        .add-btn:hover { background: #218838; }
        .table-container { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8f9fa; }
        th { padding: 15px; text-align: left; font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6; }
        td { padding: 15px; border-bottom: 1px solid #dee2e6; }
        tr:hover { background: #f8f9fa; }
        .empty-msg { text-align: center; padding: 40px; color: #666; }
        .btn-view { color: #0066cc; text-decoration: none; font-weight: 500; }
        .btn-view:hover { text-decoration: underline; }
        .btn-edit { color: #ffc107; text-decoration: none; font-weight: 500; margin-left: 15px; }
        .btn-edit:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Daily Meal Logs</h1>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}">← Dashboard</a>
                <a href="{{ route('daily-logs.create') }}" class="add-btn">+ Add Meal Log</a>
            </div>
        </div>

        @if($dailyLogs->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Recipe</th>
                            <th>Meal Type</th>
                            <th>Servings</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyLogs as $log)
                        <tr>
                            <td>{{ $log->date }}</td>
                            <td><strong>{{ $log->recipe->name ?? 'N/A' }}</strong></td>
                            <td>{{ ucfirst($log->meal_type ?? 'N/A') }}</td>
                            <td>{{ $log->servings ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('daily-logs.show', $log) }}" class="btn-view">View</a>
                                <a href="{{ route('daily-logs.edit', $log) }}" class="btn-edit">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table-container">
                <div class="empty-msg">
                    <h3>No meal logs found yet</h3>
                    <p style="margin-top: 10px;">Start logging your meals to track your nutrition!</p>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
