@if($product->min_order !== null && $product->min_order > 1)
    {{  number_format(\App\Services\Theme\Product\ThemeProductManager::getProductTotalSum($product) * $product->min_order, 2, ',', '')}}
@else
    {{\App\Services\Theme\Product\ThemeProductManager::getProductTotalSumWithReplace($product)}}
@endif
