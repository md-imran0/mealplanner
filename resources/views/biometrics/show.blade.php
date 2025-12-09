<!DOCTYPE html>
<html>
<head>
    <title>Biometric</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .back-link { color: #007bff; text-decoration: none; margin-bottom: 20px; display: inline-block; }
        .bio-detail { max-width: 600px; margin: 20px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-bottom: 20px; }
        .detail-row { margin-bottom: 20px; }
        .detail-label { font-weight: bold; color: #555; }
        .detail-value { color: #333; margin-top: 5px; }
        .actions { margin-top: 30px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-back { background: #95a5a6; color: white; }
    </style>
</head>
<body>
    <a href="{{ route('biometrics.index') }}" class="back-link">← Back to Biometrics</a>
    
    <div class="bio-detail">
        <h2>Biometric - {{ $biometric->measurement_date }}</h2>
        
        <div class="detail-row">
            <div class="detail-label">Measurement Date</div>
            <div class="detail-value">{{ $biometric->measurement_date }}</div>
        </div>

        @if($biometric->weight)
        <div class="detail-row">
            <div class="detail-label">Weight</div>
            <div class="detail-value">{{ $biometric->weight }} kg</div>
        </div>
        @endif

        @if($biometric->height)
        <div class="detail-row">
            <div class="detail-label">Height</div>
            <div class="detail-value">{{ $biometric->height }} cm</div>
        </div>
        @endif

        @if($biometric->body_fat_percentage)
        <div class="detail-row">
            <div class="detail-label">Body Fat Percentage</div>
            <div class="detail-value">{{ $biometric->body_fat_percentage }}%</div>
        </div>
        @endif

        <div class="actions">
            <a href="{{ route('biometrics.edit', $biometric) }}" class="btn btn-edit">Edit</a>
            <a href="{{ route('biometrics.index') }}" class="btn btn-back">Back</a>
        </div>
    </div>
</body>
</html>
