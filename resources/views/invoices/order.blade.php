<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $order->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ISI BURGER</h1>
        <h2>Facture</h2>
    </div>

    <div class="details">
        <p><strong>Facture N° :</strong> {{ $order->invoice_number }}</p>
        <p><strong>Date :</strong> {{ $order->updated_at->format('d/m/Y') }}</p>
        <p><strong>Client :</strong> {{ $order->client_name }}</p>
        <p><strong>Téléphone :</strong> {{ $order->client_phone }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->burger->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
                <td>{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 40px; text-align: center;">
        <p>Merci pour votre commande !</p>
    </div>
</body>
</html>
