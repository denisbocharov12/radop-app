<table>
    <tr>
        <td><strong>{{ __('theme.order-number')}}:</strong></td>
        <td>{{ $order->order_number }}</td>
    </tr>
    <tr>
        <td><strong>{{ __('theme.data')}}</strong></td>
        <td>{{ $order->created_at }}</td>
    </tr>
    <tr>
        <td><strong>{{ __('theme.order-delivery')}}:</strong></td>
        <td>{{ $order->city . ',' . $order->address }}</td>
    </tr>
    <tr>
        <td><strong>{{ __('theme.client_type')}}</strong></td>
        <td>{{ $order->user_type == 'fiz' ? __('theme.physical-person') : __('theme.legal-person') }}</td>
    </tr>
    <tr>
        <td><strong>{{ __('theme.client')}}</strong></td>
        <td>{{ $order->first_name . ' ' .$order->last_name }}</td>
    </tr>
</table>

<br>

<table style="border: 1px solid">
    <thead>
    <tr>
        <th>№</th>
        <th>{{ __('theme.order-cod')}}</th>
        <th>{{ __('theme.product-name')}}</th>
        <th>{{ __('theme.order-quantity')}}</th>
        <th>{{ __('theme.order-price')}}</th>
        <th>{{ __('theme.cart-table-sum')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $index => $item)
        <tr>
            @php
                $product = \App\Models\Product::where('id', $item->product_id)->first()
            @endphp
            <td>{{ $index + 1 }}</td>
            <td>{{ $product->onec_id }}</td>
            <td>{{ $product->title }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price, 2, '.', ' ') }}</td>
            <td>{{ number_format($item->price * $item->quantity, 2, '.', ' ') }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5" style="text-align: center"><strong>{{ __('theme.cart-table-sum')}}</strong></td>
        <td><strong>{{ number_format($order->total, 2, '.', ' ') }}</strong></td>
    </tr>
    </tfoot>
</table>
