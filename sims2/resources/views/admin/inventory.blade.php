<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - FreshMartTrack</title>
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
                    <h1>Inventory Management</h1>
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

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 20px; padding: 12px 16px; border-radius: 8px; background: rgba(46, 204, 113, 0.16); border: 1px solid rgba(46, 204, 113, 0.35); color: #b7f7cf;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom: 20px; padding: 12px 16px; border-radius: 8px; background: rgba(231, 76, 60, 0.16); border: 1px solid rgba(231, 76, 60, 0.35); color: #ffb3aa;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="filter-bar">
                <button class="filter-btn active" onclick="setInventoryFilter('all')">All Items</button>
                <button class="filter-btn" onclick="setInventoryFilter('Fruits')">Fruits</button>
                <button class="filter-btn" onclick="setInventoryFilter('Vegetables')">Vegetables</button>
                <button class="filter-btn" onclick="setInventoryFilter('low-stock')">Low Stock</button>
            </div>

            <div class="recent-orders">
                <div class="section-header">
                    <h2>Inventory Items</h2>
                    <button class="btn-add" onclick="openAddItemModal()">+ Add Item</button>
                </div>
                <table class="styled-table" id="inventory-table">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items ?? [] as $index => $item)
                        <tr data-category="{{ $item->category }}" data-stock="{{ $item->stock }}">
                            <td>#ITM-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->stock }}</td>
                            <td><span class="status {{ $item->stock > 20 ? 'delivered' : 'pending' }}">{{ $item->stock > 20 ? 'In Stock' : 'Low Stock' }}</span></td>
                            <td>
                                <button class="action-btn btn-edit" onclick="handleInventoryAction('edit', '#ITM-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}')">Edit</button>
                                <button class="action-btn btn-delete" onclick="handleInventoryAction('delete', '#ITM-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}')">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #9bb7ed;">No inventory items found. Add your first item!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Add Item Modal -->
    <div id="addItemModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Inventory Item</h3>
                <button class="modal-close" onclick="closeAddItemModal()">&times;</button>
            </div>
            <form id="addItemForm" method="post" action="{{ route('inventory.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="input-group">
                        <label for="item_name">Item Name</label>
                        <input type="text" id="item_name" name="name" placeholder="Enter item name" required>
                    </div>

                    <div class="input-group">
                        <label for="item_category">Category</label>
                        <select id="item_category" name="category" required>
                            <option value="">Select category</option>
                            <option value="Fruits">Fruits</option>
                            <option value="Vegetables">Vegetables</option>
                            <option value="Dairy">Dairy</option>
                            <option value="Meat">Meat</option>
                            <option value="Bakery">Bakery</option>
                            <option value="Beverages">Beverages</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="item_stock">Initial Stock</label>
                        <input type="number" id="item_stock" name="stock" placeholder="Enter initial stock quantity" min="0" required>
                    </div>

                    <div class="input-group">
                        <label for="item_price">Price (₱)</label>
                        <input type="number" id="item_price" name="price" placeholder="Enter price per unit" min="0" step="0.01" required>
                    </div>

                    <div class="input-group">
                        <label for="item_description">Description</label>
                        <textarea id="item_description" name="description" placeholder="Enter item description" rows="3"></textarea>
                    </div>

                    <div class="input-group">
                        <label for="item_supplier">Supplier</label>
                        <input type="text" id="item_supplier" name="supplier" placeholder="Enter supplier name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeAddItemModal()">Cancel</button>
                    <button type="submit" class="btn-save">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function openAddItemModal() {
            document.getElementById('addItemModal').style.display = 'flex';
        }

        function closeAddItemModal() {
            document.getElementById('addItemModal').style.display = 'none';
            document.getElementById('addItemForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('addItemModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddItemModal();
            }
        });
    </script>
</body>
</html>
