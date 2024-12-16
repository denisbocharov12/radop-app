@if(app('wishlist')->getContent()->count() < 1)
    @include('frontend.v1.pages.wishlist.parts.not-found')
@endif
@foreach(app('wishlist')->getContent()->sort() as $product)
    @php
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        $item = \Cart::session($sessionId)->get($product->id);
    @endphp
    <div class="col-lg-3 col-md-4 col-6 product-item-category drop-shadow @if($item !== null) product-item-category-in-cart @endif" id="item-wishlist-{{$product->conditions->id}}" data-id="{{$product->id}}">
        <div class="product-wrap">
            @include('frontend.v1.pages.product.components.label')
            <div class="product-wrap-main">
                @if($product->conditions->sale_price !== '')
                    <a href="{{route('theme.product.index', $product->conditions->slug)}}" class="product-label">
                        <div class="product-label-wrap">
                            <span class="product-label-span">- {{round((((float)$product->conditions->price - (float)$product->conditions->sale_price) / $product->conditions->price) * 100)}}%</span>
                        </div>
                    </a>
                @endif
                @include('frontend.v1.pages.wishlist.parts.product-image')
                    @if(app('wishlist')->get($product->conditions->id) !== null)
                        <a href="javascript:void(0);" id="add_to_wishlist-{{$product->conditions->id}}" data-id="{{$product->conditions->id}}" data-qty="1"  class="add_to_wishlist delete-from-wishlist-btn" tabindex="0"><i class="fa fa-heart" style="color: red"></i>
                        </a>
                    @else
                        <a href="javascript:void(0);" id="add_to_wishlist-{{$product->conditions->id}}" data-id="{{$product->conditions->id}}" data-qty="1" class="add_to_wishlist add-to-wishlist-btn">
                            <i class="fa fa-heart"></i>
                        </a>
                    @endif
                <div class="product-item-title-wrap">
                    <h3 class="product_item_name">
                        <a href="{{route('theme.product.index', $product->conditions->slug)}}">{{$product->conditions->title}}</a>
                    </h3>
                </div>
                <div class="product-item-article-wrap">
                    <h3 class="product_item_article">{{__('theme.code')}}: {{$product->conditions->onec_id}}</h3>
                    <div class="details-wrap">
                    <span class="stock {{$product->conditions->stock > 0 ? 'in-stock' : 'out-of-stock'}}">
                        @if($product->conditions->stock > 0)
                            {{__('theme.in-stock')}}
                        @else
                            {{__('theme.out-of-stock')}}
                        @endif
                    </span>
                    </div>
                </div>
            </div>
            <div class="add_to_cart_wrap">
                <hr class="product-card-item">
                <div class="wrap">
                    @if($product->conditions->sale_price !== '')
                        <span class="price">{{ number_format($product->conditions->sale_price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                        <span class="old_price">{{ number_format($product->conditions->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                    @else
                        <span class="price">{{ number_format($product->conditions->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                    @endif
                </div>
                <div class="product-card-summary">
                    <p><span class="summary-title">{{__('theme.total')}}</span>
                        <span class="product-card-summary-text" id="product-card-summary-{{$product->conditions->onec_id}}">
                            @if($product->conditions->sale_price !== '')
                                {{ number_format($product->conditions->sale_price, 2, ',', '') }}
                            @else
                                {{ number_format($product->conditions->price, 2, ',', '') }}
                            @endif
                        </span> {{__('theme.MDL')}}
                    </p>
                </div>
                @include('frontend.v1.components.add_to_cart_widget_v2')            </div>
            @if(!$product->conditions->packages->isEmpty())
                <div class="packages-wrap">
                    <p>{{__('theme.package')}}: @foreach($product->conditions->packages->sortBy('value') as $package){{$package->value}}{{$loop->last ? '' : '/'}}@endforeach</p>
                </div>
            @endif
        </div>
        @include('frontend.v1.components.in_cart_widget')
    </div>
@endforeach

@section('scripts')
    <script>
        $('.delete-from-wishlist-btn').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            $('#item-wishlist-'+productId).fadeOut();
        })
    </script>
@endsection
