<section class="section-invoice" style="padding: 40px 0; background-color: #f9f9f9;">
    <div class="invoice-container" style="max-width: 800px; margin: auto; background-color: #ffffff; padding: 40px; border: 1px solid #eaeaea; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif; color: #333333; line-height: 1.6;">
        <div class="invoice-header" style="display: flex; justify-content: space-between; margin-bottom: 40px;">
            <div class="company-info" style="width: 45%;">
                <h3>'RADOP-OPT' SRL</h3>
                <p>
                    MD94ML000000002251419173   la <br>
                    BC Moldindconbank SA  MOLDMD2X <br>
                    Cod MOLDMD2X
                </p>
            </div>
            <div class="client-info" style="width: 66%; text-align: right;">
                <!-- Site Logo -->
                <a href="{{ route('theme.home') }}" class="site-logo" style="margin-top: 20px;">
                    <img src="{{ $message->embed(public_path('/v1/frontend/assets/images/logo_svg_radop.png')) }}" alt="Radop Logo" style="max-width: 150px;" />
                </a>
                <p>{{ __('theme.address')}}: Sarmizegetusa, 15 Chisinau</p>
                <p>Tel. 022-78-21-00</p>
            </div>
        </div>

        <div class="invoice-details" style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 32px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 2px; color: #333333;">{{ __('theme.payment-account')}}</h1>
            <p style="font-size: 18px; color: #555555;"><strong>{{ __('theme.payment-account')}} №:</strong> {{ $order->order_number }}</p>
            <p style="font-size: 18px; color: #555555;"><strong>{{ __('theme.data')}}</strong> {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        </div>

        <table class="invoice-table" style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">
            <thead style="background-color: #f0f0f0;">
            <tr>
                <th style="padding: 15px; border: 1px solid #eaeaea; text-align: left;">{{ __('theme.title')}}</th>
                <th style="padding: 15px; border: 1px solid #eaeaea; text-align: left;">{{ __('theme.quantity-shortly')}}</th>
                <th style="padding: 15px; border: 1px solid #eaeaea; text-align: left;">{{ __('theme.price')}}</th>
                <th style="padding: 15px; border: 1px solid #eaeaea; text-align: left;">{{ __('theme.total')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td style="padding: 15px; border: 1px solid #eaeaea; text-align: left;">{{ \App\Models\Product::find($product->product_id)->title }}</td>
                    <td style="padding: 15px; border: 1px solid #eaeaea; text-align: left;">{{ $product->quantity }}</td>
                    <td style="padding: 15px; border: 1px solid #eaeaea; text-align: left;">{{ $product->price }} {{ __('theme.MDL') }}</td>
                    <td style="padding: 15px; border: 1px solid #eaeaea; text-align: left;">{{ $product->price * $product->quantity}} {{ __('theme.MDL') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="total-amount" style="text-align: right; margin-bottom: 20px; font-size: 18px;">
            <strong>{{ __('theme.summary')}}</strong>
            @php
                $totalAmount = $products->sum(function($product) {
                    return $product->price * $product->quantity;
                });
            @endphp
            {{ $totalAmount }} {{ __('theme.MDL')}}
        </div>
        <div class="invoice-footer" style="text-align: center; font-size: 14px; color: #777777; border-top: 1px solid #eaeaea; padding-top: 20px;">
            <p>radop.md | radop112@radop.md | 022-78-21-00</p>
        </div>
    </div>
</section>
