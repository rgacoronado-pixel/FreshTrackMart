<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\SaleItem;
use App\Models\Sale;
use App\Models\SpoilageLog;
use App\Models\StockAlert;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        if ($response = $this->authorizeRole('Admin')) {
            return $response;
        }

        $lowStockCount = Inventory::query()->whereColumn('stock', '<=', 'low_stock_threshold')->count();
        $criticalStockCount = Inventory::query()
            ->whereRaw('stock <= GREATEST(1, FLOOR(low_stock_threshold / 2))')
            ->count();
        $highSpoilageCount = Inventory::query()
            ->whereRaw('spoiled_stock >= GREATEST(5, low_stock_threshold)')
            ->count();

        $todaySalesAmount = (float) Sale::query()->whereDate('sold_at', today())->sum('total_amount');
        $todaySalesCount = Sale::query()->whereDate('sold_at', today())->count();
        $todayRefundAmount = (float) SaleItem::query()
            ->whereDate('updated_at', today())
            ->where('refunded_quantity', '>', 0)
            ->sum(DB::raw('refunded_quantity * unit_price'));
        $todaySpoiledQty = (int) SpoilageLog::query()->whereDate('detected_at', today())->sum('quantity');

        $activeAlerts = StockAlert::query()
            ->with('inventory')
            ->whereNull('resolved_at')
            ->latest('triggered_at')
            ->limit(12)
            ->get();

        return view('admin.dashboard', [
            'lowStockCount' => $lowStockCount,
            'criticalStockCount' => $criticalStockCount,
            'highSpoilageCount' => $highSpoilageCount,
            'todaySalesAmount' => $todaySalesAmount,
            'todaySalesCount' => $todaySalesCount,
            'todayRefundAmount' => $todayRefundAmount,
            'todaySpoiledQty' => $todaySpoiledQty,
            'inventories' => Inventory::query()->orderBy('name')->get(),
            'recentSales' => Sale::query()->latest('sold_at')->limit(8)->get(),
            'recentRefunds' => SaleItem::query()
                ->with(['sale', 'inventory'])
                ->where('refunded_quantity', '>', 0)
                ->latest('updated_at')
                ->limit(8)
                ->get(),
            'recentSpoilage' => SpoilageLog::query()
                ->with(['inventory', 'detector', 'refundSale'])
                ->latest('detected_at')
                ->limit(8)
                ->get(),
            'staffActivities' => StockMovement::query()
                ->with(['inventory', 'performer'])
                ->whereNotNull('performed_by')
                ->latest('created_at')
                ->limit(10)
                ->get(),
            'activeAlerts' => $activeAlerts,
        ]);
    }

    public function staffDashboard()
    {
        if ($response = $this->authorizeRole('Staff')) {
            return $response;
        }

        $queueCount = Sale::where('sold_at', '>=', now()->subMinutes(15))->count();
        $recentMovements = StockMovement::with('inventory')->latest('created_at')->limit(6)->get();

        return view('staff.dashboard', [
            'queueCount' => $queueCount,
            'queueLevel' => $queueCount >= 20 ? 'high' : ($queueCount >= 8 ? 'medium' : 'low'),
            'recentMovements' => $recentMovements,
        ]);
    }

    public function reports()
    {
        if ($response = $this->authorizeRole('Admin')) {
            return $response;
        }

        $weeklySales = (float) Sale::query()->where('sold_at', '>=', now()->subDays(7))->sum('total_amount');
        $weeklyRefunds = (float) SaleItem::query()
            ->where('updated_at', '>=', now()->subDays(7))
            ->where('refunded_quantity', '>', 0)
            ->sum(DB::raw('refunded_quantity * unit_price'));
        $weeklySpoiledQty = (int) SpoilageLog::query()->where('detected_at', '>=', now()->subDays(7))->sum('quantity');

        return view('admin.reports', [
            'weeklySales' => $weeklySales,
            'weeklyRefunds' => $weeklyRefunds,
            'weeklySpoiledQty' => $weeklySpoiledQty,
            'activeAlerts' => StockAlert::query()->with('inventory')->whereNull('resolved_at')->latest('triggered_at')->limit(20)->get(),
            'recentSales' => Sale::query()->latest('sold_at')->limit(10)->get(),
            'recentRefunds' => SaleItem::query()->with(['sale', 'inventory'])->where('refunded_quantity', '>', 0)->latest('updated_at')->limit(10)->get(),
            'recentSpoilage' => SpoilageLog::query()->with(['inventory', 'detector'])->latest('detected_at')->limit(10)->get(),
            'staffActivities' => StockMovement::query()->with(['inventory', 'performer'])->whereNotNull('performed_by')->latest('created_at')->limit(12)->get(),
        ]);
    }

    public function adminComplaints(Request $request)
    {
        if ($response = $this->authorizeRole('Admin')) {
            return $response;
        }

        $logs = SpoilageLog::query()
            ->with(['inventory', 'detector', 'refundSale'])
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status'));
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%'.$request->string('search').'%';
                $query->whereHas('inventory', function ($inventoryQuery) use ($search) {
                    $inventoryQuery->where('name', 'like', $search);
                })->orWhereHas('refundSale', function ($saleQuery) use ($search) {
                    $saleQuery->where('sale_number', 'like', $search);
                });
            })
            ->latest('detected_at')
            ->paginate(15);

        return view('admin.complaints', [
            'logs' => $logs,
        ]);
    }

    public function pos()
    {
        if ($response = $this->authorizeRole('Admin')) {
            return $response;
        }

        $inventories = Inventory::with('category')->orderBy('name')->get();
        $recentMovements = StockMovement::with('inventory')->latest('created_at')->limit(10)->get();
        $todayRevenue = (float) Sale::whereDate('sold_at', today())->sum('total_amount');
        $activeTransactions = Sale::where('sold_at', '>=', now()->subMinutes(15))->count();

        return view('admin.pos', [
            'inventories' => $inventories,
            'recentMovements' => $recentMovements,
            'todayRevenue' => $todayRevenue,
            'activeTransactions' => $activeTransactions,
        ]);
    }

    public function staffTasks()
    {
        if ($response = $this->authorizeRole('Staff')) {
            return $response;
        }

        return view('staff.tasks');
    }

    public function staffScan()
    {
        if ($response = $this->authorizeRole('Staff')) {
            return $response;
        }

        return view('staff.scan', [
            'queueCount' => Sale::where('sold_at', '>=', now()->subMinutes(15))->count(),
            'recentSpoilageLogs' => SpoilageLog::with('inventory')
                ->latest('detected_at')
                ->limit(10)
                ->get(),
        ]);
    }

    public function staffReport()
    {
        if ($response = $this->authorizeRole('Staff')) {
            return $response;
        }

        return view('staff.report');
    }

    private function authorizeRole($role)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'You must be logged in.');
        }

        $userRole = Auth::user()->role ?? 'Staff';

        if ($userRole !== $role) {
            $correctDashboard = $userRole === 'Admin' ? '/admin/dashboard' : '/staff/dashboard';
            return redirect($correctDashboard)->with('error', 'Access denied for this account.');
        }
    }
}
