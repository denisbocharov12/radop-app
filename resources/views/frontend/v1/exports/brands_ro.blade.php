<table style="border-collapse: collapse; width: 100%; font-family: Arial;">
    <thead>
    <tr></tr>
    <tr>
        <th rowspan="2"></th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">№</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.code') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.product-name') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.brand') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.barcode_excel') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.photo') }}</th>
        <th colspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.packaging') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.characteristics') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.price_excel') }}</th>
    </tr>
    <tr>
        <th style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.box') }}</th>
        <th style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.pallet') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $i => $product)
        @php
            $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
        @endphp
        <tr>
            <td style="font-family: Arial; font-size: 11px;"></td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $i + 1 }}</td>
            <td data-type="{{ \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING }}" style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $product->onec_id }}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{!! $product->title !!}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $product->brand?->title }}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}">{{ $product->shtrih_code }}</td>
            @if(count($imagesArray) > 1)
                <td style="font-family: Arial; font-size: 11px; border: 1px solid black;"><img src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$product->title}}" /></td>
            @elseif(count($imagesArray) == 1)
                <td style="font-family: Arial; font-size: 11px; border: 1px solid black;"><img src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$product->title}}" /></td>
            @else
                <td style="font-family: Arial; font-size: 11px; border: 1px solid black;"></td>
            @endif
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $product->packages->min('value') }}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $product->packages->max('value') }}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">
                @if($product->values)
                    @foreach($product->values as $value)
                        <span>
                        {{$value->attribute?->name}}: {{$value->value}}
                    </span>
                    @endforeach
                @endif
            </td>
            <td style="font-family: Arial; font-size: 12px; font-weight: bold; border: 1px solid black;">{{ number_format($product->price, 2, ',', ' ') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
