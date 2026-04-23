<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SpoilageLog;
use App\Models\StockMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StaffOperationsController extends Controller
{
    public function markSpoiled(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_code' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($validated, $request): void {
            $inventory = $this->resolveInventoryByCode($validated['item_code']);

            if (!$inventory) {
                throw ValidationException::withMessages([
                    'item_code' => 'Item code not found for spoilage tagging.',
                ]);
            }

            $lockedInventory = Inventory::lockForUpdate()->findOrFail($inventory->id);
            $qty = (int) $validated['quantity'];
            $stockBefore = (int) $lockedInventory->stock;
            $spoiledBefore = (int) $lockedInventory->spoiled_stock;

            if ($qty > $stockBefore) {
                throw ValidationException::withMessages([
                    'quantity' => 'Spoilage quantity exceeds available stock.',
                ]);
            }

            $stockAfter = $stockBefore - $qty;
            $spoiledAfter = $spoiledBefore + $qty;
            $reason = trim((string) ($validated['reason'] ?? ''));

            $lockedInventory->stock = $stockAfter;
            $lockedInventory->spoiled_stock = $spoiledAfter;
            $lockedInventory->status = $stockAfter > 0 ? 'active' : 'inactive';
            $lockedInventory->save();

            $spoilageLog = SpoilageLog::create([
                'inventory_id' => $lockedInventory->id,
                'quantity' => $qty,
                'reason' => $reason !== '' ? $reason : 'Marked as spoiled/bulok manually',
                'detected_at' => now(),
                'detected_by' => $request->user()?->id,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'spoiled_before' => $spoiledBefore,
                'spoiled_after' => $spoiledAfter,
                'status' => 'detected',
            ]);

            StockMovement::create([
                'inventory_id' => $lockedInventory->id,
                'reference_type' => SpoilageLog::class,
                'reference_id' => $spoilageLog->id,
                'movement_type' => 'out',
                'quantity_before' => $stockBefore,
                'quantity_change' => -$qty,
                'quantity_after' => $stockAfter,
                'unit_price' => $lockedInventory->price,
                'total_amount' => (float) $lockedInventory->price * $qty,
                'tags' => ['spoilage', 'bulok', strtolower($lockedInventory->category_label)],
                'notes' => 'Spoiled stock deducted from available inventory',
                'performed_by' => $request->user()?->id,
            ]);
        });

        return redirect()->back()->with('success', 'Spoiled items logged and deducted from available stock.');
    }

    public function scanLookup(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
        ]);

        $code = trim($validated['code']);
        $inventory = $this->resolveInventoryByCode($code);

        if (!$inventory) {
            return response()->json([
                'found' => false,
                'message' => 'Item not found for scanned code.',
            ], 404);
        }

        $latestMovement = StockMovement::where('inventory_id', $inventory->id)
            ->latest('created_at')
            ->first();

        return response()->json([
            'found' => true,
            'item' => [
                'id' => $inventory->id,
                'code' => $this->itemCode($inventory->id),
                'name' => $inventory->name,
                'category' => $inventory->category_label,
                'stock' => $inventory->stock,
                'price' => (float) $inventory->price,
                'status' => $inventory->status,
            ],
            'latest_movement' => $latestMovement ? [
                'type' => $latestMovement->movement_type,
                'change' => $latestMovement->quantity_change,
                'at' => $latestMovement->created_at?->toDateTimeString(),
                'notes' => $latestMovement->notes,
            ] : null,
        ]);
    }

    public function liveSnapshot(): JsonResponse
    {
        $queueCount = Sale::where('sold_at', '>=', now()->subMinutes(15))->count();
        $queueLevel = $queueCount >= 20 ? 'high' : ($queueCount >= 8 ? 'medium' : 'low');

        $recentStock = StockMovement::with('inventory')
            ->latest('created_at')
            ->limit(8)
            ->get()
            ->map(static function (StockMovement $movement): array {
                return [
                    'item' => $movement->inventory?->name ?? 'N/A',
                    'code' => $movement->inventory_id ? sprintf('ITM-%03d', $movement->inventory_id) : 'N/A',
                    'type' => $movement->movement_type,
                    'change' => $movement->quantity_change,
                    'after' => $movement->quantity_after,
                    'time' => $movement->created_at?->format('M d, h:i A'),
                ];
            })
            ->values();

        return response()->json([
            'queue' => [
                'count' => $queueCount,
                'level' => $queueLevel,
            ],
            'recent_stock' => $recentStock,
        ]);
    }

    public function refundOrVoid(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_code' => 'required|string|max:255',
            'action_type' => 'required|in:refund,void',
            'quantity' => 'nullable|integer|min:1',
            'reason' => 'nullable|string|max:1000',
            'spoilage_log_id' => 'nullable|exists:spoilage_logs,id',
        ]);

        DB::transaction(function () use ($validated, $request): void {
            $context = $this->resolveSaleContext($validated['item_code']);
            $saleItem = $context['saleItem'];
            $sale = $context['sale'];
            $inventory = $context['inventory'];

            if (!$saleItem || !$sale || !$inventory) {
                $message = $context['message'] ?? 'Unable to match item code to a valid sale record.';
                $suggestion = $context['suggestion'] ?? null;
                throw ValidationException::withMessages([
                    'item_code' => $suggestion ? $message.' '.$suggestion : $message,
                ]);
            }

            $lockedSaleItem = SaleItem::lockForUpdate()->findOrFail($saleItem->id);
            $lockedInventory = Inventory::lockForUpdate()->findOrFail($inventory->id);
            $lockedSale = Sale::lockForUpdate()->findOrFail($sale->id);

            $remainingQty = (int) $lockedSaleItem->quantity - (int) $lockedSaleItem->refunded_quantity;
            if ($remainingQty <= 0) {
                throw ValidationException::withMessages([
                    'item_code' => 'This sale item is already fully refunded/voided.',
                ]);
            }

            $actionType = $validated['action_type'];
            $qty = $actionType === 'void'
                ? $remainingQty
                : (int) ($validated['quantity'] ?? 0);

            if ($qty <= 0 || $qty > $remainingQty) {
                throw ValidationException::withMessages([
                    'quantity' => 'Invalid refund quantity. Remaining refundable qty: '.$remainingQty,
                ]);
            }

            $beforeStock = (int) $lockedInventory->stock;
            $afterStock = $beforeStock + $qty;
            $refundAmount = round((float) $lockedSaleItem->unit_price * $qty, 2);

            $lockedSaleItem->refunded_quantity = (int) $lockedSaleItem->refunded_quantity + $qty;
            $lockedSaleItem->save();

            $lockedInventory->stock = $afterStock;
            $lockedInventory->status = $afterStock > 0 ? 'active' : 'inactive';
            $lockedInventory->save();

            $lockedSale->subtotal = max(0, (float) $lockedSale->subtotal - $refundAmount);
            $lockedSale->total_amount = max(0, (float) $lockedSale->total_amount - $refundAmount);

            $reason = trim((string) ($validated['reason'] ?? ''));
            $noteLine = strtoupper($actionType).' processed by staff. Item: '.$lockedInventory->name.' Qty: '.$qty;
            if ($reason !== '') {
                $noteLine .= ' | Reason: '.$reason;
            }
            $lockedSale->notes = trim(((string) $lockedSale->notes).PHP_EOL.$noteLine);
            $lockedSale->save();

            StockMovement::create([
                'inventory_id' => $lockedInventory->id,
                'reference_type' => Sale::class,
                'reference_id' => $lockedSale->id,
                'movement_type' => 'in',
                'quantity_before' => $beforeStock,
                'quantity_change' => $qty,
                'quantity_after' => $afterStock,
                'unit_price' => $lockedSaleItem->unit_price,
                'total_amount' => $refundAmount,
                'tags' => ['staff', $actionType, 'scan'],
                'notes' => strtoupper($actionType).' for '.$lockedSale->sale_number.' by staff account',
                'performed_by' => $request->user()?->id,
            ]);

            if (!empty($validated['spoilage_log_id'])) {
                $spoilageLog = SpoilageLog::lockForUpdate()->find($validated['spoilage_log_id']);
                if ($spoilageLog && (int) $spoilageLog->inventory_id === (int) $lockedInventory->id) {
                    $spoilageLog->status = 'refunded';
                    $spoilageLog->refund_sale_id = $lockedSale->id;
                    $spoilageLog->refund_processed_at = now();
                    $spoilageLog->save();
                }
            }
        });

        return redirect()->route('staff.scan')->with('success', 'Refund/Void processed successfully and inventory/logs updated.');
    }

    private function resolveInventoryByCode(string $code): ?Inventory
    {
        $normalized = trim($code);

        if (preg_match('/^ITM-(\d{1,})$/i', $normalized, $matches)) {
            return Inventory::find((int) $matches[1]);
        }

        if (is_numeric($normalized)) {
            return Inventory::find((int) $normalized);
        }

        return Inventory::whereRaw('LOWER(name) = ?', [strtolower($normalized)])->first()
            ?? Inventory::where('name', 'like', '%'.$normalized.'%')->first();
    }

    private function resolveSaleContext(string $code): array
    {
        $normalized = trim($code);

        if (preg_match('/^SL-/i', $normalized)) {
            $sale = Sale::where('sale_number', $normalized)->latest('id')->first();
            if (!$sale) {
                return [
                    'saleItem' => null,
                    'sale' => null,
                    'inventory' => null,
                    'message' => 'Sale code not found.',
                    'suggestion' => 'Use a valid sale code (SL-...), invoice (INV-...), or receipt (RCP-...).',
                ];
            }

            $saleItem = $sale?->items()->latest('id')->first();
            $inventory = $saleItem?->inventory;
            if (!$saleItem || !$inventory) {
                return [
                    'saleItem' => null,
                    'sale' => $sale,
                    'inventory' => null,
                    'message' => 'Sale record found, but no refundable item is linked to it.',
                    'suggestion' => 'Try another SL code or use an item code with available refundable quantity.',
                ];
            }

            return [
                'saleItem' => $saleItem,
                'sale' => $sale,
                'inventory' => $inventory,
                'message' => null,
                'suggestion' => null,
            ];
        }

        if (preg_match('/^(INV-|RCP-)/i', $normalized)) {
            $invoice = Invoice::where('invoice_number', $normalized)
                ->orWhere('receipt_number', $normalized)
                ->first();

            if (!$invoice) {
                return [
                    'saleItem' => null,
                    'sale' => null,
                    'inventory' => null,
                    'message' => 'Invoice/Receipt code not found.',
                    'suggestion' => 'Use a valid INV/RCP code generated after payment.',
                ];
            }

            $sale = $invoice?->sale;
            $saleItem = $sale?->items()->latest('id')->first();
            $inventory = $saleItem?->inventory;
            if (!$sale || !$saleItem || !$inventory) {
                return [
                    'saleItem' => null,
                    'sale' => $sale,
                    'inventory' => null,
                    'message' => 'Invoice/Receipt found, but no refundable item was resolved.',
                    'suggestion' => 'Check if this transaction was already fully refunded/voided.',
                ];
            }

            return [
                'saleItem' => $saleItem,
                'sale' => $sale,
                'inventory' => $inventory,
                'message' => null,
                'suggestion' => null,
            ];
        }

        $inventory = $this->resolveInventoryByCode($normalized);
        if (!$inventory) {
            return [
                'saleItem' => null,
                'sale' => null,
                'inventory' => null,
                'message' => 'Item code not found.',
                'suggestion' => 'Scan/type a valid item code like ITM-001, or use SL/INV/RCP reference.',
            ];
        }

        $latestSaleItem = SaleItem::where('inventory_id', $inventory->id)
            ->latest('id')
            ->first();

        $saleItem = SaleItem::where('inventory_id', $inventory->id)
            ->whereRaw('quantity > refunded_quantity')
            ->latest('id')
            ->first();

        if (!$latestSaleItem) {
            return [
                'saleItem' => null,
                'sale' => null,
                'inventory' => $inventory,
                'message' => 'Item exists, but no sale record found yet for refund.',
                'suggestion' => 'Create a POS sale first, then use its SL/INV/RCP code for refund.',
            ];
        }

        if (!$saleItem) {
            $latestSale = $latestSaleItem->sale;
            return [
                'saleItem' => null,
                'sale' => $latestSale,
                'inventory' => $inventory,
                'message' => 'Item sale exists, but it appears fully refunded/voided already.',
                'suggestion' => $latestSale ? 'Latest sale reference: '.$latestSale->sale_number.'.' : null,
            ];
        }

        $sale = $saleItem?->sale;

        return [
            'saleItem' => $saleItem,
            'sale' => $sale,
            'inventory' => $inventory,
            'message' => null,
            'suggestion' => null,
        ];
    }

    private function itemCode(int $id): string
    {
        return sprintf('ITM-%03d', $id);
    }
}
