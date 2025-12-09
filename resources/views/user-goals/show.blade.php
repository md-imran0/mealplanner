<!DOCTYPE html>
<html>
<head>
    <title>Goal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .back-link { color: #007bff; text-decoration: none; margin-bottom: 20px; display: inline-block; }
        .goal-detail { max-width: 600px; margin: 20px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-bottom: 20px; }
        .detail-row { margin-bottom: 20px; }
        .detail-label { font-weight: bold; color: #555; }
        .detail-value { color: #333; margin-top: 5px; }
        .actions { margin-top: 30px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-back { background: #95a5a6; color: white; }
    </style>
</head>
<body>
    <a href="{{ route('user-goals.index') }}" class="back-link">← Back to Goals</a>
    
    <div class="goal-detail">
        <h2>{{ $userGoal->goal_type }}</h2>
        
        <div class="detail-row">
            <div class="detail-label">Target Value</div>
            <div class="detail-value">{{ $userGoal->target_value }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Start Date</div>
            <div class="detail-value">{{ $userGoal->start_date ?? 'Not set' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Status</div>
            <div class="detail-value">{{ $userGoal->is_active ? 'Active' : 'Inactive' }}</div>
        </div>

        <div class="actions">
            <a href="{{ route('user-goals.edit', $userGoal) }}" class="btn btn-edit">Edit</a>
            <a href="{{ route('user-goals.index') }}" class="btn btn-back">Back</a>
        </div>
    </div>
</body>
</html>
