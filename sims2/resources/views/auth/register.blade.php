<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshMartTrack Signup</title>
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
                    <h2>Join Our Team</h2>
                    <p>Create your account to start managing inventory, tracking sales, and ensuring fresh produce quality control for our customers.</p>
                </div>
            </div>
            <div class="copyright">&copy; 2026 FreshMartTrack Inc. All rights reserved.</div>
        </div>

        <div class="form-section">
            <h2>Sign Up</h2>
            <div class="sub-head">Admin Account Registration</div>

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

            <form method="post" action="{{ route('register') }}">
                @csrf

                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required>
                </div>

                <div class="alert alert-success">Signup is for Admin accounts only. Staff accounts are created by Admin from Staff Management.</div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>

                <div class="input-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                </div>

                <button type="submit" class="btn-login">SIGN UP</button>

                <div class="footer-links">
                    <span>Already have an account? <a href="{{ route('login') }}">Login</a></span>
                </div>
            </form>

            <div class="footer-links" style="justify-content: center; margin-top: 18px;">
                <span>Staff signup is disabled on public form.</span>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
