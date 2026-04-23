<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - FreshMartTrack</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
                    <h1>Receipt / Invoice</h1>
                    <p class="date">{{ now()->format('l, M j, Y') }}</p>
                </div>
            </header>

            <div class="recent-orders">
                <div class="section-header">
                    <h2>Payment Complete</h2>
                    <a href="{{ route('pos.index') }}" class="report-btn" style="text-decoration:none;">Back to POS</a>
                </div>

                <div class="report-summary-grid">
                    <div class="card stat-card">
                        <h3>Invoice No.</h3>
                        <div class="number" style="font-size:1rem;">{{ $invoice->invoice_number }}</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Receipt No.</h3>
                        <div class="number" style="font-size:1rem;">{{ $invoice->receipt_number }}</div>
                    </div>
                    <div class="card stat-card">
                        <h3>Sale Ref</h3>
                        <div class="number" style="font-size:1rem;">{{ $sale->sale_number }}</div>
                    </div>
                </div>

                <table class="styled-table" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Tags</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                            <tr>
                                <td>{{ $item->inventory?->name ?? 'N/A' }}</td>
                                <td>{{ $item->inventory?->category ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₱{{ number_format((float) $item->unit_price, 2) }}</td>
                                <td>{{ implode(', ', $item->tags ?? []) }}</td>
                                <td>₱{{ number_format((float) $item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top: 20px; display: grid; gap: 8px; max-width: 360px; margin-left:auto;">
                    <div style="display:flex; justify-content:space-between;"><strong>Transaction Type</strong><span>{{ strtoupper($sale->transaction_type) }}</span></div>
                    <div style="display:flex; justify-content:space-between;"><strong>Subtotal</strong><span>₱{{ number_format((float) $sale->subtotal, 2) }}</span></div>
                    <div style="display:flex; justify-content:space-between;"><strong>Total</strong><span>₱{{ number_format((float) $sale->total_amount, 2) }}</span></div>
                    <div style="display:flex; justify-content:space-between;"><strong>Paid</strong><span>₱{{ number_format((float) $sale->paid_amount, 2) }}</span></div>
                    <div style="display:flex; justify-content:space-between;"><strong>Change</strong><span>₱{{ number_format((float) $sale->change_amount, 2) }}</span></div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
