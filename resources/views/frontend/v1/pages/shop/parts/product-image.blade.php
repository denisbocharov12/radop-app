<div class="wrap-image-with-gallery wrap-product-card-gallery">
    @if($product->hasMedia('products'))
        <a href="{{$product->getFirstMediaUrl('products')}}" data-product-card-fancybox data-product-onec="{{$product->onec_id}}" data-product-title="{{$product->title}}">
            <img class="product-card-gallery-image"
                 src="{{$product->getFirstMediaUrl('products', 'medium')}}"
                 loading="lazy"
                 alt="{{$product->title}}" />
        </a>
    @else
        @php
            $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
        @endphp
        @if(count($imagesArray) > 1)
            @foreach($imagesArray as $key => $file)
                @switch($key)
                    @case(0)
                        <a href="{{config('app.url')}}/{{$file}}" data-product-card-fancybox data-product-onec="{{$product->onec_id}}" data-product-title="{{$product->title}}">
                            <img class="product-card-gallery-image" src="{{config('app.url')}}/{{$file}}" loading="lazy" alt="{{$product->title}}" />
                        </a>
                        @break
                @endswitch
            @endforeach
        @elseif(count($imagesArray) == 1)
            <a href="{{config('app.url')}}/{{$imagesArray[0]}}" data-product-card-fancybox data-product-onec="{{$product->onec_id}}" data-product-title="{{$product->title}}">
                <img class="product-card-gallery-image" src="{{config('app.url')}}/{{$imagesArray[0]}}" loading="lazy" alt="{{$product->title}}" />
            </a>
        @endif
    @endif
</div>
