<!DOCTYPE html>
<html>
<head>
    <title>{{ $ingredient->name }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; margin: 0; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; }
        .container { max-width: 800px; margin: 30px auto; padding: 0 20px; }
        .back-link { color: #667eea; text-decoration: none; margin-bottom: 20px; display: inline-block; }
        .ingredient-detail { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .ingredient-title { font-size: 32px; font-weight: bold; color: #333; margin-bottom: 20px; }
        .nutrition-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px; }
        .nutrition-card { background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #667eea; }
        .nutrition-label { font-weight: bold; color: #555; font-size: 14px; }
        .nutrition-value { font-size: 24px; color: #667eea; font-weight: bold; }
        .nutrition-unit { font-size: 12px; color: #999; }
        .actions { margin-top: 30px; }
        .btn { padding: 12px 25px; border-radius: 6px; text-decoration: none; display: inline-block; margin-right: 10px; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-back { background: #95a5a6; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ingredient Details</h1>
    </div>

    <div class="container">
        <a href="{{ route('ingredients.index') }}" class="back-link">← Back to Ingredients</a>
        
        <div class="ingredient-detail">
            <div class="ingredient-title">{{ $ingredient->name }}</div>
            
            @if($ingredient->category)
            <p><strong>Category:</strong> {{ ucfirst($ingredient->category) }}</p>
            @endif

            <h3>Nutritional Information (per 100g)</h3>
            
            <div class="nutrition-grid">
                <div class="nutrition-card">
                    <div class="nutrition-label">Calories</div>
                    <div class="nutrition-value">{{ $ingredient->calories_per_100g }}<span class="nutrition-unit">kcal</span></div>
                </div>
                
                <div class="nutrition-card">
                    <div class="nutrition-label">Protein</div>
                    <div class="nutrition-value">{{ $ingredient->protein_per_100g }}<span class="nutrition-unit">g</span></div>
                </div>
                
                <div class="nutrition-card">
                    <div class="nutrition-label">Carbs</div>
                    <div class="nutrition-value">{{ $ingredient->carbs_per_100g ?? 0 }}<span class="nutrition-unit">g</span></div>
                </div>
                
                <div class="nutrition-card">
                    <div class="nutrition-label">Fat</div>
                    <div class="nutrition-value">{{ $ingredient->fat_per_100g ?? 0 }}<span class="nutrition-unit">g</span></div>
                </div>
                
                <div class="nutrition-card">
                    <div class="nutrition-label">Fiber</div>
                    <div class="nutrition-value">{{ $ingredient->fiber_per_100g }}<span class="nutrition-unit">g</span></div>
                </div>
                
                <div class="nutrition-card">
                    <div class="nutrition-label">Sugar</div>
                    <div class="nutrition-value">{{ $ingredient->sugar_per_100g ?? 0 }}<span class="nutrition-unit">g</span></div>
                </div>

                <div class="nutrition-card">
                    <div class="nutrition-label">Sodium</div>
                    <div class="nutrition-value">{{ $ingredient->sodium_per_100g ?? 0 }}<span class="nutrition-unit">mg</span></div>
                </div>

                <div class="nutrition-card" style="border-left-color: #27ae60;">
                    <div class="nutrition-label">CO2 Footprint</div>
                    <div class="nutrition-value" style="color: #27ae60;">{{ $ingredient->co2_per_100g }}<span class="nutrition-unit">g</span></div>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('ingredients.edit', $ingredient) }}" class="btn btn-edit">Edit Ingredient</a>
                <a href="{{ route('ingredients.index') }}" class="btn btn-back">Back to Ingredients</a>
            </div>
        </div>
    </div>
</body>
</html>
