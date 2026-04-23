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
                <!-- PO link commented until route fixed -->

                <a href="{{ route('staff.index') }}">Staff</a>
                <a href="{{ route('reports.index') }}">Reports</a>
                <a href="{{ route('pos.index') }}">Point of Sales</a>
            </nav>

            <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid rgba(125, 180, 255, 0.2);">
                <h4 style="font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.08em; color: #9fc7ff; margin-bottom: 12px;">Categories</h4>
                <div style="display: grid; gap: 8px; max-height: 220px; overflow-y: auto; padding-right: 4px;">
                    <a href="{{ route('inventory.index') }}" class="{{ ($selectedCategoryId ?? 0) === 0 ? 'active' : '' }}" style="text-decoration: none; color: #b8cced; padding: 8px 10px; border-radius: 8px; background: rgba(255,255,255,0.03);">All Categories</a>
                    @foreach($categories as $category)
                        <a href="{{ route('inventory.index', ['category_id' => $category->id, 'quick_add' => 1]) }}" class="{{ ($selectedCategoryId ?? 0) === $category->id ? 'active' : '' }}" style="text-decoration: none; color: #b8cced; padding: 8px 10px; border-radius: 8px; background: rgba(255,255,255,0.03);">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>

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
                @foreach($categories as $category)
                    <button class="filter-btn" onclick="setInventoryFilter('{{ $category->name }}')">{{ $category->name }}</button>
                @endforeach
                <button class="filter-btn" onclick="setInventoryFilter('low-stock')">Low Stock</button>
            </div>

            <div class="recent-orders">
                <div class="section-header">
                    <h2>Inventory Items</h2>
                    <button class="btn-add" onclick="openAddItemModal()">+ Add Item{{ ($selectedCategoryId ?? 0) > 0 ? ' in Category' : '' }}</button>
                </div>
                <table class="styled-table" id="inventory-table">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr
                            id="inventory-row-{{ $item->id }}"
                            data-category="{{ $item->category->name ?? $item->category }}"
                            data-stock="{{ $item->stock }}"
                            data-name="{{ $item->name }}"
                            data-category-id="{{ $item->category_id }}"
                            data-price="{{ $item->price }}"
                            data-description="{{ $item->description }}"
                            data-supplier="{{ $item->supplier }}"
                            data-barcode="{{ $item->barcode }}"
                            data-low-stock-threshold="{{ $item->low_stock_threshold ?? 10 }}"
                        >
                            <td>#ITM-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category->name ?? $item->category }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>₱{{ number_format((float) $item->price, 2) }}</td>
                            <td>{{ optional($item->updated_at)->format('M d, Y h:i A') }}</td>
                            <td><span class="status {{ $item->stock > 20 ? 'delivered' : 'pending' }}">{{ $item->stock > 20 ? 'In Stock' : 'Low Stock' }}</span></td>
                            <td>
                                <button class="action-btn btn-edit" onclick="openEditItemModal({{ $item->id }})">Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteItem({{ $item->id }})">Delete</button>
                                <form id="delete-form-{{ $item->id }}" method="post" action="{{ route('inventory.destroy', $item) }}" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #9bb7ed;">No inventory items found. Add your first item!</td>
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
                        <select id="item_category" name="category_id" required>
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ ($selectedCategoryId ?? 0) === $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="item_barcode">Barcode</label>
                        <input type="text" id="item_barcode" name="barcode" placeholder="Optional barcode">
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
                        <label for="item_low_stock_threshold">Low Stock Threshold</label>
                        <input type="number" id="item_low_stock_threshold" name="low_stock_threshold" placeholder="Default: 10" min="0" value="10">
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

    <!-- Edit Item Modal -->
    <div id="editItemModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Inventory Item</h3>
                <button class="modal-close" onclick="closeEditItemModal()">&times;</button>
            </div>
            <form id="editItemForm" method="post" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="input-group">
                        <label for="edit_item_name">Item Name</label>
                        <input type="text" id="edit_item_name" name="name" required>
                    </div>

                    <div class="input-group">
                        <label for="edit_item_category">Category</label>
                        <select id="edit_item_category" name="category_id" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="edit_item_stock">Current Stock</label>
                        <input type="number" id="edit_item_stock" name="stock" min="0" required>
                    </div>

                    <div class="input-group">
                        <label for="edit_item_price">Price (₱)</label>
                        <input type="number" id="edit_item_price" name="price" min="0" step="0.01" required>
                    </div>

                    <div class="input-group">
                        <label for="edit_item_barcode">Barcode</label>
                        <input type="text" id="edit_item_barcode" name="barcode">
                    </div>

                    <div class="input-group">
                        <label for="edit_item_low_stock_threshold">Low Stock Threshold</label>
                        <input type="number" id="edit_item_low_stock_threshold" name="low_stock_threshold" min="0">
                    </div>

                    <div class="input-group">
                        <label for="edit_item_description">Description</label>
                        <textarea id="edit_item_description" name="description" rows="3"></textarea>
                    </div>

                    <div class="input-group">
                        <label for="edit_item_supplier">Supplier</label>
                        <input type="text" id="edit_item_supplier" name="supplier">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditItemModal()">Cancel</button>
                    <button type="submit" class="btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        const selectedCategoryId = {{ (int) ($selectedCategoryId ?? 0) }};
        const quickAdd = {{ ($quickAdd ?? false) ? 'true' : 'false' }};

        function openAddItemModal() {
            if (selectedCategoryId > 0) {
                document.getElementById('item_category').value = String(selectedCategoryId);
            }
            document.getElementById('addItemModal').style.display = 'flex';
        }

        function closeAddItemModal() {
            document.getElementById('addItemModal').style.display = 'none';
            document.getElementById('addItemForm').reset();
        }

        function openEditItemModal(itemId) {
            const row = document.getElementById(`inventory-row-${itemId}`);
            const form = document.getElementById('editItemForm');

            form.action = `{{ url('/inventory') }}/${itemId}`;
            document.getElementById('edit_item_name').value = row.dataset.name || '';
            document.getElementById('edit_item_category').value = row.dataset.categoryId || '';
            document.getElementById('edit_item_stock').value = row.dataset.stock || 0;
            document.getElementById('edit_item_price').value = row.dataset.price || 0;
            document.getElementById('edit_item_description').value = row.dataset.description || '';
            document.getElementById('edit_item_supplier').value = row.dataset.supplier || '';
            document.getElementById('edit_item_barcode').value = row.dataset.barcode || '';
            document.getElementById('edit_item_low_stock_threshold').value = row.dataset.lowStockThreshold || 10;

            document.getElementById('editItemModal').style.display = 'flex';
        }

        function closeEditItemModal() {
            document.getElementById('editItemModal').style.display = 'none';
            document.getElementById('editItemForm').reset();
        }

        function deleteItem(itemId) {
            if (!confirm('Delete this inventory item?')) {
                return;
            }

            document.getElementById(`delete-form-${itemId}`).submit();
        }

        // Close modal when clicking outside
        document.getElementById('addItemModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddItemModal();
            }
        });

        document.getElementById('editItemModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditItemModal();
            }
        });

        if (quickAdd) {
            openAddItemModal();
        }
    </script>
</body>
</html>
