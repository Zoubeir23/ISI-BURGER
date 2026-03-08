{{-- Template email : Commande livrée — Dark Premium · Accent or/ambre --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande livrée — ISI BURGER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap');
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #0f0d08; color: #1a1a1a;
            line-height: 1.5; -webkit-font-smoothing: antialiased;
        }
        /* ── Layout ── */
        .outer { background: #0f0d08; padding: 40px 20px; }
        .card {
            max-width: 580px; margin: 0 auto; background: #fff;
            border-radius: 20px; overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,.7), 0 8px 24px rgba(0,0,0,.5);
        }
        /* ── Header ── */
        .hdr { background: #0f0d08; padding: 26px 36px; }
        .hdr-inner { display: flex; justify-content: space-between; align-items: center; }
        .hdr-logo {
            font-family: 'Barlow Condensed', 'Arial Narrow', sans-serif;
            font-size: 24px; font-weight: 900; color: #fff;
            letter-spacing: 1.5px; text-transform: uppercase;
        }
        .hdr-logo span { color: #f59e0b; }
        .hdr-badge {
            font-size: 9px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase;
            color: rgba(255,255,255,.28); border: 1px solid rgba(255,255,255,.1);
            padding: 4px 11px; border-radius: 100px;
        }
        /* ── Stripe ── */
        .stripe { height: 5px; background: linear-gradient(90deg, #92400e 0%, #d97706 40%, #f59e0b 75%, #fde68a 100%); }
        /* ── Hero (dark) ── */
        .hero { background: #0f0d08; padding: 44px 40px 40px; text-align: center; }
        .hero-chip {
            display: inline-block; margin-bottom: 26px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
            color: #f59e0b; border: 1px solid rgba(245,158,11,.35);
            padding: 5px 14px; border-radius: 100px; background: rgba(245,158,11,.08);
        }
        .hero-icon {
            width: 80px; height: 80px; margin: 0 auto 22px;
            background: linear-gradient(145deg, #f59e0b, #92400e);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 20px 60px rgba(245,158,11,.4), 0 4px 16px rgba(245,158,11,.2);
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
            background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.25);
            border-radius: 12px; padding: 14px 28px;
        }
        .ticket-label {
            font-size: 9px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
            color: rgba(245,158,11,.55); margin-bottom: 5px;
        }
        .ticket-number {
            font-family: 'Barlow Condensed', monospace;
            font-size: 22px; font-weight: 800; color: #f59e0b; letter-spacing: .5px;
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
            background: #0f0d08; border-radius: 14px;
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
            font-size: 30px; font-weight: 900; color: #f59e0b;
        }
        /* ── Notice ── */
        .notice {
            margin-top: 20px; background: #fffdf0;
            border: 1px solid rgba(245,158,11,.2); border-left: 4px solid #f59e0b;
            border-radius: 12px; padding: 16px 20px;
        }
        .notice p { font-size: 13px; color: #78350f; line-height: 1.75; }
        .notice p strong { color: #92400e; }
        /* ── Stars / CTA ── */
        .cta-box {
            margin-top: 20px; padding: 22px 20px;
            background: linear-gradient(135deg, #fffdf0, #fef9e0);
            border: 1px solid rgba(245,158,11,.18); border-radius: 14px;
            text-align: center;
        }
        .cta-box p { font-size: 14px; color: #78350f; line-height: 1.65; margin-bottom: 8px; }
        .cta-box p strong { color: #92400e; }
        .stars { font-size: 24px; letter-spacing: 5px; display: block; }
        /* ── Meta ── */
        .meta-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 0; border-bottom: 1px solid #f5f2f0;
        }
        .meta-row:last-child { border-bottom: none; }
        .meta-k { font-size: 12px; color: #c0b8b4; font-weight: 500; }
        .meta-v { font-size: 13px; color: #1a1a1a; font-weight: 600; }
        .meta-v.accent { color: #f59e0b; }
        /* ── Footer ── */
        .footer { background: #0f0d08; padding: 28px 36px; text-align: center; }
        .footer-logo {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 22px; font-weight: 900; color: #fff;
            letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px;
        }
        .footer-logo span { color: #f59e0b; }
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
            <div class="hdr-badge">Commande livrée</div>
        </div>
    </div>
    <div class="stripe"></div>

    <!-- Hero -->
    <div class="hero">
        <div class="hero-chip">Livrée avec succès 🎊</div>
        <div class="hero-icon">
            <svg viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
        </div>
        <div class="hero-title">Bon<br>appétit !</div>
        <div class="hero-sub">Bonjour <strong>{{ $order->client_name }}</strong>,<br>votre commande a été livrée avec succès.</div>
        <div class="ticket">
            <div class="ticket-label">N° Commande</div>
            <div class="ticket-number">{{ $order->order_number ?? '#'.$order->id }}</div>
        </div>
    </div>

    <!-- Items -->
    <div class="section">
        <div class="sec-label">Récapitulatif de la commande</div>
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
            <span class="total-lbl">Total</span>
            <span class="total-amt">{{ number_format($order->total_amount, 0, ',', ' ') }} F</span>
        </div>
        <div class="notice">
            <p>🎉 <strong>Votre commande est maintenant livrée.</strong><br>
            Nous espérons que vous allez vous régaler. À très bientôt chez ISI BURGER !</p>
        </div>
        <div class="cta-box">
            <p>Vous avez apprécié votre expérience ?<br>
            <strong>Votre avis compte beaucoup pour nous !</strong></p>
            <span class="stars">⭐⭐⭐⭐⭐</span>
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
            <span class="meta-k">Date commande</span>
            <span class="meta-v">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-k">Statut</span>
            <span class="meta-v accent">Livrée ✓</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-logo">ISI <span>BURGER</span></div>
        <div class="footer-tagline">Bon appétit 🍔 &nbsp;À bientôt !</div>
        <div class="footer-sep"></div>
        <div class="footer-legal">Cet email a été envoyé automatiquement &middot; ISI BURGER &copy; {{ date('Y') }}<br>Merci de ne pas répondre à cet email.</div>
    </div>

</div>
</div>
</body>
</html>
