@php
    $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
@endphp
<div class="product-slider-main">
    @foreach($imagesArray as $key => $file)
        <a href="/{{$file}}" class="product-image" data-fancybox="gallery">
            <img src="/{{$file}}" alt="{{$product->title}}">
        </a>
    @endforeach
    <a href="https://placehold.co/600x400" class="product-image">
        <img src="https://placehold.co/500x900" alt="{{$product->title}}">
    </a>
    <a href="https://placehold.co/600x400" class="product-image">
        <img src="https://placehold.co/500x900" alt="{{$product->title}}">
    </a>
</div>
<div class="product-slider-thumb">
    @foreach($imagesArray as $key => $file)
        <a href="https://placehold.co/600x400" class="product-image @if($key == 0) current slick-active @endif" >
            <img src="https://placehold.co/600x400" alt="{{$product->title}}">
        </a>
    @endforeach
    <a href="https://placehold.co/500x400" class="product-image current slick-active" >
        <img src="https://placehold.co/500x900" alt="{{$product->title}}">
    </a>
    <a href="https://placehold.co/500x500" class="product-image" >
        <img src="https://placehold.co/500x900" alt="{{$product->title}}">
    </a>
</div>
