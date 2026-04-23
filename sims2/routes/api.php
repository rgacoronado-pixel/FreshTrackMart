<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Inventory;

Route::get('/inventory/search', function (Request $request) {
    $barcode = $request->query('barcode');
    $inventory = Inventory::where('barcode', $barcode)->orWhere('name', 'like', '%' . $barcode . '%')->first();

    if ($inventory) {
        return response()->json([
            'id' => $inventory->id,
            'name' => $inventory->name,
            'price' => $inventory->price,
            'stock' => $inventory->stock,
        ]);
    }

    return response()->json(['error' => 'Item not found'], 404);
})->name('api.inventory.search');

