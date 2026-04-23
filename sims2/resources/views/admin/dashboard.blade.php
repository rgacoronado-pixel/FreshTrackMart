<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshMartTrack - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo sidebar-logo">FreshMart<span>Track</span></div>

            <nav class="nav-links">
                <a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a>
                <a href="{{ route('inventory.index') }}">Inventory</a>
                <a href="{{ route('staff.index') }}">Staff</a>
                <a href="{{ route('reports.index') }}">Reports</a>
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
                    <h1>Admin Monitoring Dashboard</h1>
                    <p class="date">{{ now()->format('l, M j, Y') }}</p>
                </div>
                <div class="user-profile">
                    <div class="user-info">
                        <span id="display-username">{{ Auth::user()->name }}</span>
                        <small id="display-role">{{ Auth::user()->role }}</small>
                    </div>
                    <div class="avatar"></div>
                </div>
            </header>

            @if(session('error'))
                <div class="alert alert-error" style="margin-bottom: 20px;">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 20px;">{{ session('success') }}</div>
            @endif

            <div class="stats-grid">
                <div class="card stat-card">
                    <h3>Sales Today</h3>
                    <div class="number">₱{{ number_format($todaySalesAmount, 2) }}</div>
                    <div class="trend up">{{ $todaySalesCount }} transactions</div>
                </div>
                <div class="card stat-card">
                    <h3>Refunds Today</h3>
                    <div class="number">₱{{ number_format($todayRefundAmount, 2) }}</div>
                    <div class="trend down">Customer refund exposure</div>
                </div>
                <div class="card stat-card">
                    <h3>Spoiled Qty Today</h3>
                    <div class="number">{{ $todaySpoiledQty }}</div>
                    <div class="trend down">Bulok deductions logged</div>
                </div>
                <div class="card stat-card">
                    <h3>Open Alerts</h3>
                    <div class="number">{{ $activeAlerts->count() }}</div>
                    <div class="trend {{ $activeAlerts->count() > 0 ? 'down' : 'up' }}">Low/Critical/Spoilage</div>
                </div>
            </div>

            <div class="stats-grid" style="margin-top: 10px;">
                <div class="card stat-card">
                    <h3>Low Stock Items</h3>
                    <div class="number">{{ $lowStockCount }}</div>
                </div>
                <div class="card stat-card">
                    <h3>Critical Stock</h3>
                    <div class="number">{{ $criticalStockCount }}</div>
                </div>
                <div class="card stat-card">
                    <h3>High Spoilage Risk</h3>
                    <div class="number">{{ $highSpoilageCount }}</div>
                </div>
            </div>

            <div class="recent-orders" style="margin-top: 16px;">
                <div class="section-header">
                    <h2>Manual Spoilage Tagging (Admin)</h2>
                </div>
                <form method="POST" action="{{ route('staff.spoilage') }}" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;">
                    @csrf
                    <div class="input-group" style="margin-bottom:0;">
                        <label for="item_code">Item Code</label>
                        <select id="item_code" name="item_code" required>
                            <option value="">Select item code</option>
                            @foreach($inventories as $item)
                                <option value="ITM-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}">ITM-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }} | {{ $item->name }} | Stock: {{ $item->stock }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group" style="margin-bottom:0;">
                        <label for="quantity">Spoiled Quantity</label>
                        <input id="quantity" type="number" name="quantity" min="1" required>
                    </div>
                    <div class="input-group" style="margin-bottom:0;">
                        <label for="reason">Reason</label>
                        <input id="reason" type="text" name="reason" placeholder="e.g. Overripe, foul odor, damaged pack">
                    </div>
                    <div style="display:flex; align-items:flex-end;">
                        <button type="submit" class="btn-login">Mark as Bulok / Spoiled</button>
                    </div>
                </form>
            </div>

            <div class="recent-orders" style="margin-top: 16px;">
                <h2>Active Stock Alerts</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Item</th>
                            <th>Alert Type</th>
                            <th>Value</th>
                        </tr>
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

            <div class="recent-orders" style="margin-top: 16px;">
                <h2>Sales, Refunds, Spoilage, and Staff Activities</h2>
                <div class="report-grid">
                    <div class="report-card">
                        <h3>Recent Sales</h3>
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
                                    <tr><td colspan="3" style="text-align:center; color:#9bb7ed;">No sales yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="report-card">
                        <h3>Recent Refunds</h3>
                        <table class="styled-table">
                            <thead>
                                <tr><th>Sale #</th><th>Item</th><th>Refund Qty</th></tr>
                            </thead>
                            <tbody>
                                @forelse($recentRefunds as $refund)
                                    <tr>
                                        <td>{{ $refund->sale?->sale_number ?? 'N/A' }}</td>
                                        <td>{{ $refund->inventory?->name ?? 'N/A' }}</td>
                                        <td>{{ $refund->refunded_quantity }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" style="text-align:center; color:#9bb7ed;">No refunds yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="report-grid" style="margin-top: 12px;">
                    <div class="report-card">
                        <h3>Recent Spoiled Items</h3>
                        <table class="styled-table">
                            <thead>
                                <tr><th>Item</th><th>Qty</th><th>Detected</th></tr>
                            </thead>
                            <tbody>
                                @forelse($recentSpoilage as $log)
                                    <tr>
                                        <td>{{ $log->inventory?->name ?? 'N/A' }}</td>
                                        <td>{{ $log->quantity }}</td>
                                        <td>{{ optional($log->detected_at)->format('M d, h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" style="text-align:center; color:#9bb7ed;">No spoilage logs yet.</td></tr>
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
                                    <tr><td colspan="3" style="text-align:center; color:#9bb7ed;">No activities found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
