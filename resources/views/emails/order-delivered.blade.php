{{-- Email: Commande livrée — ISI BURGER --}}
<!DOCTYPE html>
<html lang="fr" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Commande livrée — ISI BURGER</title>
    <style type="text/css">
        body, table, td { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        body { margin: 0 !important; padding: 0 !important; }
        @media screen and (max-width: 600px) {
            .email-wrap  { width: 100% !important; }
            .mob-pad     { padding: 24px 20px !important; }
            .mob-hero    { padding: 32px 20px 28px !important; }
            .hero-title  { font-size: 30px !important; }
            .ticket-num  { font-size: 15px !important; letter-spacing: 1px !important; }
            .total-amt   { font-size: 24px !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#0f0d08;font-family:Arial,Helvetica,sans-serif;">

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#0f0d08" style="background-color:#0f0d08;">
<tr><td align="center" style="padding:36px 12px 40px;">

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" class="email-wrap" style="width:100%;max-width:600px;background-color:#ffffff;">

  <!-- TOP BAR -->
  <tr>
    <td height="6" bgcolor="#f59e0b" style="background:linear-gradient(90deg,#92400e 0%,#d97706 40%,#f59e0b 75%,#fde68a 100%);background-color:#f59e0b;height:6px;font-size:1px;line-height:1px;">&nbsp;</td>
  </tr>

  <!-- HEADER -->
  <tr>
    <td bgcolor="#13110a" style="background-color:#13110a;padding:20px 36px;" class="mob-pad">
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
        <td valign="middle">
          <span style="font-family:'Arial Black',Arial,sans-serif;font-size:20px;font-weight:900;color:#fff;letter-spacing:2.5px;text-transform:uppercase;line-height:1;">ISI&nbsp;<span style="color:#f59e0b;">BURGER</span></span>
        </td>
        <td align="right" valign="middle">
          <span style="font-family:Arial,sans-serif;font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.28);border:1px solid rgba(255,255,255,.1);padding:4px 11px;">LIVRAISON</span>
        </td>
      </tr></table>
    </td>
  </tr>

  <!-- HERO -->
  <tr>
    <td bgcolor="#13110a" style="background-color:#13110a;padding:44px 36px 40px;text-align:center;" class="mob-hero">
      <div style="display:inline-block;font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#f59e0b;border:1px solid rgba(245,158,11,.38);padding:5px 16px;border-radius:100px;background-color:rgba(245,158,11,.1);margin-bottom:26px;">LIVR&Eacute;E AVEC SUCC&Egrave;S &#127882;</div><br>

      <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 22px;">
        <tr>
          <td width="76" height="76" bgcolor="#f59e0b" style="width:76px;height:76px;border-radius:50%;background-color:#f59e0b;text-align:center;vertical-align:middle;font-size:32px;color:#fff;line-height:76px;">&#9733;</td>
        </tr>
      </table>

      <div class="hero-title" style="font-family:'Arial Black',Arial,sans-serif;font-size:38px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-0.5px;line-height:1.05;margin-bottom:14px;">Bon<br>App&eacute;tit&nbsp;!</div>
      <p style="margin:0 auto 28px;max-width:400px;font-family:Arial,sans-serif;font-size:15px;color:rgba(255,255,255,.5);line-height:1.7;">Bonjour <strong style="color:rgba(255,255,255,.85);">{{ $order->client_name }}</strong>,<br>votre commande a &eacute;t&eacute; livr&eacute;e avec succ&egrave;s. R&eacute;galez-vous&nbsp;!</p>

      <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto;">
        <tr>
          <td bgcolor="#1f1c0e" style="background-color:#1f1c0e;border:1px solid rgba(245,158,11,.32);border-radius:10px;padding:15px 34px;text-align:center;">
            <div style="font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(245,158,11,.55);margin-bottom:7px;">N&deg; COMMANDE</div>
            <div class="ticket-num" style="font-family:'Courier New',Courier,monospace;font-size:19px;font-weight:700;color:#f59e0b;letter-spacing:2.5px;">{{ $order->order_number ?? '#'.$order->id }}</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- ITEMS -->
  <tr>
    <td bgcolor="#ffffff" style="background-color:#fff;padding:32px 36px 0;" class="mob-pad">
      <div style="font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#c0b8b4;padding-bottom:12px;border-bottom:2px solid #f0ece8;margin-bottom:2px;">R&Eacute;CAPITULATIF</div>
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        @foreach($order->orderItems as $item)
        <tr>
          <td style="padding:13px 0;border-bottom:1px solid #f5f1ef;vertical-align:top;">
            <div style="font-family:Arial,sans-serif;font-size:14px;font-weight:700;color:#1a1a1a;">{{ $item->burger?->name ?? 'Article supprimé' }}</div>
            <div style="font-family:Arial,sans-serif;font-size:11px;color:#afa8a4;margin-top:3px;">&times;&nbsp;{{ $item->quantity }}</div>
          </td>
          <td align="right" valign="top" style="padding:13px 0 13px 14px;border-bottom:1px solid #f5f1ef;white-space:nowrap;">
            <span style="font-family:Arial,sans-serif;font-size:14px;font-weight:700;color:#374151;">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }}&nbsp;F</span>
          </td>
        </tr>
        @endforeach
      </table>
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top:18px;">
        <tr>
          <td bgcolor="#13110a" style="background-color:#13110a;border-radius:10px;padding:17px 22px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
              <td valign="middle"><span style="font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:rgba(255,255,255,.3);">TOTAL</span></td>
              <td align="right" valign="middle"><span class="total-amt" style="font-family:'Arial Black',Arial,sans-serif;font-size:28px;font-weight:900;color:#f59e0b;">{{ number_format($order->total_amount, 0, ',', ' ') }}&nbsp;F</span></td>
            </tr></table>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- NOTICE -->
  <tr>
    <td bgcolor="#ffffff" style="background-color:#fff;padding:18px 36px 0;" class="mob-pad">
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
          <td bgcolor="#fffdf0" style="background-color:#fffdf0;border-left:4px solid #f59e0b;border-radius:8px;padding:14px 18px;">
            <p style="margin:0;font-family:Arial,sans-serif;font-size:13px;color:#78350f;line-height:1.75;">&#127881;&nbsp;<strong style="color:#92400e;">Votre commande est maintenant livr&eacute;e.</strong><br>Nous esp&eacute;rons que vous allez vous r&eacute;galer. &Agrave; tr&egrave;s bient&ocirc;t chez ISI BURGER&nbsp;!</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- STAR RATING CTA -->
  <tr>
    <td bgcolor="#ffffff" style="background-color:#fff;padding:16px 36px 0;" class="mob-pad">
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
          <td bgcolor="#fffbeb" style="background-color:#fffbeb;border:1px solid rgba(245,158,11,.2);border-radius:10px;padding:20px;text-align:center;">
            <div style="font-family:Arial,sans-serif;font-size:14px;color:#78350f;line-height:1.65;margin-bottom:10px;">Vous avez appr&eacute;ci&eacute; votre exp&eacute;rience&nbsp;?<br><strong style="color:#92400e;">Votre avis compte beaucoup pour nous&nbsp;!</strong></div>
            <div style="font-size:26px;letter-spacing:6px;">&#11088;&#11088;&#11088;&#11088;&#11088;</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- META -->
  <tr>
    <td bgcolor="#ffffff" style="background-color:#fff;padding:28px 36px;" class="mob-pad">
      <div style="font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#c0b8b4;padding-bottom:12px;border-bottom:2px solid #f0ece8;margin-bottom:2px;">INFORMATIONS</div>
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
          <td style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:12px;color:#b0a8a4;">N&deg; Commande</span></td>
          <td align="right" style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#1a1a1a;">{{ $order->order_number ?? '#'.$order->id }}</span></td>
        </tr>
        @if($order->invoice_number)
        <tr>
          <td style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:12px;color:#b0a8a4;">N&deg; Facture</span></td>
          <td align="right" style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#1a1a1a;">{{ $order->invoice_number }}</span></td>
        </tr>
        @endif
        <tr>
          <td style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:12px;color:#b0a8a4;">Client</span></td>
          <td align="right" style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#1a1a1a;">{{ $order->client_name }}</span></td>
        </tr>
        <tr>
          <td style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:12px;color:#b0a8a4;">Date commande</span></td>
          <td align="right" style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#1a1a1a;">{{ $order->created_at->format('d/m/Y à H:i') }}</span></td>
        </tr>
        <tr>
          <td style="padding:11px 0;"><span style="font-family:Arial,sans-serif;font-size:12px;color:#b0a8a4;">Statut</span></td>
          <td align="right" style="padding:11px 0;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#f59e0b;">Livr&eacute;e &#10003;</span></td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- FOOTER -->
  <tr>
    <td bgcolor="#13110a" style="background-color:#13110a;padding:28px 36px;text-align:center;" class="mob-pad">
      <div style="font-family:'Arial Black',Arial,sans-serif;font-size:18px;font-weight:900;color:#fff;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:5px;">ISI&nbsp;<span style="color:#f59e0b;">BURGER</span></div>
      <div style="font-family:Arial,sans-serif;font-size:11px;color:rgba(255,255,255,.2);margin-bottom:18px;">Bon app&eacute;tit &#127828;&nbsp;&nbsp;&Agrave; bient&ocirc;t&nbsp;!</div>
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td height="1" style="border-top:1px solid rgba(255,255,255,.07);font-size:1px;line-height:1px;padding-bottom:18px;"></td></tr></table>
      <p style="margin:0;font-family:Arial,sans-serif;font-size:10px;color:rgba(255,255,255,.18);line-height:1.8;">Cet email a &eacute;t&eacute; envoy&eacute; automatiquement &middot; ISI BURGER &copy; {{ date('Y') }}<br>Merci de ne pas r&eacute;pondre &agrave; cet email.</p>
    </td>
  </tr>

  <!-- BOTTOM BAR -->
  <tr>
    <td height="4" bgcolor="#f59e0b" style="background:linear-gradient(90deg,#92400e 0%,#d97706 40%,#f59e0b 75%,#fde68a 100%);background-color:#f59e0b;height:4px;font-size:1px;line-height:1px;">&nbsp;</td>
  </tr>

</table>
</td></tr>
</table>
</body>
</html>
