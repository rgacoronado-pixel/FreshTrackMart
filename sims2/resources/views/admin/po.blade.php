<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Orders - FreshMartTrack</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo sidebar-logo">FreshMart<span>Track</span></div>
            <nav class="nav-links">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('inventory.index') }}">Inventory</a>
                <a href="{{ route('categories.index') }}">Categories</a>
                <a href="{{ route('po.index') }}" class="active">Purchase Orders</a>
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
                <h1>Purchase Orders</h1>
            </header>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card" style="margin-bottom: 20px;">
                <form method="POST" action="{{ route('po.store') }}" style="display:grid; gap: 10px;">
                    @csrf
                    <div class="input-group" style="margin-bottom: 0;">
                        <label for="inventory_id">Inventory Item</label>
                        <select id="inventory_id" name="inventory_id" required>
                            <option value="">Select item</option>
                            @foreach($inventories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->category->name ?? 'No category' }} | Stock: {{ $item->stock }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group" style="margin-bottom: 0;">
                        <label for="supplier">Supplier</label>
                        <input id="supplier" type="text" name="supplier" required>
                    </div>

                    <div class="input-group" style="margin-bottom: 0;">
                        <label for="quantity">Quantity</label>
                        <input id="quantity" type="number" name="quantity" min="1" required>
                    </div>

                    <div class="input-group" style="margin-bottom: 0;">
                        <label for="unit_cost">Unit Cost (₱)</label>
                        <input id="unit_cost" type="number" name="unit_cost" step="0.01" min="0" required>
                    </div>

                    <div class="input-group" style="margin-bottom: 0;">
                        <label for="notes">Notes</label>
                        <textarea id="notes" name="notes" rows="2"></textarea>
                    </div>

                    <button class="btn-login" type="submit">Receive PO & Update Stock</button>
                </form>
            </div>

            <div class="recent-orders">
                <h2>Recent Inbound Stock Movements</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Item</th>
                            <th>Change</th>
                            <th>After</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentMovements as $movement)
                            <tr>
                                <td>{{ optional($movement->created_at)->format('M d, h:i A') }}</td>
                                <td>{{ $movement->inventory?->name ?? 'N/A' }}</td>
                                <td>{{ $movement->quantity_change }}</td>
                                <td>{{ $movement->quantity_after }}</td>
                                <td>{{ $movement->notes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; color:#9bb7ed;">No PO stock movements yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
