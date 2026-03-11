{{-- Email: Confirmation de commande — ISI BURGER --}}
<!DOCTYPE html>
<html lang="fr" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Confirmation de commande — ISI BURGER</title>
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
<body style="margin:0;padding:0;background-color:#0d0908;font-family:Arial,Helvetica,sans-serif;">

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#0d0908" style="background-color:#0d0908;">
<tr><td align="center" style="padding:36px 12px 40px;">

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" class="email-wrap" style="width:100%;max-width:600px;background-color:#ffffff;">

  <!-- TOP BAR -->
  <tr>
    <td height="6" bgcolor="#e53e3e" style="background:linear-gradient(90deg,#991b1b 0%,#e53e3e 55%,#fca5a5 100%);background-color:#e53e3e;height:6px;font-size:1px;line-height:1px;">&nbsp;</td>
  </tr>

  <!-- HEADER -->
  <tr>
    <td bgcolor="#111111" style="background-color:#111111;padding:20px 36px;" class="mob-pad">
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
        <td valign="middle">
          <span style="font-family:'Arial Black',Arial,sans-serif;font-size:20px;font-weight:900;color:#fff;letter-spacing:2.5px;text-transform:uppercase;line-height:1;">ISI&nbsp;<span style="color:#e53e3e;">BURGER</span></span>
        </td>
        <td align="right" valign="middle">
          <span style="font-family:Arial,sans-serif;font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.28);border:1px solid rgba(255,255,255,.1);padding:4px 11px;">CONFIRMATION</span>
        </td>
      </tr></table>
    </td>
  </tr>

  <!-- HERO -->
  <tr>
    <td bgcolor="#111111" style="background-color:#111111;padding:44px 36px 40px;text-align:center;" class="mob-hero">
      <div style="display:inline-block;font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#e53e3e;border:1px solid rgba(229,62,62,.38);padding:5px 16px;border-radius:100px;background-color:rgba(229,62,62,.1);margin-bottom:26px;">NOUVELLE COMMANDE</div><br>

      <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 22px;">
        <tr>
          <td width="76" height="76" bgcolor="#e53e3e" style="width:76px;height:76px;border-radius:50%;background-color:#e53e3e;text-align:center;vertical-align:middle;font-size:34px;color:#fff;font-weight:900;line-height:76px;">&#10003;</td>
        </tr>
      </table>

      <div class="hero-title" style="font-family:'Arial Black',Arial,sans-serif;font-size:38px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-0.5px;line-height:1.05;margin-bottom:14px;">Commande<br>Confirm&eacute;e&nbsp;!</div>
      <p style="margin:0 auto 28px;max-width:400px;font-family:Arial,sans-serif;font-size:15px;color:rgba(255,255,255,.5);line-height:1.7;">Bonjour <strong style="color:rgba(255,255,255,.85);">{{ $order->client_name }}</strong>,<br>votre commande a bien &eacute;t&eacute; enregistr&eacute;e.</p>

      <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto;">
        <tr>
          <td bgcolor="#1d1510" style="background-color:#1d1510;border:1px solid rgba(229,62,62,.32);border-radius:10px;padding:15px 34px;text-align:center;">
            <div style="font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(229,62,62,.55);margin-bottom:7px;">N&deg; COMMANDE</div>
            <div class="ticket-num" style="font-family:'Courier New',Courier,monospace;font-size:19px;font-weight:700;color:#e53e3e;letter-spacing:2.5px;">{{ $order->order_number ?? '#'.$order->id }}</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- ITEMS -->
  <tr>
    <td bgcolor="#ffffff" style="background-color:#fff;padding:32px 36px 0;" class="mob-pad">
      <div style="font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#c0b8b4;padding-bottom:12px;border-bottom:2px solid #f0ece8;margin-bottom:2px;">R&Eacute;CAPITULATIF DE COMMANDE</div>
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        @foreach($order->orderItems as $item)
        <tr>
          <td style="padding:13px 0;border-bottom:1px solid #f5f1ef;vertical-align:top;">
            <div style="font-family:Arial,sans-serif;font-size:14px;font-weight:700;color:#1a1a1a;">{{ $item->burger->name }}</div>
            <div style="font-family:Arial,sans-serif;font-size:11px;color:#afa8a4;margin-top:3px;">&times;&nbsp;{{ $item->quantity }}&nbsp;&nbsp;&bull;&nbsp;&nbsp;{{ number_format($item->unit_price, 0, ',', ' ') }}&nbsp;FCFA/u</div>
          </td>
          <td align="right" valign="top" style="padding:13px 0 13px 14px;border-bottom:1px solid #f5f1ef;white-space:nowrap;">
            <span style="font-family:Arial,sans-serif;font-size:14px;font-weight:700;color:#e53e3e;">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }}&nbsp;F</span>
          </td>
        </tr>
        @endforeach
      </table>
      <!-- Total bar -->
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top:18px;">
        <tr>
          <td bgcolor="#111111" style="background-color:#111111;border-radius:10px;padding:17px 22px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
              <td valign="middle"><span style="font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:rgba(255,255,255,.3);">TOTAL &Agrave; PAYER</span></td>
              <td align="right" valign="middle"><span class="total-amt" style="font-family:'Arial Black',Arial,sans-serif;font-size:28px;font-weight:900;color:#e53e3e;">{{ number_format($order->total_amount, 0, ',', ' ') }}&nbsp;F</span></td>
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
          <td bgcolor="#fff8f5" style="background-color:#fff8f5;border-left:4px solid #e53e3e;border-radius:8px;padding:14px 18px;">
            <p style="margin:0;font-family:Arial,sans-serif;font-size:13px;color:#7a3a20;line-height:1.75;">&#128179;&nbsp;<strong style="color:#991b1b;">R&egrave;glement au comptoir.</strong> Pr&eacute;sentez-vous &agrave; la caisse pour effectuer votre paiement. Une facture vous sera remise d&egrave;s que votre commande sera pr&ecirc;te.</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- META -->
  <tr>
    <td bgcolor="#ffffff" style="background-color:#fff;padding:28px 36px;" class="mob-pad">
      <div style="font-family:Arial,sans-serif;font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#c0b8b4;padding-bottom:12px;border-bottom:2px solid #f0ece8;margin-bottom:2px;">VOS INFORMATIONS</div>
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
          <td style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:12px;color:#b0a8a4;">Nom</span></td>
          <td align="right" style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#1a1a1a;">{{ $order->client_name }}</span></td>
        </tr>
        <tr>
          <td style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:12px;color:#b0a8a4;">T&eacute;l&eacute;phone</span></td>
          <td align="right" style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#1a1a1a;">{{ $order->client_phone }}</span></td>
        </tr>
        <tr>
          <td style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:12px;color:#b0a8a4;">Date</span></td>
          <td align="right" style="padding:11px 0;border-bottom:1px solid #f5f1ef;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#1a1a1a;">{{ $order->created_at->format('d/m/Y à H:i') }}</span></td>
        </tr>
        <tr>
          <td style="padding:11px 0;"><span style="font-family:Arial,sans-serif;font-size:12px;color:#b0a8a4;">Statut</span></td>
          <td align="right" style="padding:11px 0;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:700;color:#e53e3e;">En attente de pr&eacute;paration</span></td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- FOOTER -->
  <tr>
    <td bgcolor="#111111" style="background-color:#111111;padding:28px 36px;text-align:center;" class="mob-pad">
      <div style="font-family:'Arial Black',Arial,sans-serif;font-size:18px;font-weight:900;color:#fff;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:5px;">ISI&nbsp;<span style="color:#e53e3e;">BURGER</span></div>
      <div style="font-family:Arial,sans-serif;font-size:11px;color:rgba(255,255,255,.2);margin-bottom:18px;">Restaurant &middot; Kiosque &middot; Commandes</div>
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td height="1" style="border-top:1px solid rgba(255,255,255,.07);font-size:1px;line-height:1px;padding-bottom:18px;"></td></tr></table>
      <p style="margin:0;font-family:Arial,sans-serif;font-size:10px;color:rgba(255,255,255,.18);line-height:1.8;">Cet email a &eacute;t&eacute; envoy&eacute; automatiquement &middot; ISI BURGER &copy; {{ date('Y') }}<br>Merci de ne pas r&eacute;pondre &agrave; cet email.</p>
    </td>
  </tr>

  <!-- BOTTOM BAR -->
  <tr>
    <td height="4" bgcolor="#e53e3e" style="background:linear-gradient(90deg,#991b1b 0%,#e53e3e 55%,#fca5a5 100%);background-color:#e53e3e;height:4px;font-size:1px;line-height:1px;">&nbsp;</td>
  </tr>

</table>
</td></tr>
</table>
</body>
</html>
