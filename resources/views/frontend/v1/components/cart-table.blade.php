@php
    $sessionId = config('shopping_cart.default_session_id');

    if (auth()->guard('user')->user()) {
        $sessionId = auth()->guard('user')->user()->id;
    }

    $cartAuthUser = auth()->guard('user')->user();
    // Minimum for the authenticated user is the selected city's required_sum;
    // guests fall back to the global minimum.
    $cartMinSum = $cartAuthUser ? $cartAuthUser->minOrderSum() : (float) config('app.min_delivery_sum');
    $cartIsSupplement = $cartAuthUser ? $cartAuthUser->isSupplementWindowOpen() : false;
    $cartTotal = \Cart::session($sessionId)->getTotal();
    $cartBelowMin = !$cartIsSupplement && $cartTotal < $cartMinSum;
    $cartRemaining = max($cartMinSum - $cartTotal, 0);
@endphp
<style>
    .min-order-banner{display:flex;align-items:center;gap:12px;background:#FCE9D4;border:1px solid #F4C88A;border-radius:12px;padding:14px 18px;margin-bottom:20px;color:#8A5518;font-size:15px;line-height:1.45;}
    .min-order-banner-icon{flex:0 0 24px;width:24px;height:24px;border-radius:50%;background:#F5A623;color:#fff;font-weight:700;display:flex;align-items:center;justify-content:center;font-size:15px;}
    .min-order-banner-text b{color:#7A4A12;font-weight:700;}
    .min-order-banner-add{margin-left:4px;white-space:nowrap;}
    .min-order-banner-link{display:inline-flex;align-items:center;gap:4px;margin-left:8px;color:#8A5518;text-decoration:underline;font-size:13px;opacity:.85;}
    .min-order-banner-link:hover{opacity:1;color:#7A4A12;}
    .min-order-banner-ico{width:1em;height:1em;flex:0 0 auto;}
</style>
@if($cartBelowMin)
    <div class="col-12 col-cart-min-banner">
        <div class="min-order-banner" role="alert">
            <span class="min-order-banner-icon">!</span>
            <span class="min-order-banner-text">
                {{ __('theme.min_order_sum_warning_message') }} <b>{{ number_format($cartMinSum, 2, '.', '') }} {{ __('theme.MDL') }}</b>.
                <b class="min-order-banner-add">{{ __('theme.min_order_add_more') }} {{ number_format($cartRemaining, 2, '.', '') }} {{ __('theme.MDL') }}</b>
                <a href="{{ route('theme.delivery.index') }}" class="min-order-banner-link"><svg class="min-order-banner-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>{{ __('theme.min_order_delivery_link') }}</a>
            </span>
        </div>
    </div>
@endif
<div class="col-lg-9 col-cart-contents">
    <div class="table-responsive">
        <table class="theme-cart-table">
            <thead class="theme-cart-table-thead">
                <tr>
                    <th class="text-center">№</th>
                    <th></th>
                    <th class="d-none d-md-table-cell">{{__('theme.cart-table-name')}}</th>
                    <th class="text-center"><div class="d-block d-md-none">{{__('theme.cart-table-name')}}/</div>{{__('theme.cart-table-quantity')}}</th>
                    <th class="text-center">{{__('theme.cart-table-price')}}</th>
                    <th class="text-center">{{__('theme.cart-table-sum')}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @foreach(\Cart::session($sessionId)->getContent()->sortBy("attributes.added_at") as $item)
                <tr class="theme-cart-item-row">
                    <td class="text-center col-theme-cart-count">{{ $count++ }}</td>
                    <td class="theme-cart-item-img">
                        <a href="{{route('theme.product.index',$item->model->slug)}}">
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
                    </td>
                    <td class="theme-cart-item-row-title d-none d-md-table-cell">
                        <a href="{{route('theme.product.index',$item->model->slug)}}" class="d-flex">
                            <h5 class="item-title">
                                {{$item->associatedModel->title}}
                            </h5>
                        </a>
                    </td>
                    <td class="text-center theme-cart-item-qty">
                        <div class="d-md-none cart-item-mobile-header">
                            <a href="{{route('theme.product.index',$item->model->slug)}}" class="d-flex">
                                <h5 class="item-title">{{$item->associatedModel->title}}</h5>
                            </a>
                        </div>
                        <div class="d-flex aling-items-center justify-content-center number-spinner-box">
                            <div class="cart-item-info">
                                <div class="sc-product-qty qty-block">
                                    <div class="input-group-btn">
                                        <button
                                            onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                            class="sc-product-decrement btn-quantity-cart minus"
                                            type="button"
                                        >
                                            -
                                        </button>
                                    </div>
                                    <input
                                        data-id="{{$item->id}}"
                                        id="qty-item-cart-{{$item->id}}"
                                        type="number"
                                        min="{{$item->associatedModel->min_order ?? 1}}"
                                        max="{{$item->associatedModel->stock}}"
                                        placeholder="{{$item->associatedModel->min_order ?? 1}}"
                                        value="{{$item->quantity}}"
                                        step="{{$item->associatedModel->min_order ?? 1}}"
                                        class="sc-qty"
                                    />
                                    <input type="hidden" data-id="{{$item->id}}" data-product-stock="{{$item->associatedModel->stock}}" id="update-cart-page-{{$item->id}}">
                                    <div class="input-group-btn">
                                        <button
                                            onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                            class="sc-product-increment btn-quantity-cart plus"
                                            type="button"
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
                                @include('frontend.v1.components.product_price', ['product' => $item->associatedModel])
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
    </div>
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
                        <span class="left">{{__('theme.quantity-shortly')}} </span><span class="right">{{\Cart::session($sessionId)->getContent()->count()}} {{ __('theme.cart-quantity') }}</span>
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
                @if($cartAuthUser)
                    <a href="{{route('theme.checkout.index')}}" class="sc-btn-checkout sc-btn {{ $cartBelowMin ? 'hide-important' : '' }}">{{__('theme.place-order')}}</a>
                @else
                    <a href="javascript:;" class="sc-btn-checkout sc-btn cart-auth-modal-btn {{ $cartBelowMin ? 'hide-important' : '' }}">{{__('theme.place-order')}}</a>
                @endif
                <a href="{{route('theme.shop.catalog')}}" class="sc-btn-continuie sc-btn">{{__('theme.сontinue-shopping')}}</a>
            </div>
        </div>
    </div>
</div>
@include('frontend.v1.components.cart_auth_modal')
