<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->orderBy('name')->get();
        $selectedCategoryId = $request->integer('category_id');

        $itemsQuery = Inventory::query()->with('category')->latest('updated_at');
        if ($selectedCategoryId > 0) {
            $itemsQuery->where('category_id', $selectedCategoryId);
        }

        $items = $itemsQuery->get();

        return view('admin.inventory', [
            'items' => $items,
            'categories' => $categories,
            'selectedCategoryId' => $selectedCategoryId,
            'quickAdd' => $request->boolean('quick_add'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|string|unique:inventories,barcode',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'supplier' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $request): void {
            $openingStock = (int) $validated['stock'];

            $inventory = Inventory::create($validated + [
                'status' => $openingStock > 0 ? 'active' : 'inactive',
                'updated_by' => $request->user()?->id,
                'low_stock_threshold' => $validated['low_stock_threshold'] ?? 10,
                'spoiled_stock' => 0,
            ]);

            if ($openingStock > 0) {
                StockMovement::create([
                    'inventory_id' => $inventory->id,
                    'reference_type' => Inventory::class,
                    'reference_id' => $inventory->id,
                    'movement_type' => 'in',
                    'quantity_before' => 0,
                    'quantity_change' => $openingStock,
                    'quantity_after' => $openingStock,
                    'unit_price' => $inventory->price,
                    'total_amount' => (float) $inventory->price * $openingStock,
                    'tags' => ['inventory', 'opening-stock'],
                    'notes' => 'Opening stock from product creation',
                    'performed_by' => $request->user()?->id,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Inventory item added successfully!');
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|string|unique:inventories,barcode,' . $inventory->id,
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'supplier' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $inventory, $request): void {
            $stockBefore = (int) $inventory->stock;
            $stockAfter = (int) $validated['stock'];
            $stockChange = $stockAfter - $stockBefore;

            $inventory->update($validated + [
                'updated_by' => $request->user()?->id,
                'low_stock_threshold' => $validated['low_stock_threshold'] ?? 10,
                'status' => $stockAfter > 0 ? 'active' : 'inactive',
            ]);

            if ($stockChange !== 0) {
                StockMovement::create([
                    'inventory_id' => $inventory->id,
                    'reference_type' => Inventory::class,
                    'reference_id' => $inventory->id,
                    'movement_type' => $stockChange > 0 ? 'in' : 'out',
                    'quantity_before' => $stockBefore,
                    'quantity_change' => $stockChange,
                    'quantity_after' => $stockAfter,
                    'unit_price' => $inventory->price,
                    'total_amount' => (float) $inventory->price * abs($stockChange),
                    'tags' => ['inventory', 'manual-adjustment'],
                    'notes' => 'Stock adjusted from inventory edit',
                    'performed_by' => $request->user()?->id,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Inventory item updated successfully!');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->back()->with('success', 'Inventory item deleted!');
    }
}

