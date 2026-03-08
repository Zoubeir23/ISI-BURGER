@extends('layouts.admin')
@section('title', 'Commandes')
@section('header', 'Commandes')

@php
$statusConfig = [
    'pending'   => ['label' => 'En attente',    'dot' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)',  'text' => '#d97706'],
    'preparing' => ['label' => 'En préparation','dot' => '#3b82f6', 'bg' => 'rgba(59,130,246,0.1)',  'text' => '#2563eb'],
    'ready'     => ['label' => 'Prête',         'dot' => '#22c55e', 'bg' => 'rgba(34,197,94,0.1)',   'text' => '#16a34a'],
    'paid'      => ['label' => 'Payée',         'dot' => '#8b5cf6', 'bg' => 'rgba(139,92,246,0.1)',  'text' => '#7c3aed'],
    'delivered' => ['label' => 'Livrée',        'dot' => '#06b6d4', 'bg' => 'rgba(6,182,212,0.1)',   'text' => '#0891b2'],
    'cancelled' => ['label' => 'Annulée',       'dot' => '#ef4444', 'bg' => 'rgba(239,68,68,0.1)',   'text' => '#dc2626'],
];
@endphp

@section('content')

{{-- Onglets --}}
<div class="flex items-center gap-2 mb-6 border-b pb-3" style="border-color: var(--admin-border, #e5e7eb);">
    <a href="{{ route('admin.orders.index', ['filter' => 'active']) }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-semibold transition
        {{ $filter === 'active' ? 'bg-primary text-white shadow' : 'text-gray-500 hover:bg-gray-100' }}">
        <span class="material-symbols-outlined text-base">shopping_bag</span>
        Actives <span class="ml-1 text-xs opacity-80">({{ $activeCount }})</span>
    </a>
    <a href="{{ route('admin.orders.index', ['filter' => 'archived']) }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-semibold transition"
        style="{{ $filter === 'archived' ? 'background: var(--admin-text-muted, #6b7280); color: white; box-shadow: 0 1px 4px rgba(0,0,0,0.15);' : 'color: var(--admin-text-muted, #6b7280);' }}"
        @if($filter !== 'archived') onmouseover="this.style.background='var(--admin-content-bg, #f1f5f9)'" onmouseout="this.style.background=''" @endif>
        <span class="material-symbols-outlined text-base">archive</span>
        Archivées <span class="ml-1 text-xs opacity-80">({{ $archivedCount }})</span>
    </a>
</div>

