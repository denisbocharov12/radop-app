<div class="product-item-article-wrap">
    <h3 class="product_item_article">
        <span>@lang('theme.code'):</span>
        <span
            class="product-code"
            role="button"
            tabindex="0"
            data-copy-value="{{ $product->onec_id }}"
            data-copy-message="{{ __('theme.product_code_copied') }}"
        >{!! $product->onec_id !!}</span>
    </h3>
{{--    <div class="details-wrap">--}}
{{--        <span class="stock {{$product->stock > 0 ? 'in-stock' : 'out-of-stock'}}">--}}
{{--            @if($product->stock > 0)--}}
{{--                {{__('theme.in-stock')}}--}}
{{--            @else--}}
{{--                {{__('theme.out-of-stock')}}--}}
{{--            @endif--}}
{{--        </span>--}}
{{--    </div>--}}

    <div class="product_item_article product_item_article_code">
        @if($product->article !== null && $product->article !== '')
            <h3 class="product_item_barcode">
                <span>{{__('theme.article')}}:</span>
                <span
                    class="product-code product-code--article"
                    role="button"
                    tabindex="0"
                    data-copy-value="{{ $product->article }}"
                    data-copy-message="{{ __('theme.product_code_copied') }}"
                >{{$product->article}}</span>
            </h3>
        @endif
    </div>
</div>
