@if($product->sale_price !== '')
    <a href="{{route('theme.product.index', $product->slug)}}" class="product-label">
        <div class="product-label-wrap">
            <span class="product-label-span">
                - {{\App\Services\Theme\Product\ThemeProductManager::getProductSaleForLabel($product)}}%
            </span>
        </div>
    </a>
@endif
