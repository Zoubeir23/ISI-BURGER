{{-- Template email : Paiement confirmé — Dark Premium · Accent émeraude --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement confirmé — ISI BURGER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap');
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #0a0f0c; color: #1a1a1a;
            line-height: 1.5; -webkit-font-smoothing: antialiased;
        }
        /* ── Layout ── */
        .outer { background: #0a0f0c; padding: 40px 20px; }
        .card {
            max-width: 580px; margin: 0 auto; background: #fff;
            border-radius: 20px; overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,.7), 0 8px 24px rgba(0,0,0,.5);
        }
        /* ── Header ── */
        .hdr { background: #0a0f0c; padding: 26px 36px; }
        .hdr-inner { display: flex; justify-content: space-between; align-items: center; }
        .hdr-logo {
            font-family: 'Barlow Condensed', 'Arial Narrow', sans-serif;
            font-size: 24px; font-weight: 900; color: #fff;
            letter-spacing: 1.5px; text-transform: uppercase;
        }
        .hdr-logo span { color: #10b981; }
        .hdr-badge {
            font-size: 9px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase;
            color: rgba(255,255,255,.28); border: 1px solid rgba(255,255,255,.1);
            padding: 4px 11px; border-radius: 100px;
        }
        /* ── Stripe ── */
        .stripe { height: 5px; background: linear-gradient(90deg, #047857 0%, #10b981 55%, #6ee7b7 100%); }
        /* ── Hero (dark) ── */
        .hero { background: #0a0f0c; padding: 44px 40px 40px; text-align: center; }
        .hero-chip {
            display: inline-block; margin-bottom: 26px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
            color: #10b981; border: 1px solid rgba(16,185,129,.35);
            padding: 5px 14px; border-radius: 100px; background: rgba(16,185,129,.08);
        }
        .hero-icon {
            width: 80px; height: 80px; margin: 0 auto 22px;
            background: linear-gradient(145deg, #10b981, #047857);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 20px 60px rgba(16,185,129,.4), 0 4px 16px rgba(16,185,129,.2);
        }
        .hero-icon svg { width: 38px; height: 38px; }
        .hero-title {
            font-family: 'Barlow Condensed', 'Arial Narrow', sans-serif;
            font-size: 44px; font-weight: 900; color: #fff;
            text-transform: uppercase; letter-spacing: 1px; line-height: 1.05; margin-bottom: 12px;
        }
        .hero-sub { font-size: 15px; color: rgba(255,255,255,.5); line-height: 1.65; }
        .hero-sub strong { color: rgba(255,255,255,.85); }
        .ticket {
            display: inline-block; margin-top: 28px;
            background: rgba(16,185,129,.08); border: 1px solid rgba(16,185,129,.25);
            border-radius: 12px; padding: 14px 28px;
        }
        .ticket-label {
            font-size: 9px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
            color: rgba(16,185,129,.55); margin-bottom: 5px;
        }
        .ticket-number {
            font-family: 'Barlow Condensed', monospace;
            font-size: 22px; font-weight: 800; color: #10b981; letter-spacing: .5px;
        }
        /* ── Body ── */
        .section { padding: 32px 36px; background: #fff; }
        .section + .section { padding-top: 0; }
        .sec-label {
            font-size: 9px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
            color: #d0c8c4; padding-bottom: 12px; margin-bottom: 4px; border-bottom: 1px solid #f0ece9;
        }
        /* ── Items ── */
        .items { width: 100%; border-collapse: collapse; }
        .items thead th {
            font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
            color: #c8c2be; padding-bottom: 10px; text-align: left; border-bottom: 1px solid #f0ece9;
        }
        .items thead th.r { text-align: right; }
        .items thead th.c { text-align: center; }
        .items tbody td { padding: 12px 0; border-bottom: 1px solid #f5f2f0; vertical-align: middle; }
        .items tbody tr:last-child td { border-bottom: none; }
        .iname { font-size: 14px; font-weight: 600; color: #1a1a1a; }
        .iqty { font-size: 11px; color: #b5aeaa; margin-top: 2px; }
        .iprice { font-size: 14px; font-weight: 700; color: #374151; text-align: right; white-space: nowrap; }
        /* ── Total ── */
        .total-bar {
            background: #0a0f0c; border-radius: 14px;
            padding: 18px 24px; display: flex; justify-content: space-between; align-items: center;
            margin-top: 18px;
        }
        .total-lbl {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 13px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase;
            color: rgba(255,255,255,.32);
        }
        .total-amt {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 30px; font-weight: 900; color: #10b981;
        }
        /* ── Notice ── */
        .notice {
            margin-top: 20px; background: #f0fdf7;
            border: 1px solid rgba(16,185,129,.2); border-left: 4px solid #10b981;
            border-radius: 12px; padding: 16px 20px;
        }
        .notice p { font-size: 13px; color: #065f46; line-height: 1.75; }
        .notice p strong { color: #047857; }
        /* ── Meta ── */
        .meta-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 0; border-bottom: 1px solid #f5f2f0;
        }
        .meta-row:last-child { border-bottom: none; }
        .meta-k { font-size: 12px; color: #c0b8b4; font-weight: 500; }
        .meta-v { font-size: 13px; color: #1a1a1a; font-weight: 600; }
        .meta-v.accent { color: #10b981; }
        /* ── Footer ── */
        .footer { background: #0a0f0c; padding: 28px 36px; text-align: center; }
        .footer-logo {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 22px; font-weight: 900; color: #fff;
            letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px;
        }
        .footer-logo span { color: #10b981; }
        .footer-tagline { font-size: 12px; color: rgba(255,255,255,.22); margin-bottom: 16px; }
        .footer-sep { border: none; border-top: 1px solid rgba(255,255,255,.07); margin-bottom: 16px; }
        .footer-legal { font-size: 11px; color: rgba(255,255,255,.18); line-height: 1.7; }
        @media (max-width: 600px) {
            .outer { padding: 12px 8px; }
            .hdr, .hero, .section, .footer { padding-left: 22px !important; padding-right: 22px !important; }
            .hero-title { font-size: 34px; }
            .total-amt { font-size: 24px; }
        }
    </style>
</head>
<body>
<div class="outer">
<div class="card">

    <!-- Header -->
    <div class="hdr">
        <div class="hdr-inner">
            <div class="hdr-logo">ISI <span>BURGER</span></div>
            <div class="hdr-badge">Confirmation paiement</div>
        </div>
    </div>
    <div class="stripe"></div>

    <!-- Hero -->
    <div class="hero">
        <div class="hero-chip">Paiement reçu</div>
        <div class="hero-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div class="hero-title">Paiement<br>confirmé !</div>
        <div class="hero-sub">Bonjour <strong>{{ $order->client_name }}</strong>,<br>votre paiement a bien été enregistré. Merci !</div>
        <div class="ticket">
            <div class="ticket-label">N° Commande</div>
            <div class="ticket-number">{{ $order->order_number ?? '#'.$order->id }}</div>
        </div>
    </div>

    <!-- Items -->
    <div class="section">
        <div class="sec-label">Détail de votre commande</div>
        <table class="items">
            <thead>
                <tr>
                    <th>Article</th>
                    <th class="c">Qté</th>
                    <th class="r">Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td><div class="iname">{{ $item->burger?->name ?? 'Article supprimé' }}</div></td>
                    <td style="text-align:center;"><div class="iqty">× {{ $item->quantity }}</div></td>
                    <td class="iprice">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} F</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total-bar">
            <span class="total-lbl">Total payé</span>
            <span class="total-amt">{{ number_format($order->total_amount, 0, ',', ' ') }} F</span>
        </div>
        <div class="notice">
            <p>✅ <strong>Paiement confirmé avec succès.</strong><br>
            @if($order->invoice_number)Votre facture PDF est jointe à cet email.@else
            Conservez cet email comme preuve de paiement.@endif</p>
        </div>
    </div>

    <!-- Meta -->
    <div class="section" style="padding-top:0;">
        <div class="sec-label">Informations</div>
        <div class="meta-row">
            <span class="meta-k">N° Commande</span>
            <span class="meta-v">{{ $order->order_number ?? '#'.$order->id }}</span>
        </div>
        @if($order->invoice_number)
        <div class="meta-row">
            <span class="meta-k">N° Facture</span>
            <span class="meta-v">{{ $order->invoice_number }}</span>
        </div>
        @endif
        <div class="meta-row">
            <span class="meta-k">Client</span>
            <span class="meta-v">{{ $order->client_name }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-k">Date</span>
            <span class="meta-v">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-k">Statut</span>
            <span class="meta-v accent">Payé ✓</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-logo">ISI <span>BURGER</span></div>
        <div class="footer-tagline">Merci pour votre paiement 🙏</div>
        <div class="footer-sep"></div>
        <div class="footer-legal">Cet email a été envoyé automatiquement &middot; ISI BURGER &copy; {{ date('Y') }}<br>Merci de ne pas répondre à cet email.</div>
    </div>

</div>
</div>
</body>
</html>
