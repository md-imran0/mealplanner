<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredients List</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            background-color: #f5f5f5; 
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 25px; 
            text-align: center; 
        }
        .container { 
            max-width: 1000px; 
            margin: 30px auto; 
            padding: 0 20px; 
        }
        .top-section { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 25px; 
            align-items: center; 
        }
        .add-btn { 
            background: #28a745; 
            color: white; 
            padding: 12px 25px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold; 
        }
        .back-link { 
            color: #6c757d; 
            text-decoration: none; 
        }
        table { 
            width: 100%; 
            background: white; 
            border-collapse: collapse; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
        }
        th, td { 
            padding: 15px; 
            text-align: left; 
            border-bottom: 1px solid #ddd; 
        }
        th { 
            background-color: #f8f9fa; 
            font-weight: 600; 
        }
        .actions { 
            display: flex; 
            gap: 10px; 
        }
        .btn-view { 
            background: #007bff; 
            color: white; 
            padding: 6px 12px; 
            text-decoration: none; 
            border-radius: 3px; 
            font-size: 14px; 
        }
        .btn-edit { 
            background: #ffc107; 
            color: black; 
            padding: 6px 12px; 
            text-decoration: none; 
            border-radius: 3px; 
            font-size: 14px; 
        }
        .empty-state { 
            text-align: center; 
            padding: 50px; 
            background: white; 
            border-radius: 8px; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🥕 Ingredients Management</h1>
        <p>Manage your ingredient database</p>
    </div>

    <div class="container">
        <div class="top-section">
            <a href="{{ route('dashboard') }}" class="back-link">← Back to Dashboard</a>
            <a href="{{ route('ingredients.create') }}" class="add-btn">+ Add New Ingredient</a>
        </div>

        @if($ingredients->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Calories (per 100g)</th>
                    <th>Protein (g)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingredients as $ingredient)
                <tr>
                    <td><strong>{{ $ingredient->name }}</strong></td>
                    <td>{{ $ingredient->category ?? 'Uncategorized' }}</td>
                    <td>{{ $ingredient->calories_per_100g ?? '0' }}</td>
                    <td>{{ $ingredient->protein_per_100g ?? '0' }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('ingredients.show', $ingredient) }}" class="btn-view">View</a>
                            <a href="{{ route('ingredients.edit', $ingredient) }}" class="btn-edit">Edit</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <h3>No ingredients found</h3>
            <p>Start by adding your first ingredient to build your nutrition database.</p>
            <a href="{{ route('ingredients.create') }}" class="add-btn">Add First Ingredient</a>
        </div>
        @endif
    </div>
</body>
</html>
