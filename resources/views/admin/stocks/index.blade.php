@extends('layouts.admin')
@section('title', 'Stocks')
@section('header', 'Gestion des Stocks')

@section('content')

{{-- Résumé rapide --}}
@php
    $total   = $burgers->count();
    $optimal = $burgers->where('stock_quantity', '>=', 10)->count();
    $faible  = $burgers->where('stock_quantity', '>', 0)->where('stock_quantity', '<', 10)->count();
    $rupture = $burgers->where('stock_quantity', 0)->count();
@endphp

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="rounded-xl p-4 flex items-center gap-3"
         style="background: var(--admin-card-bg, #fff); border: 1px solid var(--admin-card-border, #e5e7eb);">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: rgba(34,197,94,0.12);">
            <span class="material-symbols-outlined" style="color:#22c55e; font-size:1.25rem; font-variation-settings:'FILL' 1;">inventory_2</span>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-wider" style="color: var(--admin-text-muted, #6b7280);">Optimal (≥10)</p>
            <p class="text-2xl font-black" style="color: #22c55e; font-family: 'Barlow Condensed', sans-serif;">{{ $optimal }}</p>
        </div>
    </div>
    <div class="rounded-xl p-4 flex items-center gap-3"
         style="background: var(--admin-card-bg, #fff); border: 1px solid var(--admin-card-border, #e5e7eb);">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: rgba(245,158,11,0.12);">
            <span class="material-symbols-outlined" style="color:#f59e0b; font-size:1.25rem; font-variation-settings:'FILL' 1;">warning</span>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-wider" style="color: var(--admin-text-muted, #6b7280);">Faible (1–9)</p>
            <p class="text-2xl font-black" style="color: #f59e0b; font-family: 'Barlow Condensed', sans-serif;">{{ $faible }}</p>
        </div>
    </div>
    <div class="rounded-xl p-4 flex items-center gap-3"
         style="background: var(--admin-card-bg, #fff); border: 1px solid var(--admin-card-border, #e5e7eb);">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: rgba(239,68,68,0.12);">
            <span class="material-symbols-outlined" style="color:#ef4444; font-size:1.25rem; font-variation-settings:'FILL' 1;">remove_shopping_cart</span>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-wider" style="color: var(--admin-text-muted, #6b7280);">Rupture (0)</p>
            <p class="text-2xl font-black" style="color: #ef4444; font-family: 'Barlow Condensed', sans-serif;">{{ $rupture }}</p>
        </div>
    </div>
</div>

{{-- Légende des seuils --}}
<div class="rounded-xl px-5 py-3 mb-4 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-semibold"
     style="background: var(--admin-card-bg, #fff); border: 1px solid var(--admin-card-border, #e5e7eb); color: var(--admin-text-muted, #6b7280);">
    <span>Seuils automatiques :</span>
    <span class="flex items-center gap-1.5">
        <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
        <span style="color:#16a34a;">Optimal / Dispo</span> — ≥ 10 unités
    </span>
    <span class="flex items-center gap-1.5">
        <span style="width:8px;height:8px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>
        <span style="color:#d97706;">Faible / X restants</span> — 1 à 9 unités
    </span>
    <span class="flex items-center gap-1.5">
        <span style="width:8px;height:8px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
        <span style="color:#dc2626;">Rupture / Épuisé</span> — 0 unité (bouton désactivé côté kiosk)
    </span>
</div>

{{-- Table --}}
<div class="rounded-2xl overflow-hidden"
     style="background: var(--admin-card-bg, #fff); border: 1px solid var(--admin-card-border, #e5e7eb); box-shadow: 0 1px 6px rgba(0,0,0,0.06);">

    <div class="px-6 py-4 flex items-center justify-between border-b" style="border-color: var(--admin-card-border, #e5e7eb);">
        <div>
            <h3 class="font-bold text-base" style="color: var(--admin-text, #111827);">Inventaire des burgers</h3>
            <p class="text-xs mt-0.5" style="color: var(--admin-text-muted, #6b7280);">{{ $total }} article{{ $total > 1 ? 's' : '' }} — mise à jour manuelle</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr style="background: var(--admin-thead-bg, #f9fafb); border-bottom: 1px solid var(--admin-card-border, #e5e7eb);">
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Article</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Quantité actuelle</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Statut admin</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest" style="color: var(--admin-text-muted);">Affichage kiosk</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest text-right" style="color: var(--admin-text-muted);">Modifier le stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($burgers as $burger)
                @php
                    if ($burger->stock_quantity >= 10) {
                        $adminStatus = ['label' => 'Optimal',  'dot' => '#22c55e', 'bg' => 'rgba(34,197,94,0.1)',   'text' => '#16a34a'];
                        $kioskStatus = ['label' => 'Dispo',    'dot' => '#22c55e', 'bg' => 'rgba(34,197,94,0.1)',   'text' => '#16a34a', 'icon' => 'check_circle'];
                    } elseif ($burger->stock_quantity > 0) {
                        $adminStatus = ['label' => 'Faible',   'dot' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)', 'text' => '#d97706'];
                        $kioskStatus = ['label' => $burger->stock_quantity . ' restant' . ($burger->stock_quantity > 1 ? 's' : ''), 'dot' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)', 'text' => '#d97706', 'icon' => 'hourglass_bottom'];
                    } else {
                        $adminStatus = ['label' => 'Rupture',  'dot' => '#ef4444', 'bg' => 'rgba(239,68,68,0.1)',  'text' => '#dc2626'];
                        $kioskStatus = ['label' => 'Épuisé',   'dot' => '#ef4444', 'bg' => 'rgba(239,68,68,0.1)',  'text' => '#dc2626', 'icon' => 'block'];
                    }
                @endphp
                <tr style="border-bottom: 1px solid var(--admin-divide, #f3f4f6); transition: background 0.15s;"
                    onmouseover="this.style.background='var(--admin-row-hover, #f9fafb)'"
                    onmouseout="this.style.background=''">

                    {{-- Article --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-11 w-11 rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center"
                                 style="background: var(--admin-thead-bg, #f3f4f6); border: 1px solid var(--admin-card-border, #e5e7eb);">
                                @if($burger->image_path)
                                    <img src="{{ $burger->image_path }}" class="h-full w-full object-cover" alt="{{ $burger->name }}">
                                @else
                                    <span class="material-symbols-outlined" style="color: var(--admin-text-muted); font-size:1.25rem;">lunch_dining</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold" style="color: var(--admin-text, #111827);">{{ $burger->name }}</p>
                                @if($burger->category)
                                <p class="text-xs" style="color: var(--admin-text-muted, #6b7280);">{{ $burger->category }}</p>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Quantité + mini barre --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="font-black text-xl leading-none" style="font-family: 'Barlow Condensed', sans-serif; color: {{ $adminStatus['text'] }};">
                                {{ $burger->stock_quantity }}
                            </span>
                            <span class="text-xs font-semibold" style="color: var(--admin-text-muted, #6b7280);">unités</span>
                        </div>
                        @php $barWidth = min(100, $burger->stock_quantity >= 20 ? 100 : $burger->stock_quantity * 5); @endphp
                        <div class="w-24 rounded-full overflow-hidden" style="height:3px; background: var(--admin-border, #e5e7eb);">
                            <div class="h-full rounded-full" style="width: {{ $barWidth }}%; background: {{ $adminStatus['dot'] }};"></div>
                        </div>
                    </td>

                    {{-- Statut admin --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold"
                              style="background: {{ $adminStatus['bg'] }}; color: {{ $adminStatus['text'] }};">
                            <span style="width:6px;height:6px;border-radius:50%;background:{{ $adminStatus['dot'] }};display:inline-block;flex-shrink:0;"></span>
                            {{ $adminStatus['label'] }}
                        </span>
                    </td>

                    {{-- Affichage kiosk --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold"
                              style="background: {{ $kioskStatus['bg'] }}; color: {{ $kioskStatus['text'] }};">
                            <span class="material-symbols-outlined" style="font-size:13px; font-variation-settings:'FILL' 1;">{{ $kioskStatus['icon'] }}</span>
                            {{ $kioskStatus['label'] }}
                        </span>
                    </td>

                    {{-- Modifier --}}
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.stocks.update', $burger) }}" method="POST"
                              class="flex items-center justify-end gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="stock_quantity"
                                   value="{{ $burger->stock_quantity }}" min="0"
                                   class="w-20 px-3 py-2 rounded-xl text-sm font-bold text-center"
                                   style="background: var(--admin-thead-bg, #f3f4f6); border: 1.5px solid var(--admin-card-border, #e5e7eb); color: var(--admin-text, #111827); outline: none;"
                                   onfocus="this.style.borderColor='#e53e3e';"
                                   onblur="this.style.borderColor='var(--admin-card-border, #e5e7eb)';">
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition-all"
                                    style="background: rgba(229,62,62,0.1); color: #e53e3e; border: 1.5px solid rgba(229,62,62,0.2);"
                                    onmouseover="this.style.background='#e53e3e'; this.style.color='white';"
                                    onmouseout="this.style.background='rgba(229,62,62,0.1)'; this.style.color='#e53e3e';">
                                <span class="material-symbols-outlined" style="font-size:15px;">save</span>
                                Sauvegarder
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
