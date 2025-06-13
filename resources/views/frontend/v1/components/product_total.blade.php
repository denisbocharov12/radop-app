@if($product->min_order !== null && $product->min_order > 1)
    {{\App\Services\Theme\Product\ThemeProductManager::getProductTotalSum($product) * $product->min_order}}
@else
    {{\App\Services\Theme\Product\ThemeProductManager::getProductTotalSumWithReplace($product)}}
@endif
