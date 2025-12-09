<!DOCTYPE html>
<html>
<head>
    <title>Add Ingredient</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f7; margin: 0; padding: 20px; }
        .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        h2 { color: #333; margin-bottom: 20px; }
        .form-row { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input, select, textarea { width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        .cancel-link { margin-left: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Ingredient</h2>
        
        <form method="POST" action="{{ route('ingredients.store') }}">
            @csrf
            
            <div class="form-row">
                <label>Ingredient Name</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-row">
                <label>Category</label>
                <select name="category">
                    <option value="">Select Category</option>
                    <option value="vegetables">Vegetables</option>
                    <option value="fruits">Fruits</option>
                    <option value="grains">Grains</option>
                    <option value="proteins">Proteins</option>
                    <option value="dairy">Dairy</option>
                </select>
            </div>
            
            <div class="form-row">
                <label>Calories per 100g</label>
                <input type="number" name="calories_per_100g" step="0.01">
            </div>
            
            <div class="form-row">
                <label>Protein per 100g</label>
                <input type="number" name="protein_per_100g" step="0.01" required>
            </div>

            <div class="form-row">
                <label>Fiber per 100g</label>
                <input type="number" name="fiber_per_100g" step="0.01" required>
            </div>

            <div class="form-row">
                <label>CO2 per 100g (environmental footprint)</label>
                <input type="number" name="co2_per_100g" step="0.01" required>
            </div>

            <div class="form-row">
                <label>Carbs per 100g (optional)</label>
                <input type="number" name="carbs_per_100g" step="0.01">
            </div>

            <div class="form-row">
                <label>Fat per 100g (optional)</label>
                <input type="number" name="fat_per_100g" step="0.01">
            </div>

            <div class="form-row">
                <label>Sugar per 100g (optional)</label>
                <input type="number" name="sugar_per_100g" step="0.01">
            </div>

            <div class="form-row">
                <label>Sodium per 100g (optional)</label>
                <input type="number" name="sodium_per_100g" step="0.01">
            </div>
            
            <div class="form-row">
                <button type="submit" class="submit-btn">Save Ingredient</button>
                <a href="{{ route('ingredients.index') }}" class="cancel-link">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
