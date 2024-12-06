@if($product->sale_price !== '')
<div class="
    product-label-s-wrap
    s-on_sale
    ">
    <span class="product-label-s">
        {{__('theme.label_on_sale')}}
    </span>
</div>
@endif

@if($product?->data?->condition === 'new' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-new
    ">
    <span class="product-label-s">
        {{__('theme.label_new')}}
    </span>
    </div>
@endif

@if($product?->data?->condition === 'popular' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-popular
    ">
    <span class="product-label-s">
        {{__('theme.label_popular')}}
    </span>
    </div>
@endif

@if($product?->data?->condition === 'featured' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-featured
    ">
    <span class="product-label-s">
        {{__('theme.label_featured')}}
    </span>
    </div>
@endif

@if($product?->data?->condition === 'hot' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-hot
    ">
    <span class="product-label-s">
        {{__('theme.label_hot')}}
    </span>
    </div>
@endif

@if($product?->data?->condition === 'winter' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-winter
    ">
    <span class="product-label-s">
         {{__('theme.label_winter')}}
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data?->condition === 'new')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-new
    ">
    <span class="product-label-s">
        {{__('theme.label_new')}}
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data?->condition === 'popular')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-popular
    ">
    <span class="product-label-s">
        {{__('theme.label_popular')}}
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data?->condition === 'featured')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-featured
    ">
    <span class="product-label-s">
                {{__('theme.label_featured')}}
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data?->condition === 'hot')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-hot
    ">
    <span class="product-label-s">
        {{__('theme.label_hot')}}
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data?->condition === 'winter')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-winter
    ">
    <span class="product-label-s">
        {{__('theme.label_winter')}}
    </span>
    </div>
@endif
