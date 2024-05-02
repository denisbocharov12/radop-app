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

<div class="product-slider-main">
    <a href="https://placehold.co/600x900?text=Demo 1" class="product-image" data-fancybox="gallery">
        <img src="https://placehold.co/600x900?text=Demo 1" alt="Demo 1">
    </a>
    <a href="https://placehold.co/600x900?text=Demo 2" class="product-image" data-fancybox="gallery">
        <img src="https://placehold.co/600x900?text=Demo 2" alt="Demo 2">
    </a>
    <a href="https://placehold.co/600x900?text=Demo 3" class="product-image" data-fancybox="gallery">
        <img src="https://placehold.co/600x900?text=Demo 3" alt="Demo 3">
    </a>
</div>
<div class="product-slider-thumb">
    <div class="product-image slick-current slick-active">
        <img src="https://placehold.co/600x900?text=Demo" alt="Demo">
    </div>
    <div class="product-image">
        <img src="https://placehold.co/600x900?text=Demo" alt="Demo">
    </div>
    <div class="product-image">
        <img src="https://placehold.co/600x900?text=Demo" alt="Demo">
    </div>
</div>
