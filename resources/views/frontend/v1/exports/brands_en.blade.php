<table style="border-collapse: collapse; width: 100%; font-family: Arial;">
    <thead>
    <tr>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">№</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.code') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.product-name') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.brand') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.barcode_excel') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.sheets_in_package') }}</th>
        <th colspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.packaging') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.description') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.price_excel') }}</th>
    </tr>
    <tr>
        <th style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.box') }}</th>
        <th style="font-family: Arial; font-weight: bold; font-size: 12px; border: 1px solid black;">{{ __('theme.pallet') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $i => $product)
        <tr>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $i + 1 }}</td>
            <td data-type="{{ \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING }}" style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $product->onec_id }}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{!! $product->title !!}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $product->brand->title }}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">="{{ $product->shtrih_code }}"</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $product->sheets_in_pack }}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $product->packs_in_box }}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{{ $product->packs_on_pallet }}</td>
            <td style="font-family: Arial; font-size: 11px; border: 1px solid black;">{!! $product->data?->description !!}</td>
            <td style="font-family: Arial; font-size: 12px; font-weight: bold; border: 1px solid black;">{{ $product->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
