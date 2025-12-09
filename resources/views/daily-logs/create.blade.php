<!DOCTYPE html>
<html>
<head>
    <title>Log Meal</title>
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
        <h2>Log a Meal</h2>
        
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
        
        <form method="POST" action="{{ route('daily-logs.store') }}">
            @csrf
            
            <div class="form-row">
                <label>Date *</label>
                <input type="date" name="date" required value="{{ old('date', date('Y-m-d')) }}">
            </div>
            
            <div class="form-row">
                <label>Recipe *</label>
                <select name="recipe_id" required>
                    <option value="">Select Recipe</option>
                    @foreach($recipes as $recipe)
                        <option value="{{ $recipe->id }}" {{ old('recipe_id') == $recipe->id ? 'selected' : '' }}>{{ $recipe->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-row">
                <label>Meal Type</label>
                <select name="meal_type">
                    <option value="">Select Type</option>
                    <option value="breakfast" {{ old('meal_type') === 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                    <option value="lunch" {{ old('meal_type') === 'lunch' ? 'selected' : '' }}>Lunch</option>
                    <option value="dinner" {{ old('meal_type') === 'dinner' ? 'selected' : '' }}>Dinner</option>
                    <option value="snack" {{ old('meal_type') === 'snack' ? 'selected' : '' }}>Snack</option>
                </select>
            </div>
            
            <div class="form-row">
                <label>Servings *</label>
                <input type="number" name="servings" step="0.1" min="0.1" required value="{{ old('servings', 1) }}">
            </div>

            <div class="form-row">
                <label>Notes</label>
                <input type="text" name="notes" placeholder="Optional notes about this meal" value="{{ old('notes', '') }}">
            </div>
            
            <div class="form-row">
                <button type="submit" class="submit-btn">Save Meal Log</button>
                <a href="{{ route('daily-logs.index') }}" class="cancel-link">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
