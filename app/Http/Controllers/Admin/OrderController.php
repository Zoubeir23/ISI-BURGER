<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderDelivered;
use App\Mail\OrderPaid;
use App\Mail\OrderReady;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'active');
        $activeCount   = Order::where('is_archived', false)->count();
        $archivedCount = Order::where('is_archived', true)->count();

        $orders = Order::where('is_archived', $filter === 'archived')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'filter', 'activeCount', 'archivedCount'));
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
                Log::error('PDF Generation failed: ' . $e->getMessage());
            }

            // Envoyer l'email de notification "commande prête" au client
            if ($order->client_email) {
                try {
                    Mail::to($order->client_email)->send(new OrderReady($order));
                } catch (\Exception $e) {
                    Log::warning('Email commande prête non envoyé : ' . $e->getMessage());
                }
            }
        }

        // Envoyer un email de confirmation de paiement
        if ($newStatus === 'paid' && $order->client_email) {
            try {
                $order->loadMissing('orderItems.burger');
                Mail::to($order->client_email)->send(new OrderPaid($order));
            } catch (\Exception $e) {
                Log::warning('Email commande payée non envoyé : ' . $e->getMessage());
            }
        }

        // Envoyer un email de confirmation de livraison
        if ($newStatus === 'delivered' && $order->client_email) {
            try {
                $order->loadMissing('orderItems.burger');
                Mail::to($order->client_email)->send(new OrderDelivered($order));
            } catch (\Exception $e) {
                Log::warning('Email commande livrée non envoyé : ' . $e->getMessage());
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

    public function archive(Order $order)
    {
        $activeStatuses = ['pending', 'preparing', 'ready'];
        if (in_array($order->status, $activeStatuses)) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Impossible d\'archiver une commande encore en cours (en attente, en préparation ou prête).');
        }
        $order->update(['is_archived' => true]);
        return redirect()->route('admin.orders.index')
            ->with('success', 'Commande ' . ($order->order_number ?? '#' . $order->id) . ' archivée.');
    }

    public function restore(Order $order)
    {
        $order->update(['is_archived' => false]);
        return redirect()->route('admin.orders.index', ['filter' => 'archived'])
            ->with('success', 'Commande ' . ($order->order_number ?? '#' . $order->id) . ' restaurée.');
    }

    public function destroy(Order $order)
    {
        if (!$order->is_archived) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Archivez d\'abord la commande avant de la supprimer définitivement.');
        }
        $num = $order->order_number ?? '#' . $order->id;
        $order->delete(); // cascade sur order_items et payments
        return redirect()->route('admin.orders.index', ['filter' => 'archived'])
            ->with('success', 'Commande ' . $num . ' supprimée définitivement.');
    }
}
