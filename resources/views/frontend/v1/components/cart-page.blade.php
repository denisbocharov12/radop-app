@php
    $sessionId = config('shopping_cart.default_session_id');

    if (auth()->guard('user')->user()) {
        $sessionId = auth()->guard('user')->user()->id;
    }
@endphp

<div class="col-lg-9 col-cart-contents">
    <div class="cart-items-wrap">
        @foreach(\Cart::session($sessionId)->getContent() as $item)
            @php
                $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($item->associatedModel->onec_id);
            @endphp
            <div class="cart-item drop-shadow">
                <div class="cart-item-wrap">
                    <div class="cart-product">
                        <a href="{{route('theme.product.index',$item->model->slug)}}" class="d-flex">
                            @foreach($imagesArray as $key => $file)
                                @switch($key)
                                    @case(0)
                                    <img src="/{{$file}}" alt="{{$item->associatedModel->title}}" class="sc-image" />
                                    @break
                                @endswitch
                            @endforeach
                        </a>
                        <h5 class="item-title">
                            {{$item->associatedModel->title}}
                        </h5>
                    </div>
                    <div class="cart-item-info">
                        <div class="sc-product-qty qty-block">
                            <div class="input-group-btn">
                                <button
                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                    class="sc-product-decrement btn-quantity-cart minus"
                                    type="button"
                                    id="button-minus"
                                >
                                    -
                                </button>
                            </div>
                            <input
                                data-id="{{$item->id}}"
                                id="qty-item-cart-{{$item->id}}"
                                type="number"
                                min="1"
                                placeholder="1"
                                value="{{$item->quantity}}"
                                class="sc-qty"
                            />
                            <input type="hidden" data-id="{{$item->id}}" data-product-stock="{{$item->associatedModel->stock}}" id="update-cart-page-{{$item->id}}">
                            <div class="input-group-btn">
                                <button
                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                    class="sc-product-increment btn-quantity-cart plus"
                                    type="button"
                                    id="button-plus"
                                >
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="price-wrap">
                            @if($item->associatedModel->sale_price !== '')
                                <span class="price">{{$item->associatedModel->sale_price}} {{__('theme.MDL')}}</span>
                                <span class="old_price">{{$item->associatedModel->price}} {{__('theme.MDL')}}</span>
                            @else
                                <span class="price">{{$item->associatedModel->price}} {{__('theme.MDL')}}</span>
                            @endif
                            <span class="total-price" style="margin-left: 5px; font-weight: bold; font-style: italic">( {{$item->quantity * $item->price}} {{__('theme.MDL')}} )</span>
                        </div>
                    </div>
                    <div class="delete-cart-item">
                        <a href="javascript:void(0)" data-id="{{$item->id}}" class="item-delete remove-cart-btn"><i class="icon-trash-radop"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="col-lg-3 col-cart-total">
    <div class="shopping-cart-total-wrap">
        <div class="shopping-cart-bonus-code-info" style="background-color: #0293b2; padding: 12.5px; margin-bottom: 15px; border-radius: 15px">
            <p class="info-text" style="color: #e2e8f0; text-align: center; font-size: 14px">{{__('theme.coupon-text')}}</p>
        </div>
        <div class="shopping-cart-bonus-code-wrap">
            <form action="{{route('theme.cart.coupon')}}" id="coupon-form" method="POST" class="cs-form">
                @csrf
                <div class="form-control-sc">
                    <input
                        type="text"
                        class="cart-input"
                        placeholder="{{__('theme.discount-code')}}"
                        name="code"
                    />
                    <button type="submit" class="cart-btn-code">{{__('theme.apply')}}</button>
                </div>
            </form>
        </div>
        <div class="shopping-cart-total">
            <div class="total-heading">
                <h3>{{__('theme.invoice-payable')}}</h3>
            </div>
            @if(session()->has('coupon'))
                <div class="sc-details-wrap">
                    <ul class="details-ul">
                        <li class="item">
                            <span class="left">{{__('theme.quantity-shortly')}} </span><span class="right">{{\Cart::session($sessionId)->getContent()->count()}} ед.</span>
                        </li>
                        <li class="item">
                            <span class="left">{{__('theme.summary')}} </span><span class="right">{{\Cart::session($sessionId)->getTotal()}} {{__('theme.MDL')}}</span>
                        </li>
                        <li class="item">
                            <span class="left">{{__('theme.discount')}} </span><span class="right">- {{number_format(session('coupon')['value'],2)}} {{__('theme.MDL')}}</span>
                        </li>
                    </ul>
                </div>
                <div class="total-wrap">
                    <p class="total-text">{{__('theme.for-payment')}}</p>
                    <span>{{number_format((float)str_replace(',','', \Cart::session($sessionId)->getTotal()) - session('coupon')['value'],2)}} {{__('theme.MDL')}}</span>
                </div>
            @else
                <div class="sc-details-wrap">
                    <ul class="details-ul">
                        <li class="item">
                            <span class="left">{{__('theme.quantity-shortly')}} </span><span class="right">{{\Cart::session($sessionId)->getContent()->count()}} ед.</span>
                        </li>
                        <li class="item">
                            <span class="left">{{__('theme.summary')}} </span><span class="right">{{\Cart::session($sessionId)->getTotal()}} {{__('theme.MDL')}}</span>
                        </li>
                        <li class="item">
                            <span class="left">{{__('theme.discount')}} </span><span class="right">0.00 {{__('theme.MDL')}}</span>
                        </li>
                    </ul>
                </div>
                <div class="total-wrap">
                    <p class="total-text">{{__('theme.for-payment')}}</p>
                    <span>{{\Cart::session($sessionId)->getTotal()}} {{__('theme.MDL')}}</span>
                </div>
            @endif
            <div class="sc-buttons-wrap">
                <a href="{{route('theme.checkout.index')}}" class="sc-btn-checkout sc-btn">{{__('theme.place-order')}}</a>
                <a href="{{route('theme.shop.index')}}" class="sc-btn-continuie sc-btn">{{__('theme.сontinue-shopping')}}</a>
            </div>
        </div>
    </div>
</div>
