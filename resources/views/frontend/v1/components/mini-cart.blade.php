@php
    $sessionId = config('shopping_cart.default_session_id');

    if (auth()->guard('user')->user()) {
        $sessionId = auth()->guard('user')->user()->id;
    }
@endphp
@if(\Cart::session($sessionId)->getContent()->count() > 0)
        <ul class="content-shopping-cart">
            @foreach(\Cart::session($sessionId)->getContent()->sort()  as $item)
                @php
                    $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($item->associatedModel->onec_id);
                @endphp
                <li class="item">
                    <div class="sc-product-item">
                        <div class="product-info">
                            <a href="{{route('theme.product.index', $item->associatedModel->slug)}}" >
                                @foreach($imagesArray as $key => $file)
                                    @switch($key)
                                        @case(0)
                                        <img src="/{{$file}}" alt="{{$item->associatedModel->title}}" class="sc-image" />
                                        @break
                                    @endswitch
                                @endforeach
                            </a>
                            <div class="sc-item-info-wrap">
                                <p class="sc-title">
                                    {{Str::words($item->associatedModel->title, 6)}}
                                </p>
                                <div class="sc-product-qty">
                                    <div class="input-group-btn">
                                        <button
                                            onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                            class="sc-product-decrement btn-quantity minus"
                                            type="button"
                                            id="button-minus"
                                        >
                                            -
                                        </button>
                                    </div>
                                    <input
                                        data-id="{{$item->id}}"
                                        id="qty-item-{{$item->id}}"
                                        type="number"
                                        min="1"
                                        placeholder="1"
                                        value="{{$item->quantity}}"
                                        class="sc-qty"
                                    />
                                    <input type="hidden" data-id="{{$item->id}}" data-product-stock="{{$item->associatedModel->stock}}" id="update-cart-{{$item->id}}">
                                    <div class="input-group-btn">
                                        <button
                                            onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                            class="sc-product-increment btn-quantity plus"
                                            type="button"
                                            id="button-plus"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="sc-price">{{number_format($item->price * $item->quantity, 2, ',', '')}} {{__('theme.MDL')}}</span>
                        <div data-id="{{$item->id}}" class="item-delete remove-cart-btn"><i class="icon-trash-radop"></i></div>
                    </div>
                </li>
            @endforeach
        </ul>
        <p class="min-order-sum-warning-text {{\Cart::session($sessionId)->getTotal() < config('app.min_delivery_sum') ? 'show' : ''}}">
            {{__('theme.min_order_sum_warning_message')}} <span class="sum">{{config('app.min_delivery_sum')}}</span> {{__('theme.MDL')}}
        </p>
        <div class="heading-shopping-cart mb-2 mt-2">
            <span class="sc-subtotal">
                {{__('theme.subtotal')}} {{__('theme.subtotal')}} {{morphos\Russian\pluralize(\Cart::session($sessionId)->getTotalQuantity(), __('theme.add_to_cart_product_item'))}} {{__('theme.for-amount')}} {{number_format(\Cart::session($sessionId)->getTotal(), 2, ',', '')}} {{__('theme.MDL')}}
            </span>
        </div>
    @else
        <p class="text-center">
            {{__('theme.empty-cart')}}
        </p>
    @endif
<div class="bottom-shopping-cart">
    <a href="{{route('theme.shop.index')}}" class="btn-shopping-cart ">{{__('theme.сontinue-shopping')}}</a>
    <a href="{{route('theme.cart.index')}}" class="btn-shopping-cart red {{\Cart::session($sessionId)->getTotal() < config('app.min_delivery_sum') ? 'hide-important' : '' }}">{{__('theme.place-order')}}</a>
</div>
