<table style="border-collapse: collapse; width: 100%; font-family: Arial;">
    <thead>
    <tr></tr>
    <tr>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px;">№</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.code') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px; text-align: left;">{{ __('theme.excel-product-name') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.brand') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.photo') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.barcode_excel') }}</th>
        <th colspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.packaging') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.characteristics') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.personalized_price_excel') }}</th>
        <th rowspan="2" style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.note_excel') }}</th>
    </tr>
    <tr>
        <th style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.box') }}</th>
        <th style="font-family: Arial; font-weight: bold; font-size: 11px;">{{ __('theme.pallet') }}</th>
    </tr>
    </thead>
    <tbody>
    @php $rowNum = 0; @endphp
    @foreach($groups as $group)
        {{-- Category sub-header: spans the full row width (colspan) so the name
             is never squashed into the narrow first column; the band is also
             merged + wrapped in the export's AfterSheet hook. --}}
        <tr>
            <td colspan="11" style="font-family: Arial; font-weight: bold; font-size: 13px; text-align: left; white-space: normal; word-wrap: break-word;">{{ $group['category_name'] }}</td>
        </tr>
        @foreach($group['products'] as $product)
            @php $rowNum++; @endphp
            <tr>
                <td style="font-family: Arial; font-size: 11px;">{{ $rowNum }}</td>
                <td data-type="{{ \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING }}" style="font-family: Arial; font-size: 11px;">{{ $product->onec_id }}</td>
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
                <td data-format="#,##0.00" style="font-family: Arial; font-size: 12px; font-weight: bold;">{{ number_format((float)$product->price, 2, '.', '') }}</td>
                <td style="font-family: Arial; font-size: 11px;"></td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
