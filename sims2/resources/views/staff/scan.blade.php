<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Inventory - FreshMartTrack</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo sidebar-logo">FreshMart<span>Staff</span></div>
            <nav class="nav-links">
                <a href="{{ route('staff.dashboard') }}">My Dashboard</a>
                <a href="{{ route('staff.tasks') }}">My Tasks</a>
                <a href="{{ route('staff.scan') }}" class="active">Scan Inventory</a>
                <a href="{{ route('staff.report') }}">Report Issue</a>
            </nav>
            <div class="logout-section">
                <form method="post" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </aside>
        <main class="main-content">
            <header class="top-bar">
                <div class="page-title">
                    <h1>Scan Inventory</h1>
                    <p class="date">{{ now()->format('l, M j, Y') }}</p>
                </div>
                <div class="user-profile">
                    <div class="user-info">
                        <span>{{ Auth::user()->name }}</span>
                        <small>{{ Auth::user()->role }}</small>
                    </div>
                    <div class="avatar" style="background-color: #f1c40f;"></div>
                </div>
            </header>
            <div class="recent-orders">
                <h2>Inventory Scanner</h2>
                <p>Scan items to update stock counts or validate product information.</p>
                <div class="input-group" style="max-width: 480px; margin-top: 20px;">
                    <label for="scan-code">Scan Barcode</label>
                    <input type="text" id="scan-code" name="scan_code" placeholder="Scan or enter product code" />
                </div>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>