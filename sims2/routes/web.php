<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StaffOperationsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return Auth::user()?->role === 'Admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('staff.dashboard');
    })->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/staff/dashboard', [DashboardController::class, 'staffDashboard'])->name('staff.dashboard');

    Route::resource('inventory', InventoryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/po', [PurchaseOrderController::class, 'index'])->name('po.index');
    Route::post('/po', [PurchaseOrderController::class, 'store'])->name('po.store');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/receipt/{sale}', [SalesController::class, 'showReceipt'])->name('receipt.show');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports.index');
    Route::get('/admin/complaints', [DashboardController::class, 'adminComplaints'])->name('admin.complaints');
    Route::get('/pos', [DashboardController::class, 'pos'])->name('pos.index');

    // Staff routes
    Route::get('/staff/tasks', [DashboardController::class, 'staffTasks'])->name('staff.tasks');
    Route::get('/staff/scan', [DashboardController::class, 'staffScan'])->name('staff.scan');
    Route::get('/staff/report', [DashboardController::class, 'staffReport'])->name('staff.report');
    Route::get('/staff/scan/lookup', [StaffOperationsController::class, 'scanLookup'])->name('staff.scan.lookup');
    Route::get('/staff/live-snapshot', [StaffOperationsController::class, 'liveSnapshot'])->name('staff.live.snapshot');
    Route::post('/staff/spoilage', [StaffOperationsController::class, 'markSpoiled'])->name('staff.spoilage');
    Route::post('/staff/refund', [StaffOperationsController::class, 'refundOrVoid'])->name('staff.refund');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //route for user management
    Route::resource('users', UserController::class);

});



require __DIR__ . '/auth.php';
