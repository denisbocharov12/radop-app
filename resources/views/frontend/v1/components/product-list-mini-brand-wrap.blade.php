<div class="product-list-mini-brand-wrap">
    @if($product->brand !== null)
        <span class="mini-heading">{{__('theme.all-brand-products')}}</span>
        <a href="{{route('theme.brand.index', $product->brand->onec_id)}}" class="product-mini-brand">
            <span class="brand-text"><p>{{$product->brand->title}}</p></span>
        </a>
    @endif
</div>
