@php
    $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
@endphp
<div class="wrap-image-with-gallery wrap-product-card-gallery">
    <div class="product-slider-main">
        @foreach($imagesArray as $key => $file)
            <a href="/{{$file}}" class="product-image" data-fancybox="product-gallery-{{$product->onec_id}}">
                <img src="/{{$file}}" alt="{{$product->title}}">
            </a>
        @endforeach
    </div>
    <div class="product-slider-thumb">
        @foreach($imagesArray as $key => $file)
            <a href="/{{$file}}" class="product-image @if($key == 0) current slick-active @endif" data-fancybox="product-gallery-{{$product->onec_id}}">
                <img src="/{{$file}}" alt="{{$product->title}}">
            </a>
        @endforeach
    </div>
</div>
