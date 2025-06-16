<table style="border-collapse: collapse; width: 100%;">
    <thead>
    <tr>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">№</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.code') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.product-name') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.brand') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.package_photo') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.box_photo') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.barcode_excel') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.sheets_in_package') }}</th>
        <th colspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.packaging') }}</th>
        <th rowspan="2" style="border: 1px solid black; font-weight: 700">{{ __('theme.description') }}</th>
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
            <td style="border: 1px solid black;">{{ $i + 1 }}</td>
            <td style="border: 1px solid black;">{{ $product->onec_id }}</td>
            <td style="border: 1px solid black;">{!! $product->title !!}</td>
            <td style="border: 1px solid black;">{{ $product->brand->title }}</td>

            @if(count($imagesArray) > 1)
                <td style="border: 1px solid black;"><img src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$product->title}}" /></td>
                <td style="border: 1px solid black;"><img src="{{config('app.url')}}/{{$imagesArray[1]}}" alt="{{$product->title}}" /></td>
            @elseif(count($imagesArray) == 1)
                <td style="border: 1px solid black;"><img src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$product->title}}" /></td>
                <td style="border: 1px solid black;"></td>
            @else
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
            @endif

            <td style="border: 1px solid black;">="{{ $product->shtrih_code }}"</td>
            <td style="border: 1px solid black;">{{ $product->sheets_in_pack }}</td>
            <td style="border: 1px solid black;">{{ $product->packs_in_box }}</td>
            <td style="border: 1px solid black;">{{ $product->packs_on_pallet }}</td>
            <td style="border: 1px solid black;">{!! $product->data?->description !!}</td>
            <td style="border: 1px solid black; font-weight: 700">{{ $product->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>