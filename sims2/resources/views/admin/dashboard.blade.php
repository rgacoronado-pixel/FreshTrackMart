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
                    <h1>Dashboard</h1>
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

            <div class="stats-grid">
                <div class="card stat-card">
                    <h3>Total Orders</h3>
                    <div class="number">1,245</div>
                    <div class="trend up">+12% from yesterday</div>
                </div>
                <div class="card stat-card">
                    <h3>Pending Shipments</h3>
                    <div class="number">34</div>
                    <div class="trend down">-5% from yesterday</div>
                </div>
                <div class="card stat-card">
                    <h3>Total Revenue</h3>
                    <div class="number">₱45,200</div>
                    <div class="trend up">+8% from yesterday</div>
                </div>
                <div class="card stat-card">
                    <h3>Freshness Index</h3>
                    <div class="number">98%</div>
                    <div class="trend">Stable</div>
                </div>
            </div>

            <div class="recent-orders">
                <h2>Recent Activity</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#FM-2024</td>
                            <td>Organic Avocados</td>
                            <td><span class="status delivered">Delivered</span></td>
                            <td>{{ now()->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td>#FM-2025</td>
                            <td>Fresh Strawberries</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>{{ now()->format('M d, Y') }}</td>
                        </tr>
                         <tr>
                            <td>#FM-2026</td>
                            <td>Bananas (Cavendish)</td>
                            <td><span class="status shipped">Shipped</span></td>
                            <td>{{ now()->subDay()->format('M d, Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
