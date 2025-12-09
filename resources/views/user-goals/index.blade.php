<!DOCTYPE html>
<html>
<head>
    <title>My Goals</title>
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
        .badge { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-active { background: #d4edda; color: #155724; }
        .badge-inactive { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 My Goals</h1>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}">← Dashboard</a>
                <a href="{{ route('user-goals.create') }}" class="add-btn">+ Set New Goal</a>
            </div>
        </div>

        @if($userGoals->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Goal Type</th>
                            <th>Target Value</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userGoals as $goal)
                        <tr>
                            <td><strong>{{ ucfirst(str_replace('_', ' ', $goal->goal_type)) }}</strong></td>
                            <td>{{ $goal->target_value }}</td>
                            <td>
                                <span class="badge {{ $goal->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $goal->is_active ? '✓ Active' : '✗ Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('user-goals.show', $goal) }}" class="btn-view">View</a>
                                <a href="{{ route('user-goals.edit', $goal) }}" class="btn-edit">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table-container">
                <div class="empty-msg">
                    <h3>No goals set yet</h3>
                    <p style="margin-top: 10px;">Set your first health goal to get started tracking your progress!</p>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
