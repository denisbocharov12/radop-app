@php
    $sessionId = config('shopping_cart.default_session_id');

    if (auth()->guard('user')->user()) {
        $sessionId = auth()->guard('user')->user()->id;
    }
@endphp

<div class="col-lg-9 col-cart-contents">
    <table class="theme-cart-table">
        <thead class="theme-cart-table-thead">
            <tr>
                <th></th>
                <th>{{__('theme.cart-table-name')}}</th>
                <th class="text-center">{{__('theme.cart-table-quantity')}}</th>
                <th class="text-center">{{__('theme.cart-table-price')}}</th>
                <th class="text-center">{{__('theme.cart-table-sum')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach(\Cart::session($sessionId)->getContent()->sort() as $item)
            @php
                $imagesArray = \App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($item->associatedModel->onec_id);
            @endphp
            <tr class="theme-cart-item-row">
                <td class="theme-cart-item-img">
                    <a href="{{route('theme.product.index',$item->model->slug)}}">
                        @foreach($imagesArray as $key => $file)
                            @switch($key)
                                @case(0)
                                <img src="/{{$file}}" alt="{{$item->associatedModel->title}}" class="sc-image" />
                                @break
                            @endswitch
                        @endforeach
                    </a>
                </td>
                <td class="theme-cart-item-row-title">
                    <a href="{{route('theme.product.index',$item->model->slug)}}" class="d-flex">
                        <h5 class="item-title">
                            {{$item->associatedModel->title}}
                        </h5>
                    </a>
                </td>
                <td class="text-center theme-cart-item-qty">
                    <div class="d-flex aling-items-center justify-content-center number-spinner-box">
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
                        </div>
                    </div>
                </td>
                <td class="text-center theme-cart-item-price">
                    <div class="theme-cart-title-price-wrap">
                        <div class="price-wrap">
                            @if(Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0 && $item->associatedModel->sale_price === '')
                                <span class="price">{{number_format((float)$item->associatedModel->price * (float)$item->associatedModel->price_koef - (float)$item->associatedModel->price * (float)$item->associatedModel->price_koef * (Auth::guard('user')->user()->sale / 100), 2, ',', '')}} {{__('theme.MDL')}}</span>
                            @elseif($item->associatedModel->sale_price !== '' || Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0)
                                <span class="price" style="color: #ee0000">{{ number_format($item->associatedModel->sale_price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                <span class="old_price" style="color: #848484">{{ number_format($item->associatedModel->price * (float)$item->associatedModel->price_koef, 2, ',', '') }} {{__('theme.MDL')}}</span>
                            @else
                                <span class="price">{{ number_format($item->associatedModel->price * (float)$item->associatedModel->price_koef, 2, ',', '') }} {{__('theme.MDL')}}</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="text-center theme-cart-item-total">
                    <div class="theme-cart-title-price-wrap">
                        <div class="price-wrap">
                            <span class="total-price">{{number_format($item->quantity * $item->price, 2, ',', '')}} {{__('theme.MDL')}}</span>
                        </div>
                    </div>
                </td>
                <td class="theme-cart-item-delete">
                    <a href="javascript:void(0)" data-id="{{$item->id}}" class="item-delete remove-cart-btn"><i class="icon-trash-radop"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row">
        <div class="col-12 col-cart-destroy">
            <div class="wrap">
                <a href="{{route('theme.cart.destroy')}}" class="btn-cart-destroy">{{__('theme.cart-destroy')}}</a>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-cart-total">
{{--    <div class="shopping-cart-total-discount-grade-wrap">--}}
{{--        <a data-fancybox class="btn-sales-period"--}}
{{--           data-src="#salesPeriodModal"--}}
{{--           href="javascript:;">{{__('theme.discount_period_link')}}</a>--}}
{{--    </div>--}}
    <div class="shopping-cart-total-wrap">
        <div class="shopping-cart-total">
            <div class="total-heading">
                <h3>{{__('theme.invoice-payable')}}</h3>
            </div>
            <div class="sc-details-wrap">
                <ul class="details-ul">
                    <li class="item">
                        <span class="left">{{__('theme.quantity-shortly')}} </span><span class="right">{{\Cart::session($sessionId)->getContent()->count()}} ед.</span>
                    </li>
                    <li class="item">
                        <span class="left">{{__('theme.summary')}} </span><span class="right">{{number_format(\Cart::session($sessionId)->getTotal(), 2, ',', '')}} {{__('theme.MDL')}}</span>
                    </li>

                </ul>
            </div>
            <div class="total-wrap">
                <p class="total-text">{{__('theme.for-payment')}}</p>
{{--                @if($foundedDiscountPeriod !== null)--}}
{{--                    <span>{{number_format(\Cart::session($sessionId)->getTotal() - \Cart::session($sessionId)->getTotal() * $foundedDiscountPeriod->discount_koef / 100, 2, ',', '')}} {{__('theme.MDL')}}</span>--}}
{{--                @else--}}
{{--                    <span>{{number_format(\Cart::session($sessionId)->getTotal(), 2, ',', '')}} {{__('theme.MDL')}}</span>--}}
{{--                @endif--}}
                <span>{{number_format(\Cart::session($sessionId)->getTotal(), 2, ',', '')}} {{__('theme.MDL')}}</span>
            </div>
            <div class="sc-buttons-wrap">
                <a href="{{route('theme.checkout.index')}}" class="sc-btn-checkout sc-btn">{{__('theme.place-order')}}</a>
                <a href="{{route('theme.shop.index')}}" class="sc-btn-continuie sc-btn">{{__('theme.сontinue-shopping')}}</a>
            </div>
        </div>
    </div>
</div>
