@extends('layouts.kiosk')
@section('title', 'Catalogue')

@push('head')
<style>
/* ─── Animations ─── */
@keyframes cardIn    { from{opacity:0;transform:translateY(20px) scale(.96)} to{opacity:1;transform:none} }
@keyframes pulseGreen{ 0%,100%{box-shadow:0 0 0 0 rgba(34,197,94,.45)} 60%{box-shadow:0 0 0 5px rgba(34,197,94,0)} }
@keyframes fadeIn    { from{opacity:0} to{opacity:1} }
.burger-card { animation: cardIn .45s cubic-bezier(.22,1,.36,1) both; }

/* ═══════════════════════════════════════
   FILTER ZONE
═══════════════════════════════════════ */
.filter-zone {
    position: sticky;
    top: 64px; z-index: 30;
    background: var(--header-bg, rgba(8,10,18,.97));
    backdrop-filter: blur(28px);
    -webkit-backdrop-filter: blur(28px);
    border-bottom: 1px solid rgba(255,255,255,.055);
    padding: 14px 12px 12px;
    margin: 0 -12px;
    display: flex; flex-direction: column; gap: 10px;
}
html.light .filter-zone { background: rgba(255,250,247,.97); border-bottom-color: rgba(230,180,160,.2); }
@media(min-width:640px){
    .filter-zone { top:72px; margin:0 -24px; padding-left:24px; padding-right:24px; }
}

