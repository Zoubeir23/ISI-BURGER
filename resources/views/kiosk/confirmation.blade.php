@extends('layouts.kiosk')

@section('title', 'Confirmation')
@section('subtitle', 'Commande confirmée !')

@section('content')
<div class="w-full max-w-[640px] flex flex-col items-center animate-fade-in-up">
    <!-- Celebratory Icon -->
    <div class="relative flex items-center justify-center mb-8">
        <div class="size-24 rounded-full bg-primary flex items-center justify-center shadow-[0_0_30px_rgba(190,59,45,0.4)]">
            <span class="material-symbols-outlined text-white text-6xl font-bold">check</span>
        </div>
    </div>
    <!-- Greeting -->
    <h1 class="text-white text-4xl md:text-[40px] font-bold text-center leading-tight mb-2">
        Commande Confirmée !
    </h1>
    <h2 class="text-secondary text-2xl font-bold text-center mb-10">
        Merci !
    </h2>
    <!-- Order Reference Card -->
    <div class="w-full bg-surface-dark rounded-xl border border-white/5 p-8 shadow-xl mb-8 relative overflow-hidden">
        @if(session('last_order_id'))
        <div class="flex flex-col items-center border-b border-white/10 pb-6 mb-6">
            <p class="text-slate-400 text-sm font-medium uppercase tracking-wider mb-2">Numéro de commande</p>
            <p class="text-white text-4xl font-black tracking-wider">#{{ session('last_order_id') }}</p>
        </div>
        @endif

        <div class="flex flex-col items-center border-b border-white/10 pb-6 mb-6">
            <p class="text-slate-400 text-sm font-medium uppercase tracking-wider mb-2">Statut</p>
            <p class="text-secondary text-3xl font-bold tracking-tight">EN ATTENTE</p>
        </div>

        <!-- Info Box -->
        <div class="w-full bg-secondary/10 border border-secondary/50 rounded-lg p-4 flex gap-4 items-start">
            <span class="material-symbols-outlined text-secondary mt-0.5">info</span>
            <p class="text-slate-200 text-sm leading-relaxed">
                <span class="font-bold text-secondary">Important :</span> Veuillez vous rendre au comptoir pour régler votre commande.
            </p>
        </div>
    </div>

    <!-- Bottom Action -->
    <a href="{{ route('kiosk.index') }}" class="group w-full md:w-auto px-8 py-4 rounded-lg border-2 border-primary text-primary hover:bg-primary hover:text-white transition-all duration-300 flex items-center justify-center gap-3 font-bold text-lg">
        <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
        Passer une nouvelle commande
    </a>
</div>
@endsection
