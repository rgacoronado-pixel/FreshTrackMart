<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spoilage Report - FreshMartTrack</title>
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
                    <h1>Spoilage Report</h1>
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
                <div class="section-header">
                    <h2>Daily / Weekly Loss Totals</h2>
                    <a href="{{ route('reports.index') }}" class="report-btn" style="text-decoration:none;">Back to Reports</a>
                </div>

                <div class="report-summary-grid">
                    <div class="card stat-card">
                        <h3>Daily Spoilage Loss</h3>
                        <div class="number">₱{{ number_format($dailyLoss, 2) }}</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Weekly Spoilage Loss</h3>
                        <div class="number">₱{{ number_format($weeklyLoss, 2) }}</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Daily Spoiled Qty</h3>
                        <div class="number">{{ $dailySpoiledQty }}</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Weekly Spoiled Qty</h3>
                        <div class="number">{{ $weeklySpoiledQty }}</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Weekly Refunded Complaints</h3>
                        <div class="number">{{ $weeklyRefundedCount }}</div>
                    </div>
                </div>
            </div>

            <div class="recent-orders" style="margin-top:20px;">
                <h2>Auto Alerts by Shelf-life (Fruits / Seafood)</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Age (hrs)</th>
                            <th>Threshold</th>
                            <th>Alert</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shelfLifeAlerts as $alert)
                            <tr>
                                <td>{{ $alert['item_name'] }}</td>
                                <td>{{ $alert['category'] }}</td>
                                <td>{{ $alert['stock'] }}</td>
                                <td>{{ $alert['age_hours'] }}</td>
                                <td>{{ $alert['threshold_hours'] }}</td>
                                <td><span class="status {{ $alert['level'] === 'overdue' ? 'pending' : 'shipped' }}">{{ strtoupper($alert['level']) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;">No alerts right now.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="recent-orders" style="margin-top:20px;">
                <h2>Today Spoilage Logs</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Log ID</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Detected At</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dailyLogs as $log)
                            <tr>
                                <td>#SPL-{{ $log->id }}</td>
                                <td>{{ $log->inventory?->name ?? 'N/A' }}</td>
                                <td>{{ $log->quantity }}</td>
                                <td>{{ optional($log->detected_at)->format('M d, Y h:i A') }}</td>
                                <td><span class="status {{ $log->status === 'refunded' ? 'delivered' : 'pending' }}">{{ strtoupper($log->status) }}</span></td>
                                <td>{{ $log->reason ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;">No spoilage records today.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="recent-orders" style="margin-top:20px;">
                <h2>Weekly Spoilage Logs</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Log ID</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Detected At</th>
                            <th>Status</th>
                            <th>Refund Sale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($weeklyLogs as $log)
                            <tr>
                                <td>#SPL-{{ $log->id }}</td>
                                <td>{{ $log->inventory?->name ?? 'N/A' }}</td>
                                <td>{{ $log->quantity }}</td>
                                <td>{{ optional($log->detected_at)->format('M d, Y h:i A') }}</td>
                                <td><span class="status {{ $log->status === 'refunded' ? 'delivered' : 'pending' }}">{{ strtoupper($log->status) }}</span></td>
                                <td>{{ $log->refund_sale_id ? '#SL-'.$log->refund_sale_id : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;">No spoilage logs this week.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
