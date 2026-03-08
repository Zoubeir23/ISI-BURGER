{{-- Template email : Confirmation de commande — Dark Premium --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande — ISI BURGER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap');
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #0f0d0a; color: #1a1a1a;
            line-height: 1.5; -webkit-font-smoothing: antialiased;
        }
        /* ── Layout ── */
        .outer { background: #0f0d0a; padding: 40px 20px; }
        .card {
            max-width: 580px; margin: 0 auto; background: #fff;
            border-radius: 20px; overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,.7), 0 8px 24px rgba(0,0,0,.5);
        }
        /* ── Header ── */
        .hdr { background: #0f0d0a; padding: 26px 36px; }
        .hdr-inner { display: flex; justify-content: space-between; align-items: center; }
        .hdr-logo {
            font-family: 'Barlow Condensed', 'Arial Narrow', sans-serif;
            font-size: 24px; font-weight: 900; color: #fff;
            letter-spacing: 1.5px; text-transform: uppercase;
        }
        .hdr-logo span { color: #ff6b35; }
        .hdr-badge {
            font-size: 9px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase;
            color: rgba(255,255,255,.28); border: 1px solid rgba(255,255,255,.1);
            padding: 4px 11px; border-radius: 100px;
        }
        /* ── Stripe ── */
        .stripe { height: 5px; background: linear-gradient(90deg, #a82d08 0%, #ff6b35 55%, #ffb08a 100%); }
        /* ── Hero (dark) ── */
        .hero {
            background: #0f0d0a;
            padding: 44px 40px 40px; text-align: center;
        }
        .hero-chip {
            display: inline-block; margin-bottom: 26px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
            color: #ff6b35; border: 1px solid rgba(255,107,53,.35);
            padding: 5px 14px; border-radius: 100px; background: rgba(255,107,53,.08);
        }
        .hero-icon {
            width: 80px; height: 80px; margin: 0 auto 22px;
            background: linear-gradient(145deg, #ff6b35, #a82d08);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 20px 60px rgba(255,107,53,.4), 0 4px 16px rgba(255,107,53,.2);
        }
        .hero-icon svg { width: 38px; height: 38px; }
        .hero-title {
            font-family: 'Barlow Condensed', 'Arial Narrow', sans-serif;
            font-size: 44px; font-weight: 900; color: #fff;
            text-transform: uppercase; letter-spacing: 1px; line-height: 1.05;
            margin-bottom: 12px;
        }
        .hero-sub { font-size: 15px; color: rgba(255,255,255,.5); line-height: 1.65; }
        .hero-sub strong { color: rgba(255,255,255,.85); }
        /* ── Order number ticket ── */
        .ticket {
            display: inline-block; margin-top: 28px;
            background: rgba(255,107,53,.08); border: 1px solid rgba(255,107,53,.25);
            border-radius: 12px; padding: 14px 28px;
        }
        .ticket-label {
            font-size: 9px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
            color: rgba(255,107,53,.55); margin-bottom: 5px;
        }
        .ticket-number {
            font-family: 'Barlow Condensed', monospace;
            font-size: 22px; font-weight: 800; color: #ff6b35; letter-spacing: .5px;
        }
        /* ── Body ── */
        .section { padding: 32px 36px; background: #fff; }
        .section + .section { padding-top: 0; }
        .sec-label {
            font-size: 9px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
            color: #d0c8c4; padding-bottom: 12px; margin-bottom: 4px;
            border-bottom: 1px solid #f0ece9;
        }
        /* ── Items ── */
        .item-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 0; border-bottom: 1px solid #f5f2f0;
        }
        .item-row:last-child { border-bottom: none; }
        .item-name { font-size: 14px; font-weight: 600; color: #1a1a1a; }
        .item-meta { font-size: 11px; color: #b5aeaa; margin-top: 2px; }
        .item-price { font-size: 14px; font-weight: 700; color: #ff6b35; white-space: nowrap; padding-left: 16px; }
        /* ── Total ── */
        .total-bar {
            background: #0f0d0a; border-radius: 14px;
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
            font-size: 30px; font-weight: 900; color: #ff6b35;
        }
        /* ── Notice ── */
        .notice {
            margin-top: 20px; background: #fff8f5;
            border: 1px solid rgba(255,107,53,.18); border-left: 4px solid #ff6b35;
            border-radius: 12px; padding: 16px 20px;
        }
        .notice p { font-size: 13px; color: #7a3a20; line-height: 1.75; }
        .notice p strong { color: #c2340a; }
        /* ── Meta rows ── */
        .meta-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 0; border-bottom: 1px solid #f5f2f0;
        }
        .meta-row:last-child { border-bottom: none; }
        .meta-k { font-size: 12px; color: #c0b8b4; font-weight: 500; }
        .meta-v { font-size: 13px; color: #1a1a1a; font-weight: 600; }
        .meta-v.accent { color: #ff6b35; }
        /* ── Footer ── */
        .footer { background: #0f0d0a; padding: 28px 36px; text-align: center; }
        .footer-logo {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 22px; font-weight: 900; color: #fff;
            letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px;
        }
        .footer-logo span { color: #ff6b35; }
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
            <div class="hdr-badge">Confirmation commande</div>
        </div>
    </div>
    <div class="stripe"></div>

    <!-- Hero -->
    <div class="hero">
        <div class="hero-chip">Nouvelle commande</div>
        <div class="hero-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div class="hero-title">Commande<br>confirmée !</div>
        <div class="hero-sub">Bonjour <strong>{{ $order->client_name }}</strong>,<br>votre commande a bien été enregistrée.</div>
        <div class="ticket">
            <div class="ticket-label">N° Commande</div>
            <div class="ticket-number">{{ $order->order_number ?? '#' . $order->id }}</div>
        </div>
    </div>

    <!-- Items -->
    <div class="section">
        <div class="sec-label">Récapitulatif de la commande</div>
        @foreach($order->orderItems as $item)
        <div class="item-row">
            <div>
                <div class="item-name">{{ $item->burger->name }}</div>
                <div class="item-meta">× {{ $item->quantity }} &nbsp;·&nbsp; {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA/u</div>
            </div>
            <div class="item-price">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} F</div>
        </div>
        @endforeach
        <div class="total-bar">
            <span class="total-lbl">Total à payer</span>
            <span class="total-amt">{{ number_format($order->total_amount, 0, ',', ' ') }} F</span>
        </div>
    </div>

    <!-- Notice -->
    <div class="section" style="padding-top:0;">
        <div class="notice">
            <p>💳 <strong>Règlement au comptoir.</strong> Veuillez vous présenter à la caisse pour effectuer votre paiement. Une facture vous sera remise dès que votre commande sera prête.</p>
        </div>
    </div>

    <!-- Meta -->
    <div class="section" style="padding-top:0;">
        <div class="sec-label">Vos informations</div>
        <div class="meta-row">
            <span class="meta-k">Nom</span>
            <span class="meta-v">{{ $order->client_name }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-k">Téléphone</span>
            <span class="meta-v">{{ $order->client_phone }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-k">Date</span>
            <span class="meta-v">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-k">Statut</span>
            <span class="meta-v accent">En attente de préparation</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-logo">ISI <span>BURGER</span></div>
        <div class="footer-tagline">Restaurant · Kiosk · Commandes</div>
        <div class="footer-sep"></div>
        <div class="footer-legal">Cet email a été envoyé automatiquement &middot; ISI BURGER &copy; {{ date('Y') }}<br>Merci de ne pas répondre à cet email.</div>
    </div>

</div>
</div>
</body>
</html>
