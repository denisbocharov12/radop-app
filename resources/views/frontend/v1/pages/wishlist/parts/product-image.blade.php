@php
    $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->conditions->onec_id);
@endphp

<a href="{{route('theme.product.index', $product->conditions->slug)}}" class="wrap-image">
    @if(count($imagesArray) > 1)
        @foreach($imagesArray as $key => $file)
            @switch($key)
                @case(0)
                <img class="primary-image" src="{{config('app.url')}}//{{$file}}" loading="lazy" alt="{{$product->conditions->title}}" />
                @break
                @case(1)
                <img class="secondary-image" src="{{config('app.url')}}//{{$file}}" loading="lazy" alt="{{$product->conditions->title}}" />
                @break
            @endswitch
        @endforeach
    @elseif(count($imagesArray) == 1)
        <img class="primary-image" style="display: block;" loading="lazy" src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$product->conditions->title}}" />
    @endif
</a>
