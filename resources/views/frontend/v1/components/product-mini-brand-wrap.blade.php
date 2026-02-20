<div class="product-mini-brand-wrap">
    @if($product->brand !== null)
        <a href="{{route('theme.brand.index', $product->brand->onec_id)}}" class="product-mini-brand">
            <span class="brand-text">
                <span class="mini-heading">{{__('theme.all-brand-products')}}</span>
                {{$product->brand->title}}
                <i class="icon-arrow-radop-right"></i>
            </span>
        </a>
    @endif
</div>
