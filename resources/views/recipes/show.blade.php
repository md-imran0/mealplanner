<!DOCTYPE html>
<html>
<head>
    <title>{{ $recipe->name }}</title>
    <style>
        body { font-family: 'Trebuchet MS', sans-serif; background: #f0f4f8; margin: 0; }
        .top-bar { background: #2c5aa0; color: white; padding: 20px; }
        .main-content { padding: 25px; max-width: 900px; margin: 0 auto; }
        .recipe-detail { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
        .recipe-title { font-size: 32px; font-weight: bold; color: #2c5aa0; margin-bottom: 20px; }
        .recipe-meta { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .meta-item { background: #f8f9fa; padding: 15px; border-radius: 6px; }
        .meta-label { font-weight: bold; color: #555; }
        .meta-value { font-size: 18px; color: #2c5aa0; }
        .section-title { font-size: 20px; font-weight: bold; color: #2c5aa0; margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; }
        .ingredients-list { background: #f8f9fa; padding: 20px; border-radius: 6px; }
        .ingredient-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e0e0e0; }
        .ingredient-item:last-child { border-bottom: none; }
        .instructions { white-space: pre-wrap; line-height: 1.6; }
        .button-group { margin-top: 30px; }
        .btn { padding: 12px 25px; border-radius: 6px; text-decoration: none; margin-right: 10px; display: inline-block; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-back { background: #95a5a6; color: white; }
        .back-nav { color: #2c5aa0; text-decoration: none; margin-bottom: 20px; display: inline-block; }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>📖 {{ $recipe->name }}</h1>
    </div>

    <div class="main-content">
        <a href="{{ route('recipes.index') }}" class="back-nav">← Back to Recipes</a>
        
        <div class="recipe-detail">
            <div class="recipe-title">{{ $recipe->name }}</div>
            
            <div class="recipe-meta">
                <div class="meta-item">
                    <div class="meta-label">Servings</div>
                    <div class="meta-value">{{ $recipe->servings }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Prep Time</div>
                    <div class="meta-value">{{ $recipe->prep_time_minutes }} mins</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Cook Time</div>
                    <div class="meta-value">{{ $recipe->cook_time_minutes }} mins</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Difficulty</div>
                    <div class="meta-value">{{ ucfirst($recipe->difficulty) }}</div>
                </div>
            </div>

            @if($recipe->ingredients->count())
            <div class="section-title">Ingredients</div>
            <div class="ingredients-list">
                @foreach($recipe->ingredients as $ingredient)
                <div class="ingredient-item">
                    <span>{{ $ingredient->name }}</span>
                    <span>{{ $ingredient->pivot->amount_grams }}g</span>
                </div>
                @endforeach
            </div>
            @endif

            <div class="section-title">Instructions</div>
            <div class="instructions">{{ $recipe->instructions }}</div>

            <div class="button-group">
                <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-edit">Edit Recipe</a>
                <a href="{{ route('recipes.index') }}" class="btn btn-back">Back to Recipes</a>
            </div>
        </div>
    </div>
</body>
</html>
