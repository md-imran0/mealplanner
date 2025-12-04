<!DOCTYPE html>
<html>
<head>
    <title>My Recipes</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Trebuchet MS', sans-serif; background: #f0f4f8; margin: 0; }
        .top-bar { background: #2c5aa0; color: white; padding: 20px; }
        .main-content { padding: 25px; max-width: 1200px; margin: 0 auto; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .recipes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .recipe-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
        .recipe-title { font-size: 18px; font-weight: bold; color: #2c5aa0; margin-bottom: 10px; }
        .recipe-info { color: #666; font-size: 14px; margin-bottom: 15px; }
        .card-actions { display: flex; gap: 8px; }
        .btn { padding: 8px 16px; border-radius: 4px; text-decoration: none; font-size: 13px; }
        .btn-primary { background: #2c5aa0; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .add-new-btn { background: #28a745; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; }
        .back-nav { color: #2c5aa0; text-decoration: none; margin-bottom: 20px; display: inline-block; }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>📖 Recipe Collection</h1>
    </div>

    <div class="main-content">
        <a href="{{ route('dashboard') }}" class="back-nav">← Dashboard</a>
        
        <div class="page-header">
            <h2>All Recipes</h2>
            <a href="{{ route('recipes.create') }}" class="add-new-btn">Create Recipe</a>
        </div>

        @if($recipes->count())
        <div class="recipes-grid">
            @foreach($recipes as $recipe)
            <div class="recipe-card">
                <div class="recipe-title">{{ $recipe->name }}</div>
                <div class="recipe-info">
                    Servings: {{ $recipe->servings ?? 'Not specified' }}<br>
                    Created: {{ $recipe->created_at->format('M d, Y') }}
                </div>
                <div class="card-actions">
                    <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-primary">Details</a>
                    <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-secondary">Modify</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 60px; background: white; border-radius: 8px;">
            <h3>No recipes yet!</h3>
            <p>Create your first recipe to get started.</p>
            <a href="{{ route('recipes.create') }}" class="add-new-btn">Create First Recipe</a>
        </div>
        @endif
    </div>
</body>
</html>
