<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return view('admin.po', [
            'inventories' => Inventory::with('category')->orderBy('name')->get(),
            'recentMovements' => StockMovement::with('inventory')
                ->where('movement_type', 'in')
                ->latest('created_at')
                ->limit(10)
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'supplier' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($validated, $request): void {
            $inventory = Inventory::lockForUpdate()->findOrFail($validated['inventory_id']);
            $quantity = (int) $validated['quantity'];
            $unitCost = (float) $validated['unit_cost'];
            $lineTotal = round($unitCost * $quantity, 2);
            $before = (int) $inventory->stock;
            $after = $before + $quantity;

            $po = PurchaseOrder::create([
                'po_number' => $this->nextPONumber(),
                'supplier' => $validated['supplier'],
                'status' => 'received',
                'received_at' => now(),
                'total_amount' => $lineTotal,
                'created_by' => $request->user()?->id,
                'notes' => $validated['notes'] ?? null,
            ]);

            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'inventory_id' => $inventory->id,
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'line_total' => $lineTotal,
            ]);

            $inventory->stock = $after;
            $inventory->supplier = $validated['supplier'];
            $inventory->status = $after > 0 ? 'active' : 'inactive';
            $inventory->save();

            StockMovement::create([
                'inventory_id' => $inventory->id,
                'reference_type' => PurchaseOrder::class,
                'reference_id' => $po->id,
                'movement_type' => 'in',
                'quantity_before' => $before,
                'quantity_change' => $quantity,
                'quantity_after' => $after,
                'unit_price' => $unitCost,
                'total_amount' => $lineTotal,
                'tags' => ['po', 'delivery', strtolower($inventory->category_label)],
                'notes' => 'Stock increased from PO delivery '.$po->po_number,
                'performed_by' => $request->user()?->id,
            ]);
        });

        return redirect()->route('pos.index')->with('success', 'PO delivery posted and stocks updated automatically.');
    }

    private function nextPONumber(): string
    {
        $latest = PurchaseOrder::query()->latest('id')->value('id') ?? 0;
        return sprintf('PO-%s-%05d', now()->format('Ymd'), $latest + 1);
    }
}
