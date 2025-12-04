<!DOCTYPE html>
<html>
<head>
    <title>Add Biometric Record</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f7; margin: 0; padding: 20px; }
        .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        h2 { color: #333; margin-bottom: 20px; }
        .form-row { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input { width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { background: #28a745; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        .cancel-link { margin-left: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Biometric Record</h2>
        
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
        
        <form method="POST" action="{{ route('biometrics.store') }}">
            @csrf
            
            <div class="form-row">
                <label>Measurement Date *</label>
                <input type="date" name="measurement_date" required value="{{ old('measurement_date', date('Y-m-d')) }}">
            </div>
            
            <div class="form-row">
                <label>Weight (kg)</label>
                <input type="number" name="weight" step="0.1" min="0" value="{{ old('weight', '') }}">
            </div>
            
            <div class="form-row">
                <label>Height (cm)</label>
                <input type="number" name="height" step="0.1" min="0" value="{{ old('height', '') }}">
            </div>
            
            <div class="form-row">
                <label>Body Fat Percentage (%)</label>
                <input type="number" name="body_fat_percentage" step="0.1" min="0" max="100" value="{{ old('body_fat_percentage', '') }}">
            </div>

            <div class="form-row">
                <button type="submit" class="submit-btn">Save Record</button>
                <a href="{{ route('biometrics.index') }}" class="cancel-link">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
