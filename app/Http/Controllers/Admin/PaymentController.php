<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // Un paiement ne peut être enregistré qu'une seule et unique fois
        if ($order->payment()->exists()) {
            return redirect()->back()->withErrors(['error' => 'Un paiement a déjà été enregistré pour cette commande.']);
        }

        if ($order->status === 'cancelled') {
            return redirect()->back()->withErrors(['error' => 'Impossible d\'enregistrer un paiement pour une commande annulée.']);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $order->payment()->create([
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'paid_at' => now(),
            ]);

            $order->update(['status' => 'paid']);

            DB::commit();

            return redirect()->back()->with('success', 'Paiement enregistré avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Erreur lors de l\'enregistrement du paiement.']);
        }
    }
}
