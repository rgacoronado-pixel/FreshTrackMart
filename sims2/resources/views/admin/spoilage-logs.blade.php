<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spoilage Logs - {{ $inventory->name }} - FreshMartTrack</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo sidebar-logo">FreshMart<span>Track</span></div>
            <nav class="nav-links">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('inventory.index') }}" class="active">Inventory</a>
                <a href="{{ route('staff.index') }}">Staff</a>
                <a href="{{ route('reports.index') }}">Reports</a>
                <a href="{{ route('pos.index') }}">Point of Sales</a>
                <a href="{{ route('admin.complaints') }}">Complaints</a>
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
                    <h1>Spoilage Logs: {{ $inventory->name }}</h1>
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

            <div class="filter-bar">
                <a href="{{ route('inventory.index') }}" class="filter-btn">Back to Inventory</a>
            </div>

            @if($logs->isEmpty())
                <div class="recent-orders">
                    <div style="text-align: center; padding: 40px; color: #9bb7ed;">
                        <h3>No spoilage logs for this item yet.</h3>
                        <p>Stock: {{ $inventory->stock }} available | {{ $inventory->spoiled_stock ?? 0 }} spoiled</p>
                    </div>
                </div>
            @else
                <div class="recent-orders">
                    <h2>Spoilage History ({{ $logs->total() }} records)</h2>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Detected</th>
                                <th>Reason</th>
                                <th>By</th>
                                <th>Refund</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
                                <td>#SPL-{{ $log->id }}</td>
                                <td>{{ $log->quantity }}</td>
                                <td><span class="status {{ $log->status === 'refunded' ? 'delivered' : ($log->status === 'disposed' ? 'shipped' : 'pending') }}">{{ strtoupper($log->status) }}</span></td>
                                <td>{{ $log->detected_at->format('M d h:i A') }}</td>
                                <td>{{ Str::limit($log->reason, 50) }}</td>
                                <td>{{ $log->detector?->name ?? 'N/A' }}</td>
                                <td>{{ $log->refundSale ? $log->refundSale->sale_number : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $logs->links() }}
                </div>
            @endif
        </main>
    </div>
</body>
</html>
