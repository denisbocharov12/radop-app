@php
    $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
@endphp
<a href="{{route('theme.product.index', $product->slug)}}" class="wrap-image">
    @if(count($imagesArray) > 1)
        @foreach($imagesArray as $key => $file)
            @switch($key)
                @case(0)
                <img class="primary-image" src="{{config('app.url')}}/{{$file}}" loading="lazy" alt="{{$product->title}}" />
                @break
                @case(1)
                <img class="secondary-image" src="{{config('app.url')}}/{{$file}}" loading="lazy" alt="{{$product->title}}" />
                @break
            @endswitch
        @endforeach
    @elseif(count($imagesArray) == 1)
        <img class="primary-image" style="display: block;" loading="lazy" src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$product->title}}" />
    @endif
</a>
