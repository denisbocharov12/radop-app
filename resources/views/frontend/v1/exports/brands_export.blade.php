<table style="border-collapse: collapse; width: 100%;">
    <thead>
    <tr></tr>
    <tr>
        <th rowspan="2"></th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">№</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.code') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.product-name') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.brand') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.barcode_excel') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.photo') }}</th>
        <th colspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.packaging') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.characteristics') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.price_excel') }}</th>
    </tr>
    <tr>
        <th style="border: 1px solid black; font-weight: 700">{{ __('theme.box') }}</th>
        <th style="border: 1px solid black; font-weight: 700">{{ __('theme.pallet') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $i => $product)
        @php
            $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
        @endphp
        <tr>
            <td></td>
            <td style="border: 1px solid black;">{{ $i + 1 }}</td>
            <td style="border: 1px solid black;">{{ $product->onec_id }}</td>
            <td style="border: 1px solid black;">{!! $product->title !!}</td>
            <td style="border: 1px solid black;">{{ $product->brand?->title }}</td>
            <td style="border: 1px solid black;" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}">{{ $product->shtrih_code }}</td>
            @if(count($imagesArray) > 1)
                <td style="border: 1px solid black;"><img src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$product->title}}" /></td>
            @elseif(count($imagesArray) == 1)
                <td style="border: 1px solid black;"><img src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$product->title}}" /></td>
            @else
                <td style="border: 1px solid black;"></td>
            @endif
            <td style="border: 1px solid black;">{{ $product->packages->min('value') }}</td>
            <td style="border: 1px solid black;">{{ $product->packages->max('value') }}</td>
            <td>
                {{ $product->values->map(fn($value) => $value->attribute?->name . ': ' . $value->value)->implode(chr(10)) }}
            </td>
            <td style="border: 1px solid black; font-weight: 700">{{ number_format($product->price, 2, ',', ' ') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
