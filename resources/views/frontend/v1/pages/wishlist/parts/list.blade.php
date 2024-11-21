@if(app('wishlist')->getContent()->count() < 1)
    @include('frontend.v1.pages.wishlist.parts.not-found')
@endif
@foreach(app('wishlist')->getContent()->sort() as $product)
    <div class="col-lg-3 col-md-4 col-6 product-item-category" id="item-wishlist-{{$product->conditions->id}}">
        <div class="product-wrap drop-shadow">
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
                </div>
            </div>
            <div class="add_to_cart_wrap">
                <div class="wrap">
                    @if($product->conditions->sale_price !== '')
                        <span class="price">{{$product->conditions->sale_price}} {{__('theme.MDL')}}</span>
                        <span class="old_price">{{$product->conditions->price}} {{__('theme.MDL')}}</span>
                    @else
                        <span class="price">{{$product->conditions->price}} {{__('theme.MDL')}}</span>
                    @endif
                </div>
                <div class="details-wrap">
                    <span class="stock {{$product->conditions->stock > 0 ? 'in-stock' : 'out-of-stock'}}">
                        @if($product->conditions->stock > 0)
                            В наличии
                        @else
                            Нет в наличии
                        @endif
                    </span>
                </div>
                <div class="product-card-summary">
                    <p><span class="summary-title">{{__('theme.total')}}</span>
                        <span class="product-card-summary-text" id="product-card-summary-{{$product->conditions->onec_id}}">
                            @if($product->conditions->sale_price !== '')
                                {{$product->conditions->sale_price}}
                            @else
                                {{$product->conditions->price}}
                            @endif
                        </span> {{__('theme.MDL')}}
                    </p>
                </div>
                <div class="product-card-summary-cart mt-2">
                    <p>
                        <span class="summary-title">{{__('theme.in-cart')}}</span>
                        <span class="product-card-summary-cart-title" >
                            @php
                                $sessionId = config('shopping_cart.default_session_id');

                                if (auth()->guard('user')->user()) {
                                    $sessionId = auth()->guard('user')->user()->id;
                                }

                                $item = \Cart::session($sessionId)->get($product->conditions->id);
                            @endphp
                            {{$item?->quantity ?? 0}}
                        </span> {{__('theme.unit')}}
                    </p>
                </div>
                <div class="qty-add-to-cart">
                    <div class="sc-product-qty qty-block">
                        <div class="input-group-btn">
                            <button
                                onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                class="sc-product-decrement btn-quantity-product minus"
                                type="button"
                                id="button-minus"
                            >
                                -
                            </button>
                        </div>
                        <input
                            id="product-{{$product->conditions->id}}-qty"
                            type="number"
                            min="1"
                            max="{{$product->conditions->stock}}"
                            placeholder="1"
                            value="1"
                            name="product-{{$product->conditions->id}}-qty"
                            data-product-id="{{$product->conditions->onec_id}}"
                            data-price="@if($product->conditions->sale_price !== ''){{$product->conditions->sale_price}}@else{{$product->conditions->price}}@endif"
                            class="product-qty-item"
                        />
                        <div class="input-group-btn">
                            <button
                                onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                class="sc-product-increment btn-quantity-product plus"
                                type="button"
                                id="button-plus"
                            >
                                +
                            </button>
                        </div>
                    </div>
                    <a href="#" data-id="{{$product->conditions->id}}" id="add-to-cart-{{$product->conditions->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                </div>
            </div>
        </div>
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
