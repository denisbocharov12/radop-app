@if($product->hasMedia('products'))
    <div class="wrap-image-with-gallery wrap-product-card-gallery-v2">
        @if(app('wishlist')->get($product->id) !== null)
            <a href="javascript:void(0);" 
               id="add_to_wishlist-{{$product->id}}" 
               data-id="{{$product->id}}" 
               data-qty="1" 
               class="add_to_wishlist delete-from-wishlist-btn wishlist-v2-btn" 
               tabindex="0">
                <i class="fa fa-heart" style="color: red"></i>
            </a>
        @else
            <a href="javascript:void(0);" 
               id="add_to_wishlist-{{$product->id}}" 
               data-id="{{$product->id}}" 
               data-qty="1" 
               class="add_to_wishlist add-to-wishlist-btn wishlist-v2-btn">
                <i class="icon-heart"></i>
            </a>
        @endif
        <div class="gallery-v2-container">
            <div class="product-slider-thumb-v2">
                @foreach($product->getMedia('products') as $key => $file)
                    <a href="javascript:void(0);" class="product-image-thumb @if($key == 0) active @endif" data-slide-index="{{$key}}">
                        <img src="{{$file->getUrl()}}" alt="{{$product->title}}">
                    </a>
                @endforeach
            </div>
            <div class="product-slider-main-v2">
                @foreach($product->getMedia('products') as $key => $file)
                    <a href="{{$file->getUrl()}}" class="product-image @if($key == 0) active @endif" data-slide="{{$key}}" data-fancybox="gallery">
                        <img src="{{$file->getUrl()}}" alt="{{$product->title}}">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@else
    @php
        $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id);
    @endphp
    <div class="wrap-image-with-gallery wrap-product-card-gallery-v2">
        @if(app('wishlist')->get($product->id) !== null)
            <a href="javascript:void(0);" 
               id="add_to_wishlist-{{$product->id}}" 
               data-id="{{$product->id}}" 
               data-qty="1" 
               class="add_to_wishlist delete-from-wishlist-btn wishlist-v2-btn" 
               tabindex="0">
                <i class="fa fa-heart" style="color: red"></i>
            </a>
        @else
            <a href="javascript:void(0);" 
               id="add_to_wishlist-{{$product->id}}" 
               data-id="{{$product->id}}" 
               data-qty="1" 
               class="add_to_wishlist add-to-wishlist-btn wishlist-v2-btn">
                <i class="icon-heart"></i>
            </a>
        @endif
        <div class="gallery-v2-container">
            <div class="product-slider-thumb-v2">
                @foreach($imagesArray as $key => $file)
                    <a href="javascript:void(0);" class="product-image-thumb @if($key == 0) active @endif" data-slide-index="{{$key}}">
                        <img src="/{{$file}}" alt="{{$product->title}}">
                    </a>
                @endforeach
            </div>
            <div class="product-slider-main-v2">
                @foreach($imagesArray as $key => $file)
                    <a href="/{{$file}}" class="product-image @if($key == 0) active @endif" data-slide="{{$key}}" data-fancybox="gallery">
                        <img src="/{{$file}}" alt="{{$product->title}}">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif


