<!DOCTYPE html>
<html>
<head>
    <title>Edit Goal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f7; margin: 0; padding: 20px; }
        .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        h2 { color: #333; margin-bottom: 20px; }
        .form-row { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input, select { width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; }
        .delete-btn { background: #dc3545; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        .cancel-link { margin-left: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Goal</h2>
        
        <form method="POST" action="{{ route('user-goals.update', $userGoal) }}">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <label>Goal Type</label>
                <input type="text" name="goal_type" required value="{{ $userGoal->goal_type }}">
            </div>

            <div class="form-row">
                <label>Target Value</label>
                <input type="number" name="target_value" step="0.1" required value="{{ $userGoal->target_value }}">
            </div>

            <div class="form-row">
                <label>Start Date</label>
                <input type="date" name="start_date" value="{{ $userGoal->start_date }}">
            </div>

            <div class="form-row">
                <label>Active</label>
                <select name="is_active">
                    <option value="1" {{ $userGoal->is_active ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$userGoal->is_active ? 'selected' : '' }}>No</option>
                </select>
            </div>
            
            <div class="form-row">
                <button type="submit" class="submit-btn">Update Goal</button>
                <a href="{{ route('user-goals.index') }}" class="cancel-link">Cancel</a>
            </div>
        </form>
        
        <div style="margin-top: 20px;">
            <form method="POST" action="{{ route('user-goals.destroy', $userGoal) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete Goal</button>
            </form>
        </div>
    </div>
</body>
</html>
