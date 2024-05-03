{{--<div class="product-slider-main">--}}
{{--    @if(count($product->images) > 0)--}}
{{--        @foreach($product->images as $key=>$photo)--}}
{{--            <div class="product-image {{$key==0 ? 'slick-current slick-active' : ''}}">--}}
{{--                <img src="{{asset('storage').$photo->image_path}}" alt="">--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    @else--}}
{{--        <div class="product-image">--}}
{{--            <img src="https://placehold.co/600x900?text=Demo" alt="Demo">--}}
{{--        </div>--}}
{{--    @endif--}}
{{--</div>--}}
{{--<div class="product-slider-thumb">--}}
{{--    @if(count($product->images) > 0)--}}
{{--        @foreach($product->images as $key=>$photo)--}}
{{--            <div class="product-image {{$key==0 ? 'slick-current slick-active' : ''}}">--}}
{{--                <img src="{{asset('storage').$photo->image_path}}" alt="">--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    @else--}}
{{--    @endif--}}
{{--</div>--}}
@php
    $dir = public_path() . config('media-files.DIR_PATH');
    $files = glob($dir . "$product->onec_id*");

    $imagesArray = [];

    foreach ($files as $key => $file) {
        $imagesArray[] = str_replace('/var/www/html/public/', '', $file);
    }
@endphp
<div class="product-slider-main">
    @foreach($imagesArray as $key => $file)
        <a href="/{{$file}}" class="product-image" data-fancybox="gallery">
            <img src="/{{$file}}" alt="{{$product->title}}">
        </a>
    @endforeach
</div>
<div class="product-slider-thumb">
    @foreach($imagesArray as $key => $file)
        <a href="/{{$file}}" class="product-image @if($key == 0) current slick-active @endif" >
            <img src="/{{$file}}" alt="{{$product->title}}">
        </a>
    @endforeach
</div>