/* ─── Search wrapper ─── */
.search-wrap { position: relative; }
.search-icon {
    position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
    pointer-events: none; color: rgba(255,255,255,.35);
    font-size: 20px; line-height: 1; transition: color .22s;
    font-variation-settings: 'wght' 300;
}
html.light .search-icon { color: #b08878; }
.search-wrap:focus-within .search-icon { color: #ff6b35; }

/* ─── Search input — pill arrondie ─── */
.f-search {
    width: 100%; height: 52px;
    padding: 0 48px 0 52px;
    background: rgba(255,255,255,.06);
    border: 1.5px solid rgba(255,255,255,.09);
    border-radius: 999px;
    color: #f9fafb;
    font-family: 'Karla', sans-serif; font-size: 15px; font-weight: 500;
    transition: border-color .22s, box-shadow .22s, background .22s;
    -webkit-appearance: none; appearance: none; color-scheme: dark;
    letter-spacing: .01em;
}
html.light .f-search {
    background: #fffaf7;
    border-color: #ecd6c8;
    color: #1a1208;
    color-scheme: light;
    box-shadow: 0 2px 12px rgba(255,107,53,.07), 0 1px 3px rgba(0,0,0,.05);
}
.f-search::placeholder { color: rgba(255,255,255,.24); font-weight: 400; }
html.light .f-search::placeholder { color: #a89080; font-weight: 400; }
.f-search:focus {
    outline: none; border-color: #ff6b35;
    background: rgba(255,107,53,.04);
    box-shadow: 0 0 0 4px rgba(255,107,53,.13), 0 2px 20px rgba(255,107,53,.07);
}
html.light .f-search:focus {
    background: #fff;
    border-color: #ff6b35;
    box-shadow: 0 0 0 4px rgba(255,107,53,.12), 0 4px 20px rgba(255,107,53,.09);
}
.f-search:-webkit-autofill, .f-search:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0 1000px #0c0f1a inset !important;
    -webkit-text-fill-color: #f9fafb !important;
}
html.light .f-search:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 1000px #fff inset !important;
    -webkit-text-fill-color: #0f172a !important;
}

.btn-clear-search {
    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(255,255,255,.1); border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: rgba(255,255,255,.5);
    transition: background .15s, color .15s;
}
html.light .btn-clear-search { background: #f5ece6; color: #a07060; }
.btn-clear-search:hover { background: rgba(255,107,53,.2); color: #ff6b35; }
.btn-clear-search span { font-size: 15px; line-height: 1; }

/* ─── Filter row: prix + pills côte à côte ─── */
.filter-row {
    display: flex; align-items: center; gap: 8px;
    min-height: 44px;
}

/* ─── Price section — pill indépendante ─── */
.price-section {
    display: inline-flex; align-items: center; gap: 2px;
    height: 42px; padding: 0 12px 0 10px;
    background: rgba(255,255,255,.07);
    border: 1.5px solid rgba(255,255,255,.1);
    border-radius: 999px; flex-shrink: 0;
    transition: border-color .2s, background .2s;
}
.price-section:focus-within {
    border-color: rgba(255,107,53,.55);
    background: rgba(255,107,53,.05);
}
html.light .price-section {
    background: #fffaf7;
    border-color: #ecd6c8;
    box-shadow: 0 2px 8px rgba(255,107,53,.06), 0 1px 3px rgba(0,0,0,.04);
}
html.light .price-section:focus-within {
    border-color: #ff6b35;
    background: #fff7f2;
}

.price-icon { display: flex; align-items: center; margin-right: 7px; flex-shrink: 0; }
.price-icon span { font-size: 15px; color: #ff6b35; }

.f-price {
    width: 48px; height: 34px; padding: 0 4px;
    background: transparent; border: none;
    color: #f9fafb;
    font-family: 'Karla', sans-serif; font-size: 13px; font-weight: 700;
    text-align: center; -webkit-appearance: none; appearance: none;
}
html.light .f-price { color: #1a1208; }
.f-price::placeholder { color: rgba(255,255,255,.28); font-weight: 400; font-size: 12px; }
html.light .f-price::placeholder { color: #b09080; }
.f-price:focus { outline: none; color: #ff6b35; }
.f-price::-webkit-inner-spin-button, .f-price::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
.f-price[type=number] { -moz-appearance: textfield; }

.price-sep {
    font-size: 12px; font-weight: 700;
    color: rgba(255,255,255,.2); flex-shrink: 0; padding: 0 1px;
}
html.light .price-sep { color: #d4bfb5; }

.price-unit {
    font-size: 9.5px; font-weight: 800; letter-spacing: .07em; text-transform: uppercase;
    color: rgba(255,255,255,.28); flex-shrink: 0; margin: 0 7px 0 4px;
}
html.light .price-unit { color: #c0a090; }

.price-clear {
    background: rgba(255,255,255,.08); border: none; cursor: pointer;
    width: 20px; height: 20px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.35); transition: all .14s; flex-shrink: 0;
}
html.light .price-clear { background: #f1f5f9; color: #94a3b8; }
.price-clear:hover { background: rgba(239,68,68,.2); color: #ef4444; }
.price-clear span { font-size: 12px; line-height: 1; }

/* ─── Pills scroll area ─── */
.pills-area {
    display: flex; align-items: center; gap: 6px;
    overflow-x: auto; scrollbar-width: none; -ms-overflow-style: none;
    flex: 1; padding: 1px 0;
}
.pills-area::-webkit-scrollbar { display: none; }

/* ─── Category pill — pill arrondie ─── */
.cat-pill {
    display: inline-flex; align-items: center; gap: 5px;
    height: 42px; padding: 0 16px;
    border-radius: 999px;
    font-size: 13px; font-weight: 800; white-space: nowrap;
    cursor: pointer; flex-shrink: 0; user-select: none;
    background: rgba(255,255,255,.07);
    border: 1.5px solid rgba(255,255,255,.1);
    color: rgba(255,255,255,.5);
    transition: all .18s ease; letter-spacing: .01em;
}
html.light .cat-pill { background: #fffaf7; border-color: #ecd6c8; color: #78614f; box-shadow: 0 1px 4px rgba(255,107,53,.05); }
.cat-pill:hover {
    background: rgba(255,107,53,.11);
    border-color: rgba(255,107,53,.3);
    color: rgba(255,255,255,.92);
}
html.light .cat-pill:hover { background: #fff0e8; border-color: rgba(255,107,53,.4); color: #1a1208; }
.cat-pill.active {
    background: #ff6b35; border-color: #ff6b35; color: #fff;
    box-shadow: 0 6px 22px rgba(255,107,53,.42), 0 2px 8px rgba(255,107,53,.22);
}
.cat-pill .cat-pill-icon { font-size: 14px; opacity: .9; }

/* ─── Meta row ─── */
.meta-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 2px;
}
.count-badge {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11.5px; font-weight: 700; letter-spacing: .02em;
    color: rgba(255,255,255,.38);
}
html.light .count-badge { color: #b09080; }
.count-dot { width: 6px; height: 6px; border-radius: 50%; background: #ff6b35; flex-shrink: 0; }

.btn-reset {
    display: none; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 800; cursor: pointer; letter-spacing: .01em;
    color: #ff6b35;
    background: rgba(255,107,53,.1);
    border: 1.5px solid rgba(255,107,53,.22);
    padding: 5px 14px; border-radius: 999px;
    transition: all .16s;
}
.btn-reset:hover { background: rgba(255,107,53,.2); box-shadow: 0 3px 14px rgba(255,107,53,.22); }
.btn-reset span { font-size: 13px; }

/* ═══════════════════════════════════════
   CARDS
═══════════════════════════════════════ */
.burger-card-kiosk {
    background: var(--card-bg, #1a2035);
    border: 1px solid var(--border, rgba(255,255,255,.07));
    border-radius: 18px; overflow: hidden;
    display: flex; flex-direction: column; position: relative;
    transition: transform .28s cubic-bezier(.22,1,.36,1), box-shadow .28s, border-color .22s;
}
.burger-card-kiosk:hover {
    transform: translateY(-5px);
    box-shadow: 0 18px 48px rgba(255,107,53,.16), 0 6px 20px rgba(0,0,0,.22);
    border-color: rgba(255,107,53,.32);
}
html.light .burger-card-kiosk { background: #fff; border-color: #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,.07); }
html.light .burger-card-kiosk:hover { box-shadow: 0 14px 44px rgba(255,107,53,.13), 0 4px 14px rgba(0,0,0,.09); border-color: rgba(255,107,53,.25); }

/* ─── Card image ─── */
.c-img { position: relative; height: 190px; overflow: hidden; flex-shrink: 0; background: var(--surface-2, #232d3f); }
.c-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s ease; }
.burger-card-kiosk:hover .c-img img { transform: scale(1.06); }
.c-img-ph { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
.c-img-grad {
    position: absolute; bottom: 0; left: 0; right: 0; height: 90px;
    background: linear-gradient(to top, rgba(15,17,23,.95) 0%, transparent 100%);
    pointer-events: none;
}
html.light .c-img-grad { background: linear-gradient(to top, rgba(255,255,255,.9) 0%, transparent 100%); }

/* ─── Badge ─── */
.badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 10px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
    padding: 3px 8px; border-radius: 999px;
    background: rgba(0,0,0,.6); backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.12);
}
.sdot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
.sdot.ok  { background: #22c55e; animation: pulseGreen 2s infinite; }
.sdot.low { background: #f59e0b; }
.sdot.out { background: #ef4444; }

/* ─── Card body ─── */
.c-body { padding: 14px 16px 16px; display: flex; flex-direction: column; flex: 1; gap: 10px; }
.c-name { font-size: 1rem; font-weight: 800; letter-spacing: -.02em; line-height: 1.2; color: var(--text, #f9fafb); }
.c-desc { font-size: .78rem; line-height: 1.5; color: var(--text-muted, #9ca3af); }
.c-sep  { border-top: 1px solid var(--border, rgba(255,255,255,.07)); }
.c-price-lbl { font-size: .58rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em; color: var(--text-dim, #4b5563); display: block; margin-bottom: 2px; }
.c-price { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 1.5rem; letter-spacing: -.01em; color: #ff6b35; line-height: 1; }

/* ─── Btn Commander ─── */
.btn-add {
    flex: 1; height: 40px;
    background: #ff6b35; color: #fff;
    font-family: 'Karla', sans-serif; font-weight: 700; font-size: .84rem; letter-spacing: .03em;
    border: none; border-radius: 11px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 5px;
    transition: background .16s, box-shadow .16s, transform .1s;
    box-shadow: 0 3px 12px rgba(255,107,53,.28);
    white-space: nowrap;
}
.btn-add:hover  { background: #e55a26; box-shadow: 0 5px 18px rgba(255,107,53,.42); }
.btn-add:active { transform: scale(.96); }
.btn-add:disabled { background: var(--surface-2, #232d3f); color: var(--text-dim, #4b5563); box-shadow: none; cursor: not-allowed; }

/* ─── Qty ctrl ─── */
.qty-wrap {
    display: flex; align-items: center; gap: 3px; flex: 1;
    background: var(--surface-2, #232d3f);
    border: 1px solid rgba(255,107,53,.25); border-radius: 11px;
    padding: 3px;
}
html.light .qty-wrap { background: #f3f4f6; }
.qty-btn {
    width: 34px; height: 34px; border-radius: 8px;
    background: rgba(255,107,53,.12); color: #ff6b35;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .14s; flex-shrink: 0;
}
.qty-btn:hover { background: #ff6b35; color: #fff; }
.qty-val { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 1.1rem; color: var(--text, #f9fafb); text-align: center; flex: 1; }

/* ─── Cart header btn ─── */
.cart-hbtn {
    display: flex; align-items: center; gap: 8px;
    padding: 7px 12px; border-radius: 12px;
    background: var(--surface, #1c2333);
    border: 1.5px solid var(--border-input, rgba(255,255,255,.1));
    text-decoration: none; transition: border-color .2s, background .2s;
}
.cart-hbtn:hover { border-color: #ff6b35; background: rgba(255,107,53,.08); }
html.light .cart-hbtn { background: #fff; border-color: #e2e8f0; }

/* ─── Toast ─── */
#kiosk-toast {
    position: fixed; bottom: 92px; left: 50%;
    transform: translateX(-50%) translateY(8px);
    background: rgba(20,24,36,.96);
    backdrop-filter: blur(16px);
    border: 1.5px solid rgba(255,107,53,.35);
    color: #f9fafb;
    padding: 10px 20px; border-radius: 999px;
    font-size: 13px; font-weight: 600;
    opacity: 0; pointer-events: none; z-index: 9998;
    transition: opacity .2s, transform .2s;
    white-space: nowrap; display: flex; align-items: center; gap: 8px;
    box-shadow: 0 8px 24px rgba(0,0,0,.3);
}
#kiosk-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

/* ─── Footer cart ─── */
#footer-cart {
    position: fixed; bottom: 0; left: 0; width: 100%;
    padding: 10px 16px; z-index: 50;
    display: none; justify-content: center;
}
.footer-inner {
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    width: 100%; max-width: 600px;
    background: linear-gradient(135deg, #ff6b35 0%, #e55a26 100%);
    box-shadow: 0 6px 28px rgba(255,107,53,.45);
    padding: 13px 20px; border-radius: 18px;
    text-decoration: none; color: #fff;
    transition: transform .2s, box-shadow .2s;
}
.footer-inner:hover { transform: translateY(-2px); box-shadow: 0 10px 36px rgba(255,107,53,.55); }

/* ─── No results ─── */
#no-results-msg {
    grid-column: 1/-1;
    display: none; flex-direction: column; align-items: center;
    padding: 56px 16px; text-align: center;
    animation: fadeIn .25s ease;
}
</style>
@endpush

{{-- ─── Cart btn header ─── --}}
@section('header_actions')
<a href="{{ route('kiosk.checkout', [], false) }}" class="cart-hbtn">
    <span class="material-symbols-outlined" style="font-size:20px;color:#ff6b35;">shopping_cart</span>
    <span class="font-bold text-sm hidden sm:block" style="color:#ff6b35;" id="header-total">0 FCFA</span>
</a>
@endsection

@section('content')

{{-- ─── Zone filtres sticky ─── --}}
<div class="filter-zone -mt-5 sm:-mt-8 mb-5">

    {{-- Ligne 1 : Recherche --}}
    <div class="search-wrap">
        <span class="material-symbols-outlined search-icon">search</span>
        <input type="text" id="search-input" class="f-search"
               placeholder="Rechercher un burger..."
               oninput="filterBurgers()" autocomplete="off" spellcheck="false"
               aria-label="Rechercher un burger">
        <button id="btn-clear-search" class="btn-clear-search" onclick="clearSearch()"
                title="Effacer la recherche" style="display:none;" aria-label="Effacer">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    {{-- Ligne 2 : Prix + Pills --}}
    <div class="filter-row">

        {{-- Price pill autonome --}}
        <div class="price-section">
            <div class="price-icon">
                <span class="material-symbols-outlined" style="font-size:15px;">payments</span>
            </div>
            <input type="text" inputmode="numeric" pattern="[0-9]*"
                   id="price-min" class="f-price" placeholder="Min" oninput="filterBurgers()" aria-label="Prix minimum">
            <span class="price-sep">–</span>
            <input type="text" inputmode="numeric" pattern="[0-9]*"
                   id="price-max" class="f-price" placeholder="Max" oninput="filterBurgers()" aria-label="Prix maximum">
            <span class="price-unit">FCFA</span>
            <button class="price-clear" onclick="clearPriceFilter()" title="Effacer les prix" aria-label="Effacer filtre prix">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        {{-- Pills catégories scrollables --}}
        <div class="pills-area">
            <button class="cat-pill active" data-cat="all" onclick="setCategory('all')" aria-pressed="true">
                <span class="material-symbols-outlined cat-pill-icon" style="font-size:14px;">apps</span>Tous
            </button>
            @php $categories = $burgers->pluck('category')->unique()->filter()->sort()->values(); @endphp
            @foreach($categories as $cat)
            <button class="cat-pill" data-cat="{{ $cat }}" onclick="setCategory('{{ $cat }}')" aria-pressed="false">{{ $cat }}</button>
            @endforeach
        </div>
    </div>

    {{-- Ligne 3 : Compteur + Reset --}}
    <div class="meta-row">
        <span class="count-badge" id="results-count">
            <span class="count-dot"></span>
            {{ $burgers->count() }} burger{{ $burgers->count()>1?'s':'' }}
        </span>
        <button id="btn-reset" class="btn-reset" onclick="resetFilters()" aria-label="Réinitialiser les filtres">
            <span class="material-symbols-outlined">refresh</span>Réinitialiser
        </button>
    </div>

</div>

{{-- ─── Grille ─── --}}
<div id="burgers-grid" class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 pb-28">

    @forelse($burgers as $burger)
    <article class="burger-card burger-card-kiosk"
             data-name="{{ strtolower($burger->name) }}"
             data-cat="{{ $burger->category }}"
             data-price="{{ $burger->price }}"
             style="animation-delay:{{ $loop->index * .05 }}s;">

        {{-- Image --}}
        <div class="c-img">
            @if($burger->image_path)
                <img src="{{ $burger->image_path }}" alt="{{ $burger->name }}" width="400" height="190" loading="lazy">
            @else
                <div class="c-img-ph">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 48" style="width:60px;height:45px;opacity:.15;">
                        <rect x="4" y="6"  width="56" height="9"  rx="4.5" fill="#ff6b35"/>
                        <rect x="4" y="20" width="56" height="9"  rx="4.5" fill="currentColor" opacity=".4"/>
                        <rect x="4" y="34" width="56" height="9"  rx="4.5" fill="#ff6b35"/>
                    </svg>
                </div>
            @endif
            <div class="c-img-grad"></div>

            @if($burger->category)
            <div class="absolute top-2.5 left-2.5 z-10">
                <span class="badge text-white/90">{{ $burger->category }}</span>
            </div>
            @endif

            <div class="absolute top-2.5 right-2.5 z-10">
                @if($burger->stock_quantity > 5)
                    <span class="badge text-green-400"><span class="sdot ok"></span>Dispo</span>
                @elseif($burger->stock_quantity > 0)
                    <span class="badge text-amber-400"><span class="sdot low"></span>{{ $burger->stock_quantity }} restant{{ $burger->stock_quantity > 1 ? 's' : '' }}</span>
                @else
                    <span class="badge text-red-400"><span class="sdot out"></span>Épuisé</span>
                @endif
            </div>
        </div>

        {{-- Corps --}}
        <div class="c-body">
            <div>
                <h3 class="c-name">{{ $burger->name }}</h3>
                @if($burger->description)
                <p class="c-desc line-clamp-2 mt-1">{{ $burger->description }}</p>
                @endif
            </div>

            <div class="c-sep pt-2.5 mt-auto flex items-center justify-between gap-3">
                <div>
                    <span class="c-price-lbl">Prix</span>
                    <span class="c-price">{{ number_format($burger->price,0,',',' ') }}<span style="font-size:.85rem;opacity:.6;font-weight:700;"> FCFA</span></span>
                </div>

                @if($burger->stock_quantity > 0)
                <div class="flex gap-2 flex-1 justify-end">
                    <button type="button" id="add-btn-{{ $burger->id }}"
                        onclick="addToCart({{ $burger->id }}, @js($burger->name), {{ $burger->price }}, @js($burger->image_path))"
                        class="btn-add">
                        <span class="material-symbols-outlined" style="font-size:17px;">add_shopping_cart</span>Commander
                    </button>
                    <div id="qty-wrap-{{ $burger->id }}" class="qty-wrap hidden">
                        <button type="button" class="qty-btn" onclick="changeQty({{ $burger->id }}, -1)">
                            <span class="material-symbols-outlined" style="font-size:17px;">remove</span>
                        </button>
                        <span class="qty-val" id="qty-val-{{ $burger->id }}">0</span>
                        <button type="button" class="qty-btn" onclick="changeQty({{ $burger->id }}, 1)">
                            <span class="material-symbols-outlined" style="font-size:17px;">add</span>
                        </button>
                    </div>
                </div>
                @else
                <button type="button" class="btn-add" disabled>
                    <span class="material-symbols-outlined" style="font-size:16px;">block</span>Épuisé
                </button>
                @endif
            </div>
        </div>
    </article>

    @empty
    <div style="grid-column:1/-1;display:flex;flex-direction:column;align-items:center;padding:64px 16px;text-align:center;">
        <div style="width:88px;height:88px;border-radius:50%;background:var(--surface);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 48" style="width:44px;height:33px;opacity:.18;">
                <rect x="4" y="6"  width="56" height="9"  rx="4.5" fill="#ff6b35"/>
                <rect x="4" y="20" width="56" height="9"  rx="4.5" fill="currentColor"/>
                <rect x="4" y="34" width="56" height="9"  rx="4.5" fill="#ff6b35"/>
            </svg>
        </div>
        <h3 style="font-family:'Playfair Display SC',serif;font-size:1.2rem;font-weight:700;color:var(--text);margin-bottom:8px;">Catalogue vide</h3>
        <p style="color:var(--text-muted);font-size:.875rem;max-width:240px;line-height:1.6;">Aucun burger disponible. L'administrateur doit d'abord ajouter des produits.</p>
    </div>
    @endforelse

    {{-- No results (filtres) --}}
    <div id="no-results-msg">
        <div style="width:76px;height:76px;border-radius:50%;background:var(--surface);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <span class="material-symbols-outlined" style="font-size:34px;color:var(--text-dim);">search_off</span>
        </div>
        <p style="font-size:.95rem;font-weight:800;color:var(--text);margin-bottom:6px;">Aucun résultat</p>
        <p style="color:var(--text-muted);font-size:.82rem;max-width:220px;line-height:1.6;">Modifiez votre recherche ou ajustez les filtres.</p>
        <button onclick="resetFilters()" class="cursor-pointer"
            style="margin-top:14px;display:inline-flex;align-items:center;gap:5px;font-size:13px;font-weight:700;padding:7px 16px;border-radius:999px;background:rgba(255,107,53,.1);color:#ff6b35;border:1.5px solid rgba(255,107,53,.22);">
            <span class="material-symbols-outlined" style="font-size:14px;">refresh</span>Voir tout
        </button>
    </div>
</div>

{{-- Toast --}}
<div id="kiosk-toast">
    <span class="material-symbols-outlined" style="color:#ff6b35;font-size:15px;font-variation-settings:'FILL' 1;">check_circle</span>
    <span id="toast-text"></span>
</div>

{{-- Footer cart --}}
<div id="footer-cart">
    <a href="{{ route('kiosk.checkout', [], false) }}" class="footer-inner">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:38px;height:38px;border-radius:11px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span class="material-symbols-outlined" style="font-size:19px;">shopping_basket</span>
            </div>
            <div>
                <p style="font-size:12px;font-weight:600;opacity:.9;line-height:1.1;">Voir ma commande</p>
                <p style="font-size:11px;opacity:.75;line-height:1.1;margin-top:1px;" id="cart-count">0 article</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:6px;">
            <span style="font-family:'Barlow Condensed',sans-serif;font-weight:900;font-size:1.25rem;letter-spacing:-.01em;" id="cart-total">0 FCFA</span>
            <span class="material-symbols-outlined" style="font-size:20px;">arrow_forward</span>
        </div>
    </a>
</div>

@push('scripts')
<script>
    let _cat = 'all';

    /* ── Filtre central ── */
    function filterBurgers() {
        const q    = document.getElementById('search-input').value.toLowerCase().trim();
        const pMin = parseFloat(document.getElementById('price-min').value) || 0;
        const pMax = parseFloat(document.getElementById('price-max').value) || Infinity;

        const cards  = document.querySelectorAll('.burger-card');
        let visible  = 0;

        cards.forEach(c => {
            const ok = (c.dataset.name || '').includes(q)
                    && (_cat === 'all' || (c.dataset.cat || '') === _cat)
                    && (parseFloat(c.dataset.price) || 0) >= pMin
                    && (parseFloat(c.dataset.price) || 0) <= pMax;
            c.style.display = ok ? '' : 'none';
            if (ok) visible++;
        });

        /* Compteur */
        document.getElementById('results-count').textContent = visible + ' burger' + (visible > 1 ? 's' : '');

        /* No results */
        const nr = document.getElementById('no-results-msg');
        if (nr) nr.style.display = (visible === 0 && cards.length > 0) ? 'flex' : 'none';

        /* Bouton reset */
        const hasF = q || pMin > 0 || pMax < Infinity || _cat !== 'all';
        const rb   = document.getElementById('btn-reset');
        if (rb) rb.style.display = hasF ? 'inline-flex' : 'none';
        /* aria */
        document.querySelectorAll('.cat-pill').forEach(b => {
            b.setAttribute('aria-pressed', b.classList.contains('active') ? 'true' : 'false');
        });

        /* Clear search btn */
        const cs = document.getElementById('btn-clear-search');
        if (cs) cs.style.display = q ? 'block' : 'none';
    }

    function clearSearch() {
        document.getElementById('search-input').value = '';
        filterBurgers();
        document.getElementById('search-input').focus();
    }

    function clearPriceFilter() {
        document.getElementById('price-min').value = '';
        document.getElementById('price-max').value = '';
        filterBurgers();
    }

    function setCategory(cat) {
        _cat = cat;
        document.querySelectorAll('.cat-pill').forEach(b => {
            b.classList.toggle('active', b.dataset.cat === cat);
        });
        filterBurgers();
    }

    function resetFilters() {
        document.getElementById('search-input').value = '';
        document.getElementById('price-min').value = '';
        document.getElementById('price-max').value = '';
        setCategory('all');
    }

    /* ── Panier ── */
    const fmt = n => new Intl.NumberFormat('fr-FR').format(n);

    function updateCartUI() {
        const cart  = JSON.parse(localStorage.getItem('cart') || '[]');
        const total = cart.reduce((s,i) => s + i.price * i.quantity, 0);
        const count = cart.reduce((s,i) => s + i.quantity, 0);

        document.getElementById('header-total').textContent = fmt(total) + ' FCFA';
        document.getElementById('cart-total').textContent   = fmt(total) + ' FCFA';
        document.getElementById('cart-count').textContent   = count + (count > 1 ? ' articles' : ' article');
        document.getElementById('footer-cart').style.display = count > 0 ? 'flex' : 'none';
    }

    function syncCard(id) {
        const item = (JSON.parse(localStorage.getItem('cart') || '[]')).find(i => i.id === id);
        const add  = document.getElementById('add-btn-'   + id);
        const wrap = document.getElementById('qty-wrap-'  + id);
        const val  = document.getElementById('qty-val-'   + id);
        if (!add || !wrap) return;
        if (item && item.quantity > 0) {
            val.textContent = item.quantity;
            add.classList.add('hidden');
            wrap.classList.remove('hidden');
        } else {
            add.classList.remove('hidden');
            wrap.classList.add('hidden');
        }
    }

    function changeQty(id, delta) {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const i  = cart.findIndex(x => x.id === id);
        if (i !== -1) {
            cart[i].quantity += delta;
            if (cart[i].quantity <= 0) cart.splice(i, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
        }
        updateCartUI(); syncCard(id);
    }

    let _tt = null;
    function showToast(name) {
        const t = document.getElementById('kiosk-toast');
        document.getElementById('toast-text').textContent = '"' + name + '" ajouté';
        t.classList.add('show');
        clearTimeout(_tt);
        _tt = setTimeout(() => t.classList.remove('show'), 2200);
    }

    function addToCart(id, name, price, image) {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const ex = cart.find(i => i.id === id);
        if (ex) { ex.quantity++; } else { cart.push({ id, name, price, image, quantity:1 }); }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI(); syncCard(id); showToast(name);
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateCartUI();
        JSON.parse(localStorage.getItem('cart') || '[]').forEach(i => syncCard(i.id));
    });
</script>
@endpush
@endsection
