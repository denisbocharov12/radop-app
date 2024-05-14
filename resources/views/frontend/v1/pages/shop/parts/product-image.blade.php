{{--<a href="" class="wrap-image">--}}
{{--    @if(count($product->getMedia()) < 2)--}}
{{--        @foreach($product->getMedia() as $photo)--}}
{{--            <img class="primary-image" src="{{asset('storage').$product->images->first()->image_path}}" alt="" />--}}
{{--            <img class="primary-image" src="{{asset('storage').$product->images->first()->image_path}}" alt="" />--}}
{{--        @endforeach--}}
{{--    @else--}}
{{--        @foreach($product->getMedia() as $photo)--}}
{{--            @switch($key)--}}
{{--                @case(0)--}}
{{--                <img class="primary-image" src="{{asset('storage').$product->images->first()->image_path}}" alt="" />--}}
{{--                @break--}}
{{--                @case(1)--}}
{{--                <img class="secondary-image" src="{{asset('storage').$product->images->get(1)->image_path}}" alt="" />--}}
{{--                @break--}}
{{--            @endswitch--}}
{{--        @endforeach--}}
{{--    @endif--}}
{{--</a>--}}
@php
    $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
@endphp

<a href="{{route('theme.product.index', $product->slug)}}" class="wrap-image">
    @if(count($imagesArray) > 1)
        @foreach($imagesArray as $key => $file)
            @switch($key)
                @case(0)
                <img class="primary-image" src="{{config('app.url')}}/{{$file}}" alt="{{$file}}" />
                @break
                @case(1)
                <img class="secondary-image" src="{{config('app.url')}}/{{$file}}" alt="{{$file}}" />
                @break
            @endswitch
        @endforeach
    @elseif(count($imagesArray) == 1)
        <img class="primary-image" src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$imagesArray[0]}}" />
        <img class="secondary-image" src="{{config('app.url')}}/{{$imagesArray[0]}}" alt="{{$imagesArray[0]}}" />
    @endif
</a>

{{--<a href="{{route('theme.product.index', $product->slug)}}" class="wrap-image">--}}
{{--    <img class="secondary-image" src="https://placehold.co/600x600?text=Demo 1" alt="" />--}}
{{--    <img class="primary-image" src="https://placehold.co/600x600?text=Demo 2" alt="" />--}}
{{--</a>--}}
