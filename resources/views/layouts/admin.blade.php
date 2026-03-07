<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ISI BURGER Admin - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#f2240d",
                        "background-light": "#f8f6f5",
                        "background-dark": "#221210",
                        "sidebar-dark": "#1C1C1C",
                        "success": "#10B981",
                        "warning": "#F59E0B",
                        "info": "#3B82F6",
                    },
                    fontFamily: {
                        "display": ["Be Vietnam Pro", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        /* Sidebar slide transition */
        #sidebar {
            transition: transform 0.3s ease;
        }
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed;
                top: 0; left: 0;
                height: 100vh;
                transform: translateX(-100%);
                z-index: 40;
            }
            #sidebar.open {
                transform: translateX(0);
            }
        }
        /* Overlay */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 30;
        }
        #sidebar-overlay.open {
            display: block;
        }
    </style>
</head>
<body class="bg-background-light font-display text-slate-900 antialiased">

<!-- Sidebar overlay (mobile) -->
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<div class="flex h-screen w-full overflow-hidden">
    <!-- Sidebar -->
    <aside id="sidebar" class="flex w-[260px] flex-col bg-[#1C1C1C] text-white h-full flex-shrink-0 lg:static lg:translate-x-0">
        <div class="flex h-16 lg:h-20 items-center px-6 border-b border-gray-800 bg-[#1C1C1C]">
            <span class="material-symbols-outlined text-primary text-3xl mr-3">lunch_dining</span>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-white leading-none">ISI <span class="text-primary">BURGER</span></h1>
                <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Admin Console</p>
            </div>
            <!-- Close button mobile -->
            <button onclick="closeSidebar()" class="ml-auto lg:hidden text-gray-400 hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group transition-all mb-2" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm font-medium">Tableau de bord</span>
            </a>
            <a class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group transition-all" href="{{ route('admin.orders.index') }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <span class="text-sm font-medium">Commandes</span>
                </div>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.burgers.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group transition-all" href="{{ route('admin.burgers.index') }}">
                <span class="material-symbols-outlined">restaurant_menu</span>
                <span class="text-sm font-medium">Gestion des Burgers</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.stocks.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group transition-all" href="{{ route('admin.stocks.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-sm font-medium">Stocks</span>
            </a>
            <div class="pt-6 mt-2">
                <p class="px-4 text-xs font-bold text-gray-600 uppercase tracking-widest mb-3">Système</p>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white group transition-all">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="text-sm font-medium">Déconnexion</span>
                    </button>
                </form>
            </div>
        </nav>
        <div class="p-4 border-t border-gray-800 bg-[#1C1C1C]">
            <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-800 transition-colors cursor-pointer">
                <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center text-white overflow-hidden border-2 border-gray-600 relative">
                    <span class="material-symbols-outlined absolute text-2xl">person</span>
                </div>
                <div class="flex flex-col overflow-hidden">
                    <span class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <span class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? '' }}</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#F3F4F6] min-w-0">
        <!-- Header -->
        <header class="h-16 lg:h-20 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 flex-shrink-0 z-10">
            <div class="flex items-center gap-3">
                <!-- Hamburger (mobile only) -->
                <button onclick="openSidebar()" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h2 class="text-lg lg:text-2xl font-bold text-slate-900 leading-tight">@yield('header')</h2>
                    <p class="text-xs text-gray-500 mt-0.5 hidden sm:flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        {{ now()->format('l, d F Y') }}
                    </p>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 lg:p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }
</script>
</body>
</html>
