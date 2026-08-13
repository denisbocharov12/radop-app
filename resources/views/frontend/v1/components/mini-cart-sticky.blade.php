@php
    $sessionId = config('shopping_cart.default_session_id');

    if (auth()->guard('user')->user()) {
        $sessionId = auth()->guard('user')->user()->id;
    }

    $cartAuthUser = auth()->guard('user')->user();
    $cartMinSum = $cartAuthUser ? $cartAuthUser->minOrderSum() : (float) config('app.min_delivery_sum');
    $cartIsSupplement = $cartAuthUser ? $cartAuthUser->isSupplementWindowOpen() : false;
    $cartBelowMin = !$cartIsSupplement && \Cart::session($sessionId)->getTotal() < $cartMinSum;
@endphp
@if(\Cart::session($sessionId)->getContent()->count() > 0)
        <ul class="content-shopping-cart">
            @foreach(\Cart::session($sessionId)->getContent()->sortBy("attributes.added_at")  as $item)
                <li class="item">
                    <div class="sc-product-item">
                        <div class="product-info">
                            <a href="{{route('theme.product.index', $item->associatedModel->slug)}}" >
                                @if($item->associatedModel->hasMedia('products'))
                                    <img src="{{$item->associatedModel->getFirstMediaUrl('products')}}" alt="{{$item->associatedModel->title}}" class="sc-image" />
                                @else
                                    @php
                                        $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($item->associatedModel->onec_id);
                                    @endphp
                                    @foreach($imagesArray as $key => $file)
                                        @switch($key)
                                            @case(0)
                                                <img src="/{{$file}}" alt="{{$item->associatedModel->title}}" class="sc-image" />
                                                @break
                                        @endswitch
                                    @endforeach
                                @endif
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
                                        >
                                            -
                                        </button>
                                    </div>
                                    <input
                                        data-id="{{$item->id}}"
                                        id="qty-item-sticky-{{$item->id}}"
                                        type="number"
                                        min="{{$item->associatedModel->min_order ?? 1}}"
                                        max="{{$item->associatedModel->stock}}"
                                        placeholder="{{$item->associatedModel->min_order ?? 1}}"
                                        value="{{$item->quantity}}"
                                        step="{{$item->associatedModel->min_order ?? 1}}"
                                        class="sc-qty"
                                        oninput="if (this.value !== '' && this.max !== '' && Number(this.value) > Number(this.max)) { this.value = this.max; }"
                                        onblur="if (this.value === '') { this.value = this.min; } this.dispatchEvent(new Event('change', { bubbles: true }));"
                                    />
                                    <input type="hidden" data-id="{{$item->id}}" data-product-stock="{{$item->associatedModel->stock}}" id="update-cart-sticky-{{$item->id}}">
                                    <div class="input-group-btn">
                                        <button
                                            onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                            class="sc-product-increment btn-quantity plus"
                                            type="button"
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
        <p class="min-order-sum-warning-text {{ $cartBelowMin ? 'show' : '' }}">
            {{__('theme.min_order_sum_warning_message')}} <span class="sum">{{ $cartMinSum }}</span> {{__('theme.MDL')}}
        </p>
        <div class="heading-shopping-cart mb-2 mt-2">
            <span class="sc-subtotal">
                {{__('theme.subtotal')}} {{\Cart::session($sessionId)->getContent()->count()}} {{mb_strtolower(__('theme.mini_cart_unit_in_cart'))}} {{__('theme.for-amount')}} {{number_format(\Cart::session($sessionId)->getTotal(), 2, ',', '')}} {{__('theme.MDL')}}
            </span>
        </div>
    @else
        <p class="text-center">
            {{__('theme.empty-cart')}}
        </p>
    @endif
<div class="bottom-shopping-cart">
    <a href="{{route('theme.shop.catalog')}}" class="btn-shopping-cart ">{{__('theme.сontinue-shopping')}}</a>
    <a href="{{route('theme.cart.index')}}" class="btn-shopping-cart red {{ $cartBelowMin ? 'hide-important' : '' }}">{{__('theme.place-order')}}</a>
</div>
