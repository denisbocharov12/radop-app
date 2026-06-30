<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#ffffff; overflow-x: scroll;">
<table align="center" width="700" style="border-collapse: collapse; margin: 50px auto" >
    <tbody style="display: inline-grid">
    <!-- Success Message -->
    <tr style="margin-bottom: 10px; border: 2px solid #cccccc;  border-radius: 4px;">
        <td width="70%" style="margin-left: 40px; width: 100%; padding: 20px 50px;">
            <p style="background-color: #0052a6; color: white;  padding: 15px 20px; text-align: center; border-radius: 4px; font-size: 20px; margin-bottom: 10px">Comandă a fost înregistrată cu succes!</p>
            <p style="text-align: center; font-size: 14px; margin-top: 10px;">Stimate client, mulțumim pentru comanda plasată pe site-ul nostru.<br>
                În curând veți primi un apel de la operatorul nostru pentru a clarifica<br>
                detaliile referitor la comandă.</p>
        </td>
        <td style="padding: 20px 40px 20px 0; vertical-align: middle; width: 100%" width="30%">
            <img width="120px" src="https://radop.md/v1/frontend/assets/images/logo_wide.svg" alt="Radop Logo" />
        </td>
    </tr>

    <!-- Order Information -->
    <tr  style="margin-bottom: 10px; border: 2px solid #cccccc;  border-radius: 4px;">
        <td width="50%" style="padding: 10px 20px; font-size: 13px; vertical-align: top; border-right: 2px solid #ccc;">
            <p><span>Comandă Nr:</span> <span style="color: black;">{{ $order->order_number }}</span></p>
            <p><span>Data:</span> <span style="color: black;">{{ \Carbon\Carbon::now()->format('d-m-Y , H:i') }}</span></p>
            <p><span>Nume:</span>
                <span style="color: black;">
                    @if($order->user !== null && $order->user->type->key_name === 'iur')
                        {{ $order->user->profile?->organization_name }}
                    @else
                        {{ $order?->fio }}
                    @endif
                </span>
            </p>
            <p><span>Date de contact:</span> <span style="color: black;">{{ $order->phone }}</span></p>
        </td>
        <td width="50%" style="padding: 10px 20px; font-size: 13px; vertical-align: top;">
            <p><span>Achitare:</span>
                <span style="color: black;">
                    @if($order->payment_method === 'cash')
                        Numerar  la primirea mărfii
                    @elseif($order->payment_method === 'transfer')
                        Transfer bancar
                    @elseif($order->payment_method === 'card')
                        Cu cardul bancar la primirea mărfii
                    @endif
                </span>
            </p>
            <p><span>Modalitate de primire a comenzii:</span> <span style="color: black;">Livrare pe adresa</span></p>
            <p style="color: black;">{{$order->address}}</p>
        </td>
    </tr>

    <!-- Product Table -->
    <tr>
        <td colspan="2">
            <table width="700" style="border-collapse: collapse; font-size: 13px; ">
                <tbody style="width: 100%">
                <tr style="text-align: center; ">
                    <td style="width: 40px; padding: 5px 10px; border: 1px solid #ccc;">№</td>
                    <td style="width: 80px; padding: 5px 10px; border: 1px solid #ccc;">Cod</td>
                    <td style="width: 400px; padding: 5px 10px; border: 1px solid #ccc;">Denumire produsului</td>
                    <td style="width: 80px; padding: 5px 10px; border: 1px solid #ccc;">Cantitate, buc.</td>
                    <td style="width: 80px; padding: 5px 10px; border: 1px solid #ccc;">Preț incl. TVA</td>
                    <td style="width: 150px; padding: 5px 10px; border: 1px solid #ccc;">Suma totală, ML</td>
                </tr>
                @php
                $i = 1;
                @endphp
                @foreach($products as $product)
                    <tr style="text-align: center;">
                        <td style="width: 40px; padding: 5px 10px;  border: 1px solid #ccc; color: black;">{{$i}}</td>
                        <td style="width: 80px; padding: 5px 10px;  border: 1px solid #ccc; color: black;">{{ \App\Models\Product::find($product->product_id)->onec_id }}</td>
                        <td style="width: 400px;  padding: 5px 10px; border: 1px solid #ccc; color: black; text-wrap: normal; text-align: left;">
                            {{ \App\Models\Product::find($product->product_id)->getTranslation('title', 'ro') }}
                        </td>
                        <td style="width: 80px; padding: 5px 10px; border: 1px solid #ccc; color: black; text-align: right">{{ $product->quantity }}</td>
                        <td style="width: 80px; padding: 5px 10px; border: 1px solid #ccc; text-align: right">{{ number_format($product->price, 2, ',', ' ') }}</td>
                        <td style="width: 80px; padding: 5px 10px; border: 1px solid #ccc; text-align: right">{{ number_format($product->quantity * (float)$product->price, 2, ',', ' ') }}</td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="5" style="padding: 10px 20px; text-align: right; font-size: 14px; border: 1px solid #ccc;">
                        <strong>Total:</strong>
                    </td>
                    <td colspan="1" style="padding: 10px 20px; font-size: 14px; border: 1px solid #ccc; text-align: right;">
                        <strong>{{ number_format($order->total, 2, ',', ' ') }}</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td colspan="2" width="700px" style="padding: 10px 20px; font-size: 14px; color: #555; text-align: center;">
            Puteți urmări starea comenzii în cabinetul personal.<br>
            Pentru orice informații sau modificări ale comenzii, contactați
            <a href="tel:022782112" style="color: #0056b3;">022 78 21 12</a>,
            <a href="tel:+37379782112" style="color: #0056b3;">+373 79 78 21 12</a><br>
            Program de lucru: Luni – Vineri: 08:00 – 17:00
        </td>
    </tr>
    </tbody>
</table>
</body>
