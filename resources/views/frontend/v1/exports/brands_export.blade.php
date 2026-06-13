<table style="border-collapse: collapse; width: 100%; font-family: Arial;">
    <thead>
    <tr></tr>
    <tr>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px;">№</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.code') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px; text-align: left;">{{ __('theme.excel-product-name') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.brand') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.photo') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.barcode_excel') }}</th>
        <th colspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.packaging') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.characteristics') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.price_excel') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.note_excel') }}</th>
    </tr>
    <tr>
        <th style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.box') }}</th>
        <th style="font-family: Arial; font-weight: bold; font-size: 12px;">{{ __('theme.pallet') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $i => $product)
        <tr>
            <td style="font-family: Arial; font-size: 11px;">{{ $i + 1 }}</td>
            <td style="font-family: Arial; font-size: 11px;">{{ ' '.$product->onec_id.' ' }}</td>
            <td style="font-family: Arial; font-size: 11px; text-align: left;">{{ $product->title }}</td>
            <td style="font-family: Arial; font-size: 11px;">{{ $product->brand?->title }}</td>
            <td style="font-family: Arial; font-size: 11px;"></td>
            <td style="font-family: Arial; font-size: 11px;" data-format="{{PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER}}">{{ $product->shtrih_code }}</td>
            <td style="font-family: Arial; font-size: 11px;">{{ $product->packages->min('value') }}</td>
            <td style="font-family: Arial; font-size: 11px;">{{ $product->packages->max('value') }}</td>
            <td style="font-family: Arial; font-size: 11px; white-space: pre-line;">
                {!! $product->values
                    ->map(fn($value) => e($value->attribute?->name . ': ' . $value->value))
                    ->implode('<br>') !!}
            </td>
            <td data-format="#,##0.00" style="font-family: Arial; font-size: 12px; font-weight: bold;">{{ \App\Services\Theme\Product\ThemeProductManager::getProductTotalSum($product) }}</td>
            <td style="font-family: Arial; font-size: 11px;"></td>
        </tr>
    @endforeach
    </tbody>
</table>
