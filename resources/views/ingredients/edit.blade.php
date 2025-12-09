<!DOCTYPE html>
<html>
<head>
    <title>Edit Ingredient</title>
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
        <h2>Edit Ingredient: {{ $ingredient->name }}</h2>
        
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
        
        <form method="POST" action="{{ route('ingredients.update', $ingredient) }}">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <label>Ingredient Name</label>
                <input type="text" name="name" required value="{{ $ingredient->name }}">
            </div>
            
            <div class="form-row">
                <label>Category</label>
                <select name="category">
                    <option value="">Select Category</option>
                    <option value="vegetables" {{ $ingredient->category === 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                    <option value="fruits" {{ $ingredient->category === 'fruits' ? 'selected' : '' }}>Fruits</option>
                    <option value="grains" {{ $ingredient->category === 'grains' ? 'selected' : '' }}>Grains</option>
                    <option value="proteins" {{ $ingredient->category === 'proteins' ? 'selected' : '' }}>Proteins</option>
                    <option value="dairy" {{ $ingredient->category === 'dairy' ? 'selected' : '' }}>Dairy</option>
                </select>
            </div>
            
            <div class="form-row">
                <label>Calories per 100g</label>
                <input type="number" name="calories_per_100g" step="0.01" required value="{{ $ingredient->calories_per_100g }}">
            </div>
            
            <div class="form-row">
                <label>Protein per 100g</label>
                <input type="number" name="protein_per_100g" step="0.01" required value="{{ $ingredient->protein_per_100g }}">
            </div>

            <div class="form-row">
                <label>Fiber per 100g</label>
                <input type="number" name="fiber_per_100g" step="0.01" required value="{{ $ingredient->fiber_per_100g }}">
            </div>

            <div class="form-row">
                <label>CO2 per 100g (environmental footprint)</label>
                <input type="number" name="co2_per_100g" step="0.01" required value="{{ $ingredient->co2_per_100g }}">
            </div>

            <div class="form-row">
                <label>Carbs per 100g (optional)</label>
                <input type="number" name="carbs_per_100g" step="0.01" value="{{ $ingredient->carbs_per_100g ?? '' }}">
            </div>

            <div class="form-row">
                <label>Fat per 100g (optional)</label>
                <input type="number" name="fat_per_100g" step="0.01" value="{{ $ingredient->fat_per_100g ?? '' }}">
            </div>

            <div class="form-row">
                <label>Sugar per 100g (optional)</label>
                <input type="number" name="sugar_per_100g" step="0.01" value="{{ $ingredient->sugar_per_100g ?? '' }}">
            </div>

            <div class="form-row">
                <label>Sodium per 100g (optional)</label>
                <input type="number" name="sodium_per_100g" step="0.01" value="{{ $ingredient->sodium_per_100g ?? '' }}">
            </div>

            <div class="form-row">
                <button type="submit" class="submit-btn">Update Ingredient</button>
                <a href="{{ route('ingredients.index') }}" class="cancel-link">Cancel</a>
            </div>
        </form>
        
        <div style="margin-top: 20px;">
            <form method="POST" action="{{ route('ingredients.destroy', $ingredient) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this ingredient?')">Delete Ingredient</button>
            </form>
        </div>
    </div>
</body>
</html>
