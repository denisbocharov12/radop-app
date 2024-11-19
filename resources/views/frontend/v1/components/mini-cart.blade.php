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
                        <span class="sc-price">{{number_format($item->price * $item->quantity, 2)}} {{__('theme.MDL')}}</span>
                        <div data-id="{{$item->id}}" class="item-delete remove-cart-btn"><i class="icon-trash-radop"></i></div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="heading-shopping-cart mb-3 mt-3">
            <span class="sc-subtotal">{{__('theme.for-payment')}} <span class="fw-600">{{round(\Cart::session($sessionId)->getTotal(), 2)}} {{__('theme.MDL')}}</span></span>
            <span class="sc-count">{{\Cart::session($sessionId)->getContent()->count()}} {{__('theme.unit')}}</span>
        </div>
    @else
        <p class="text-center">
            {{__('theme.empty-cart')}}
        </p>
    @endif
