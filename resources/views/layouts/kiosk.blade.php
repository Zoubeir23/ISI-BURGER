<!DOCTYPE html>
<html lang="fr" id="html-root">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ISI BURGER - @yield('title')</title>

    <!-- ⚡ Anti-flash FIRST -->
    <script>
        (function() {
            var saved = localStorage.getItem('kiosk-theme');
            var html  = document.documentElement;
            if (saved === 'light') {
                html.classList.add('light');
                html.style.backgroundColor = '#f9fafb';
                html.style.colorScheme = 'light';
            } else {
                html.style.backgroundColor = '#0f1117';
                html.style.colorScheme = 'dark';
            }
        })();
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display+SC:wght@400;700&family=Barlow+Condensed:wght@700;900&family=Karla:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @stack('head')
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
              "danger":       "#ef4444",
              "warning":      "#f59e0b",
            },
            fontFamily: {
              "display": ["'Playfair Display SC'", "serif"],
              "price":   ["'Barlow Condensed'", "sans-serif"],
              "body":    ["Karla", "sans-serif"],
            },
          },
        },
      }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* ── Anti-flash base ── */
        html       { background-color: #0f1117; color-scheme: dark; }
        html.light { background-color: #f9fafb; color-scheme: light; }

        /* ── Palette : dark (default) ── */
        :root {
            --bg-base:      #0f1117;
            --surface:      #1c2333;
            --surface-2:    #232d3f;
            --card-bg:      #1a2035;
            --border:       rgba(255,255,255,0.07);
            --border-input: rgba(255,255,255,0.12);
            --text:         #f9fafb;
            --text-muted:   #9ca3af;
            --text-dim:     #4b5563;
            --input-bg:     #111827;
            --header-bg:    rgba(15,17,23,0.97);
            --header-border:rgba(255,255,255,0.06);
            --filter-bg:    #1c2333;
            --pill-inactive:#1c2333;
            --pill-text:    #9ca3af;
            --pill-border:  rgba(255,255,255,0.1);
            --price-color:  #e53e3e;
            --accent:       #e53e3e;
            --accent-dark:  #c53030;
        }

        /* ── Palette : light ── */
        html.light {
            --bg-base:      #f9fafb;
            --surface:      #ffffff;
            --surface-2:    #f3f4f6;
            --card-bg:      #ffffff;
            --border:       rgba(0,0,0,0.07);
            --border-input: #e5e7eb;
            --text:         #111827;
            --text-muted:   #6b7280;
            --text-dim:     #9ca3af;
            --input-bg:     #f9fafb;
            --header-bg:    rgba(249,250,251,0.97);
            --header-border:rgba(0,0,0,0.07);
            --filter-bg:    #ffffff;
            --pill-inactive:#f3f4f6;
            --pill-text:    #6b7280;
            --pill-border:  #e5e7eb;
            --price-color:  #e53e3e;
            --accent:       #e53e3e;
            --accent-dark:  #c53030;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Karla', sans-serif;
            background-color: var(--bg-base);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-input); border-radius: 4px; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* Brand */
        .brand-isi    { font-family: 'Playfair Display SC', serif; font-weight: 700; letter-spacing: 0.05em; }
        .brand-burger { font-family: 'Playfair Display SC', serif; font-weight: 700; color: #e53e3e; letter-spacing: 0.05em; }

        /* Header */
        .site-header {
            background-color: var(--header-bg);
            border-bottom: 1px solid var(--header-border);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* Red glow line under header */
        .header-glow {
            background: linear-gradient(90deg, transparent 0%, #e53e3e 30%, #fc8181 50%, #e53e3e 70%, transparent 100%);
            height: 1.5px;
            opacity: 0.45;
        }

        /* Theme toggle */
        .theme-toggle {
            width: 36px; height: 36px;
            border-radius: 10px;
            border: 1px solid var(--border-input);
            background: var(--surface);
            color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .theme-toggle:hover { border-color: #e53e3e; color: #e53e3e; }

        /* ── Override global Tailwind forms CDN — dark mode ── */
        html:not(.light) input,
        html:not(.light) input[type="text"],
        html:not(.light) input[type="search"],
        html:not(.light) input[type="number"],
        html:not(.light) input[type="email"],
        html:not(.light) input[type="tel"],
        html:not(.light) input[type="password"],
        html:not(.light) select,
        html:not(.light) textarea {
            background-color: var(--surface, #1c2333) !important;
            border-color: var(--border-input, rgba(255,255,255,0.12)) !important;
            color: var(--text, #f9fafb) !important;
            color-scheme: dark;
        }
        html:not(.light) input::placeholder,
        html:not(.light) textarea::placeholder {
            color: var(--text-dim, #4b5563) !important;
        }
        html:not(.light) input:-webkit-autofill,
        html:not(.light) input:-webkit-autofill:hover,
        html:not(.light) input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px var(--surface, #1c2333) inset !important;
            -webkit-text-fill-color: var(--text, #f9fafb) !important;
            caret-color: var(--text, #f9fafb) !important;
        }

        /* Light mode */
        html.light input,
        html.light input[type="text"],
        html.light input[type="search"],
        html.light input[type="number"],
        html.light input[type="email"],
        html.light input[type="tel"],
        html.light select,
        html.light textarea {
            background-color: #ffffff !important;
            border-color: #e5e7eb !important;
            color: #111827 !important;
            color-scheme: light;
        }
        html.light input::placeholder { color: #9ca3af !important; }

        html.light .burger-card-kiosk { box-shadow: 0 2px 16px rgba(0,0,0,0.08); }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body style="color: var(--text);">

<header class="site-header sticky top-0 z-50 w-full">
    <div class="px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between max-w-7xl mx-auto gap-3">
        <!-- Logo -->
        <a href="{{ route('kiosk.index', [], false) }}" class="flex items-center gap-2.5 sm:gap-3 flex-shrink-0 group cursor-pointer">
            <div class="size-9 sm:size-11 rounded-xl flex items-center justify-center text-white transition-all duration-200 shadow-lg group-hover:scale-105"
                 style="background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%); box-shadow: 0 4px 14px rgba(229,62,62,0.4);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 sm:w-6 h-5 sm:h-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 10.5V9c0-3.87-3.13-7-7-7S6 5.13 6 9v1.5C4.84 10.5 4 11.34 4 12.5V19c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6.5c0-1.16-.84-2-2-2zM12 4c2.76 0 5 2.24 5 5H7c0-2.76 2.24-5 5-5zm2 11.5h-4v-2c0-.55.45-1 1-1h2c.55 0 1 .45 1 1v2z"/>
                </svg>
            </div>
            <div class="leading-none">
                <div class="flex items-baseline gap-1">
                    <span class="brand-isi text-base sm:text-xl leading-none" style="color: var(--text);">ISI</span>
                    <span class="brand-burger text-base sm:text-xl leading-none">BURGER</span>
                </div>
                <p class="text-[10px] font-semibold tracking-widest uppercase mt-0.5 hidden sm:block" style="color: var(--text-muted);">Restaurant</p>
            </div>
        </a>

        <!-- Subtitle center -->
        <div class="hidden md:block flex-1 text-center">
            <p class="text-sm font-semibold tracking-widest uppercase" style="color: var(--text-muted);">@yield('subtitle', 'Que souhaitez-vous commander ?')</p>
        </div>

        <!-- Right actions -->
        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
            @yield('header_actions')

            <!-- Theme toggle -->
            <button class="theme-toggle" id="theme-toggle-btn" onclick="toggleTheme()" title="Changer le thème" aria-label="Basculer mode clair/sombre">
                <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
                    <path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 01.26.77 7 7 0 009.958 7.967.75.75 0 011.067.853A8.5 8.5 0 116.647 1.921a.75.75 0 01.808.083z" clip-rule="evenodd"/>
                </svg>
                <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;display:none;">
                    <path d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 15zM10 7a3 3 0 100 6 3 3 0 000-6zM15.657 5.404a.75.75 0 10-1.06-1.06l-1.061 1.06a.75.75 0 001.06 1.06l1.06-1.06zM6.464 14.596a.75.75 0 10-1.06-1.06l-1.06 1.06a.75.75 0 001.06 1.06l1.06-1.06zM18 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 0118 10zM5 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 015 10zM14.596 15.657a.75.75 0 001.06-1.06l-1.06-1.061a.75.75 0 10-1.06 1.06l1.06 1.06zM5.404 6.464a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.061 1.06l1.06 1.06z"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="header-glow"></div>
</header>

<main class="flex-grow flex flex-col items-center w-full max-w-7xl mx-auto px-3 sm:px-6 py-5 sm:py-8 pb-28 sm:pb-32">
    @yield('content')
</main>

@stack('scripts')

<script>
    function syncThemeIcons() {
        const isLight = document.getElementById('html-root').classList.contains('light');
        document.getElementById('icon-moon').style.display = isLight ? 'none' : 'block';
        document.getElementById('icon-sun').style.display  = isLight ? 'block' : 'none';
    }

    function toggleTheme() {
        const html = document.getElementById('html-root');
        html.classList.toggle('light');
        const isLight = html.classList.contains('light');
        localStorage.setItem('kiosk-theme', isLight ? 'light' : 'dark');
        syncThemeIcons();
    }

    document.addEventListener('DOMContentLoaded', syncThemeIcons);
</script>
</body>
</html>
