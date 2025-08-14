@php
    $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
@endphp
<div class="wrap-image-with-gallery wrap-product-card-gallery">
    <div class="product-slider-main">
        @foreach($product->getMedia('products') as $key => $file)
            <a href="{{$file->getUrl()}}" class="product-image" data-fancybox-product>
                <img src="{{$file->getUrl()}}" alt="{{$product->title}}">
            </a>
        @endforeach
    </div>
    <div class="product-slider-thumb">
        @foreach($product->getMedia('products') as $key => $file)
            <a href="{{$file->getUrl()}}" class="product-image @if($key == 0) current slick-active @endif" data-fancybox-product>
                <img src="{{$file->getUrl()}}" alt="{{$product->title}}">
            </a>
        @endforeach
    </div>
</div>
