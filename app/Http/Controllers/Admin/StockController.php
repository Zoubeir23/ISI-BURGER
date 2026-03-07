<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Burger;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $burgers = Burger::orderBy('stock_quantity', 'asc')->get();
        return view('admin.stocks.index', compact('burgers'));
    }

    public function update(Request $request, Burger $burger)
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $burger->update(['stock_quantity' => $validated['stock_quantity']]);
        return redirect()->back()->with('success', 'Stock updated.');
    }
}
