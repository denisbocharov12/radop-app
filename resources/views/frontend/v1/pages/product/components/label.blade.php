@if($product->sale_price !== '')
<div class="
    product-label-s-wrap
    s-on_sale
    ">
    <span class="product-label-s">
        Sale
    </span>
</div>
@endif

@if($product?->data->condition === 'new' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-new
    ">
    <span class="product-label-s">
        New
    </span>
    </div>
@endif

@if($product?->data->condition === 'popular' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-popular
    ">
    <span class="product-label-s">
        Popular
    </span>
    </div>
@endif

@if($product?->data->condition === 'featured' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-featured
    ">
    <span class="product-label-s">
        Featured
    </span>
    </div>
@endif

@if($product?->data->condition === 'hot' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-hot
    ">
    <span class="product-label-s">
        Hot
    </span>
    </div>
@endif

@if($product?->data->condition === 'winter' && $product->sale_price === '')
    <div class="
    product-label-s-wrap
    s-winter
    ">
    <span class="product-label-s">
        Winter
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data->condition === 'new')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-new
    ">
    <span class="product-label-s">
        New
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data->condition === 'popular')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-popular
    ">
    <span class="product-label-s">
        New
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data->condition === 'featured')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-featured
    ">
    <span class="product-label-s">
        Featured
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data->condition === 'hot')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-hot
    ">
    <span class="product-label-s">
        Hot
    </span>
    </div>
@endif

@if($product->sale_price !== '' && $product?->data->condition === 'winter')
    <div class="
    product-label-s-wrap
    product-label-s-wrap-right
    s-winter
    ">
    <span class="product-label-s">
        Winter
    </span>
    </div>
@endif
