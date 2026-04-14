<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - FreshMartTrack</title>
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
                <a href="{{ route('reports.index') }}" class="active">Reports</a>
                <a href="{{ route('pos.index') }}">Point of Sales</a>
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
                    <h1>Reports</h1>
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
                <div class="report-header">
                    <div>
                        <h2>Sales and Inventory Reports</h2>
                        <p>Here is a summary of the latest activity and performance for your store.</p>
                    </div>
                    <div class="report-actions">
                        <button class="report-btn" onclick="refreshReports()">Refresh Data</button>
                        <button class="report-btn secondary" onclick="exportReport('csv')">Export CSV</button>
                        <button class="report-btn secondary" onclick="exportReport('pdf')">Export PDF</button>
                    </div>
                </div>

                <div class="report-summary-grid">
                    <div class="card stat-card">
                        <h3>Weekly Sales</h3>
                        <div class="number">₱12,840</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Low Stock Items</h3>
                        <div class="number">7</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Pending Orders</h3>
                        <div class="number">24</div>
                    </div>
                </div>

                <div class="report-grid">
                    <div class="report-card">
                        <h3>Revenue Bar Chart</h3>
                        <div class="bar-chart" id="revenue-bar-chart">
                            <div class="bar" style="height: 72%;"><span>₱9.2k</span></div>
                            <div class="bar" style="height: 84%;"><span>₱10.8k</span></div>
                            <div class="bar" style="height: 100%;"><span>₱12.8k</span></div>
                            <div class="bar" style="height: 78%;"><span>₱10.0k</span></div>
                            <div class="bar" style="height: 92%;"><span>₱11.8k</span></div>
                        </div>
                        <div class="chart-labels">
                            <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span>
                        </div>
                    </div>
                    <div class="report-card">
                        <h3>Sales Distribution</h3>
                        <div class="pie-chart" id="sales-pie-chart"></div>
                        <ul class="pie-legend">
                            <li><span class="legend-dot blue"></span>Fruits 42%</li>
                            <li><span class="legend-dot green"></span>Vegetables 28%</li>
                            <li><span class="legend-dot purple"></span>Other 30%</li>
                        </ul>
                    </div>
                    <div class="report-card">
                        <h3>Report Trend</h3>
                        <div class="line-chart-wrapper">
                            <svg viewBox="0 0 280 160" class="line-chart">
                                <polyline points="0,120 56,98 112,70 168,80 224,50 280,58" fill="none" stroke="#60a5fa" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="56" cy="98" r="4" fill="#93c5fd" />
                                <circle cx="112" cy="70" r="4" fill="#93c5fd" />
                                <circle cx="168" cy="80" r="4" fill="#93c5fd" />
                                <circle cx="224" cy="50" r="4" fill="#93c5fd" />
                                <circle cx="280" cy="58" r="4" fill="#93c5fd" />
                            </svg>
                            <div class="chart-bottom-labels">
                                <span>Week 1</span>
                                <span>Week 2</span>
                                <span>Week 3</span>
                                <span>Week 4</span>
                                <span>Week 5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>