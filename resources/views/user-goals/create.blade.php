<!DOCTYPE html>
<html>
<head>
    <title>Set New Goal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f7; margin: 0; padding: 20px; }
        .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        h2 { color: #333; margin-bottom: 20px; }
        .form-row { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input, select { width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { background: #28a745; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        .cancel-link { margin-left: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Set New Goal</h2>
        
        @if ($errors->any())
            <div style="background: #ffe6e6; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                <strong>Errors:</strong>
                <ul style="margin: 10px 0 0 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('user-goals.store') }}">
            @csrf
            
            <div class="form-row">
                <label>Goal Type *</label>
                <select name="goal_type" required>
                    <option value="">Select Goal Type</option>
                    <option value="calories" {{ old('goal_type') === 'calories' ? 'selected' : '' }}>Daily Calories</option>
                    <option value="protein" {{ old('goal_type') === 'protein' ? 'selected' : '' }}>Daily Protein (g)</option>
                    <option value="carbs" {{ old('goal_type') === 'carbs' ? 'selected' : '' }}>Daily Carbs (g)</option>
                    <option value="fat" {{ old('goal_type') === 'fat' ? 'selected' : '' }}>Daily Fat (g)</option>
                    <option value="fiber" {{ old('goal_type') === 'fiber' ? 'selected' : '' }}>Daily Fiber (g)</option>
                    <option value="weight" {{ old('goal_type') === 'weight' ? 'selected' : '' }}>Target Weight (kg)</option>
                </select>
            </div>
            
            <div class="form-row">
                <label>Target Value *</label>
                <input type="number" name="target_value" step="0.01" min="0" required value="{{ old('target_value', '') }}">
            </div>
            
            <div class="form-row">
                <label>Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}">
            </div>
            
            <div class="form-row">
                <button type="submit" class="submit-btn">Set Goal</button>
                <a href="{{ route('user-goals.index') }}" class="cancel-link">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
