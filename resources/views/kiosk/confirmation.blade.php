@extends('layouts.kiosk')

@section('title', 'Confirmation')
@section('subtitle', 'Commande confirmée !')

@push('head')
<style>
    @keyframes scaleIn {
        from { transform: scale(0.5); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }
    @keyframes fadeUp {
        from { transform: translateY(24px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }
    .anim-scale-in { animation: scaleIn 0.5s cubic-bezier(0.22,1,0.36,1) both; }
    .anim-fade-up  { animation: fadeUp  0.55s cubic-bezier(0.22,1,0.36,1) both; }

    .confirm-card {
        background: var(--surface, #1c2333);
        border: 1px solid var(--border, rgba(255,255,255,0.07));
        border-radius: 20px;
    }
    .confirm-divider { border-top: 1px solid var(--border, rgba(255,255,255,0.07)); }
    html.light .confirm-card { background: #ffffff; border-color: #e5e7eb; box-shadow: 0 4px 24px rgba(0,0,0,0.07); }
    html.light .confirm-divider { border-color: #f3f4f6; }

    .confirm-info-box {
        background: rgba(255,107,53,0.08);
        border: 1px solid rgba(255,107,53,0.2);
        border-radius: 12px;
    }
    html.light .confirm-info-box {
        background: rgba(255,107,53,0.06);
        border-color: rgba(255,107,53,0.25);
    }
</style>
@endpush

@section('content')
<div class="w-full max-w-[600px] mx-auto flex flex-col items-center">

    <!-- Icône succès -->
    <div class="relative flex items-center justify-center mb-8 anim-scale-in">
        <div class="absolute w-32 h-32 rounded-full" style="background: radial-gradient(circle, rgba(255,107,53,0.2), transparent 70%);"></div>
        <div class="size-24 rounded-full flex items-center justify-center relative"
             style="background: linear-gradient(135deg, #ff6b35, #e55a26); box-shadow: 0 8px 32px rgba(255,107,53,0.45);">
            <span class="material-symbols-outlined text-white" style="font-size: 3rem; font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
    </div>

    <!-- Titre -->
    <div class="text-center mb-8 anim-fade-up" style="animation-delay: 0.1s;">
        <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-2" style="font-family: 'Playfair Display SC', serif; color: var(--text);">
            Confirmée !
        </h1>
        <p class="text-lg font-semibold" style="color: var(--text-muted);">Votre commande a bien été enregistrée</p>
    </div>

    <!-- Carte récapitulatif -->
    <div class="w-full confirm-card p-6 sm:p-8 mb-6 anim-fade-up" style="animation-delay: 0.2s;">

        @if(session('last_order_number') || session('last_order_id'))
        <div class="flex flex-col items-center pb-6 mb-6 confirm-divider" style="border-top: none; padding-top: 0;">
            <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color: var(--text-muted);">Numéro de commande</p>
            <p class="font-black tracking-wider" style="font-family: 'Barlow Condensed', sans-serif; font-size: 2rem; color: #ff6b35;">
                {{ session('last_order_number') ?? ('#' . session('last_order_id')) }}
            </p>
        </div>
        @endif

        <div class="flex items-center justify-between py-5 mb-5 confirm-divider">
            <span class="text-sm font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Statut</span>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-bold"
                  style="background: rgba(245,158,11,0.12); color: #d97706;">
                <span style="width:7px;height:7px;border-radius:50%;background:#f59e0b;display:inline-block;flex-shrink:0;"></span>
                En attente
            </span>
        </div>

        <!-- Info box -->
        <div class="confirm-info-box p-4 flex gap-3 items-start">
            <span class="material-symbols-outlined flex-shrink-0 mt-0.5" style="color: #ff6b35; font-size: 1.25rem;">store</span>
            <p class="text-sm leading-relaxed" style="color: var(--text-muted);">
                <span class="font-bold" style="color: var(--text);">Rendez-vous au comptoir</span> pour régler votre commande en espèces. Communiquez votre numéro de commande.
            </p>
        </div>
    </div>

    <!-- Action -->
    <a href="{{ route('kiosk.index', [], false) }}"
       class="group w-full flex items-center justify-center gap-3 py-4 px-8 rounded-2xl font-bold text-base transition-all duration-200 cursor-pointer anim-fade-up"
       style="animation-delay: 0.3s; background: #ff6b35; color: white; box-shadow: 0 6px 24px rgba(255,107,53,0.35);"
       onmouseover="this.style.background='#e55a26'; this.style.boxShadow='0 8px 32px rgba(255,107,53,0.5)';"
       onmouseout="this.style.background='#ff6b35'; this.style.boxShadow='0 6px 24px rgba(255,107,53,0.35)';">
        <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
        Passer une nouvelle commande
    </a>

</div>
@endsection
