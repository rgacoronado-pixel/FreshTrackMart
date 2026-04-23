<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints & Refunds - FreshMartTrack</title>
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
                <a href="{{ route('pos.index') }}">Point of Sales</a>
                <a href="{{ route('admin.complaints') }}" class="active">Complaints</a>
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
                    <h1>Customer Complaints & Refunds</h1>
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
                <form method="GET" style="display: inline-flex; gap: 8px;">
                    <input type="text" name="search" placeholder="Search item name or sale number..." value="{{ request('search') }}" style="flex:1;">
                    <select name="status">
                        <option value="">All Status</option>
                        <option value="detected" {{ request('status') == 'detected' ? 'selected' : '' }}>Detected</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        <option value="disposed" {{ request('status') == 'disposed' ? 'selected' : '' }}>Disposed</option>
                    </select>
                    <button type="submit" class="filter-btn">Filter</button>
                    <a href="{{ route('admin.complaints') }}" class="filter-btn">Clear</a>
                </form>
            </div>

            @if($logs->isEmpty())
                <div class="recent-orders">
                    <div style="text-align: center; padding: 40px; color: #9bb7ed;">
                        <h3>No complaint records found.</h3>
                        <p>Staff spoilage logs appear here for customer complaint review and refund processing.</p>
                    </div>
                </div>
            @else
                <div class="recent-orders">
                    <h2>Spoilage Logs for Review ({{ $logs->total() }} total)</h2>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Detected</th>
                                <th>Detected By</th>
                                <th>Refund Sale</th>
                                <th>Loss Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
                                <td>#SPL-{{ $log->id }}</td>
                                <td>{{ $log->inventory?->name ?? 'N/A' }}</td>
                                <td>{{ $log->quantity }}</td>
                                <td><span class="status {{ $log->status === 'refunded' ? 'delivered' : ($log->status === 'disposed' ? 'shipped' : 'pending') }}">{{ strtoupper($log->status) }}</span></td>
                                <td>{{ $log->detected_at->format('M d h:i A') }}</td>
                                <td>{{ $log->detector?->name ?? 'N/A' }}</td>
                                <td>{{ $log->refundSale?->sale_number ?? '-' }}</td>
                                <td>₱{{ number_format(($log->inventory?->price ?? 0) * $log->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            @endif
        </main>
    </div>
</body>
</html>
