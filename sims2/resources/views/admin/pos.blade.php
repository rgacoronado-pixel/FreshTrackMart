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

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 20px;">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="recent-orders">
                <h2>Integrated POS Terminal</h2>
                <p>PO deliveries, sales/exchange, stock deduction, and invoice/receipt are connected to stock movement logs.</p>

                <div class="stats-grid">
                    <div class="card stat-card">
                        <h3>Active Transactions</h3>
                        <div class="number">{{ $activeTransactions }}</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Today's Revenue</h3>
                        <div class="number">₱{{ number_format($todayRevenue, 2) }}</div>
                    </div>
                </div>

                <div class="pos-overview" style="margin-top: 18px;">
                    <div class="pos-card">
                        <h3>Receive Delivery (PO)</h3>
                        <form method="POST" action="{{ route('po.store') }}" style="display: grid; gap: 10px;">
                            @csrf
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="po_inventory">Inventory Item</label>
                                <select id="po_inventory" name="inventory_id" required>
                                    <option value="">Select item</option>
                                    @foreach($inventories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->category->name ?? 'No category' }} | Stock: {{ $item->stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="po_supplier">Supplier</label>
                                <input id="po_supplier" type="text" name="supplier" required>
                            </div>
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="po_qty">Delivery Quantity</label>
                                <input id="po_qty" type="number" name="quantity" min="1" required>
                            </div>
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="po_unit_cost">Unit Cost (₱)</label>
                                <input id="po_unit_cost" type="number" name="unit_cost" min="0" step="0.01" required>
                            </div>
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="po_notes">Notes</label>
                                <textarea id="po_notes" name="notes" rows="2"></textarea>
                            </div>
                            <button class="btn-login" type="submit">Post Delivery & Add Stock</button>
                        </form>
                    </div>

                    <div class="pos-card">
                        <h3>Sell / Exchange</h3>
                        <form method="POST" action="{{ route('sales.store') }}" style="display: grid; gap: 10px;">
                            @csrf
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="sale_inventory">Inventory Item</label>
                                <select id="sale_inventory" name="inventory_id" required>
                                    <option value="">Select item</option>
                                    @foreach($inventories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} (Stock: {{ $item->stock }} | Price: ₱{{ number_format((float) $item->price, 2) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="sale_type">Transaction Type</label>
                                <select id="sale_type" name="transaction_type" required>
                                    <option value="sale">Sale</option>
                                    <option value="exchange">Exchange</option>
                                </select>
                            </div>
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="sale_qty">Quantity</label>
                                <input id="sale_qty" type="number" name="quantity" min="1" value="1" required>
                            </div>
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="paid_amount">Paid Amount (₱)</label>
                                <input id="paid_amount" type="number" name="paid_amount" min="0" step="0.01" required>
                            </div>
                            <div class="input-group" style="margin-bottom: 0;">
                                <label for="sale_notes">Notes</label>
                                <textarea id="sale_notes" name="notes" rows="2"></textarea>
                            </div>
                            <button class="btn-login" type="submit">Complete Payment & Generate Receipt</button>
                        </form>
                    </div>
                </div>

                <div style="margin-top: 24px;">
                    <h3 style="margin-bottom: 12px; color:#cfe4ff;">Recent Stock Movements</h3>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Item</th>
                                <th>Type</th>
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
                                    <td>{{ strtoupper($movement->movement_type) }}</td>
                                    <td>{{ $movement->quantity_change }}</td>
                                    <td>{{ $movement->quantity_after }}</td>
                                    <td>{{ $movement->notes }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #9bb7ed;">No movements yet.</td>
                                </tr>
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
