@extends('layouts.kiosk')

@section('title', 'Catalogue')

@section('header_actions')
<div class="flex items-center gap-2 sm:gap-3 bg-surface-dark px-3 sm:px-4 py-2 rounded-xl border border-[#372b2a]">
    <div class="flex flex-col items-end">
        <span class="text-xs text-gray-400 font-medium hidden sm:block">Total actuel</span>
        <span class="text-primary font-bold text-base sm:text-lg leading-none" id="header-total">0 FCFA</span>
    </div>
    <div class="bg-primary/20 p-1.5 sm:p-2 rounded-lg text-primary">
        <span class="material-symbols-outlined text-xl">shopping_cart</span>
    </div>
</div>
@endsection

@section('content')
<!-- Search & Filter -->
<div class="w-full flex flex-col gap-4 mb-6 sm:mb-10">
    <!-- Search bar -->
    <div class="w-full relative group">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
            <span class="material-symbols-outlined">search</span>
        </div>
        <input type="text" id="search-input" onkeyup="filterBurgers()"
            class="w-full h-12 sm:h-14 pl-12 pr-4 bg-surface-dark border-none rounded-full text-white placeholder-gray-500 focus:ring-2 focus:ring-primary focus:bg-[#333] transition-all shadow-inner text-base sm:text-lg"
            placeholder="Rechercher un burger...">
    </div>

    <!-- Price filter -->
    <div class="flex items-center gap-3 bg-surface-dark border border-[#372b2a] rounded-xl px-4 py-3">
        <span class="material-symbols-outlined text-gray-400 text-[20px]">price_change</span>
        <span class="text-gray-400 text-sm font-medium whitespace-nowrap hidden sm:block">Prix :</span>
        <div class="flex items-center gap-2 flex-1">
            <input type="number" id="price-min" placeholder="Min" min="0"
                class="w-24 sm:w-28 h-9 px-3 bg-[#2A2A2A] border border-[#444] rounded-lg text-white text-sm placeholder-gray-600 focus:ring-1 focus:ring-primary focus:border-primary"
                onchange="filterBurgers()">
            <span class="text-gray-500 text-sm">—</span>
            <input type="number" id="price-max" placeholder="Max" min="0"
                class="w-24 sm:w-28 h-9 px-3 bg-[#2A2A2A] border border-[#444] rounded-lg text-white text-sm placeholder-gray-600 focus:ring-1 focus:ring-primary focus:border-primary"
                onchange="filterBurgers()">
            <span class="text-gray-500 text-xs whitespace-nowrap">FCFA</span>
        </div>
        <button onclick="clearPriceFilter()" class="text-gray-500 hover:text-primary transition-colors" title="Réinitialiser le filtre">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
    </div>

    <!-- Category filters -->
    <div class="flex gap-2 sm:gap-3 overflow-x-auto pb-2 scrollbar-hide">
        <button onclick="setCategory('all')"
            class="category-btn flex items-center gap-1.5 sm:gap-2 px-4 sm:px-6 h-10 sm:h-12 rounded-full bg-primary text-white font-bold shadow-lg shadow-primary/25 transition-transform active:scale-95 whitespace-nowrap text-sm sm:text-base"
            data-category="all">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">check</span>
            Tous
        </button>
        @php
            $categories = $burgers->pluck('category')->unique()->filter();
        @endphp
        @foreach($categories as $category)
        <button onclick="setCategory('{{ $category }}')"
            class="category-btn flex items-center gap-1.5 sm:gap-2 px-4 sm:px-6 h-10 sm:h-12 rounded-full bg-surface-dark text-gray-300 hover:bg-[#333] hover:text-white font-medium transition-colors whitespace-nowrap border border-[#372b2a] text-sm sm:text-base"
            data-category="{{ $category }}">
            {{ $category }}
        </button>
        @endforeach
    </div>
</div>

