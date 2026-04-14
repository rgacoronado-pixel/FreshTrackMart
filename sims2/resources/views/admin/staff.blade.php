<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management - FreshMartTrack</title>
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
                <a href="{{ route('staff.index') }}" class="active">Staff</a>
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
                    <h1>Staff Management</h1>
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

            <div class="recent-orders">
                <div class="section-header">
                    <h2>Staff Members</h2>
                    <button class="btn-add" onclick="openAddStaffModal()">+ Add Staff</button>
                </div>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff ?? [] as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->role }}</td>
                            <td><span class="status {{ $member->status === 'active' ? 'delivered' : 'pending' }}">{{ ucfirst($member->status ?? 'Active') }}</span></td>
                            <td>
                                <button class="action-btn btn-edit">Edit</button>
                                <button class="action-btn btn-delete">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #9bb7ed;">No staff members found. Add your first staff member!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Add Staff Modal -->
    <div id="addStaffModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Staff Member</h3>
                <button class="modal-close" onclick="closeAddStaffModal()">&times;</button>
            </div>
            <form id="addStaffForm" method="post" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="input-group">
                        <label for="staff_name">Full Name</label>
                        <input type="text" id="staff_name" name="name" placeholder="Enter full name" required>
                    </div>

                    <div class="input-group">
                        <label for="staff_email">Email Address</label>
                        <input type="email" id="staff_email" name="email" placeholder="Enter email address" required>
                    </div>

                    <div class="input-group">
                        <label for="staff_phone">Phone Number</label>
                        <input type="tel" id="staff_phone" name="phone" placeholder="Enter phone number">
                    </div>

                    <div class="input-group">
                        <label for="staff_address">Address</label>
                        <textarea id="staff_address" name="address" placeholder="Enter address" rows="3"></textarea>
                    </div>

                    <div class="input-group">
                        <label for="staff_role">Role</label>
                        <select id="staff_role" name="role" required>
                            <option value="Staff">Staff</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="staff_password">Password</label>
                        <input type="password" id="staff_password" name="password" placeholder="Enter password" required>
                    </div>

                    <div class="input-group">
                        <label for="staff_password_confirmation">Confirm Password</label>
                        <input type="password" id="staff_password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeAddStaffModal()">Cancel</button>
                    <button type="submit" class="btn-save">Add Staff</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function openAddStaffModal() {
            document.getElementById('addStaffModal').style.display = 'flex';
        }

        function closeAddStaffModal() {
            document.getElementById('addStaffModal').style.display = 'none';
            document.getElementById('addStaffForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('addStaffModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddStaffModal();
            }
        });
    </script>
</body>
</html>
