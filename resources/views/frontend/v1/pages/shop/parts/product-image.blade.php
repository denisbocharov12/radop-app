@php
    $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
@endphp

<div class="wrap-image-with-gallery wrap-product-card-gallery">
    @if(count($imagesArray) > 0)
        <a href="{{config('app.url')}}/{{$imagesArray[0]}}" data-fancybox="gallery-{{$product->id}}">
            <img class="product-card-gallery-image" src="{{config('app.url')}}/{{$imagesArray[0]}}" loading="lazy" alt="{{$product->title}}" />
        </a>
        @foreach($imagesArray as $key => $file)
            @if($key > 0)
                <a href="{{config('app.url')}}/{{$file}}" data-fancybox="gallery-{{$product->id}}" class="d-none"></a>
            @endif
        @endforeach
        <div class="product-gallery-thumbs d-block d-md-none mt-2" style="display: flex; gap: 8px;">
            @foreach($imagesArray as $key => $file)
                <img src="{{config('app.url')}}/{{$file}}" alt="{{$product->title}}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 4px; border: 1px solid #eee; cursor: pointer;"
                     onclick="document.querySelectorAll('[data-fancybox=gallery-{{$product->id}}]')[{{$key}}].click()" />
            @endforeach
        </div>
    @endif
</div>
