<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshMartTrack Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .alert {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.16);
            border: 1px solid rgba(231, 76, 60, 0.35);
            color: #ffb3aa;
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.16);
            border: 1px solid rgba(46, 204, 113, 0.35);
            color: #b7f7cf;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-section">
            <div class="brand-content">
                <div class="logo">FreshMart<span>Track</span></div>
                <div class="welcome-text">
                    <h2>Welcome to...</h2>
                    <p>Monitor the journey of your fresh produce from farm to table. We ensure quality control, minimize waste, and guarantee timely delivery for every order.</p>
                </div>
            </div>
            <div class="copyright">&copy; 2026 FreshMartTrack Inc. All rights reserved.</div>
        </div>

        <div class="form-section">
            <h2>Login</h2>
            <div class="sub-head">Welcome!</div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-error">{{ $error }}</div>
                @endforeach
            @endif

            <form method="post" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label for="username">Username or Email</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username or email" value="{{ old('username') }}" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="input-group">
                    <label for="role">Select Role</label>
                    <select id="role" name="role" required>
                        <option value="" disabled selected>Select role</option>
                        <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Staff" {{ old('role') === 'Staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>

                <div class="options">
                    <input type="checkbox" id="remember" disabled>
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn-login">LOGIN</button>

                <div class="footer-links">
                    <span>New User? <a href="{{ route('register') }}">Signup</a></span>
                    <a href="#">Forgot your password?</a>
                </div>
            </form>

            <div class="footer-links" style="justify-content: center; margin-top: 18px;">
                <span>Demo accounts: admin / admin123 or staff / staff123</span>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
