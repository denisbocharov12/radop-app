<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>{{ $order->order_number }}</title>
    <style>
        table.order-table,
        table.order-table th,
        table.order-table td {
            border: 1px solid #ccc;
        }
        table.order-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            line-height: 1;
        }
        .wrapper {
            max-width: 700px;
            margin: 50px auto;
        }
        .box {
            border: 2px solid #cccccc;
            border-radius: 4px;
            padding: 20px;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        .logo {
            text-align: center;
            margin-top: 20px;
        }
        .message-text {
            width: 70%;
            display: inline-block;
            vertical-align: top;
            padding-right: 20px;
        }
        .message-text p.title {
            background-color: #029dd3;
            color: white;
            padding: 15px 20px;
            text-align: center;
            border-radius: 4px;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .message-text p.description {
            text-align: center;
            font-size: 12px;
        }
        .logo {
            width: 25%;
            display: inline-block;
            vertical-align: top;
        }
        .order-info {
            border: 2px solid #cccccc;
            border-radius: 4px;
            margin-top: 10px;
            overflow: hidden;
        }
        .info-block {
            width: 40%;
            display: inline-block;
            vertical-align: top;
            padding: 10px 20px;
            font-size: 12px;
        }
        .info-block.left {
            border-right: 2px solid #ccc;
        }
        .product-header, .product-row {
            font-size: 12px;
            text-align: center;
            margin-top: 10px;
        }
        .cell {
            display: inline-block;
            border: 0;
            border-right: 1px solid #ccc;
            border-left: 1px solid #ccc;
            padding: 5px;
            vertical-align: top;
            margin: 0;
            outline: 0;

        }
        .product-header .cell{
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }
        .product-row .cell{
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }
        .cell-float{
            float: left;

        }
        .w40 { width: 40px; }
        .w80 { width: 80px; }
        .w100 { width: 100px; }
        .w220 { width: 245px; }
        .total {
            margin-top: 5px;
            font-size: 12px;
            text-align: right;
            border: 1px solid #ccc;
            padding: 10px 20px;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #555;
        }
        .footer a {
            color: #0056b3;
        }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- Success Message -->
    <div class="box">
        <div class="message-text">
            <p class="title">Comandă a fost înregistrată cu succes!</p>
            <p class="description">
                Stimate client, mulțumim pentru comanda plasată pe site-ul nostru.<br>
                În curând veți primi un apel de la operatorul nostru pentru a clarifica<br>
                detaliile referitor la comandă.
            </p>
        </div>
        <div class="logo">
            <img width="120px" src="https://floradelivery.md/wp-content/uploads/2025/03/radop_logo.jpg" />
        </div>
    </div>

    <!-- Order Info -->
    <div class="order-info">
        <div class="info-block left">
            <p>Comanda Nr: <span>{{ $order->order_number }}</span></p>
            <p>Data: <span>{{ \Carbon\Carbon::now()->format('d-m-Y , H:i') }}</span></p>
            <p>Nume:
                <span>
            @if($order->user !== null && $order->user->type->key_name === 'iur')
                        {{ $order->user->profile?->organization_name }}
                    @else
                        {{ $order?->fio }}
                    @endif
          </span>
            </p>
            <p>Date de contact: <span>{{ $order->phone }}</span></p>
        </div>
        <div class="info-block">
            <p>Achitare:
                <span>
            @if($order->payment_method === 'cash')
                        Numerar la primirea marfii
                    @elseif($order->payment_method === 'transfer')
                        Transfer bancar
                    @elseif($order->payment_method === 'card')
                        Cu cardul bancar la primirea marfii
                    @endif
          </span>
            </p>
            <p>Modalitate de primire a comenzii: <span>Livrare pe adresa</span></p>
            <p>{{ $order->address }}</p>
        </div>
    </div>

    <!-- Products Table -->
    <table class="order-table" style="width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 20px;" border="1">
        <thead>
        <tr style="text-align: center;">
            <th style="width: 40px; font-weight: normal; padding: 5px;">№</th>
            <th style="width: 80px; font-weight: normal; padding: 5px;">Cod</th>
            <th style="width: 245px; font-weight: normal; padding: 5px;">Denumire produsului</th>
            <th style="width: 80px; font-weight: normal; padding: 5px;">Cantitate, buc.</th>
            <th style="width: 80px; font-weight: normal; padding: 5px;">Preț incl. TVA</th>
            <th style="width: 100px; font-weight: normal; padding: 5px;">Suma totală, ML</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 1; @endphp
        @foreach($products as $product)
            <tr style="text-align: center;">
                <td style="padding: 5px;">{{ $i }}</td>
                <td style="padding: 5px;">{{ \App\Models\Product::find($product->product_id)->onec_id }}</td>
                <td style="padding: 5px;">{{ \App\Models\Product::find($product->product_id)->getTranslation('title', 'ro') }}</td>
                <td style="padding: 5px;">{{ $product->quantity }}</td>
                <td style="padding: 5px;">{{ number_format($product->price, 2, ',', '.') }}</td>
                <td style="padding: 5px;">{{ number_format($product->quantity * (float)$product->price, 2, ',', ' ') }}</td>
            </tr>
            @php $i++; @endphp
        @endforeach

        <!-- Total Row -->
        <tr style="text-align: right;">
            <td colspan="5" style="text-align: right; padding: 10px; font-weight: bold;">Total:</td>
            <td style="text-align: center;">{{ number_format($order->total, 2, ',', ' ') }}</td>
        </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Puteti urmari starea comenzii în cabinetul personal.<br>
        Pentru orice informatii sau modificari ale comenzii, contactati
        <a href="tel:022781212">022 78 12 12</a>,
        <a href="tel:+37379782112">+373 79 78 21 12</a><br>
        Program de lucru: Luni – Vineri: 08:00 – 17:00
    </div>

</div>
</body>
</html>
