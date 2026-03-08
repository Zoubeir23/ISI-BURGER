@extends('layouts.admin')
@section('title', 'Commande ' . ($order->order_number ?? '#' . $order->id))
@section('header', 'Commande ' . ($order->order_number ?? '#' . $order->id))

@php
$statusConfig = [
    'pending'   => ['label' => 'En attente',    'dot' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)',  'text' => '#d97706'],
    'preparing' => ['label' => 'En préparation','dot' => '#3b82f6', 'bg' => 'rgba(59,130,246,0.1)',  'text' => '#2563eb'],
    'ready'     => ['label' => 'Prête',         'dot' => '#22c55e', 'bg' => 'rgba(34,197,94,0.1)',   'text' => '#16a34a'],
    'paid'      => ['label' => 'Payée',         'dot' => '#8b5cf6', 'bg' => 'rgba(139,92,246,0.1)',  'text' => '#7c3aed'],
    'delivered' => ['label' => 'Livrée',        'dot' => '#06b6d4', 'bg' => 'rgba(6,182,212,0.1)',   'text' => '#0891b2'],
    'cancelled' => ['label' => 'Annulée',       'dot' => '#ef4444', 'bg' => 'rgba(239,68,68,0.1)',   'text' => '#dc2626'],
];
$statusOptions = [
    'pending'   => 'En attente',
    'preparing' => 'En préparation',
    'ready'     => 'Prête',
    'paid'      => 'Payée',
    'delivered' => 'Livrée',
    'cancelled' => 'Annulée',
];
$badge = $statusConfig[$order->status] ?? ['label' => $order->status, 'dot' => '#9ca3af', 'bg' => 'rgba(156,163,175,0.1)', 'text' => '#6b7280'];
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
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold"
                  style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }};">
                <span style="width:6px;height:6px;border-radius:50%;background:{{ $badge['dot'] }};display:inline-block;flex-shrink:0;"></span>
                {{ $badge['label'] }}
            </span>
        </div>
        <div class="space-y-4">
            @foreach($order->orderItems as $item)
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 last:border-0">
                <div class="flex gap-4">
                    <span class="font-bold text-gray-500">{{ $item->quantity }}x</span>
                    <div>
                        <p class="font-medium text-slate-900">
                            {{ $item->burger?->name ?? '(Burger supprimé)' }}
                        </p>
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
            <form id="status-update-form" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" id="status-hidden-input" value="{{ $order->status }}">
                <select id="status-select" class="w-full rounded-lg mb-4"
                        style="background: var(--admin-card-bg, #fff); border: 1px solid var(--admin-border, #e5e7eb); color: var(--admin-text, #111827); padding: 8px 12px; font-size: 0.875rem;"
                        onchange="handleStatusChange(this)">
                    @foreach($statusOptions as $value => $label)
                    <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </form>

            {{-- Modale confirmation changement vers "Annulée" via select --}}
            <div id="status-cancel-modal"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 style="display:none; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
                <div class="w-full max-w-sm rounded-2xl shadow-2xl p-6 flex flex-col gap-4"
                     style="background:var(--admin-card-bg,#fff); border:1px solid var(--admin-card-border,#e5e7eb);">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background:rgba(239,68,68,0.12);">
                            <span class="material-symbols-outlined" style="color:#ef4444;font-size:1.375rem;font-variation-settings:'FILL' 1;">cancel</span>
                        </div>
                        <div>
                            <p class="font-bold text-base" style="color:var(--admin-text,#111827);">Annuler la commande&nbsp;?</p>
                            <p class="text-sm mt-1" style="color:var(--admin-text-muted,#6b7280);">Le stock des articles sera restitué automatiquement. Cette action est irréversible.</p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-1">
                        <button type="button" onclick="closeStatusCancelModal()"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold border transition cursor-pointer"
                            style="border-color:var(--admin-border,#e5e7eb);color:var(--admin-text-muted,#6b7280);"
                            onmouseover="this.style.background='var(--admin-content-bg,#f1f5f9)'" onmouseout="this.style.background=''">Retour</button>
                        <button type="button" onclick="confirmStatusCancel()"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold text-white transition shadow-lg cursor-pointer"
                            style="background:#ef4444;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                            Oui, annuler
                        </button>
                    </div>
                </div>
            </div>
            <script>
            function handleStatusChange(select) {
                if (select.value === 'cancelled') {
                    document.getElementById('status-cancel-modal').style.display = 'flex';
                } else {
                    document.getElementById('status-hidden-input').value = select.value;
                    document.getElementById('status-update-form').submit();
                }
            }
            function closeStatusCancelModal() {
                document.getElementById('status-cancel-modal').style.display = 'none';
                document.getElementById('status-select').value = '{{ $order->status }}';
            }
            function confirmStatusCancel() {
                document.getElementById('status-hidden-input').value = 'cancelled';
                document.getElementById('status-update-form').submit();
            }
            document.getElementById('status-cancel-modal').addEventListener('click', function(e) {
                if (e.target === this) closeStatusCancelModal();
            });
            </script>
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
                      id="cancel-order-form">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <button type="button" onclick="document.getElementById('cancel-order-modal').style.display='flex'"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">cancel</span>
                    Annuler la commande
                </button>
            </form>

            {{-- Modale confirmation annulation --}}
            <div id="cancel-order-modal"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 style="display:none; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
                <div class="w-full max-w-sm rounded-2xl shadow-2xl p-6 flex flex-col gap-4"
                     style="background:var(--admin-card-bg,#fff); border:1px solid var(--admin-card-border,#e5e7eb);">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background:rgba(239,68,68,0.12);">
                            <span class="material-symbols-outlined" style="color:#ef4444;font-size:1.375rem;font-variation-settings:'FILL' 1;">cancel</span>
                        </div>
                        <div>
                            <p class="font-bold text-base" style="color:var(--admin-text,#111827);">Annuler la commande&nbsp;?</p>
                            <p class="text-sm mt-1" style="color:var(--admin-text-muted,#6b7280);">Le stock des articles sera restitué automatiquement. Cette action est irréversible.</p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-1">
                        <button type="button" onclick="document.getElementById('cancel-order-modal').style.display='none'"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold border transition"
                            style="border-color:var(--admin-border,#e5e7eb);color:var(--admin-text-muted,#6b7280);"
                            onmouseover="this.style.background='var(--admin-content-bg,#f1f5f9)'" onmouseout="this.style.background=''">Retour</button>
                        <button type="button" onclick="document.getElementById('cancel-order-form').submit()"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold text-white transition shadow-lg"
                            style="background:#ef4444;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                            Oui, annuler
                        </button>
                    </div>
                </div>
            </div>
            <script>
            document.getElementById('cancel-order-modal').addEventListener('click', function(e) {
                if (e.target === this) this.style.display = 'none';
            });
            </script>
        </div>
        @endif

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
                    <label class="block text-sm font-medium mb-1" style="color: var(--admin-text, #111827);">Montant reçu (Espèces)</label>
                    <input type="number" name="amount" value="{{ $order->total_amount }}"
                           style="width:100%; padding: 9px 12px; border-radius: 8px; border: 1px solid var(--admin-border, #e5e7eb); background: var(--admin-card-bg, #fff); color: var(--admin-text, #111827); font-size: 0.875rem;"
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

