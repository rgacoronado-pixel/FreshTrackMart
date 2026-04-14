<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Inventory::all();
        return view('admin.inventory', compact('items'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'supplier' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Inventory::create([
            'name' => $request->name,
            'category' => $request->category,
            'stock' => $request->stock,
            'price' => $request->price,
            'description' => $request->description,
            'supplier' => $request->supplier,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Inventory item added successfully!');
    }
}
