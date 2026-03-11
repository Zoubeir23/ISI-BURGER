<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISI BURGER — Connexion Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display+SC:wght@400;700&family=Karla:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <!-- Les styles après Tailwind pour priorité maximale -->
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Karla', sans-serif; margin: 0; }
        .brand-isi    { font-family: 'Playfair Display SC', serif; font-weight: 700; }
        .brand-burger { font-family: 'Playfair Display SC', serif; font-weight: 700; color: #e53e3e; }

        .bg-pattern {
            background-color: #0e0e0e;
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 40%, rgba(191,58,43,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 60%, rgba(230,126,34,0.07) 0%, transparent 60%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.016'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .glass-card {
            background: rgba(20, 20, 20, 0.92);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 32px 64px rgba(0,0,0,0.55), 0 0 0 1px rgba(255,255,255,0.04);
        }

        .accent-line {
            background: linear-gradient(90deg, transparent, #e53e3e, #E67E22, #e53e3e, transparent);
            height: 1.5px;
            opacity: 0.4;
            margin: 0 28px;
        }

        .field-label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.38);
            margin-bottom: 8px;
            font-family: 'Karla', sans-serif;
        }

        /* ── Forcer les champs sombres malgré le plugin Tailwind forms ── */
        .dark-input,
        .dark-input[type="email"],
        .dark-input[type="password"],
        .dark-input[type="text"] {
            -webkit-appearance: none !important;
            appearance: none !important;
            background-color: #1c1c1c !important;
            color: #e2e8f0 !important;
            caret-color: #e2e8f0 !important;
            border: 1.5px solid rgba(255,255,255,0.11) !important;
            border-radius: 10px !important;
            font-family: 'Karla', sans-serif !important;
            font-size: 15px !important;
            line-height: 1.5 !important;
            padding: 13px 16px !important;
            width: 100% !important;
            outline: none !important;
            box-shadow: none !important;
            color-scheme: dark !important;
            transition: border-color 0.2s, background-color 0.2s, box-shadow 0.2s !important;
        }
        .dark-input:focus,
        .dark-input[type="email"]:focus,
        .dark-input[type="password"]:focus {
            background-color: rgba(191,58,43,0.08) !important;
            border-color: #e53e3e !important;
            box-shadow: 0 0 0 3px rgba(191,58,43,0.15) !important;
        }
        .dark-input::placeholder { color: rgba(255,255,255,0.2) !important; }

        /* Autofill — empêche le fond blanc du navigateur */
        .dark-input:-webkit-autofill,
        .dark-input:-webkit-autofill:hover,
        .dark-input:-webkit-autofill:focus,
        .dark-input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #1c1c1c inset !important;
            -webkit-text-fill-color: #e2e8f0 !important;
            caret-color: #e2e8f0 !important;
        }

        .pw-wrap { position: relative; }
        .dark-input.has-icon { padding-right: 46px !important; }

        .pw-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255,255,255,0.28);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }
        .pw-toggle:hover { color: rgba(255,255,255,0.65); }

        .btn-login {
            width: 100%;
            background: #e53e3e;
            color: #fff;
            font-family: 'Karla', sans-serif;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 14px 20px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 18px rgba(191,58,43,0.38);
            transition: background 0.2s, transform 0.12s, box-shadow 0.2s;
            margin-top: 6px;
        }
        .btn-login:hover  { background: #c53030; box-shadow: 0 6px 26px rgba(191,58,43,0.5); }
        .btn-login:active { transform: scale(0.982); }

        .error-box {
            background: rgba(191,58,43,0.10);
            border: 1px solid rgba(191,58,43,0.28);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 18px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .error-box ul { color: #f87171; font-size: 13px; list-style: none; margin: 0; padding: 0; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both; }
        @media (prefers-reduced-motion: reduce) { .fade-up { animation: none; } }
    </style>
</head>
<body class="bg-pattern">

    <!-- Blobs décoratifs -->
    <div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
        <div style="position:absolute;width:560px;height:560px;border-radius:50%;background:radial-gradient(circle,rgba(191,58,43,0.09),transparent 70%);top:-200px;left:-200px;"></div>
        <div style="position:absolute;width:480px;height:480px;border-radius:50%;background:radial-gradient(circle,rgba(230,126,34,0.06),transparent 70%);bottom:-160px;right:-160px;"></div>
    </div>

    <!-- Carte login -->
    <div class="glass-card fade-up" style="position:relative;z-index:1;">

        <!-- En-tête marque -->
        <div style="padding:32px 32px 22px;text-align:center;">
            <div style="display:inline-flex;align-items:center;justify-content:center;width:54px;height:54px;background:#e53e3e;border-radius:14px;margin-bottom:18px;box-shadow:0 8px 24px rgba(191,58,43,0.32);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" style="width:26px;height:26px;">
                    <path d="M20 10.5V9c0-3.87-3.13-7-7-7S6 5.13 6 9v1.5C4.84 10.5 4 11.34 4 12.5V19c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6.5c0-1.16-.84-2-2-2zM12 4c2.76 0 5 2.24 5 5H7c0-2.76 2.24-5 5-5zm2 11.5h-4v-2c0-.55.45-1 1-1h2c.55 0 1 .45 1 1v2z"/>
                </svg>
            </div>
            <div style="line-height:1;">
                <span class="brand-isi" style="color:#fff;font-size:24px;">ISI&nbsp;</span><span class="brand-burger" style="font-size:24px;">BURGER</span>
            </div>
            <p style="font-size:10px;letter-spacing:3.5px;text-transform:uppercase;color:rgba(255,255,255,0.26);margin-top:7px;font-weight:600;">Espace Administration</p>
        </div>

        <div class="accent-line"></div>

        <!-- Formulaire -->
        <div style="padding:22px 32px 28px;">

            @if ($errors->any())
            <div class="error-box">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#e53e3e" style="width:17px;height:17px;flex-shrink:0;margin-top:1px;">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.authenticate') }}">
                @csrf

                <div style="margin-bottom:16px;">
                    <label class="field-label" for="email">Adresse Email</label>
                    <input class="dark-input" type="email" id="email" name="email"
                        value="{{ old('email') }}" required autofocus autocomplete="email"
                        placeholder="admin@gmail.com">
                </div>

                <div style="margin-bottom:24px;">
                    <label class="field-label" for="password">Mot de passe</label>
                    <div class="pw-wrap">
                        <input class="dark-input has-icon" type="password" id="password" name="password"
                            required autocomplete="current-password" placeholder="••••••••">
                        <button type="button" class="pw-toggle" onclick="togglePw()" title="Afficher / Masquer">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:17px;height:17px;">
                                <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"/>
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login">Se connecter</button>
            </form>
        </div>

        <div style="border-top:1px solid rgba(255,255,255,0.05);padding:13px 32px;text-align:center;">
            <p style="font-size:11px;color:rgba(255,255,255,0.17);letter-spacing:0.5px;">ISI BURGER &mdash; Administration &copy; {{ date('Y') }}</p>
        </div>
    </div>

    <a href="{{ route('kiosk.index') }}"
        style="margin-top:18px;font-size:12px;color:rgba(255,255,255,0.26);text-decoration:none;letter-spacing:1px;position:relative;z-index:1;transition:color 0.2s;"
        onmouseover="this.style.color='rgba(255,255,255,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.26)'">
        ← Retour au kiosque client
    </a>

<script>
    function togglePw() {
        const inp  = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        const show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        icon.innerHTML = show
            ? `<path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38 1.651 1.651 0 000-1.185A10.004 10.004 0 009.999 3a9.956 9.956 0 00-4.744 1.194L3.28 2.22zM7.752 6.69l1.092 1.092a2.5 2.5 0 013.374 3.373l1.091 1.092a4 4 0 00-5.557-5.557z" clip-rule="evenodd"/><path d="M10.748 13.93l2.523 2.523a10.003 10.003 0 01-8.607-2.33l-.894-.893A10.006 10.006 0 012.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 017.5 4.948L9.75 7.2a4 4 0 004.748 5.748z"/>`
            : `<path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"/><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>`;
    }
</script>
</body>
</html>