{{-- Bouton archiver (si état terminal) --}}
@php $archivable = in_array($order->status, ['delivered', 'paid', 'cancelled']); @endphp
@if(!$order->is_archived)
<div class="mt-6">
    <form id="archive-order-form" action="{{ route('admin.orders.archive', $order) }}" method="POST">
        @csrf @method('PATCH')
    </form>
    <button type="button" onclick="openArchiveOrderModal()"
        class="flex items-center gap-2 text-sm font-medium transition {{ $archivable ? 'text-orange-600 hover:text-orange-800' : 'text-gray-400 cursor-not-allowed' }}"
        {{ !$archivable ? 'disabled title="Seules les commandes livrées, payées ou annulées peuvent être archivées."' : '' }}>
        <span class="material-symbols-outlined text-base">archive</span>
        Archiver cette commande
    </button>
</div>

@if($archivable)
<div id="archive-order-modal"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="display:none; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
    <div class="w-full max-w-sm rounded-2xl shadow-2xl p-6 flex flex-col gap-4"
         style="background:var(--admin-card-bg,#fff); border:1px solid var(--admin-card-border,#e5e7eb);">
        <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(245,158,11,0.12);">
                <span class="material-symbols-outlined" style="color:#f59e0b;font-size:1.375rem;font-variation-settings:'FILL' 1;">archive</span>
            </div>
            <div>
                <p class="font-bold text-base" style="color:var(--admin-text,#111827);">Archiver cette commande&nbsp;?</p>
                <p class="text-sm mt-1" style="color:var(--admin-text-muted,#6b7280);">
                    La commande sera masquée de la liste principale mais conservée dans l’historique. Vous pourrez la restaurer ou la supprimer depuis l’onglet Archivées.
                </p>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-1">
            <button type="button" onclick="document.getElementById('archive-order-modal').style.display='none'"
                class="px-5 py-2.5 rounded-xl text-sm font-semibold border transition"
                style="border-color:var(--admin-border,#e5e7eb);color:var(--admin-text-muted,#6b7280);"
                onmouseover="this.style.background='var(--admin-content-bg,#f1f5f9)'" onmouseout="this.style.background=''">Annuler</button>
            <button type="button" onclick="document.getElementById('archive-order-form').submit()"
                class="px-5 py-2.5 rounded-xl text-sm font-bold text-white transition shadow-lg"
                style="background:#f59e0b;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
                Oui, archiver
            </button>
        </div>
    </div>
</div>
<script>
function openArchiveOrderModal() {
    document.getElementById('archive-order-modal').style.display = 'flex';
}
document.getElementById('archive-order-modal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endif
@endif
@endsection
