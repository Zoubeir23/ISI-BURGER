<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture {{ $order->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            background: #ffffff;
        }

        /* ── HEADER BAND ── */
        .header-band {
            background-color: #bf3a2b;
            padding: 28px 40px 22px 40px;
        }
        .header-top { width: 100%; }
        .brand-name {
            font-size: 30px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .brand-sub {
            font-size: 9px;
            color: rgba(255,255,255,0.60);
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 3px;
        }
        .invoice-label {
            font-size: 10px;
            color: rgba(255,255,255,0.65);
            text-transform: uppercase;
            letter-spacing: 3px;
            text-align: right;
        }
        .invoice-number {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            text-align: right;
            margin-top: 3px;
        }

        /* ── ORANGE ACCENT BAR ── */
        .accent-bar {
            background-color: #E67E22;
            height: 4px;
        }

        /* ── META SECTION ── */
        .meta-section {
            padding: 26px 40px;
            border-bottom: 1px solid #f0ece9;
        }
        .meta-table { width: 100%; }
        .meta-left  { width: 55%; vertical-align: top; }
        .meta-right { width: 45%; vertical-align: top; }

        .section-label {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 8px;
        }
        .client-name {
            font-size: 17px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 3px;
        }
        .client-phone { font-size: 13px; color: #555; }

        .meta-right-inner { text-align: right; }
        .info-row { margin-bottom: 8px; }
        .info-key {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #bbb;
            display: block;
            margin-bottom: 2px;
        }
        .info-val { font-size: 12px; font-weight: 600; color: #333; }

        .status-badge {
            display: inline-block;
            background-color: #E67E22;
            color: #ffffff;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 4px;
        }

        /* ── ITEMS TABLE ── */
        .items-section { padding: 0 40px 24px 40px; }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items-table thead tr { background-color: #1a1a1a; }
        .items-table thead th {
            padding: 10px 14px;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #ccc;
            text-align: left;
        }
        .items-table thead th.right  { text-align: right; }
        .items-table thead th.center { text-align: center; }

        .items-table tbody tr:nth-child(even) { background-color: #fafafa; }
        .items-table tbody tr:nth-child(odd)  { background-color: #ffffff; }
        .items-table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid #f0ece9;
            font-size: 12px;
            color: #2a2a2a;
            vertical-align: middle;
        }
        .items-table tbody td.product-name { font-weight: 600; font-size: 13px; }
        .items-table tbody td.right        { text-align: right; }
        .items-table tbody td.center       { text-align: center; }

        .qty-badge {
            display: inline-block;
            background-color: #f5f0ee;
            color: #bf3a2b;
            font-weight: 700;
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 12px;
            border: 1px solid #e8dbd8;
        }
        .unit-price { color: #888; font-size: 11px; }
        .line-total  { font-weight: 700; font-size: 13px; color: #1a1a1a; }

        /* ── TOTAL BOX ── */
        .total-section { padding: 0 40px 28px 40px; }
        .total-outer   { text-align: right; margin-top: 20px; }
        .total-box {
            display: inline-block;
            background-color: #1a1a1a;
            border-radius: 8px;
            padding: 16px 22px;
            text-align: right;
            min-width: 220px;
        }
        .total-label {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
            margin-bottom: 6px;
        }
        .total-amount {
            font-size: 26px;
            font-weight: 900;
            color: #E67E22;
        }
        .total-currency {
            font-size: 13px;
            color: rgba(255,255,255,0.55);
            font-weight: 400;
            margin-left: 4px;
        }
        .total-note {
            font-size: 9px;
            color: rgba(255,255,255,0.30);
            margin-top: 6px;
        }

        /* ── FOOTER ── */
        .footer {
            background-color: #f9f6f5;
            border-top: 1px solid #ede8e5;
            padding: 18px 40px;
            text-align: center;
            margin-top: 32px;
        }
        .footer-main {
            font-size: 13px;
            font-weight: 700;
            color: #bf3a2b;
            margin-bottom: 4px;
        }
        .footer-sub {
            font-size: 9px;
            color: #bbb;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header-band">
        <table class="header-top" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:55%; vertical-align:middle;">
                    <div class="brand-name">ISI BURGER</div>
                    <div class="brand-sub">Restaurant &amp; Gestion des Commandes</div>
                </td>
                <td style="width:45%; vertical-align:middle;">
                    <div class="invoice-label">Facture</div>
                    <div class="invoice-number">{{ $order->invoice_number }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Accent bar -->
    <div class="accent-bar"></div>

    <!-- Meta: client + order info -->
    <div class="meta-section">
        <table class="meta-table" cellpadding="0" cellspacing="0">
            <tr>
                <td class="meta-left">
                    <div class="section-label">Informations client</div>
                    <div class="client-name">{{ $order->client_name }}</div>
                    <div class="client-phone">{{ $order->client_phone }}</div>
                </td>
                <td class="meta-right">
                    <div class="meta-right-inner">
                        <div class="info-row">
                            <span class="info-key">Date de la commande</span>
                            <span class="info-val">{{ $order->created_at->format('d/m/Y \à H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Statut</span><br>
                            <span class="status-badge">PRETE</span>
                        </div>
                        @if($order->payment)
                        <div class="info-row" style="margin-top:8px;">
                            <span class="info-key">Paiement reçu le</span>
                            <span class="info-val">{{ $order->payment->paid_at->format('d/m/Y') }} &mdash; Espèces</span>
                        </div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Items -->
    <div class="items-section">
        <table class="items-table" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="width:44%;">Produit</th>
                    <th class="center" style="width:14%;">Qté</th>
                    <th class="right" style="width:21%;">Prix unitaire</th>
                    <th class="right" style="width:21%;">Total ligne</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="product-name">{{ $item->burger->name }}</td>
                    <td class="center"><span class="qty-badge">{{ $item->quantity }}</span></td>
                    <td class="right unit-price">{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
                    <td class="right line-total">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="total-section">
        <div class="total-outer">
            <div class="total-box">
                <div class="total-label">Montant total à payer</div>
                <div>
                    <span class="total-amount">{{ number_format($order->total_amount, 0, ',', ' ') }}</span>
                    <span class="total-currency">FCFA</span>
                </div>
                <div class="total-note">Paiement en espèces uniquement</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-main">Merci pour votre commande !</div>
        <div class="footer-sub">ISI BURGER &mdash; Institut Superieur d'Informatique &mdash; Document genere automatiquement</div>
    </div>

</body>
</html>
