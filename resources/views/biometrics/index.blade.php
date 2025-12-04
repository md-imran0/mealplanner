<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biometric Records</title>
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
        <h1>📊 Biometric Records</h1>
    </div>

    <div class="container">
        <a href="{{ route('dashboard') }}" class="back-link">← Dashboard</a>
        
        <div class="top-section">
            <h2>Your Measurements</h2>
            <a href="{{ route('biometrics.create') }}" class="add-btn">+ Add Record</a>
        </div>

        @if($biometrics->count())
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Weight (kg)</th>
                    <th>Height (cm)</th>
                    <th>Body Fat %</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($biometrics as $record)
                <tr>
                    <td>{{ $record->measurement_date }}</td>
                    <td>{{ $record->weight ?? 'N/A' }}</td>
                    <td>{{ $record->height ?? 'N/A' }}</td>
                    <td>{{ $record->body_fat_percentage ?? 'N/A' }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('biometrics.show', $record) }}" class="btn-view">View</a>
                            <a href="{{ route('biometrics.edit', $record) }}" class="btn-edit">Edit</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <h3>No biometric records yet!</h3>
            <p>Start tracking your measurements to get insights into your health.</p>
            <a href="{{ route('biometrics.create') }}" class="add-btn">Add Your First Record</a>
        </div>
        @endif
    </div>
</body>
</html>
