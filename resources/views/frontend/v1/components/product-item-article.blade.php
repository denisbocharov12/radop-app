<div class="product-item-article-wrap">
    <h3 class="product_item_article">
        <span>@lang('theme.code'):</span>
        <span class="product-code">{{$product->onec_id}}</span>
    </h3>
    <div class="details-wrap">
        <span class="stock {{$product->stock > 0 ? 'in-stock' : 'out-of-stock'}}">
            @if($product->stock > 0)
                {{__('theme.in-stock')}}
            @else
                {{__('theme.out-of-stock')}}
            @endif
        </span>
    </div>
</div>
