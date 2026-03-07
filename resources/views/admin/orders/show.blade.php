@extends('layouts.admin')
@section('title', 'Détail Commande #' . $order->id)
@section('header', 'Détail Commande')

@php
$statusLabels = [
    'pending'   => ['label' => 'En attente',    'class' => 'bg-orange-100 text-orange-800'],
    'preparing' => ['label' => 'En préparation','class' => 'bg-yellow-100 text-yellow-800'],
    'ready'     => ['label' => 'Prête',         'class' => 'bg-green-100 text-green-800'],
    'paid'      => ['label' => 'Payée',         'class' => 'bg-blue-100 text-blue-800'],
    'delivered' => ['label' => 'Livrée',        'class' => 'bg-purple-100 text-purple-800'],
    'cancelled' => ['label' => 'Annulée',       'class' => 'bg-red-100 text-red-800'],
];
$statusOptions = [
    'pending'   => 'En attente',
    'preparing' => 'En préparation',
    'ready'     => 'Prête',
    'paid'      => 'Payée',
    'delivered' => 'Livrée',
    'cancelled' => 'Annulée',
];
$badge = $statusLabels[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100 text-gray-800'];
@endphp

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-primary flex items-center gap-1">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Retour aux commandes
    </a>
</div>

<div class="flex flex-col md:flex-row gap-6">
    <!-- Articles -->
    <div class="flex-1 bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-900">Articles de la commande</h3>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badge['class'] }}">
                {{ $badge['label'] }}
            </span>
        </div>
        <div class="space-y-4">
            @foreach($order->orderItems as $item)
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 last:border-0">
                <div class="flex gap-4">
                    <span class="font-bold text-gray-500">{{ $item->quantity }}x</span>
                    <div>
                        <p class="font-medium text-slate-900">{{ $item->burger->name }}</p>
                        <p class="text-sm text-gray-500">{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA / u</p>
                    </div>
                </div>
                <span class="font-bold text-slate-900">{{ number_format($item->quantity * $item->unit_price, 0, ',', ' ') }} FCFA</span>
            </div>
            @endforeach
        </div>
        <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center">
            <span class="text-lg font-bold text-slate-900">Total</span>
            <span class="text-2xl font-bold text-primary">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="w-full md:w-96 space-y-6">
        <!-- Client -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-slate-900 mb-4">Client</h3>
            <div class="flex items-center gap-4">
                <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary text-sm">
                    {{ strtoupper(substr($order->client_name, 0, 2)) }}
                </div>
                <div>
                    <p class="font-medium text-slate-900">{{ $order->client_name }}</p>
                    <p class="text-sm text-gray-500">{{ $order->client_phone }}</p>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-400">
                Commandé le {{ $order->created_at->format('d/m/Y à H:i') }}
            </div>
        </div>

        <!-- Statut -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-slate-900 mb-4">Modifier le statut</h3>
            @if($order->status !== 'cancelled')
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full rounded-lg border-gray-300 mb-4" onchange="this.form.submit()">
                    @foreach($statusOptions as $value => $label)
                    <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </form>
            @endif

            @if($order->status === 'ready' || ($order->status === 'paid' && $order->invoice_number))
            <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg text-sm mb-3">
                <div class="flex items-center gap-2 mb-1">
                    <span class="material-symbols-outlined text-[16px]">receipt</span>
                    <span class="font-semibold">Facture générée</span>
                </div>
                <span class="font-mono text-xs">{{ $order->invoice_number }}</span>
            </div>
            <a href="{{ route('admin.orders.invoice.download', $order) }}"
               class="flex items-center justify-center gap-2 w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Télécharger la facture PDF
            </a>
            @endif

            @if($order->status === 'cancelled')
            <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg text-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                    <span class="font-semibold">Commande annulée</span>
                </div>
                <p class="text-xs mt-1 text-red-500">Le stock a été restitué automatiquement.</p>
            </div>
            @endif
        </div>

        <!-- Annulation rapide (si pas encore annulée ni payée) -->
        @if(!in_array($order->status, ['cancelled', 'paid', 'delivered']))
        <div class="bg-white rounded-xl border border-red-200 p-6">
            <h3 class="font-bold text-red-700 mb-3">Annuler la commande</h3>
            <p class="text-sm text-gray-500 mb-4">Cette action restituera le stock des articles et ne peut pas être annulée.</p>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?');">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">cancel</span>
                    Annuler la commande
                </button>
            </form>
        </div>
        @endif

        <!-- Paiement -->
        @if(!$order->payment && $order->status !== 'cancelled')
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-slate-900 mb-4">Enregistrer le paiement</h3>
            <form action="{{ route('admin.orders.payment.store', $order) }}" method="POST">
                @csrf
                @if($errors->has('error'))
                <div class="mb-3 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                    {{ $errors->first('error') }}
                </div>
                @endif
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Montant reçu (Espèces)</label>
                    <input type="number" name="amount" value="{{ $order->total_amount }}"
                           class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary"
                           step="1" min="0">
                </div>
                <input type="hidden" name="payment_method" value="cash">
                <button type="submit" class="w-full bg-green-600 text-white py-2.5 rounded-lg hover:bg-green-700 font-medium flex items-center justify-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">payments</span>
                    Enregistrer le paiement
                </button>
            </form>
        </div>
        @elseif($order->payment)
        <div class="bg-white rounded-xl border border-blue-200 p-6">
            <h3 class="font-bold text-slate-900 mb-3">Paiement</h3>
            <div class="flex items-center gap-2 text-green-600 mb-2">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                <span class="font-semibold">Payée</span>
            </div>
            <div class="text-sm text-gray-500 space-y-1">
                <p>Montant : <span class="font-bold text-slate-900">{{ number_format($order->payment->amount, 0, ',', ' ') }} FCFA</span></p>
                <p>Mode : <span class="font-medium">Espèces</span></p>
                <p>Le : <span class="font-medium">{{ $order->payment->paid_at->format('d/m/Y à H:i') }}</span></p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
