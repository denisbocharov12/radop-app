<table style="border-collapse: collapse; width: 100%;">
    <thead>
    <tr></tr>
    <tr>
        <th rowspan="2" style="font-weight: 700">№</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.code') }}</th>
        <th rowspan="2" style="font-weight: 700; text-align: left">{{ __('theme.excel-product-name') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.brand') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.photo') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.barcode_excel') }}</th>
        <th colspan="2" style="font-weight: 700">{{ __('theme.packaging') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.characteristics') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.personalized_price_excel') }}</th>
    </tr>
    <tr>
        <th style="font-weight: 700">{{ __('theme.box') }}</th>
        <th style="font-weight: 700">{{ __('theme.pallet') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $i => $product)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $product->onec_id }}</td>
            <td style="text-align: left">{{ $product->title }}</td>
            <td>{{ $product->brand?->title }}</td>
            <td></td>
            <td data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}">{{ $product->shtrih_code }}</td>
            <td>{{ $product->packages->min('value') }}</td>
            <td>{{ $product->packages->max('value') }}</td>
            <td style="white-space: pre-line;">
                {!! $product->values
                    ->map(fn($value) => e($value->attribute?->name . ': ' . $value->value))
                    ->implode('<br>') !!}
            </td>
            <td style="font-weight: 700">{{ number_format((float)$product->price, 2, ',', ' ') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

