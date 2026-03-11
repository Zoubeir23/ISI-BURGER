<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Burger;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KioskController extends Controller
{
    public function index()
    {
        $burgers = Burger::where('is_archived', false)->get();
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

    public function orderStatus(int $id)
    {
        if (session('last_order_id') != $id) {
            abort(403);
        }

        $order = Order::findOrFail($id);

        $labels = [
            'pending'   => 'En attente',
            'preparing' => 'En préparation',
            'ready'     => 'Prête',
            'paid'      => 'Payée',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée',
        ];

        return response()->json([
            'status' => $order->status,
            'label'  => $labels[$order->status] ?? $order->status,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'  => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'nullable|email|max:255',
            'items'        => 'required|array',
            'items.*.id'   => 'required|exists:burgers,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $itemsData   = [];

            foreach ($validated['items'] as $item) {
                $burger = Burger::lockForUpdate()->find($item['id']);

                if ($burger->stock_quantity < $item['quantity']) {
                    throw new \Exception("Stock insuffisant pour " . $burger->name);
                }

                $burger->decrement('stock_quantity', $item['quantity']);

                $totalAmount += $burger->price * $item['quantity'];
                $itemsData[] = [
                    'burger_id'  => $burger->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $burger->price,
                ];
            }

            $year  = now()->year;
            $count = Order::whereYear('created_at', $year)->count() + 1;
            $orderNumber = 'ISI-BURGER-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'order_number' => $orderNumber,
                'client_name'  => $validated['client_name'],
                'client_phone' => $validated['client_phone'],
                'client_email' => $validated['client_email'] ?? null,
                'status'       => 'pending',
                'total_amount' => $totalAmount,
            ]);

            foreach ($itemsData as $data) {
                $order->orderItems()->create($data);
            }

            DB::commit();

            session([
                'last_order_id'     => $order->id,
                'last_order_number' => $order->order_number,
            ]);

            // Envoyer l'email de confirmation si une adresse est fournie
            if (!empty($validated['client_email'])) {
                try {
                    $order->load('orderItems.burger');
                    Mail::to($validated['client_email'])
                        ->send(new OrderConfirmation($order));
                } catch (\Exception $e) {
                    Log::warning('Email de confirmation non envoyé : ' . $e->getMessage());
                }
            }

            return response()->json(['success' => true, 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
