<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks - FreshMartTrack</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo sidebar-logo">FreshMart<span>Staff</span></div>
            <nav class="nav-links">
                <a href="{{ route('staff.dashboard') }}">My Dashboard</a>
                <a href="{{ route('staff.tasks') }}" class="active">My Tasks</a>
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
                    <h1>My Tasks</h1>
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
                <h2>Your Task List</h2>
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
                            <td>#TSK-103</td>
                            <td>Inspect incoming shipment</td>
                            <td>Receiving</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#TSK-104</td>
                            <td>Update inventory records</td>
                            <td>Warehouse</td>
                            <td><span class="status up">In Progress</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>