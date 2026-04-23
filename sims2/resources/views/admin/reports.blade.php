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
                <a href="{{ route('admin.complaints') }}">Complaints</a>
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
                    <h1>Full Monitoring Report</h1>
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

            <div class="stats-grid">
                <div class="card stat-card">
                    <h3>Weekly Sales</h3>
                    <div class="number">₱{{ number_format($weeklySales, 2) }}</div>
                </div>
                <div class="card stat-card">
                    <h3>Weekly Refunds</h3>
                    <div class="number">₱{{ number_format($weeklyRefunds, 2) }}</div>
                </div>
                <div class="card stat-card">
                    <h3>Weekly Spoiled Qty</h3>
                    <div class="number">{{ $weeklySpoiledQty }}</div>
                </div>
                <div class="card stat-card">
                    <h3>Open Alerts</h3>
                    <div class="number">{{ $activeAlerts->count() }}</div>
                </div>
            </div>

            <div class="recent-orders" style="margin-top: 16px;">
                <h2>Alert Feed</h2>
                <table class="styled-table">
                    <thead>
                        <tr><th>Time</th><th>Item</th><th>Type</th><th>Value</th></tr>
                    </thead>
                    <tbody>
                        @forelse($activeAlerts as $alert)
                            <tr>
                                <td>{{ optional($alert->triggered_at)->format('M d, h:i A') }}</td>
                                <td>{{ $alert->inventory?->name ?? 'N/A' }}</td>
                                <td>{{ strtoupper(str_replace('_', ' ', $alert->alert_type)) }}</td>
                                <td>{{ $alert->threshold_value }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="text-align:center; color:#9bb7ed;">No active alerts.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="report-grid" style="margin-top: 16px;">
                <div class="report-card">
                    <h3>Latest Sales</h3>
                    <table class="styled-table">
                        <thead>
                            <tr><th>Sale #</th><th>Total</th><th>Time</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                                <tr>
                                    <td>{{ $sale->sale_number }}</td>
                                    <td>₱{{ number_format((float) $sale->total_amount, 2) }}</td>
                                    <td>{{ optional($sale->sold_at)->format('M d, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" style="text-align:center; color:#9bb7ed;">No sales records.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="report-card">
                    <h3>Latest Refunds</h3>
                    <table class="styled-table">
                        <thead>
                            <tr><th>Sale #</th><th>Item</th><th>Qty</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentRefunds as $refund)
                                <tr>
                                    <td>{{ $refund->sale?->sale_number ?? 'N/A' }}</td>
                                    <td>{{ $refund->inventory?->name ?? 'N/A' }}</td>
                                    <td>{{ $refund->refunded_quantity }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" style="text-align:center; color:#9bb7ed;">No refund records.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="report-grid" style="margin-top: 12px;">
                <div class="report-card">
                    <h3>Latest Spoilage Logs</h3>
                    <table class="styled-table">
                        <thead>
                            <tr><th>Item</th><th>Qty</th><th>Detected By</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentSpoilage as $log)
                                <tr>
                                    <td>{{ $log->inventory?->name ?? 'N/A' }}</td>
                                    <td>{{ $log->quantity }}</td>
                                    <td>{{ $log->detector?->name ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" style="text-align:center; color:#9bb7ed;">No spoilage logs.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="report-card">
                    <h3>Staff Activities</h3>
                    <table class="styled-table">
                        <thead>
                            <tr><th>Staff</th><th>Item</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            @forelse($staffActivities as $activity)
                                <tr>
                                    <td>{{ $activity->performer?->name ?? 'N/A' }}</td>
                                    <td>{{ $activity->inventory?->name ?? 'N/A' }}</td>
                                    <td>{{ strtoupper($activity->movement_type) }} ({{ $activity->quantity_change }})</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" style="text-align:center; color:#9bb7ed;">No staff activity records.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
