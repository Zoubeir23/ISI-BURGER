<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ISI BURGER - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#bf3a2b",
              "secondary": "#E67E22",
              "success": "#27AE60",
              "background-light": "#f8f6f6",
              "background-dark": "#1C1C1C",
              "surface-dark": "#2A2A2A",
            },
            fontFamily: {
              "display": ["Inter", "sans-serif"],
              "body": ["Inter", "sans-serif"],
            },
            borderRadius: {
              "DEFAULT": "0.375rem",
              "lg": "0.5rem",
              "xl": "0.75rem",
              "2xl": "1rem",
              "full": "9999px"
            },
          },
        },
      }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1C1C1C; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #444; }
        /* Hide scrollbar for category filter */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-background-dark text-slate-100 min-h-screen flex flex-col font-display antialiased selection:bg-primary selection:text-white">

<header class="sticky top-0 z-50 w-full bg-[#1C1C1C]/95 backdrop-blur-sm border-b border-[#372b2a] shadow-lg">
    <div class="px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between max-w-7xl mx-auto gap-3">
        <!-- Logo -->
        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
            <div class="size-8 sm:size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                <span class="material-symbols-outlined" style="font-size: 22px;">lunch_dining</span>
            </div>
            <h1 class="text-white text-lg sm:text-2xl font-black tracking-tight leading-none">
                ISI <span class="text-primary">BURGER</span>
            </h1>
        </div>

        <!-- Subtitle (hidden on very small screens) -->
        <div class="hidden md:block flex-1 text-center">
            <h2 class="text-white text-base lg:text-lg font-medium tracking-wide">@yield('subtitle', 'Que souhaitez-vous commander ?')</h2>
        </div>

        <!-- Header actions (cart total etc.) -->
        <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
            @yield('header_actions')
        </div>
    </div>
</header>

<main class="flex-grow flex flex-col items-center w-full max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-8 pb-28 sm:pb-32">
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
