<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe</title>
    <style>
        body { font-family: Georgia, serif; background: #fafafa; padding: 20px; margin: 0; }
        .recipe-form { max-width: 800px; margin: 20px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #444; margin-bottom: 30px; }
        h3 { color: #666; border-bottom: 2px solid #e74c3c; padding-bottom: 10px; margin-top: 30px; }
        .field { margin-bottom: 25px; }
        .field label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; }
        .field input, .field textarea, .field select { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 16px; box-sizing: border-box; }
        .field textarea { height: 100px; resize: vertical; }
        .ingredient-row { display: grid; grid-template-columns: 2fr 1fr auto; gap: 10px; margin-bottom: 15px; align-items: end; }
        .ingredient-row input, .ingredient-row select { padding: 10px; border: 1px solid #ccc; border-radius: 6px; }
        .remove-btn { background: #e74c3c; color: white; padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; }
        .add-ingredient-btn { background: #27ae60; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; margin-top: 10px; }
        .form-actions { text-align: center; margin-top: 30px; }
        .save-button { background: #e74c3c; color: white; padding: 15px 40px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; }
        .delete-button { background: #dc3545; color: white; padding: 15px 40px; border: none; border-radius: 8px; font-size: 16px; margin-left: 10px; }
        .back-button { background: #95a5a6; color: white; padding: 15px 40px; border: none; border-radius: 8px; font-size: 16px; margin-left: 10px; text-decoration: none; display: inline-block; }
        .error { color: #e74c3c; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="recipe-form">
        <h1>Edit Recipe: {{ $recipe->name }}</h1>
        
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
        
        <form method="POST" action="{{ route('recipes.update', $recipe) }}">
            @csrf
            @method('PUT')
            
            <h3>Basic Information</h3>
            
            <div class="field">
                <label for="name">Recipe Name *</label>
                <input type="text" id="name" name="name" required value="{{ $recipe->name }}">
            </div>
            
            <div class="field">
                <label for="servings">Number of Servings *</label>
                <input type="number" id="servings" name="servings" min="1" required value="{{ $recipe->servings }}">
            </div>
            
            <div class="field">
                <label for="prep_time_minutes">Preparation Time (minutes) *</label>
                <input type="number" id="prep_time_minutes" name="prep_time_minutes" min="0" required value="{{ $recipe->prep_time_minutes }}">
            </div>

            <div class="field">
                <label for="cook_time_minutes">Cooking Time (minutes) *</label>
                <input type="number" id="cook_time_minutes" name="cook_time_minutes" min="0" required value="{{ $recipe->cook_time_minutes }}">
            </div>

            <div class="field">
                <label for="difficulty">Difficulty *</label>
                <select id="difficulty" name="difficulty" required>
                    <option value="">Select difficulty</option>
                    <option value="easy" {{ $recipe->difficulty === 'easy' ? 'selected' : '' }}>Easy</option>
                    <option value="medium" {{ $recipe->difficulty === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="hard" {{ $recipe->difficulty === 'hard' ? 'selected' : '' }}>Hard</option>
                </select>
            </div>
            
            <div class="field">
                <label for="instructions">Cooking Instructions *</label>
                <textarea id="instructions" name="instructions" required>{{ $recipe->instructions }}</textarea>
            </div>

            <h3>Ingredients</h3>
            
            <div id="ingredients-container">
                @foreach($recipe->ingredients as $ingredient)
                <div class="ingredient-row">
                    <div>
                        <select name="ingredients[]" class="ingredient-select" required>
                            <option value="">Select ingredient</option>
                            @foreach($allIngredients as $ing)
                                <option value="{{ $ing->id }}" {{ $ing->id === $ingredient->id ? 'selected' : '' }}>{{ $ing->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="number" name="amounts[]" step="0.1" min="0.1" value="{{ $ingredient->pivot->amount_grams }}" required>
                    </div>
                    <button type="button" class="remove-btn" onclick="this.parentElement.remove()">Remove</button>
                </div>
                @endforeach
            </div>
            
            <button type="button" class="add-ingredient-btn" onclick="addIngredientRow()">+ Add Another Ingredient</button>
            
            <div class="form-actions">
                <button type="submit" class="save-button">Update Recipe</button>
                <a href="{{ route('recipes.index') }}" class="back-button">Go Back</a>
            </div>
        </form>
        
        <div style="margin-top: 20px;">
            <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete Recipe</button>
            </form>
        </div>
    </div>

    <script>
        function addIngredientRow() {
            const container = document.getElementById('ingredients-container');
            const row = document.createElement('div');
            row.className = 'ingredient-row';
            row.innerHTML = `
                <div>
                    <select name="ingredients[]" class="ingredient-select" required>
                        <option value="">Select ingredient</option>
                        @foreach($allIngredients as $ingredient)
                            <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="number" name="amounts[]" step="0.1" min="0.1" placeholder="0" required>
                </div>
                <button type="button" class="remove-btn" onclick="this.parentElement.remove()">Remove</button>
            `;
            container.appendChild(row);
        }

        // Form submission validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const selects = document.querySelectorAll('.ingredient-select');
            const selected = [];
            let hasDuplicate = false;

            selects.forEach(select => {
                const value = select.value;
                if (value) {
                    if (selected.includes(value)) {
                        hasDuplicate = true;
                    }
                    selected.push(value);
                }
            });

            if (hasDuplicate) {
                e.preventDefault();
                alert('You cannot add the same ingredient twice! Please select different ingredients.');
                return false;
            }

            // Check that all rows have both ingredient and amount
            let hasError = false;
            const rows = document.querySelectorAll('.ingredient-row');
            rows.forEach(row => {
                const select = row.querySelector('select');
                const input = row.querySelector('input[type="number"]');
                if ((select.value && !input.value) || (!select.value && input.value)) {
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault();
                alert('All ingredient rows must have both an ingredient selected and an amount entered.');
                return false;
            }
        });
    </script>
</body>
</html>
