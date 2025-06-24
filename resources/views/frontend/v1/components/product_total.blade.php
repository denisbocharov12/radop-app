@php
    $rawPrice = \App\Services\Theme\Product\ThemeProductManager::getRawProductPrice($product);
@endphp
@if($product->min_order !== null && $product->min_order > 1)
    {{number_format($rawPrice * $product->min_order, 2, ',', ' ')}}
@else
    {{number_format($rawPrice, 2, ',', ' ')}}
@endif
