<table style="border-collapse: collapse; width: 100%;">
    <thead>
    <tr></tr>
    <tr>
        <th rowspan="2"></th>
        <th rowspan="2" style="font-weight: 700">№</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.code') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.product-name') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.brand') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.barcode_excel') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.photo') }}</th>
        <th colspan="2" style="font-weight: 700">{{ __('theme.packaging') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.characteristics') }}</th>
        <th rowspan="2" style="font-weight: 700">{{ __('theme.price_excel') }}</th>
    </tr>
    <tr>
        <th style="font-weight: 700">{{ __('theme.box') }}</th>
        <th style="font-weight: 700">{{ __('theme.pallet') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $i => $product)
        @php
            $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
        @endphp
        <tr>
            <td></td>
            <td>{{ $i + 1 }}</td>
            <td>{{ $product->onec_id }}</td>
            <td>{!! $product->title !!}</td>
            <td>{{ $product->brand?->title }}</td>
            <td data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}">{{ $product->shtrih_code }}</td>
            <td></td>
            <td>{{ $product->packages->min('value') }}</td>
            <td>{{ $product->packages->max('value') }}</td>
            <td style="white-space: pre-line;">
                {!! $product->values
                    ->map(fn($value) => $value->attribute?->name . ': ' . $value->value)
                    ->implode("\n") !!}
            </td>
            <td style="font-weight: 700">{{ number_format($product->price, 2, ',', ' ') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
