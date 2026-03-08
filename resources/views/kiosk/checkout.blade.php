@extends('layouts.kiosk')

@section('title', 'Ma Commande')
@section('subtitle', 'Finaliser votre commande')

@push('head')
<style>
    /* ── Checkout-specific styles ── */
    .checkout-card {
        background: var(--surface, #1c2333);
        border: 1px solid var(--border, rgba(255,255,255,0.07));
        border-radius: 20px;
    }
    html.light .checkout-card {
        background: #ffffff;
        border-color: #e5e7eb;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
    }

    .cart-item-card {
        background: var(--card-bg, #1a2035);
        border: 1px solid var(--border, rgba(255,255,255,0.07));
        border-radius: 16px;
        transition: border-color 0.2s;
    }
    html.light .cart-item-card {
        background: #ffffff;
        border-color: #e5e7eb;
        box-shadow: 0 1px 8px rgba(0,0,0,0.06);
    }

    .form-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--text-muted, #9ca3af);
        margin-bottom: 6px;
    }
    .form-input {
        width: 100%;
        height: 52px;
        padding: 0 16px;
        background: var(--input-bg, #111827);
        border: 1.5px solid var(--border-input, rgba(255,255,255,0.1));
        border-radius: 14px;
        color: var(--text, #f9fafb);
        font-size: 15px;
        font-family: 'Karla', sans-serif;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    html.light .form-input {
        background: #f9fafb;
        border-color: #e5e7eb;
        color: #111827;
    }
    .form-input::placeholder { color: var(--text-dim, #4b5563); }
    html.light .form-input::placeholder { color: #9ca3af; }
    .form-input:focus {
        outline: none;
        border-color: #ff6b35;
        box-shadow: 0 0 0 3px rgba(255,107,53,0.18);
    }

    /* Qty controls */
    .qty-btn {
        width: 38px; height: 38px;
        border-radius: 10px;
        border: 1px solid var(--border-input, rgba(255,255,255,0.1));
        background: var(--surface-2, #232d3f);
        color: var(--text, #f9fafb);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    html.light .qty-btn { background: #f3f4f6; border-color: #e5e7eb; color: #111827; }
    .qty-btn:hover { background: #ff6b35; border-color: #ff6b35; color: white; }

    /* Submit button */
    .btn-confirm {
        width: 100%;
        height: 56px;
        background: linear-gradient(135deg, #ff6b35 0%, #e55a26 100%);
        color: white;
        font-family: 'Karla', sans-serif;
        font-weight: 800;
        font-size: 15px;
        letter-spacing: 0.05em;
        border-radius: 16px;
        border: none;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 6px 24px rgba(255,107,53,0.38);
        transition: transform 0.15s, box-shadow 0.2s, filter 0.2s;
    }
    .btn-confirm:hover  { filter: brightness(1.07); box-shadow: 0 8px 32px rgba(255,107,53,0.5); }
    .btn-confirm:active { transform: scale(0.98); }
    .btn-confirm:disabled { background: var(--surface-2); color: var(--text-dim); box-shadow: none; cursor: not-allowed; filter: none; }

    /* Price tag font */
    .price-tag { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; letter-spacing: -0.01em; }

    /* Summary panel */
    .summary-panel {
        background: var(--surface, #1c2333);
        border: 1px solid var(--border, rgba(255,255,255,0.07));
        border-radius: 20px;
    }
    html.light .summary-panel {
        background: #ffffff;
        border-color: #e5e7eb;
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    }
    .summary-divider { border-top: 1px solid var(--border, rgba(255,255,255,0.07)); }
    html.light .summary-divider { border-color: #f3f4f6; }

    /* Empty cart */
    .empty-cart-msg { color: var(--text-muted, #9ca3af); }
</style>
@endpush

@section('content')
<div class="w-full flex flex-col lg:flex-row gap-6 lg:gap-8 max-w-6xl mx-auto">

    <!-- ── Left : Cart items ── -->
    <div class="flex-1 flex flex-col gap-4 min-w-0">
        <div class="flex items-center gap-3 mb-2">
            <h2 class="text-2xl font-black tracking-tight" style="color: var(--text);">Mon panier</h2>
            <span id="cart-count-badge" class="px-2.5 py-0.5 rounded-full text-xs font-bold text-white" style="background: #ff6b35;"></span>
        </div>

        <div id="cart-items-container" class="space-y-4">
            <div class="empty-cart-msg text-center py-16 flex flex-col items-center gap-4" id="empty-cart-msg">
                <div style="width:72px;height:72px;border-radius:50%;background:var(--surface);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;">
                    <span class="material-symbols-outlined text-4xl" style="color: var(--text-dim);">shopping_cart</span>
                </div>
                <div>
                    <p class="font-bold text-lg" style="color: var(--text-muted);">Votre panier est vide</p>
                    <p class="text-sm mt-1" style="color: var(--text-dim);">Retournez au catalogue pour commander</p>
                </div>
                <a href="{{ route('kiosk.index', [], false) }}" class="flex items-center gap-2 font-bold text-sm px-5 py-2.5 rounded-full text-white transition-all" style="background: #ff6b35; box-shadow: 0 4px 14px rgba(255,107,53,0.35);">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Voir le catalogue
                </a>
            </div>
        </div>
    </div>

    <!-- ── Right : Summary + Form ── -->
    <div class="w-full lg:w-[420px] flex flex-col gap-4 flex-shrink-0">

        <!-- Total summary -->
        <div class="summary-panel p-6">
            <h3 class="font-bold text-sm uppercase tracking-widest mb-4" style="color: var(--text-muted);">Récapitulatif</h3>
            <div class="flex items-end justify-between summary-divider pt-4">
                <span class="font-semibold" style="color: var(--text-muted);">Total à payer</span>
                <span class="price-tag text-3xl" style="color: #ff6b35;" id="checkout-total">0 FCFA</span>
            </div>
        </div>

        <!-- Form -->
        <div class="summary-panel p-6">
            <h3 class="font-bold text-sm uppercase tracking-widest mb-5" style="color: var(--text-muted);">Vos informations</h3>
            <form id="checkout-form" class="flex flex-col gap-4">

                <div>
                    <label class="form-label" for="client_name">
                        <span class="material-symbols-outlined text-[14px] align-middle" style="color:#ff6b35;">person</span>
                        Nom complet
                    </label>
                    <input class="form-input" id="client_name" name="client_name" type="text" required placeholder="Ex: Moussa Diop"/>
                </div>

                <div>
                    <label class="form-label" for="client_phone">
                        <span class="material-symbols-outlined text-[14px] align-middle" style="color:#ff6b35;">phone</span>
                        Téléphone
                    </label>
                    <input class="form-input" id="client_phone" name="client_phone" type="tel" required placeholder="Ex: 77 000 00 00"/>
                </div>

                <div>
                    <label class="form-label" for="client_email">
                        <span class="material-symbols-outlined text-[14px] align-middle" style="color:#ff6b35;">mail</span>
                        Email <span style="font-weight:400; text-transform:none; letter-spacing:0; color: var(--text-dim); font-size:10px;">(optionnel — reçu)</span>
                    </label>
                    <input class="form-input" id="client_email" name="client_email" type="email" placeholder="Ex: moussa@email.com"/>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-confirm" id="submit-btn">
                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                        Confirmer ma Commande
                    </button>
                </div>
            </form>
        </div>

        <!-- Back link -->
        <a href="{{ route('kiosk.index', [], false) }}" class="flex items-center justify-center gap-2 text-sm font-semibold py-2 rounded-xl transition-colors cursor-pointer" style="color: var(--text-muted);"
           onmouseover="this.style.color='#ff6b35';" onmouseout="this.style.color='';">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Continuer mes achats
        </a>
    </div>
</div>

@push('scripts')
<style>
    #checkout-error-toast {
        position: fixed; top: 80px; left: 50%;
        transform: translateX(-50%) translateY(-16px);
        background: var(--surface, #1c2333);
        border: 1.5px solid rgba(239,68,68,0.4);
        color: var(--text, #f9fafb);
        padding: 12px 20px; border-radius: 14px;
        font-size: 13.5px; font-weight: 600;
        opacity: 0; pointer-events: none; z-index: 999;
        transition: opacity 0.25s ease, transform 0.25s ease;
        white-space: nowrap; display: flex; align-items: center; gap: 10px;
        max-width: calc(100vw - 32px);
        white-space: normal; text-align: left;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }
    #checkout-error-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
</style>
<div id="checkout-error-toast">
    <span class="material-symbols-outlined flex-shrink-0" style="color: #ef4444; font-size: 1.2rem; font-variation-settings: 'FILL' 1;">error</span>
    <span id="checkout-error-text"></span>
</div>

<script>
    let _errorToastTimer = null;
    function showErrorToast(msg) {
        const toast = document.getElementById('checkout-error-toast');
        document.getElementById('checkout-error-text').innerText = msg;
        toast.classList.add('show');
        clearTimeout(_errorToastTimer);
        _errorToastTimer = setTimeout(() => toast.classList.remove('show'), 4000);
    }

    function renderCart() {
        const cart      = JSON.parse(localStorage.getItem('cart') || '[]');
        const container = document.getElementById('cart-items-container');
        const totalEl   = document.getElementById('checkout-total');
        const badge     = document.getElementById('cart-count-badge');

        if (cart.length === 0) {
            container.innerHTML = `
                <div class="empty-cart-msg text-center py-16 flex flex-col items-center gap-4">
                    <div style="width:72px;height:72px;border-radius:50%;background:var(--surface);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;">
                        <span class="material-symbols-outlined text-4xl" style="color: var(--text-dim);">shopping_cart</span>
                    </div>
                    <div>
                        <p class="font-bold text-lg" style="color: var(--text-muted);">Votre panier est vide</p>
                        <p class="text-sm mt-1" style="color: var(--text-dim);">Retournez au catalogue pour commander</p>
                    </div>
                    <a href="{{ route('kiosk.index', [], false) }}" class="flex items-center gap-2 font-bold text-sm px-5 py-2.5 rounded-full text-white transition-all" style="background: #ff6b35; box-shadow: 0 4px 14px rgba(255,107,53,0.35);">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        Voir le catalogue
                    </a>
                </div>`;
            totalEl.innerText = '0 FCFA';
            badge.innerText = '';
            document.getElementById('submit-btn').disabled = true;
            return;
        }

        container.innerHTML = '';

        let total = 0;
        let count = 0;

        const esc = s => String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');

        cart.forEach((item, index) => {
            const sub = item.price * item.quantity;
            total += sub;
            count += item.quantity;

            const div = document.createElement('div');
            div.className = 'cart-item-card p-4 flex gap-4';
            div.innerHTML = `
                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0" style="background: var(--surface-2); aspect-ratio: 1;">
                    ${item.image
                        ? `<img src="${esc(item.image)}" alt="${esc(item.name)}" width="80" height="80" style="width:100%;height:100%;object-fit:cover;" loading="lazy">`
                        : `<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                              <span class="material-symbols-outlined" style="font-size:32px;color:var(--text-dim);">lunch_dining</span>
                           </div>`
                    }
                </div>
                <div class="flex flex-col flex-1 gap-2 min-w-0">
                    <div class="flex justify-between items-start gap-2">
                        <h3 style="font-weight:800;font-size:0.95rem;color:var(--text);line-height:1.2;"></h3>
                        <span style="font-family:'Barlow Condensed',sans-serif;font-weight:900;font-size:1.1rem;color:#ff6b35;white-space:nowrap;">
                            ${new Intl.NumberFormat('fr-FR').format(sub)} F
                        </span>
                    </div>
                    <p style="font-size:0.78rem;color:var(--text-muted);">${new Intl.NumberFormat('fr-FR').format(item.price)} FCFA / unité</p>
                    <div class="flex items-center gap-2">
                        <button onclick="updateQuantity(${index}, -1)" class="qty-btn">
                            <span class="material-symbols-outlined text-[18px]">remove</span>
                        </button>
                        <span style="min-width:28px;text-align:center;font-weight:800;font-size:1rem;color:var(--text);">${item.quantity}</span>
                        <button onclick="updateQuantity(${index}, 1)" class="qty-btn">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                        </button>
                    </div>
                </div>
            `;
            // Utiliser textContent pour le nom (évite XSS)
            div.querySelector('h3').textContent = item.name;
            container.appendChild(div);
        });

        totalEl.innerText = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
        badge.innerText   = count;
        document.getElementById('submit-btn').disabled = false;
    }

    function updateQuantity(index, change) {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        if (cart[index]) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    document.getElementById('checkout-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        if (cart.length === 0) return;

        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-[20px]" style="animation:spin 1s linear infinite;">progress_activity</span> En cours...';

        const formData = {
            client_name:  document.getElementById('client_name').value,
            client_phone: document.getElementById('client_phone').value,
            client_email: document.getElementById('client_email').value || null,
            items: cart.map(i => ({ id: i.id, quantity: i.quantity }))
        };

        try {
            const res    = await fetch('{{ route('kiosk.order.store', [], false) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify(formData)
            });
            const result = await res.json();
            if (result.success) {
                localStorage.removeItem('cart');
                window.location.href = '{{ route('kiosk.confirmation', [], false) }}';
            } else {
                showErrorToast(result.message || 'Une erreur est survenue.');
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-[20px]">check_circle</span> Confirmer ma Commande';
            }
        } catch(err) {
            showErrorToast('Erreur de connexion. Veuillez réessayer.');
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[20px]">check_circle</span> Confirmer ma Commande';
        }
    });

    document.addEventListener('DOMContentLoaded', renderCart);
</script>
<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
@endpush
@endsection
