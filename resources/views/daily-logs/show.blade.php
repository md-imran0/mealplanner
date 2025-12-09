<!DOCTYPE html>
<html>
<head>
    <title>Daily Log</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .back-link { color: #007bff; text-decoration: none; margin-bottom: 20px; display: inline-block; }
        .log-detail { max-width: 600px; margin: 20px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
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
    <a href="{{ route('daily-logs.index') }}" class="back-link">← Back to Daily Logs</a>
    
    <div class="log-detail">
        <h2>Daily Log - {{ $dailyLog->date }}</h2>
        
        <div class="detail-row">
            <div class="detail-label">Date</div>
            <div class="detail-value">{{ $dailyLog->date }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Recipe</div>
            <div class="detail-value">{{ $dailyLog->recipe->name ?? 'N/A' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Meal Type</div>
            <div class="detail-value">{{ $dailyLog->meal_type ?? 'Not specified' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Servings</div>
            <div class="detail-value">{{ $dailyLog->servings }}</div>
        </div>

        @if($dailyLog->notes)
        <div class="detail-row">
            <div class="detail-label">Notes</div>
            <div class="detail-value">{{ $dailyLog->notes }}</div>
        </div>
        @endif

        <div class="actions">
            <a href="{{ route('daily-logs.edit', $dailyLog) }}" class="btn btn-edit">Edit</a>
            <a href="{{ route('daily-logs.index') }}" class="btn btn-back">Back</a>
        </div>
    </div>
</body>
</html>