<div class="rounded-2xl overflow-hidden" style="background: var(--admin-card-bg, #fff); border: 1px solid var(--admin-card-border, #e5e7eb); box-shadow: 0 1px 6px rgba(0,0,0,0.06);">

    <div class="px-6 py-4 flex items-center justify-between border-b" style="border-color: var(--admin-card-border, #e5e7eb);">
        <div>
            <h3 class="font-bold text-base" style="color: var(--admin-text, #111827);">{{ $filter === 'archived' ? 'Commandes archivées' : 'Commandes actives' }}</h3>
            <p class="text-xs mt-0.5" style="color: var(--admin-text-muted, #6b7280);">{{ $orders->total() }} commande(s)</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-[700px]">
            <thead>
                <tr style="background: var(--admin-thead-bg, #f9fafb); border-bottom: 1px solid var(--admin-card-border, #e5e7eb);">
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">#</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Client</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Téléphone</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Montant</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Statut</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Date</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php $s = $statusConfig[$order->status] ?? ['label' => $order->status, 'dot' => '#9ca3af', 'bg' => 'rgba(156,163,175,0.1)', 'text' => '#6b7280']; @endphp
                <tr style="border-bottom: 1px solid var(--admin-divide, #f3f4f6); transition: background 0.15s;"
                    onmouseover="this.style.background='var(--admin-row-hover, #f9fafb)'"
                    onmouseout="this.style.background=''">
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold font-mono" style="color: var(--admin-text-muted);">{{ $order->order_number ?? '#' . $order->id }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-white {{ $order->is_archived ? 'opacity-40' : '' }}" style="background: linear-gradient(135deg, #ff6b35, #e55a26);">
                                {{ strtoupper(substr($order->client_name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold" style="color: var(--admin-text);">{{ $order->client_name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm" style="color: var(--admin-text-muted);">{{ $order->client_phone }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-bold" style="color: var(--admin-text); font-family: 'Barlow Condensed', sans-serif; font-size: 1rem; font-weight: 900; letter-spacing:-0.01em;">
                            {{ number_format($order->total_amount, 0, ',', ' ') }} <span style="font-size:0.75rem;font-weight:600;">FCFA</span>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold" style="background: {{ $s['bg'] }}; color: {{ $s['text'] }};">
                            <span style="width:6px;height:6px;border-radius:50%;background:{{ $s['dot'] }};display:inline-block;flex-shrink:0;"></span>
                            {{ $s['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs" style="color: var(--admin-text-muted);">{{ $order->created_at->format('d/m/Y') }}</span><br>
                        <span class="text-xs font-semibold" style="color: var(--admin-text-dim);">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 flex-wrap">
                            @if($order->is_archived)
                                {{-- Restaurer --}}
                                <form action="{{ route('admin.orders.restore', $order) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-lg transition-all"
                                        style="background: rgba(34,197,94,0.1); color: #16a34a;"
                                        onmouseover="this.style.background='#22c55e';this.style.color='white';"
                                        onmouseout="this.style.background='rgba(34,197,94,0.1)';this.style.color='#16a34a';">
                                        <span class="material-symbols-outlined text-[14px]">unarchive</span>
                                        Restaurer
                                    </button>
                                </form>
                                {{-- Supprimer définitivement --}}
                                <form id="del-order-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                </form>
                                <button type="button"
                                    onclick="openOrderDeleteModal('del-order-{{ $order->id }}', '{{ addslashes($order->order_number ?? '#' . $order->id) }}')"
                                    class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-lg transition-all"
                                    style="background: rgba(239,68,68,0.1); color: #ef4444;"
                                    onmouseover="this.style.background='#ef4444';this.style.color='white';"
                                    onmouseout="this.style.background='rgba(239,68,68,0.1)';this.style.color='#ef4444';">
                                    <span class="material-symbols-outlined text-[14px]">delete_forever</span>
                                    Supprimer
                                </button>
                            @else
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-lg transition-all"
                                   style="background: rgba(255,107,53,0.1); color: #ff6b35;"
                                   onmouseover="this.style.background='#ff6b35';this.style.color='white';"
                                   onmouseout="this.style.background='rgba(255,107,53,0.1)';this.style.color='#ff6b35';">
                                    <span class="material-symbols-outlined text-[14px]">visibility</span>
                                    Voir
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <span class="material-symbols-outlined text-5xl" style="color: var(--admin-text-dim);">{{ $filter === 'archived' ? 'archive' : 'inbox' }}</span>
                            <p class="font-semibold" style="color: var(--admin-text-muted);">{{ $filter === 'archived' ? 'Aucune commande archivée' : 'Aucune commande pour l\'instant' }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="px-6 py-4 border-t" style="border-color: var(--admin-card-border, #e5e7eb);">
        {{ $orders->links() }}
    </div>
    @endif
</div>

{{-- Modale confirmation suppression --}}
<div id="order-delete-modal"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="display:none; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
    <div class="w-full max-w-sm rounded-2xl shadow-2xl p-6 flex flex-col gap-4"
         style="background:var(--admin-card-bg,#fff); border:1px solid var(--admin-card-border,#e5e7eb);">
        <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(239,68,68,0.12);">
                <span class="material-symbols-outlined" style="color:#ef4444;font-size:1.375rem;font-variation-settings:'FILL' 1;">delete_forever</span>
            </div>
            <div>
                <p class="font-bold text-base" style="color:var(--admin-text,#111827);">Supprimer définitivement&nbsp;?</p>
                <p class="text-sm mt-1" style="color:var(--admin-text-muted,#6b7280);">
                    La commande <strong id="order-delete-num" style="color:var(--admin-text,#111827);"></strong> et toutes ses données seront supprimées. Cette action est irréversible.
                </p>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-1">
            <button type="button" onclick="closeOrderDeleteModal()"
                class="px-5 py-2.5 rounded-xl text-sm font-semibold border transition"
                style="border-color:var(--admin-border,#e5e7eb);color:var(--admin-text-muted,#6b7280);"
                onmouseover="this.style.background='var(--admin-content-bg,#f1f5f9)'"
                onmouseout="this.style.background=''">Annuler</button>
            <button type="button" id="order-delete-confirm"
                class="px-5 py-2.5 rounded-xl text-sm font-bold text-white transition shadow-lg"
                style="background:#ef4444;"
                onmouseover="this.style.background='#dc2626'"
                onmouseout="this.style.background='#ef4444'">Oui, supprimer</button>
        </div>
    </div>
</div>

<script>
let _orderDelFormId = null;
function openOrderDeleteModal(formId, num) {
    _orderDelFormId = formId;
    document.getElementById('order-delete-num').textContent = num;
    document.getElementById('order-delete-confirm').onclick = function() {
        document.getElementById(_orderDelFormId).submit();
    };
    document.getElementById('order-delete-modal').style.display = 'flex';
}
function closeOrderDeleteModal() {
    document.getElementById('order-delete-modal').style.display = 'none';
}
document.getElementById('order-delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeOrderDeleteModal();
});
</script>
@endsection
