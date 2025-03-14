<body style="max-width: 700px; margin: auto; padding: 20px; border: none; color: #000; text-align: center;">
<a href="{{route('theme.home')}}" class="link-logo">
    <img style="width: 100px; display: flex; align-items: center;justify-content: center" src="https://floradelivery.md/wp-content/uploads/2025/03/radop_logo.jpg" alt="Radop logo">
</a>
<div class="header" style="padding: 10px 0;">
    <h2>Bună ziua, {{ $order->first_name }} {{ $order->last_name }}</h2>
    <p>Vă mulțumim pentru cumpărătura făcută în magazinul nostru! Comanda dvs. nr. {{ $order->order_number }} a fost plasată cu succes și trimisă spre procesare.</p>
    <p>Managerul nostru vă va contacta în cel mai scurt timp pentru a clarifica detaliile comenzii și ale livrării.</p>
    <p>Dacă aveți întrebări, puteți să ne contactați la numărul de telefon <a href="tel:37379782112">+373 79 78 21 12</a> sau la adresa de email <a href="mailto:support@radop.md">support@radop.md</a></p>
</div>
<div class="separator" style="border-bottom: 2px solid #000; margin: 10px 0;"></div>
<div class="order-details" style="padding: 10px 0;">
    <p style="margin: 5px 0;"><strong>Număr comandă:</strong> {{ $order->order_number }}</p>
    <p style="margin: 5px 0;"><strong>Data comenzii:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
    <p style="margin: 5px 0;"><strong>Metoda de plată:</strong>
        @if($order->payment_method === 'cash')
            Plată cu numerar
        @elseif($order->payment_method === 'card')
            Plată fără numerar
        @endif
    </p>
    <p style="margin: 5px 0;"><strong>Metoda de livrare:</strong> {{ $order->delivery_method }}</p>
    <p style="margin: 5px 0;"><strong>Adresa de livrare:</strong> {{ $order->address }}</p>
    <p style="margin: 5px 0;"><strong>Datele de contact:</strong> {{ $order->phone }}</p>
<div class="separator" style="border-bottom: 2px solid #000; margin: 10px 0;"></div>
<div class="order-content" style="padding: 10px 0;">
    <h3>Conținutul comenzii:</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <tr>
            <th style="padding: 8px; text-align: left; font-weight: bold;">Cod</th>
            <th style="padding: 8px; text-align: left; font-weight: bold;">Denumire produsului</th>
            <th style="padding: 8px; text-align: left; font-weight: bold;">Cantitate</th>
            <th style="padding: 8px; text-align: left; font-weight: bold; min-width: 80px">Preț</th>
            <th style="padding: 8px; text-align: left; font-weight: bold; min-width: 80px">Sumă</th>
        </tr>
        @foreach($products as $product)
            <tr>
                <td style="padding: 8px; text-align: left;">{{ \App\Models\Product::find($product->product_id)->onec_id }}</td>
                <td style="padding: 8px; text-align: left;">{{ \App\Models\Product::find($product->product_id)->getTranslation('title', 'ro') }}</td>
                <td style="padding: 8px; text-align: left;">{{ $product->quantity }} buc.</td>
                <td style="padding: 8px; text-align: left;">{{ $product->price}} lei</td>
                <td style="padding: 8px; text-align: left;">{{ $product->price * $product->quantity}} lei</td>
            </tr>
        @endforeach
    </table>
    <div class="separator" style="border-bottom: 2px solid #000; margin: 10px 0;"></div>
    <div class="total" style="overflow: hidden;">
        <p style="float: left;">Total de plată:</p>
        <p style="float: right;">{{ $order->total }} lei</p>
    </div>
    <div class="separator" style="border-bottom: 2px solid #000; margin: 10px 0;"></div>
    <div class="additional-information">
        <h3>Informații suplimentare:</h3>
        <p><a href="{{route('theme.user.orders.index')}}">Puteți urmări starea comenzii în contul personal.</a></p>
        <p>Lucrăm constant la îmbunătățirea site-ului nostru. Dacă aveți observații sau sugestii, vă rugăm să ne scrieți la <a href="mailto:support@radop.md">support@radop.md</a> sau să ne sunați la numărul <a href="tel:37379782112">+373 79 78 21 12</a></p>
        <p>Vă mulțumim că ne-ați ales! Apreciem încrederea acordată.</p>
        <p>Cu respect,</p>
        <p>Echipa www.radop.md</p>
        <p><a href="mailto:support@radop.md">support@radop.md</a></p>
        <p><a href="tel:37322782112">022 78 21 12</a></p>
        <p><a href="tel:37379782112">mob. +373 79 78 21 12</a></p>
    </div>
</div>
</body>
