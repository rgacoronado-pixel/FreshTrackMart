<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - FreshMartTrack</title>
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
                <!-- PO link commented until route fixed -->

            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <h1>Categories</h1>
            </header>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="section-header">
                <h2>Manage Categories</h2>
                <button onclick="openAddCategoryModal()">+ Add Category</button>
            </div>

            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Color</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td><span style="background-color: {{ $category->color }}; width: 20px; height: 20px; border-radius: 50%; display: inline-block;"></span></td>
                        <td>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline-delete" onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Add Category Modal -->
            <div id="addCategoryModal" class="modal-overlay">
                <div class="modal-content">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <h3>Add Category</h3>
                        <input type="text" name="name" placeholder="Category name" required>
                        <textarea name="description" placeholder="Description"></textarea>
                        <input type="color" name="color" value="#4CAF50">
                        <div>
                            <button type="submit">Add</button>
                            <button type="button" onclick="closeAddCategoryModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

