<!DOCTYPE html>
<html>
<head>
    <title>Edit Daily Log</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f7; margin: 0; padding: 20px; }
        .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        h2 { color: #333; margin-bottom: 20px; }
        .form-row { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input, select, textarea { width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; }
        .delete-btn { background: #dc3545; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        .cancel-link { margin-left: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Daily Log</h2>
        
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
        
        <form method="POST" action="{{ route('daily-logs.update', $dailyLog) }}">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <label>Date</label>
                <input type="date" name="date" required value="{{ $dailyLog->date }}">
            </div>
            
            <div class="form-row">
                <label>Recipe</label>
                <select name="recipe_id" required>
                    <option value="">Select recipe</option>
                    @foreach($recipes as $recipe)
                        <option value="{{ $recipe->id }}" {{ $recipe->id === $dailyLog->recipe_id ? 'selected' : '' }}>{{ $recipe->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <label>Meal Type (breakfast, lunch, dinner, snack)</label>
                <input type="text" name="meal_type" value="{{ $dailyLog->meal_type ?? '' }}">
            </div>

            <div class="form-row">
                <label>Servings</label>
                <input type="number" name="servings" step="0.1" min="0.1" required value="{{ $dailyLog->servings }}">
            </div>

            <div class="form-row">
                <label>Notes</label>
                <textarea name="notes">{{ $dailyLog->notes ?? '' }}</textarea>
            </div>
            
            <div class="form-row">
                <button type="submit" class="submit-btn">Update Log</button>
                <a href="{{ route('daily-logs.index') }}" class="cancel-link">Cancel</a>
            </div>
        </form>
        
        <div style="margin-top: 20px;">
            <form method="POST" action="{{ route('daily-logs.destroy', $dailyLog) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete Log</button>
            </form>
        </div>
    </div>
</body>
</html>
