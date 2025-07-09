@php
    $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
@endphp
<div class="wrap-image">
    @if(count($imagesArray) > 1)
        @foreach($imagesArray as $key => $file)
            @switch($key)
                @case(0)
                <a href="{{config('app.url')}}/{{$file}}" data-fancybox="product-gallery-{{$product->onec_id}}" class="product-image-link">
                    <img class="primary-image" src="{{config('app.url')}}/{{$file}}" loading="lazy" alt="{{$product->title}}" />
                </a>
                @break
                @case(1)
                <img class="secondary-image" src="{{config('app.url')}}/{{$file}}" loading="lazy" alt="{{$product->title}}" />
                @break
            @endswitch
        @endforeach
        @foreach($imagesArray as $key => $file)
            @if($key > 1)
                <a href="{{config('app.url')}}/{{$file}}" data-fancybox="product-gallery-{{$product->onec_id}}" style="display: none;"></a>
            @endif
        @endforeach
    @elseif(count($imagesArray) == 1)
        <a href="{{config('app.url')}}/{{$imagesArray[0]}}" data-fancybox="product-gallery-{{$product->onec_id}}" class="product-image-link">
            <img class="primary-image" style="display: block" loading="lazy" src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$product->title}}" />
        </a>
    @endif
</div>
