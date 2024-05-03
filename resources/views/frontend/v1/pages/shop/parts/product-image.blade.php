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
    $dir = __DIR__ . config('media-files.DIR_PATH');
    $files = glob($dir . "image*");
    $fileNames = [];

    foreach ($files as $key=>$file) {
        $fileNames[] = str_replace($dir, '', $file);
    }

@endphp
<a href="{{route('theme.product.index', $product->slug)}}" class="wrap-image">
    @if(count($fileNames) > 2)
        @foreach($fileNames as $key => $file)
            @switch($key)
                @case(0)
                <img class="primary-image" src="{{'/media/'.$file}}" alt="{{$file}}" />
                @break
                @case(1)
                <img class="secondary-image" src="{{'/media/'.$file}}" alt="{{$file}}" />
                @break
            @endswitch
        @endforeach
    @else
        <img class="primary-image" src="{{$files[0]}}" alt="" />
    @endif


</a>
