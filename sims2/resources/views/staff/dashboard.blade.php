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
                    <p class="date">Live queue and stock updates for shift awareness.</p>
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
                    <h3>Queue (Last 15 mins)</h3>
                    <div class="number">{{ $queueCount }}</div>
                    <div class="trend {{ $queueLevel === 'high' ? 'down' : 'up' }}">{{ strtoupper($queueLevel) }} traffic</div>
                </div>
                <div class="card stat-card">
                    <h3>Recent Stock Events</h3>
                    <div class="number">{{ $recentMovements->count() }}</div>
                    <div class="trend up">Auto-refreshed by transactions</div>
                </div>
            </div>

            <div class="recent-orders">
                <h2>Latest Inventory Changes</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Item</th>
                            <th>Type</th>
                            <th>Change</th>
                            <th>After</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentMovements as $movement)
                            <tr>
                                <td>{{ optional($movement->created_at)->format('M d, h:i A') }}</td>
                                <td>{{ $movement->inventory?->name ?? 'N/A' }}</td>
                                <td>{{ strtoupper($movement->movement_type) }}</td>
                                <td>{{ $movement->quantity_change }}</td>
                                <td>{{ $movement->quantity_after }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #9bb7ed;">No stock movement yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
