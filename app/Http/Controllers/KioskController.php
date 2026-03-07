<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KioskController extends Controller
{
    public function index()
    {
        $burgers = Burger::where('is_archived', false)
            ->get(); // Showing all, but maybe disable "Add" if stock is 0 in UI
        return view('kiosk.index', compact('burgers'));
    }

    public function checkout()
    {
        return view('kiosk.checkout');
    }

    public function confirmation()
    {
        return view('kiosk.confirmation');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:burgers,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $burger = Burger::lockForUpdate()->find($item['id']);

                if ($burger->stock_quantity < $item['quantity']) {
                    throw new \Exception("Stock insuffisant pour " . $burger->name);
                }

                $burger->decrement('stock_quantity', $item['quantity']);

                $totalAmount += $burger->price * $item['quantity'];
                $itemsData[] = [
                    'burger_id' => $burger->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $burger->price,
                ];
            }

            $order = Order::create([
                'client_name' => $validated['client_name'],
                'client_phone' => $validated['client_phone'],
                'status' => 'pending',
                'total_amount' => $totalAmount,
            ]);

            foreach ($itemsData as $data) {
                $order->orderItems()->create($data);
            }

            DB::commit();

            session(['last_order_id' => $order->id]);

            return response()->json(['success' => true, 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
