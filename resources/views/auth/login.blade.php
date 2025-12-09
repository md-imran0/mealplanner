<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nutrition Tracker</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; margin: 0; padding: 40px; }
        .container { max-width: 400px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2d3748; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #4a5568; }
        input { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 16px; box-sizing: border-box; }
        input:focus { outline: none; border-color: #4299e1; }
        .btn { width: 100%; padding: 12px; background: #4299e1; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; }
        .btn:hover { background: #3182ce; }
        .error { background: #fed7d7; color: #9b2c2c; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .success { background: #c6f6d5; color: #276749; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .link { text-align: center; margin-top: 20px; }
        .link a { color: #4299e1; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1> Login</h1>
        
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember" style="width: auto; margin-right: 8px;">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="link">
            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
            <p><a href="{{ url('/') }}">← Back to Homepage</a></p>
        </div>
    </div>
</body>
</html>
