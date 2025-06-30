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
        <td style="border: 1px solid black;"><strong>{{ __('theme.order-delivery') }}</strong></td>
        <td style="border: 1px solid black;">{{\App\Models\City::find($order->city)?->name. ', ' . $order->address }}</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;"><strong>{{ __('theme.client_type') }}</strong></td>
        <td style="border: 1px solid black;">{{ $order->user_type == 'fiz' ? __('theme.physical-person') : __('theme.legal-person') }}</td>
    </tr>

    @if($order->user_type === 'iur' && $order->user !== null)
        <tr>
            <td style="border: 1px solid black;"><strong>{{ __('theme.client') }}</strong></td>
            <td style="border: 1px solid black;">{{ $order->user->profile->organization_name }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid black;"><strong>Фикс. код:</strong></td>
            <td style="border: 1px solid black;" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}" align="left">{!! $order->user->profile->cod_fiscal !!}</td>
        </tr>
        <tr>
            <td style="border: 1px solid black;"><strong>{{ __('theme.filial') }}:</strong></td>
            <td style="border: 1px solid black;">{{ $order->filial?->address }}</td>
        </tr>
    @elseif($order->user_type === 'fiz' && $order->user !== null)
        <tr>
            <td style="border: 1px solid black;"><strong>{{ __('theme.client') }}:</strong></td>
            <td style="border: 1px solid black;">{{ $order?->fio }}</td>
        </tr>
    @endif
    <tr>
        <td style="border: 1px solid black;"><strong>Телефон:</strong></td>
        <td style="border: 1px solid black;">{{ $order->phone }}</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;"><strong>E-mail:</strong></td>
        <td style="border: 1px solid black;">{{ $order->email }}</td>
    </tr>
</table>

<br>

<table style="border-collapse: collapse; width: 100%;">
    <thead>
    <tr>
        <th style="border: 1px solid black; width: 120px; font-weight: 700; text-align: center;">{{ __('theme.order-cod') }}</th>
        <th style="border: 1px solid black;font-weight: 700; text-align: center;">{{ __('theme.product-name') }}</th>
        <th style="border: 1px solid black;font-weight: 700; text-align: center;">{{ __('theme.order-quantity') }}</th>
        <th style="border: 1px solid black;font-weight: 700; text-align: center;">{{ __('theme.order-price') }}</th>
        <th style="border: 1px solid black;font-weight: 700; text-align: center;">{{ __('theme.cart-table-sum') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $index => $item)
        @php
            $product = \App\Models\Product::find($item->product_id);
        @endphp
        <tr>
            <td style="border: 1px solid black; text-align: center" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}">{{ $product->onec_id }}</td>
            <td style="border: 1px solid black;">{{ $product->title }}</td>
            <td style="border: 1px solid black; text-align: center">{{ $item->quantity }}</td>
            <td style="border: 1px solid black; text-align: right" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}">{{ number_format($item->price, 2, ',', ' ') }}</td>
            <td style="border: 1px solid black;">{{ $item->price * $item->quantity }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4" style="border: 1px solid black; text-align: right;" ><strong>Итого</strong></td>
        <td style="border: 1px solid black; text-align: right" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}"><strong>{{ number_format($order->total, 2, ',', ' ') }}</strong></td>
    </tr>
    </tfoot>
</table>

@if($order->note)
    <br>

    <table style="width: 100%;">
        <tr>
            <td>
            <td style="width: 300px; word-wrap: break-word; word-break: break-word;">
                <strong>Комментарий: </strong>{{ $order->note }}
            </td>
        </tr>
    </table>
@endif
