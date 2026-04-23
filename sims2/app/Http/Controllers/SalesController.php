<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalesController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'transaction_type' => 'required|in:sale,exchange',
            'quantity' => 'required|integer|min:1',
            'paid_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $sale = DB::transaction(function () use ($validated, $request): Sale {
            $inventory = Inventory::lockForUpdate()->findOrFail($validated['inventory_id']);
            $quantity = (int) $validated['quantity'];
            $unitPrice = (float) $inventory->price;
            $subtotal = round($unitPrice * $quantity, 2);
            $totalAmount = $subtotal;
            $paidAmount = (float) $validated['paid_amount'];

            if ($paidAmount < $totalAmount) {
                throw ValidationException::withMessages([
                    'paid_amount' => 'Paid amount is insufficient for this transaction.',
                ]);
            }

            $before = (int) $inventory->stock;
            $after = $before - $quantity;
            if ($after < 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'Not enough stock for this sale/exchange transaction.',
                ]);
            }

            $sale = Sale::create([
                'sale_number' => $this->nextSaleNumber(),
                'transaction_type' => $validated['transaction_type'],
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'change_amount' => round($paidAmount - $totalAmount, 2),
                'sold_at' => now(),
                'created_by' => $request->user()?->id,
                'notes' => $validated['notes'] ?? null,
            ]);

            $tags = $this->buildTags($inventory, $validated['transaction_type']);

            SaleItem::create([
                'sale_id' => $sale->id,
                'inventory_id' => $inventory->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'tags' => $tags,
                'line_total' => $totalAmount,
            ]);

            $inventory->stock = $after;
            $inventory->status = $after > 0 ? 'active' : 'inactive';
            $inventory->save();

            StockMovement::create([
                'inventory_id' => $inventory->id,
                'reference_type' => Sale::class,
                'reference_id' => $sale->id,
                'movement_type' => 'out',
                'quantity_before' => $before,
                'quantity_change' => -$quantity,
                'quantity_after' => $after,
                'unit_price' => $unitPrice,
                'total_amount' => $totalAmount,
                'tags' => $tags,
                'notes' => 'Stock deducted due to '.strtoupper($validated['transaction_type']).' '.$sale->sale_number,
                'performed_by' => $request->user()?->id,
            ]);

            Invoice::create([
                'sale_id' => $sale->id,
                'invoice_number' => $this->nextInvoiceNumber(),
                'receipt_number' => $this->nextReceiptNumber(),
                'issued_at' => now(),
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'change_amount' => round($paidAmount - $totalAmount, 2),
                'payload' => [
                    'inventory_name' => $inventory->name,
                    'category' => $inventory->category_label,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'tags' => $tags,
                    'transaction_type' => $validated['transaction_type'],
                ],
            ]);

            return $sale;
        });

        return redirect()->route('receipt.show', $sale)->with('success', 'Payment completed. Receipt and invoice generated.');
    }

    public function showReceipt(Sale $sale)
    {
        $sale->load(['items.inventory', 'invoice']);

        return view('admin.receipt', [
            'sale' => $sale,
            'invoice' => $sale->invoice,
        ]);
    }

    private function buildTags(Inventory $inventory, string $transactionType): array
    {
        $tags = [
            strtolower($transactionType),
            strtolower($inventory->category_label),
            'fresh-goods',
        ];

        if ($inventory->stock <= 20) {
            $tags[] = 'low-stock-risk';
        }

        return $tags;
    }

    private function nextSaleNumber(): string
    {
        $latest = Sale::query()->latest('id')->value('id') ?? 0;
        return sprintf('SL-%s-%05d', now()->format('Ymd'), $latest + 1);
    }

    private function nextInvoiceNumber(): string
    {
        $latest = Invoice::query()->latest('id')->value('id') ?? 0;
        return sprintf('INV-%s-%05d', now()->format('Ymd'), $latest + 1);
    }

    private function nextReceiptNumber(): string
    {
        $latest = Invoice::query()->latest('id')->value('id') ?? 0;
        return sprintf('RCP-%s-%05d', now()->format('Ymd'), $latest + 1);
    }
}
