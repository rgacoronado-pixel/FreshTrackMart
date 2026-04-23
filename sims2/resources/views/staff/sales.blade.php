<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales - FreshMartTrack</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo sidebar-logo">FreshMart<span>Staff</span></div>
            <nav class="nav-links">
                <a href="{{ route('staff.dashboard') }}">Dashboard</a>
                <a href="{{ route('staff.scan') }}">Scan</a>
                <a href="{{ route('staff.report') }}">Report</a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="top-bar">
                <h1>Quick Sale</h1>
            </header>
            <form method="POST" action="{{ route('sales.store') }}">
                @csrf
                <select name="inventory_id">
                    @foreach(\App\Models\Inventory::where('stock', '>', 0)->get() as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }} (₱{{ $item->price }} - Stock: {{ $item->stock }})</option>
                    @endforeach
                </select>
                <input type="text" name="transaction_type" value="sale">
                <input type="number" name="quantity" value="1" min="1">
                <input type="number" name="paid_amount" step="0.01" required>
                <textarea name="notes"></textarea>
                <button type="submit">Complete Sale (Auto stock deduct + receipt)</button>
            </form>
        </main>
    </div>
</body>
</html>

