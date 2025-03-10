<table style="border-collapse: collapse; width: 100%;">
    <tr>
        <td style="border: 1px solid black;"><strong>{{ __('theme.order-number') }}:</strong></td>
        <td style="border: 1px solid black;">{{ $order->order_number }}</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;"><strong>{{ __('theme.data') }}</strong></td>
        <td style="border: 1px solid black;">{{ $order->created_at }}</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;"><strong>{{ __('theme.order-delivery') }}:</strong></td>
        <td style="border: 1px solid black;">{{ $order->city . ', ' . $order->address }}</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;"><strong>{{ __('theme.client_type') }}</strong></td>
        <td style="border: 1px solid black;">{{ $order->user_type == 'fiz' ? __('theme.physical-person') : __('theme.legal-person') }}</td>
    </tr>

    @if($order->user_type !== 'fiz' && $order->user !== null)
        <tr>
            <td style="border: 1px solid black;"><strong>{{ __('theme.client') }}</strong></td>
            <td style="border: 1px solid black;">{{ $order->user->profile->organization_name }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid black;"><strong>{{ __('theme.cod-fiscal') }}</strong></td>
            <td style="border: 1px solid black;" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}" align="left">{!! $order->user->profile->cod_fiscal !!}</td>
        </tr>
    @else
        <tr>
            <td style="border: 1px solid black;"><strong>{{ __('theme.client') }}</strong></td>
            <td style="border: 1px solid black;">{{ $order->first_name . ' ' . $order->last_name }}</td>
        </tr>
    @endif
</table>

<br>

<table style="border-collapse: collapse; width: 100%;">
    <thead>
    <tr>
        <th style="border: 1px solid black; width: 120px">{{ __('theme.order-cod') }}</th>
        <th style="border: 1px solid black;">{{ __('theme.product-name') }}</th>
        <th style="border: 1px solid black;">{{ __('theme.order-quantity') }}</th>
        <th style="border: 1px solid black;">{{ __('theme.order-price') }}</th>
        <th style="border: 1px solid black;">{{ __('theme.cart-table-sum') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $index => $item)
        @php
            $product = \App\Models\Product::find($item->product_id);
        @endphp
        <tr>
            <td style="border: 1px solid black;" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}">{{ $product->onec_id }}</td>
            <td style="border: 1px solid black;">{{ $product->title }}</td>
            <td style="border: 1px solid black;">{{ $item->quantity }}</td>
            <td style="border: 1px solid black;">{{ number_format($item->price, 2, '.', ' ') }}</td>
            <td style="border: 1px solid black;" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}">{{ number_format($item->price * $item->quantity, 2, '.', ' ') }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4" style="border: 1px solid black; text-align: center;"><strong>{{ __('theme.cart-table-sum') }}</strong></td>
        <td style="border: 1px solid black;" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}"><strong>{{ number_format($order->total, 2, '.', ' ') }} лей</strong></td>
    </tr>
    </tfoot>
</table>
