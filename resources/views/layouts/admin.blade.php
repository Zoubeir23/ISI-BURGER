<!DOCTYPE html>
<html lang="fr" id="html-root">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ISI BURGER Admin - @yield('title')</title>

    <!-- ⚡ Anti-flash FIRST — avant tout CSS/font (évite le flash blanc) -->
    <script>
        (function() {
            if (localStorage.getItem('admin-theme') === 'dark') {
                var html = document.documentElement;
                html.classList.add('dark-mode');
                // Appliquer le fond sombre immédiatement via style inline
                html.style.backgroundColor = '#0f0f0f';
                html.style.colorScheme = 'dark';
            }
        })();
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary":      "#e53e3e",
                        "primary-dark": "#c53030",
                        "secondary":    "#1f2937",
                        "success":      "#22c55e",
                        "warning":      "#f59e0b",
                        "danger":       "#ef4444",
                        "info":         "#3b82f6",
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
        /* ── Anti-flash ── */
        html           { background-color: #f9fafb; color-scheme: light; }
        html.dark-mode { background-color: #0d0d0d; color-scheme: dark; }

        /* ── Variables light (default) ── */
        :root {
            --admin-accent:       #e53e3e;
            --admin-accent-dark:  #c53030;
            --admin-bg:           #f9fafb;
            --admin-content-bg:   #f1f5f9;
            --admin-header-bg:    #ffffff;
            --admin-header-text:  #111827;
            --admin-header-sub:   #6b7280;
            --admin-header-border:#e5e7eb;
            --admin-card-bg:      #ffffff;
            --admin-card-border:  #e5e7eb;
            --admin-text:         #111827;
            --admin-text-muted:   #6b7280;
            --admin-text-dim:     #9ca3af;
            --admin-border:       #e5e7eb;
            --admin-row-hover:    #fafafa;
            --admin-thead-bg:     #f9fafb;
            --admin-divide:       #f3f4f6;
            /* sidebar */
            --sidebar-bg:         #f8fafc;
            --sidebar-border:     #e5e7eb;
            --sidebar-title:      #111827;
            --sidebar-nav-text:   #64748b;
            --sidebar-hover-bg:   rgba(0,0,0,0.05);
            --sidebar-hover-text: #0f172a;
            --sidebar-divider:    rgba(0,0,0,0.08);
            --sidebar-user-hover: rgba(0,0,0,0.05);
        }

        /* ── Variables dark ── */
        html.dark-mode {
            --admin-accent:       #e53e3e;
            --admin-accent-dark:  #c53030;
            --admin-bg:           #0d0d0d;
            --admin-content-bg:   #0f1117;
            --admin-header-bg:    #161b27;
            --admin-header-text:  #f1f5f9;
            --admin-header-sub:   #6b7280;
            --admin-header-border:rgba(255,255,255,0.07);
            --admin-card-bg:      #1a2035;
            --admin-card-border:  rgba(255,255,255,0.07);
            --admin-text:         #e2e8f0;
            --admin-text-muted:   #94a3b8;
            --admin-text-dim:     #64748b;
            --admin-border:       rgba(255,255,255,0.07);
            --admin-row-hover:    #1c2540;
            --admin-thead-bg:     #161b27;
            --admin-divide:       rgba(255,255,255,0.04);
            /* sidebar */
            --sidebar-bg:         #111827;
            --sidebar-border:     rgba(255,255,255,0.07);
            --sidebar-title:      #ffffff;
            --sidebar-nav-text:   #6b7280;
            --sidebar-hover-bg:   rgba(255,255,255,0.05);
            --sidebar-hover-text: #e5e7eb;
            --sidebar-divider:    rgba(255,255,255,0.06);
            --sidebar-user-hover: rgba(255,255,255,0.05);
        }

        html.dark-mode { background-color: #0d0d0d !important; color-scheme: dark; }
        html.dark-mode body { background-color: var(--admin-bg) !important; }

        /* Sidebar slide transition */
        #sidebar {
            transition: transform 0.3s ease, background-color 0.3s, border-color 0.3s;
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

        /* ── Dark mode — layout zones ── */
        html.dark-mode #admin-main-content  { background-color: var(--admin-content-bg) !important; }
        html.dark-mode #admin-header        { background-color: var(--admin-header-bg) !important; border-color: var(--admin-header-border) !important; }
        html.dark-mode .admin-content-scroll { background-color: var(--admin-content-bg) !important; }

        /* ── Dark mode — cards ── */
        html.dark-mode .bg-white  { background-color: var(--admin-card-bg) !important; }
        html.dark-mode .bg-gray-50 { background-color: var(--admin-thead-bg) !important; }
        html.dark-mode .bg-gray-100 { background-color: #1e1e1e !important; }

        /* ── Dark mode — borders ── */
        html.dark-mode .border-gray-200 { border-color: var(--admin-card-border) !important; }
        html.dark-mode .border-gray-100 { border-color: var(--admin-divide) !important; }
        html.dark-mode .border-gray-300 { border-color: rgba(255,255,255,0.12) !important; }
        html.dark-mode .divide-gray-100 > * + *,
        html.dark-mode .divide-gray-200 > * + * { border-color: var(--admin-divide) !important; }

        /* ── Dark mode — text ── */
        html.dark-mode .text-slate-900,
        html.dark-mode .text-gray-900 { color: var(--admin-text) !important; }
        html.dark-mode .text-slate-700,
        html.dark-mode .text-gray-700 { color: #cbd5e1 !important; }
        html.dark-mode .text-gray-600 { color: var(--admin-text-muted) !important; }
        html.dark-mode .text-gray-500 { color: var(--admin-text-dim) !important; }
        html.dark-mode .text-gray-400 { color: #475569 !important; }

        /* ── Dark mode — inputs & forms ── */
        html.dark-mode input:not([type="checkbox"]):not([type="radio"]),
        html.dark-mode select,
        html.dark-mode textarea {
            -webkit-appearance: none !important;
            appearance: none !important;
            background-color: #1a2035 !important;
            border-color: rgba(255,255,255,0.1) !important;
            color: var(--admin-text, #e2e8f0) !important;
            caret-color: var(--admin-text, #e2e8f0) !important;
            color-scheme: dark;
        }
        html.dark-mode input::placeholder,
        html.dark-mode textarea::placeholder { color: #475569 !important; }
        html.dark-mode input:-webkit-autofill,
        html.dark-mode input:-webkit-autofill:hover,
        html.dark-mode input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #1a2035 inset !important;
            -webkit-text-fill-color: var(--admin-text, #e2e8f0) !important;
            caret-color: var(--admin-text, #e2e8f0) !important;
        }
        html.dark-mode input:focus,
        html.dark-mode select:focus,
        html.dark-mode textarea:focus {
            border-color: #e53e3e !important;
            box-shadow: 0 0 0 2px rgba(229,62,62,0.2) !important;
        }

        /* ── Dark mode — table rows ── */
        html.dark-mode .hover\:bg-gray-50:hover { background-color: var(--admin-row-hover) !important; }
        html.dark-mode tr:hover { background-color: var(--admin-row-hover) !important; }

        /* ── Dark mode — alerts ── */
        html.dark-mode .bg-green-100 { background-color: rgba(16,185,129,0.12) !important; }
        html.dark-mode .bg-red-100   { background-color: rgba(239,68,68,0.12) !important; }
        html.dark-mode .bg-yellow-100 { background-color: rgba(245,158,11,0.12) !important; }
        html.dark-mode .bg-blue-100  { background-color: rgba(59,130,246,0.12) !important; }

        /* ── Dark mode — stat card top borders keep their colors ── */
        html.dark-mode .border-t-4 { /* keep accent colors unchanged */ }

        /* ── Dark mode — badge icons bg ── */
        html.dark-mode .bg-primary\/10 { background-color: rgba(229,62,62,0.15) !important; }
        html.dark-mode .bg-success\/10 { background-color: rgba(34,197,94,0.15) !important; }
        html.dark-mode .bg-warning\/10 { background-color: rgba(245,158,11,0.15) !important; }
        html.dark-mode .bg-red-50      { background-color: rgba(239,68,68,0.1) !important; }

        /* ── Dark mode — shadow on cards ── */
        html.dark-mode .shadow-sm { box-shadow: 0 1px 3px rgba(0,0,0,0.4) !important; }
        html.dark-mode .shadow-md { box-shadow: 0 4px 12px rgba(0,0,0,0.5) !important; }

        /* Theme toggle button in admin header */
        .admin-theme-toggle {
            width: 36px; height: 36px;
            border-radius: 10px;
            border: 1px solid var(--admin-header-border, #e5e7eb);
            background: transparent;
            color: var(--admin-text-muted, #6b7280);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        html.dark-mode .admin-theme-toggle {
            border-color: rgba(255,255,255,0.12);
            color: #9ca3af;
        }
        .admin-theme-toggle:hover {
            border-color: #e53e3e;
            color: #e53e3e;
        }

        /* ── Toast notifications ── */
        .toast-container {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
            width: 22rem;
            pointer-events: none;
        }
        .toast-item {
            pointer-events: all;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.875rem 1rem 1.125rem;
            border-radius: 0.875rem;
            border: 1px solid var(--admin-card-border, #e5e7eb);
            border-left-width: 4px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
            position: relative;
            overflow: hidden;
            background: var(--admin-card-bg, #ffffff);
            animation: toastSlideIn 0.4s cubic-bezier(0.34,1.56,0.64,1) forwards;
        }
        .toast-item.removing {
            animation: toastSlideOut 0.3s ease-in forwards;
        }
        .toast-item[data-type="success"] { border-left-color: #22c55e; }
        .toast-item[data-type="success"] .toast-icon { color: #22c55e; }
        .toast-item[data-type="success"] .toast-bar  { background: #22c55e; }
        .toast-item[data-type="error"]   { border-left-color: #ef4444; }
        .toast-item[data-type="error"]   .toast-icon { color: #ef4444; }
        .toast-item[data-type="error"]   .toast-bar  { background: #ef4444; }
        .toast-item[data-type="warning"] { border-left-color: #f59e0b; }
        .toast-item[data-type="warning"] .toast-icon { color: #f59e0b; }
        .toast-item[data-type="warning"] .toast-bar  { background: #f59e0b; }
        .toast-item[data-type="info"]    { border-left-color: #3b82f6; }
        .toast-item[data-type="info"]    .toast-icon { color: #3b82f6; }
        .toast-item[data-type="info"]    .toast-bar  { background: #3b82f6; }
        .toast-icon {
            font-size: 1.375rem !important;
            flex-shrink: 0;
            margin-top: 1px;
            font-variation-settings: 'FILL' 1;
        }
        .toast-title {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--admin-text, #111827);
            line-height: 1.35;
        }
        .toast-msg {
            font-size: 0.78rem;
            color: var(--admin-text-muted, #6b7280);
            margin-top: 0.2rem;
            line-height: 1.45;
        }
        .toast-close {
            flex-shrink: 0;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--admin-text-dim, #9ca3af);
            padding: 0;
            line-height: 1;
            margin-top: 1px;
            transition: color 0.15s;
        }
        .toast-close:hover { color: var(--admin-text, #111827); }
        .toast-bar {
            position: absolute;
            bottom: 0; left: 0;
            height: 3px;
            animation: toastProgress 4.5s linear forwards;
        }
        @keyframes toastSlideIn {
            from { transform: translateX(calc(100% + 2rem)); opacity: 0; }
            to   { transform: translateX(0); opacity: 1; }
        }
        @keyframes toastSlideOut {
            from { transform: translateX(0); opacity: 1; max-height: 120px; }
            to   { transform: translateX(calc(100% + 2rem)); opacity: 0; max-height: 0; padding-top: 0; padding-bottom: 0; margin: 0; }
        }
        @keyframes toastProgress {
            from { width: 100%; }
            to   { width: 0%; }
        }
    </style>

</head>
<body class="font-display antialiased" style="background-color: var(--admin-bg, #f9fafb); color: var(--admin-text, #111827);">

<!-- Sidebar overlay (mobile) -->
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<div class="flex h-screen w-full overflow-hidden">
    <!-- Sidebar -->
    <aside id="sidebar" class="flex w-[260px] flex-col h-full flex-shrink-0 lg:static lg:translate-x-0" style="background: var(--sidebar-bg); border-right: 1px solid var(--sidebar-border);">
        <div class="flex h-16 lg:h-20 items-center px-6" style="background: var(--sidebar-bg); border-bottom: 1px solid var(--sidebar-border);">
            <!-- Orange burger icon -->
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 mr-3" style="background: #e53e3e; box-shadow: 0 4px 14px rgba(229,62,62,0.4);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" style="width:18px;height:18px;">
                    <path d="M20 10.5V9c0-3.87-3.13-7-7-7S6 5.13 6 9v1.5C4.84 10.5 4 11.34 4 12.5V19c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6.5c0-1.16-.84-2-2-2zM12 4c2.76 0 5 2.24 5 5H7c0-2.76 2.24-5 5-5zm2 11.5h-4v-2c0-.55.45-1 1-1h2c.55 0 1 .45 1 1v2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-tight leading-none" style="color: var(--sidebar-title);">ISI <span style="color:#e53e3e;">BURGER</span></h1>
                <p class="text-[10px] font-semibold mt-0.5 uppercase tracking-widest" style="color: var(--sidebar-nav-text);">Admin Console</p>
            </div>
            <!-- Close button mobile -->
            <button onclick="closeSidebar()" class="ml-auto lg:hidden" style="color: var(--sidebar-nav-text);">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        @php
        $navItems = [
            ['route' => 'admin.dashboard',   'icon' => 'dashboard',       'label' => 'Tableau de bord'],
            ['route' => 'admin.orders.*',     'icon' => 'shopping_bag',    'label' => 'Commandes'],
            ['route' => 'admin.burgers.*',    'icon' => 'restaurant_menu', 'label' => 'Burgers'],
            ['route' => 'admin.stocks.*',     'icon' => 'inventory_2',     'label' => 'Stocks'],
        ];
        $navRoutes = [
            'admin.dashboard' => 'admin.dashboard',
            'admin.orders.*'  => 'admin.orders.index',
            'admin.burgers.*' => 'admin.burgers.index',
            'admin.stocks.*'  => 'admin.stocks.index',
        ];
        @endphp
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-1">
            @foreach($navItems as $item)
            @php $isActive = request()->routeIs($item['route']); @endphp
            <a href="{{ route($navRoutes[$item['route']]) }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group"
               style="{{ $isActive ? 'background: rgba(229,62,62,0.15); color: #e53e3e;' : 'color: #6b7280;' }}"
               onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) sidebarHover(this, true);"
               onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) sidebarHover(this, false);">
                <span class="material-symbols-outlined text-[20px]" style="{{ $isActive ? 'color:#e53e3e;' : '' }}">{{ $item['icon'] }}</span>
                <span class="text-sm font-semibold">{{ $item['label'] }}</span>
                @if($isActive)
                <div class="ml-auto w-1.5 h-1.5 rounded-full" style="background:#e53e3e;"></div>
                @endif
            </a>
            @endforeach

            <div class="pt-5 mt-3 border-t" style="border-color: var(--sidebar-divider);">
                <p class="px-4 text-[10px] font-bold uppercase tracking-widest mb-3" style="color: var(--sidebar-nav-text);">Système</p>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 transition-all duration-200 cursor-pointer"
                        onmouseover="this.style.background='rgba(239,68,68,0.1)';this.style.color='#ef4444';"
                        onmouseout="this.style.background='';this.style.color='';">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                        <span class="text-sm font-semibold">Déconnexion</span>
                    </button>
                </form>
            </div>
        </nav>
        <div class="p-4 border-t" style="border-color: var(--sidebar-divider);">
            <div class="flex items-center gap-3 p-2.5 rounded-xl cursor-pointer"
                 onmouseover="this.style.background=getComputedStyle(document.documentElement).getPropertyValue('--sidebar-user-hover').trim();"
                 onmouseout="this.style.background='';">
                <div class="h-9 w-9 rounded-full flex items-center justify-center flex-shrink-0" style="background: rgba(229,62,62,0.2); color: #e53e3e;">
                    <span class="material-symbols-outlined text-xl">person</span>
                </div>
                <div class="flex flex-col overflow-hidden">
                    <span class="text-sm font-bold truncate" style="color: var(--sidebar-title);">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <span class="text-xs truncate" style="color: var(--sidebar-nav-text);">{{ Auth::user()->email ?? '' }}</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main id="admin-main-content" class="flex-1 flex flex-col h-full overflow-hidden min-w-0 transition-colors duration-300" style="background-color: var(--admin-content-bg, #f1f5f9);">
        <!-- Header -->
        <header id="admin-header" class="h-16 lg:h-[72px] border-b flex items-center justify-between px-4 lg:px-8 flex-shrink-0 z-10 transition-colors duration-300" style="background-color: var(--admin-header-bg, #ffffff); border-color: var(--admin-header-border, #e5e7eb);">
            <div class="flex items-center gap-3">
                <!-- Hamburger (mobile only) -->
                <button onclick="openSidebar()" class="lg:hidden p-2 rounded-xl transition-colors cursor-pointer" style="color: var(--admin-text-muted);"
                    onmouseover="this.style.background='var(--admin-content-bg)';"
                    onmouseout="this.style.background='';">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h2 class="admin-page-title text-lg lg:text-2xl font-bold leading-tight" style="color: var(--admin-header-text, #111827);">@yield('header')</h2>
                    <p class="admin-page-sub text-xs mt-0.5 hidden sm:flex items-center gap-1" style="color: var(--admin-header-sub, #6b7280);">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        {{ now()->format('l, d F Y') }}
                    </p>
                </div>
            </div>

            <!-- Theme toggle -->
            <button class="admin-theme-toggle" id="admin-theme-btn" onclick="toggleAdminTheme()" title="Basculer mode sombre/clair" aria-label="Changer le thème">
                <svg id="admin-icon-moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
                    <path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 01.26.77 7 7 0 009.958 7.967.75.75 0 011.067.853A8.5 8.5 0 116.647 1.921a.75.75 0 01.808.083z" clip-rule="evenodd"/>
                </svg>
                <svg id="admin-icon-sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;display:none;">
                    <path d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 15zM10 7a3 3 0 100 6 3 3 0 000-6zM15.657 5.404a.75.75 0 10-1.06-1.06l-1.061 1.06a.75.75 0 001.06 1.06l1.06-1.06zM6.464 14.596a.75.75 0 10-1.06-1.06l-1.06 1.06a.75.75 0 001.06 1.06l1.06-1.06zM18 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 0118 10zM5 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 015 10zM14.596 15.657a.75.75 0 001.06-1.06l-1.06-1.061a.75.75 0 10-1.06 1.06l1.06 1.06zM5.404 6.464a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.061 1.06l1.06 1.06z"/>
                </svg>
            </button>
        </header>

        <div class="admin-content-scroll flex-1 overflow-y-auto p-4 lg:p-8 transition-colors duration-300" style="background-color: var(--admin-content-bg, #f1f5f9);">
            @yield('content')
        </div>
    </main>
</div>

<!-- ── Toast notifications ── -->
@php
    $toastQueue = [];
    if (session('success')) $toastQueue[] = ['type' => 'success', 'title' => 'Succès',              'icon' => 'check_circle', 'msg' => session('success')];
    if (session('error'))   $toastQueue[] = ['type' => 'error',   'title' => 'Erreur',               'icon' => 'error',        'msg' => session('error')];
    if (session('warning')) $toastQueue[] = ['type' => 'warning', 'title' => 'Attention',            'icon' => 'warning',      'msg' => session('warning')];
    if (session('info'))    $toastQueue[] = ['type' => 'info',    'title' => 'Information',          'icon' => 'info',         'msg' => session('info')];
    if ($errors->any())     $toastQueue[] = ['type' => 'error',   'title' => 'Erreur de validation', 'icon' => 'error',        'msg' => implode(' · ', $errors->all())];
@endphp
@if(count($toastQueue))
<div class="toast-container" id="toast-container">
    @foreach($toastQueue as $t)
    <div class="toast-item" data-type="{{ $t['type'] }}" role="alert" aria-live="assertive">
        <span class="material-symbols-outlined toast-icon">{{ $t['icon'] }}</span>
        <div style="flex:1;min-width:0;">
            <p class="toast-title">{{ $t['title'] }}</p>
            <p class="toast-msg">{{ $t['msg'] }}</p>
        </div>
        <button type="button" class="toast-close" onclick="closeToast(this)" aria-label="Fermer">
            <span class="material-symbols-outlined" style="font-size:1.125rem;">close</span>
        </button>
        <div class="toast-bar"></div>
    </div>
    @endforeach
</div>
@endif

<script>
    function sidebarHover(el, entering) {
        const s = getComputedStyle(document.documentElement);
        if (entering) {
            el.style.background = s.getPropertyValue('--sidebar-hover-bg').trim();
            el.style.color      = s.getPropertyValue('--sidebar-hover-text').trim();
        } else {
            el.style.background = '';
            el.style.color      = s.getPropertyValue('--sidebar-nav-text').trim();
        }
    }

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

    function syncAdminThemeIcons() {
        const isDark = document.getElementById('html-root').classList.contains('dark-mode');
        document.getElementById('admin-icon-moon').style.display = isDark ? 'none' : 'block';
        document.getElementById('admin-icon-sun').style.display  = isDark ? 'block' : 'none';
    }

    function toggleAdminTheme() {
        const html = document.getElementById('html-root');
        html.classList.toggle('dark-mode');
        const isDark = html.classList.contains('dark-mode');
        localStorage.setItem('admin-theme', isDark ? 'dark' : 'light');
        syncAdminThemeIcons();
    }

    document.addEventListener('DOMContentLoaded', syncAdminThemeIcons);

    function closeToast(btn) {
        dismissToast(btn.closest('.toast-item'));
    }
    function dismissToast(el) {
        el.classList.add('removing');
        el.addEventListener('animationend', function () { el.remove(); }, { once: true });
    }
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toast-item').forEach(function (toast) {
            setTimeout(function () {
                if (toast.isConnected) dismissToast(toast);
            }, 4500);
        });
    });
</script>
</body>
</html>