<!-- Burgers Grid: 1 col mobile, 2 cols sm, 3 cols lg -->
<div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8" id="burgers-grid">
    @foreach($burgers as $burger)
    <article class="burger-item bg-surface-dark rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl border border-[#372b2a] flex flex-col group hover:border-primary/50 transition-colors"
        data-name="{{ strtolower($burger->name) }}"
        data-category="{{ $burger->category }}"
        data-price="{{ $burger->price }}">

        <!-- Image -->
        <div class="relative h-48 sm:h-56 lg:h-64 w-full overflow-hidden">
            <!-- Stock badge -->
            @if($burger->stock_quantity > 5)
            <div class="absolute top-3 left-3 z-10">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-success text-white shadow-sm">
                    <span class="size-1.5 bg-white rounded-full mr-1.5 animate-pulse"></span>
                    DISPONIBLE
                </span>
            </div>
            @elseif($burger->stock_quantity > 0)
            <div class="absolute top-3 left-3 z-10">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-secondary text-white shadow-sm">
                    <span class="material-symbols-outlined text-[14px] mr-1">warning</span>
                    STOCK FAIBLE ({{ $burger->stock_quantity }})
                </span>
            </div>
            @else
            <div class="absolute top-3 left-3 z-30">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-600 text-white shadow-sm">
                    <span class="material-symbols-outlined text-[14px] mr-1">block</span>
                    INDISPONIBLE
                </span>
            </div>
            @endif

            @if($burger->image_path)
            <div class="h-full w-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
                style="background-image: url('{{ $burger->image_path }}');"></div>
            @else
            <div class="h-full w-full bg-gray-700 flex items-center justify-center">
                <span class="material-symbols-outlined text-5xl text-gray-500">lunch_dining</span>
            </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-surface-dark via-transparent to-transparent opacity-60"></div>
        </div>

        <!-- Info -->
        <div class="p-4 sm:p-5 lg:p-6 flex flex-col flex-grow">
            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-white leading-tight mb-1">{{ $burger->name }}</h3>
            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $burger->description }}</p>

            <div class="mt-auto flex items-center justify-between gap-3">
                <div class="flex flex-col">
                    <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Prix</span>
                    <span class="text-lg sm:text-xl lg:text-2xl font-black text-secondary">
                        {{ number_format($burger->price, 0, ',', ' ') }} FCFA
                    </span>
                </div>
                @if($burger->stock_quantity > 0)
                <button onclick="addToCart({{ $burger->id }}, @js($burger->name), {{ $burger->price }}, @js($burger->image_path))"
                    class="h-11 sm:h-12 lg:h-14 px-5 sm:px-6 lg:px-8 bg-primary hover:bg-red-700 text-white rounded-xl font-bold text-sm sm:text-base lg:text-lg shadow-lg shadow-primary/30 flex items-center gap-1.5 sm:gap-2 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    AJOUTER
                </button>
                @else
                <button class="h-11 sm:h-12 lg:h-14 px-5 sm:px-6 lg:px-8 bg-[#372b2a] text-gray-500 rounded-xl font-bold text-sm sm:text-base cursor-not-allowed flex items-center gap-1.5 border border-gray-700" disabled>
                    ÉPUISÉ
                </button>
                @endif
            </div>
        </div>
    </article>
    @endforeach

    @if($burgers->isEmpty())
    <div class="col-span-full text-center py-20">
        <span class="material-symbols-outlined text-6xl text-gray-600 mb-4 block">lunch_dining</span>
        <p class="text-gray-500 text-lg">Aucun burger disponible pour le moment.</p>
    </div>
    @endif
</div>

<!-- Footer cart bar -->
<div id="footer-cart" class="fixed bottom-0 left-0 w-full p-3 sm:p-4 pointer-events-none z-50 flex justify-center hidden">
    <a href="{{ route('kiosk.checkout') }}"
        class="pointer-events-auto bg-primary text-white font-bold text-base sm:text-lg py-3 sm:py-4 px-5 sm:px-8 rounded-full shadow-2xl shadow-primary/50 flex items-center justify-between gap-4 sm:gap-8 max-w-2xl w-full hover:scale-[1.02] transition-transform duration-200 group ring-4 ring-black/50">
        <div class="flex items-center gap-2 sm:gap-3">
            <div class="bg-white/20 p-1.5 sm:p-2 rounded-full">
                <span class="material-symbols-outlined text-xl">shopping_basket</span>
            </div>
            <div class="flex flex-col items-start leading-tight">
                <span class="text-sm font-medium text-white/90">Voir ma commande</span>
                <span class="text-xs text-white/70" id="cart-count">0 articles</span>
            </div>
        </div>
        <div class="flex items-center gap-1.5 sm:gap-2">
            <span class="text-lg sm:text-xl font-black tracking-wide" id="cart-total">0 FCFA</span>
            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </div>
    </a>
</div>

@push('scripts')
<script>
    let currentCategory = 'all';

    function filterBurgers() {
        const search = document.getElementById('search-input').value.toLowerCase();
        const priceMin = parseFloat(document.getElementById('price-min').value) || 0;
        const priceMax = parseFloat(document.getElementById('price-max').value) || Infinity;
        const items = document.querySelectorAll('.burger-item');

        items.forEach(item => {
            const name = item.dataset.name;
            const category = item.dataset.category || '';
            const price = parseFloat(item.dataset.price) || 0;
            const matchesSearch = name.includes(search);
            const matchesCategory = currentCategory === 'all' || category === currentCategory;
            const matchesPrice = price >= priceMin && price <= priceMax;
            item.style.display = (matchesSearch && matchesCategory && matchesPrice) ? 'flex' : 'none';
        });
    }

    function clearPriceFilter() {
        document.getElementById('price-min').value = '';
        document.getElementById('price-max').value = '';
        filterBurgers();
    }

    function setCategory(category) {
        currentCategory = category;
        document.querySelectorAll('.category-btn').forEach(btn => {
            if (btn.dataset.category === category) {
                btn.classList.remove('bg-surface-dark', 'text-gray-300', 'hover:bg-[#333]', 'border', 'border-[#372b2a]');
                btn.classList.add('bg-primary', 'text-white', 'font-bold', 'shadow-lg');
            } else {
                btn.classList.add('bg-surface-dark', 'text-gray-300', 'hover:bg-[#333]', 'border', 'border-[#372b2a]');
                btn.classList.remove('bg-primary', 'text-white', 'font-bold', 'shadow-lg');
            }
        });
        filterBurgers();
    }

    function updateCartUI() {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const count = cart.reduce((sum, item) => sum + item.quantity, 0);

        document.getElementById('header-total').innerText = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
        document.getElementById('cart-total').innerText = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
        document.getElementById('cart-count').innerText = count + (count > 1 ? ' articles' : ' article');

        const footer = document.getElementById('footer-cart');
        footer.classList.toggle('hidden', count === 0);
    }

    function addToCart(id, name, price, image) {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({ id, name, price, image, quantity: 1 });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    }

    document.addEventListener('DOMContentLoaded', updateCartUI);
</script>
@endpush
@endsection
