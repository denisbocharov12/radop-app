<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>{{ $order->order_number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
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
            font-size: 20px;
            margin-bottom: 10px;
        }
        .message-text p.description {
            text-align: center;
            font-size: 14px;
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
            font-size: 14px;
        }
        .info-block.left {
            border-right: 2px solid #ccc;
        }
        .product-header, .product-row {
            font-size: 14px;
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
            font-size: 14px;
            text-align: right;
            border: 1px solid #ccc;
            padding: 10px 20px;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
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
            <p class="title">Comanda a fost înregistrata cu succes!</p>
            <p class="description">
                Stimate client, multumim pentru comanda plasata pe site-ul nostru.<br>
                În curând veti primi un apel de la operatorul nostru pentru a clarifica<br>
                detaliile referitor la comanda.
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

    <!-- Products Header -->
    <div style="margin-top: 10px; font-size: 14px; text-align: center; margin-bottom: 3px">
        <div style="display: inline-block; margin: 0 -2px; width: 40px; border: 1px solid #ccc; padding: 5px;">№</div>
        <div style="display: inline-block; margin: 0 -2px; width: 80px; border: 1px solid #ccc; padding: 5px;">Cod</div>
        <div style="display: inline-block; margin: 0 -2px; width: 245px; border: 1px solid #ccc; padding: 5px;">Denumire produsului</div>
        <div style="display: inline-block; margin: 0 -2px; width: 80px; border: 1px solid #ccc; padding: 5px;">Cantitate</div>
        <div style="display: inline-block; margin: 0 -2px; width: 80px; border: 1px solid #ccc; padding: 5px;">Pret</div>
        <div style="display: inline-block; margin: 0 -2px; width: 100px; border: 1px solid #ccc; padding: 5px;">Total</div>
    </div>

    <!-- Products Rows -->
    @php $i = 1; @endphp
    @foreach($products as $product)
        <div style="font-size: 14px; text-align: center;">
            <div style="display: inline-block;   height: 40px; margin: 0 -2px; width: 40px; border: 1px solid #ccc; padding: 5px;">{{ $i }}</div>
            <div style="display: inline-block;   height: 40px; margin: 0 -2px; width: 80px; border: 1px solid #ccc; padding: 5px;">
                {{ \App\Models\Product::find($product->product_id)->onec_id }}
            </div>
            <div style="display: inline-block;  height: 40px; margin: 0 -2px; width: 245px; border: 1px solid #ccc; padding: 5px; text-align: left;">
                {{ \App\Models\Product::find($product->product_id)->getTranslation('title', 'ro') }}
            </div>
            <div style="display: inline-block;   height: 40px; margin: 0 -2px; width: 80px; border: 1px solid #ccc; padding: 5px; text-align: right;">
                {{ $product->quantity }}
            </div>
            <div style="display: inline-block;  height: 40px; margin: 0 -2px; width: 80px; border: 1px solid #ccc; padding: 5px; text-align: right;">
                {{ number_format($product->price, 2, ',', '.') }}
            </div>
            <div style="display: inline-block;   height: 40px; margin: 0 -2px; width: 100px; border: 1px solid #ccc; padding: 5px; text-align: right;">
                {{ number_format($product->quantity * (float)$product->price, 2, ',', ' ') }}
            </div>
        </div>
    @php $i++; @endphp
@endforeach

<!-- Total -->
    <div style="margin-top: 5px; font-size: 14px; text-align: right; border: 1px solid #ccc; padding: 10px 20px;">
        <strong>Total:</strong> <span>{{ number_format($order->total, 2, ',', ' ') }}</span>
    </div>

    <!-- Footer -->
    <div class="footer">
        Puteti urmari starea comenzii în cabinetul personal.<br>
        Pentru orice informatii sau modificari ale comenzii, contactati
        <a href="tel:022781212">022 78 12 12</a>,
        <a href="tel:+37378781212">+373 78 78 12 12</a><br>
        Program de lucru: Luni – Vineri: 08:00 – 17:00
    </div>

</div>
</body>
</html>
