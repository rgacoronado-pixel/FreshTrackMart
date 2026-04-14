<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Issue - FreshMartTrack</title>
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
                <a href="{{ route('staff.scan') }}">Scan Inventory</a>
                <a href="{{ route('staff.report') }}" class="active">Report Issue</a>
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
                    <h1>Report Issue</h1>
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
                <h2>Submit a Report</h2>
                <form style="max-width: 540px;">
                    <div class="input-group">
                        <label for="issue-title">Issue Title</label>
                        <input id="issue-title" type="text" placeholder="Describe the issue" />
                    </div>
                    <div class="input-group">
                        <label for="issue-details">Details</label>
                        <textarea id="issue-details" rows="5" placeholder="Explain what happened"></textarea>
                    </div>
                    <button type="button" class="btn-login">Submit Report</button>
                </form>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>