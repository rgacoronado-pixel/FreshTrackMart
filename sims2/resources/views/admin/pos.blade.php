<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sales - FreshMartTrack</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo sidebar-logo">FreshMart<span>Track</span></div>
            <nav class="nav-links">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('inventory.index') }}">Inventory</a>
                <a href="{{ route('staff.index') }}">Staff</a>
                <a href="{{ route('reports.index') }}">Reports</a>
                <a href="{{ route('pos.index') }}" class="active">Point of Sales</a>
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
                    <h1>Point of Sales</h1>
                    <p class="date">{{ now()->format('l, M j, Y') }}</p>
                </div>
                <div class="user-profile">
                    <div class="user-info">
                        <span>{{ Auth::user()->name }}</span>
                        <small>{{ Auth::user()->role }}</small>
                    </div>
                    <div class="avatar"></div>
                </div>
            </header>
            <div class="recent-orders">
                <h2>POS Terminal</h2>
                <p>This is a live summary of your POS performance and revenue metrics.</p>
                <div class="stats-grid">
                    <div class="card stat-card">
                        <h3>Active Transactions</h3>
                        <div class="number">5</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Today's Revenue</h3>
                        <div class="number">₱3,280</div>
                    </div>
                </div>

                <div class="pos-overview">
                    <div class="pos-card">
                        <h3>POS Completion Rate</h3>
                        <div class="chart-ring">
                            <div class="chart-center">
                                <span>78%</span>
                                <small>of daily target</small>
                            </div>
                        </div>
                        <p style="color:#b8cfea; text-align:center;">Your POS performance is at 78% of the daily sales target.</p>
                    </div>

                    <div class="pos-card">
                        <h3>POS Metrics</h3>
                        <ul class="progress-list">
                            <li class="progress-item">
                                <div class="progress-label"><span>POS Usage</span><span>78%</span></div>
                                <div class="progress-bar"><div class="progress-fill pos"></div></div>
                            </li>
                            <li class="progress-item">
                                <div class="progress-label"><span>Sales Growth</span><span>64%</span></div>
                                <div class="progress-bar"><div class="progress-fill sales"></div></div>
                            </li>
                            <li class="progress-item">
                                <div class="progress-label"><span>Customer Reach</span><span>87%</span></div>
                                <div class="progress-bar"><div class="progress-fill customer"></div></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>