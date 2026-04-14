<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Portal - FreshMartTrack</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo sidebar-logo">FreshMart<span>Staff</span></div>
            <nav class="nav-links">
                <a href="{{ route('staff.dashboard') }}" class="active">My Dashboard</a>
                <a href="{{ route('staff.tasks') }}">My Tasks</a>
                <a href="{{ route('staff.scan') }}">Scan Inventory</a>
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
                    <h1>Staff Portal</h1>
                    <p class="date">Hello, ready for your shift?</p>
                </div>
                <div class="user-profile">
                    <div class="user-info">
                        <span id="display-username">{{ Auth::user()->name }}</span>
                        <small id="display-role" style="color: #f1c40f;">{{ Auth::user()->role }}</small>
                    </div>
                    <div class="avatar" style="background-color: #f1c40f;"></div>
                </div>
            </header>

            @if(session('error'))
                <div class="alert alert-error" style="margin-bottom: 20px;">{{ session('error') }}</div>
            @endif

            <div class="stats-grid">
                <div class="card stat-card">
                    <h3>Assigned Tasks</h3>
                    <div class="number">8</div>
                    <div class="trend up">3 High Priority</div>
                </div>
                <div class="card stat-card">
                    <h3>Items Scanned</h3>
                    <div class="number">142</div>
                    <div class="trend up">Today</div>
                </div>
                <div class="card stat-card">
                    <h3>Shift Hours</h3>
                    <div class="number">4.5</div>
                    <div class="trend">Remaining</div>
                </div>
            </div>

            <div class="recent-orders">
                <h2>My Assigned Tasks</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Description</th>
                            <th>Area</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#TSK-101</td>
                            <td>Restock Organic Apples</td>
                            <td>Aisle 4</td>
                            <td><span class="status pending">In Progress</span></td>
                        </tr>
                        <tr>
                            <td>#TSK-102</td>
                            <td>Quality Check: Tomatoes</td>
                            <td>Storage B</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#TSK-099</td>
                            <td>Clean Zone C</td>
                            <td>Loading Dock</td>
                            <td><span class="status delivered">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
