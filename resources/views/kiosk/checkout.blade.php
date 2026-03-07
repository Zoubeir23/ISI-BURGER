@extends('layouts.kiosk')

@section('title', 'Ma Commande')

@section('subtitle', 'Finaliser votre commande')

@section('content')
<div class="flex flex-col md:flex-row gap-8 w-full max-w-6xl">
    <!-- Left Column: Cart Items -->
    <div class="flex-1 flex flex-col gap-6">
        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-white mb-4">Récapitulatif</h2>
        <div id="cart-items-container" class="space-y-6">
            <!-- Items injected via JS -->
             <div class="text-center text-gray-400 py-10" id="empty-cart-msg">
                Votre panier est vide.
            </div>
        </div>
    </div>

    <!-- Right Column: Form -->
    <aside class="w-full md:w-[450px] bg-[#FFFDF9] text-slate-900 rounded-xl shadow-2xl overflow-hidden">
        <div class="p-8 flex flex-col h-full">
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">receipt_long</span>
                    Total
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <span class="text-xl font-bold text-slate-900">Total à payer</span>
                        <span class="text-3xl font-extrabold text-primary" id="checkout-total">0 FCFA</span>
                    </div>
                </div>
            </div>

            <form id="checkout-form" class="flex-1 flex flex-col space-y-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 ml-1" for="client_name">Nom complet</label>
                    <input class="w-full h-14 pl-4 pr-4 bg-white border-2 border-slate-200 rounded-lg text-lg focus:border-primary focus:ring-0 placeholder-slate-400 transition-colors shadow-sm text-slate-900" id="client_name" name="client_name" required type="text" placeholder="Ex: Moussa Diop"/>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 ml-1" for="client_phone">Numéro de téléphone</label>
                    <input class="w-full h-14 pl-4 pr-4 bg-white border-2 border-slate-200 rounded-lg text-lg focus:border-primary focus:ring-0 placeholder-slate-400 transition-colors shadow-sm text-slate-900" id="client_phone" name="client_phone" required type="tel" placeholder="Ex: 07 00 00 00"/>
                </div>

                <div class="mt-auto pt-8">
                    <button type="submit" class="group w-full h-[60px] bg-primary hover:bg-red-600 text-white rounded-xl font-bold text-xl shadow-lg shadow-red-500/30 transition-all transform active:scale-[0.98] flex items-center justify-center gap-3 relative overflow-hidden">
                        <span class="relative z-10">Confirmer ma Commande</span>
                        <span class="material-symbols-outlined relative z-10 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
    </aside>
</div>

@push('scripts')
<script>
    function renderCart() {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const container = document.getElementById('cart-items-container');
        const emptyMsg = document.getElementById('empty-cart-msg');
        const totalEl = document.getElementById('checkout-total');

        if (cart.length === 0) {
            container.innerHTML = '';
            container.appendChild(emptyMsg);
            emptyMsg.classList.remove('hidden');
            totalEl.innerText = '0 FCFA';
            return;
        }

        emptyMsg.classList.add('hidden');
        container.innerHTML = '';

        let total = 0;

        cart.forEach((item, index) => {
            total += item.price * item.quantity;
            const itemHtml = `
            <div class="group bg-[#2A2A2A] rounded-xl p-4 md:p-6 flex flex-col md:flex-row gap-6 items-center shadow-lg border border-white/5">
                <div class="relative shrink-0">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-lg bg-cover bg-center shadow-md" style="background-image: url('${item.image || ''}'); background-color: #333;"></div>
                </div>
                <div class="flex-1 w-full flex flex-col justify-between h-full gap-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl md:text-2xl font-bold text-white mb-1">${item.name}</h3>
                            <p class="text-gray-400 font-medium">${new Intl.NumberFormat('fr-FR').format(item.price)} FCFA <span class="text-gray-600 text-sm font-normal">/ unité</span></p>
                        </div>
                    </div>
                    <div class="flex items-end justify-between w-full mt-auto">
                        <div class="flex items-center bg-[#1C1C1C] rounded-lg p-1 border border-white/10">
                            <button onclick="updateQuantity(${index}, -1)" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-[#392a28] text-white hover:bg-primary hover:text-white rounded-md transition-all active:scale-95">
                                <span class="material-symbols-outlined">remove</span>
                            </button>
                            <input class="w-12 md:w-16 bg-transparent border-none text-center text-lg font-bold text-white focus:ring-0" readonly type="number" value="${item.quantity}"/>
                            <button onclick="updateQuantity(${index}, 1)" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-[#392a28] text-white hover:bg-primary hover:text-white rounded-md transition-all active:scale-95">
                                <span class="material-symbols-outlined">add</span>
                            </button>
                        </div>
                        <div class="text-right flex flex-col items-end gap-2">
                             <div class="text-primary font-bold text-xl md:text-2xl">${new Intl.NumberFormat('fr-FR').format(item.price * item.quantity)} FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
            `;
            container.innerHTML += itemHtml;
        });

        totalEl.innerText = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
    }

    function updateQuantity(index, change) {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        if (cart[index]) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    document.getElementById('checkout-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        if (cart.length === 0) {
            alert('Votre panier est vide.');
            return;
        }

        const formData = {
            client_name: document.getElementById('client_name').value,
            client_phone: document.getElementById('client_phone').value,
            items: cart.map(item => ({ id: item.id, quantity: item.quantity }))
        };

        try {
            const response = await fetch('{{ route('kiosk.order.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (result.success) {
                localStorage.removeItem('cart');
                window.location.href = '{{ route('kiosk.confirmation') }}';
            } else {
                alert('Erreur: ' + (result.message || 'Une erreur est survenue.'));
            }
        } catch (error) {
            console.error(error);
            alert('Erreur de connexion.');
        }
    });

    document.addEventListener('DOMContentLoaded', renderCart);
</script>
@endpush
@endsection
