<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.burger', 'payment');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,preparing,ready,paid,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        // Restituer le stock si on annule une commande non encore annulée
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            $order->load('orderItems.burger');
            foreach ($order->orderItems as $item) {
                if ($item->burger) {
                    $item->burger->increment('stock_quantity', $item->quantity);
                }
            }
        }

        $order->update(['status' => $newStatus]);

        // Générer la facture PDF quand la commande passe à "prête"
        if ($newStatus === 'ready') {
            if (!$order->invoice_number) {
                $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
                $order->update(['invoice_number' => $invoiceNumber]);
            }

            $order->load('orderItems.burger');

            try {
                $pdf = Pdf::loadView('invoices.order', compact('order'));
                $path = 'public/invoices/' . $order->invoice_number . '.pdf';
                Storage::put($path, $pdf->output());
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('PDF Generation failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Statut mis à jour.');
    }

    public function downloadInvoice(Order $order)
    {
        if (!$order->invoice_number) {
            return redirect()->route('admin.orders.show', $order)->withErrors(['error' => 'Aucune facture disponible pour cette commande.']);
        }

        $path = 'public/invoices/' . $order->invoice_number . '.pdf';

        // Régénérer si le fichier n'existe pas
        if (!Storage::exists($path)) {
            $order->load('orderItems.burger');
            try {
                $pdf = Pdf::loadView('invoices.order', compact('order'));
                Storage::put($path, $pdf->output());
            } catch (\Exception $e) {
                return redirect()->route('admin.orders.show', $order)->withErrors(['error' => 'Erreur lors de la génération de la facture.']);
            }
        }

        return response()->download(Storage::path($path), $order->invoice_number . '.pdf');
    }
}
