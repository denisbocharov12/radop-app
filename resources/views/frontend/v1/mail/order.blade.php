<body style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: none; color: #000; text-align: center;">
<div class="header" style="padding: 10px 0;">
    <h2 style="color: #0056b3; text-align: center; font-weight: bold;">{{ __('theme.order-title')}}</h2>
    <p>{{ __('theme.order-text-2')}} <strong><a href="{{ route('theme.home') }}" class="site-logo">radop.md</a></strong> {{ __('theme.order-text-3')}}</p>
    <p>{{ __('theme.order-text')}}</p>
</div>
<div class="separator" style="border-bottom: 2px solid #000; margin: 10px 0;"></div>
<div class="order-details" style="padding: 10px 0;">
    <p style="margin: 5px 0;"><strong>{{ __('theme.payment-account')}}:</strong> {{ $order->order_number }}</p>
    <p style="margin: 5px 0;"><strong>{{ __('theme.data')}}</strong> {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    <p style="margin: 5px 0;"><strong>{{ __('theme.order-delivery')}}:</strong> {{ $order->address }}</p>
    <p style="margin: 5px 0;"><strong>{{ __('theme.order-contact-data')}}:</strong> {{ $order->first_name }} {{ $order->last_name }} {{ $order->phone }}</p>
    <p style="margin: 5px 0;"><strong>{{ __('theme.order-payment')}}:</strong> {{ __('theme.' . $order->payment_method) }}</p></div>
<div class="separator" style="border-bottom: 2px solid #000; margin: 10px 0;"></div>
<div class="order-content" style="padding: 10px 0;">
    <h3>{{ __('theme.order-content')}}</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <tr>
            <th style="padding: 8px; text-align: left; font-weight: bold;">{{ __('theme.order-product')}}</th>
            <th style="padding: 8px; text-align: left; font-weight: bold;">{{ __('theme.order-cod')}}</th>
            <th style="padding: 8px; text-align: left; font-weight: bold;">{{ __('theme.order-quantity')}}</th>
            <th style="padding: 8px; text-align: left; font-weight: bold;">{{ __('theme.order-price')}}</th>
        </tr>
        @foreach($products as $product)
            <tr>
                <td style="padding: 8px; text-align: left;">{{ \App\Models\Product::find($product->product_id)->title }}</td>
                <td style="padding: 8px; text-align: left;">{{ $product->onec_id }}</td>
                <td style="padding: 8px; text-align: left;">{{ $product->quantity }} {{ __('theme.package_unit') }}</td>
                <td style="padding: 8px; text-align: left;">{{ $product->price * $product->quantity}} {{ __('theme.MDL') }}</td>
            </tr>
        @endforeach
    </table>
    <div class="separator" style="border-bottom: 2px solid #000; margin: 10px 0;"></div>
    <div class="total" style="overflow: hidden;">
        <p style="float: left;">{{ __('theme.order-delivery')}}:</p>
        <p style="float: right;">
            @if($order->delivery_charge > 0)
                {{ $order->delivery_charge }} {{ __('theme.MDL') }}
            @else
                {{ __('theme.order-delivery-free')}}
            @endif
        </p>
    </div>
    <div class="total" style="overflow: hidden;">
        <p style="float: left;">{{ __('theme.order-total')}}:</p>
        <p style="float: right;">{{ $order->total }} {{ __('theme.MDL') }}</p>
    </div>
</div>
</body>
