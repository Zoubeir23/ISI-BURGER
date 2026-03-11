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
        background: rgba(229,62,62,0.08);
        border: 1px solid rgba(229,62,62,0.2);
        border-radius: 12px;
        transition: background 0.4s, border-color 0.4s;
    }
    html.light .confirm-info-box {
        background: rgba(229,62,62,0.06);
        border-color: rgba(229,62,62,0.25);
    }

    #status-badge { transition: background 0.4s, color 0.4s; }
    #status-dot   { transition: background 0.4s; }
</style>
@endpush

@section('content')
<div class="w-full max-w-[600px] mx-auto flex flex-col items-center">

    <!-- Icône succès -->
    <div class="relative flex items-center justify-center mb-8 anim-scale-in">
        <div class="absolute w-32 h-32 rounded-full" style="background: radial-gradient(circle, rgba(229,62,62,0.2), transparent 70%);"></div>
        <div class="size-24 rounded-full flex items-center justify-center relative"
             style="background: linear-gradient(135deg, #e53e3e, #c53030); box-shadow: 0 8px 32px rgba(229,62,62,0.45);">
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
            <p class="font-black tracking-wider" style="font-family: 'Barlow Condensed', sans-serif; font-size: 2rem; color: #e53e3e;">
                {{ session('last_order_number') ?? ('#' . session('last_order_id')) }}
            </p>
        </div>
        @endif

        <div class="flex items-center justify-between py-5 mb-5 confirm-divider">
            <span class="text-sm font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Statut</span>
            <span id="status-badge" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-bold"
                  style="background: rgba(245,158,11,0.12); color: #d97706;">
                <span id="status-dot" style="width:7px;height:7px;border-radius:50%;background:#f59e0b;display:inline-block;flex-shrink:0;"></span>
                <span id="status-label">En attente</span>
            </span>
        </div>

        <!-- Info box -->
        <div id="confirm-info-box" class="confirm-info-box p-4 flex gap-3 items-start">
            <span id="info-icon" class="material-symbols-outlined flex-shrink-0 mt-0.5" style="color: #e53e3e; font-size: 1.25rem;">store</span>
            <p id="info-text" class="text-sm leading-relaxed" style="color: var(--text-muted);">
                <span class="font-bold" style="color: var(--text);">Rendez-vous au comptoir</span> pour régler votre commande en espèces. Communiquez votre numéro de commande.
            </p>
        </div>
    </div>

    <!-- Action -->
    <a href="{{ route('kiosk.index', [], false) }}"
       class="group w-full flex items-center justify-center gap-3 py-4 px-8 rounded-2xl font-bold text-base transition-all duration-200 cursor-pointer anim-fade-up"
       style="animation-delay: 0.3s; background: #e53e3e; color: white; box-shadow: 0 6px 24px rgba(229,62,62,0.35);"
       onmouseover="this.style.background='#c53030'; this.style.boxShadow='0 8px 32px rgba(229,62,62,0.5)';"
       onmouseout="this.style.background='#e53e3e'; this.style.boxShadow='0 6px 24px rgba(229,62,62,0.35)';">
        <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
        Passer une nouvelle commande
    </a>

</div>
@endsection

@push('scripts')
@if(session('last_order_id'))
<script>
(function () {
    const orderId  = {{ session('last_order_id') }};
    const statusUrl = '{{ route('kiosk.order.status', ['id' => '__ID__']) }}'.replace('__ID__', orderId);

    const statusConfig = {
        pending:   { label: 'En attente',       dot: '#f59e0b', bg: 'rgba(245,158,11,0.12)',  color: '#d97706', icon: 'store',          infoHtml: '<span class="font-bold" style="color:var(--text)">Rendez-vous au comptoir</span> pour régler votre commande en espèces. Communiquez votre numéro de commande.', infoBg: 'rgba(229,62,62,0.08)', infoBorder: 'rgba(229,62,62,0.2)', infoIconColor: '#e53e3e' },
        preparing: { label: 'En préparation',   dot: '#3b82f6', bg: 'rgba(59,130,246,0.12)',   color: '#3b82f6', icon: 'skillet',        infoHtml: 'Votre commande est <span class="font-bold" style="color:var(--text)">en cours de préparation</span> en cuisine. Patientez quelques minutes.', infoBg: 'rgba(59,130,246,0.08)', infoBorder: 'rgba(59,130,246,0.2)', infoIconColor: '#3b82f6' },
        ready:     { label: 'Prête !',          dot: '#22c55e', bg: 'rgba(34,197,94,0.12)',    color: '#16a34a', icon: 'check_circle',   infoHtml: '🎉 <span class="font-bold" style="color:var(--text)">Votre commande est prête !</span> Rendez-vous au comptoir pour la récupérer.', infoBg: 'rgba(34,197,94,0.08)', infoBorder: 'rgba(34,197,94,0.2)', infoIconColor: '#22c55e' },
        paid:      { label: 'Payée',            dot: '#8b5cf6', bg: 'rgba(139,92,246,0.12)',   color: '#7c3aed', icon: 'payments',       infoHtml: '<span class="font-bold" style="color:var(--text)">Paiement confirmé.</span> Votre commande est prise en charge.', infoBg: 'rgba(139,92,246,0.08)', infoBorder: 'rgba(139,92,246,0.2)', infoIconColor: '#8b5cf6' },
        delivered: { label: 'Livrée',           dot: '#06b6d4', bg: 'rgba(6,182,212,0.12)',    color: '#0891b2', icon: 'emoji_food_beverage', infoHtml: '<span class="font-bold" style="color:var(--text)">Commande livrée.</span> Merci pour votre commande et à bientôt !', infoBg: 'rgba(6,182,212,0.08)', infoBorder: 'rgba(6,182,212,0.2)', infoIconColor: '#06b6d4' },
        cancelled: { label: 'Annulée',          dot: '#ef4444', bg: 'rgba(239,68,68,0.12)',    color: '#dc2626', icon: 'cancel',         infoHtml: '<span class="font-bold" style="color:var(--text)">Commande annulée.</span> Veuillez contacter le comptoir pour plus d\'informations.', infoBg: 'rgba(239,68,68,0.08)', infoBorder: 'rgba(239,68,68,0.2)', infoIconColor: '#ef4444' },
    };

    const terminalStatuses = ['delivered', 'cancelled'];
    let currentStatus = 'pending';
    let intervalId = null;

    function applyStatus(status) {
        if (status === currentStatus) return;
        currentStatus = status;

        const cfg = statusConfig[status] || statusConfig.pending;

        document.getElementById('status-label').textContent = cfg.label;
        document.getElementById('status-dot').style.background = cfg.dot;

        const badge = document.getElementById('status-badge');
        badge.style.background = cfg.bg;
        badge.style.color = cfg.color;

        const box = document.getElementById('confirm-info-box');
        box.style.background = cfg.infoBg;
        box.style.borderColor = cfg.infoBorder;

        document.getElementById('info-icon').textContent = cfg.icon;
        document.getElementById('info-icon').style.color = cfg.infoIconColor;
        document.getElementById('info-text').innerHTML = cfg.infoHtml;

        if (terminalStatuses.includes(status) && intervalId) {
            clearInterval(intervalId);
            intervalId = null;
        }
    }

    function poll() {
        fetch(statusUrl)
            .then(r => r.json())
            .then(data => { if (data.status) applyStatus(data.status); })
            .catch(() => {});
    }

    // Poll every 5 seconds
    intervalId = setInterval(poll, 5000);
    poll(); // immediate first check
})();
</script>
@endif
@endpush
