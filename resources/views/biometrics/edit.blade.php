<!DOCTYPE html>
<html>
<head>
    <title>Edit Biometric</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f7; margin: 0; padding: 20px; }
        .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        h2 { color: #333; margin-bottom: 20px; }
        .form-row { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input { width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; }
        .delete-btn { background: #dc3545; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        .cancel-link { margin-left: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Biometric</h2>
        
        <form method="POST" action="{{ route('biometrics.update', $biometric) }}">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <label>Measurement Date</label>
                <input type="date" name="measurement_date" required value="{{ $biometric->measurement_date }}">
            </div>

            <div class="form-row">
                <label>Weight (kg)</label>
                <input type="number" name="weight" step="0.1" value="{{ $biometric->weight ?? '' }}">
            </div>

            <div class="form-row">
                <label>Height (cm)</label>
                <input type="number" name="height" step="0.1" value="{{ $biometric->height ?? '' }}">
            </div>

            <div class="form-row">
                <label>Body Fat Percentage (%)</label>
                <input type="number" name="body_fat_percentage" step="0.1" min="0" max="100" value="{{ $biometric->body_fat_percentage ?? '' }}">
            </div>
            
            <div class="form-row">
                <button type="submit" class="submit-btn">Update</button>
                <a href="{{ route('biometrics.index') }}" class="cancel-link">Cancel</a>
            </div>
        </form>
        
        <div style="margin-top: 20px;">
            <form method="POST" action="{{ route('biometrics.destroy', $biometric) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete Biometric</button>
            </form>
        </div>
    </div>
</body>
</html>
