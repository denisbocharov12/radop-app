@php
    $minOrderPriceMultiplier = \App\Services\Theme\Product\ThemeProductManager::getMinOrderDisplayMultiplier($product);
    $unitEffective = (float) \App\Services\Theme\Product\ThemeProductManager::getProductTotalSum($product);
@endphp
@if(Auth::guard('user')->user() !== null && Auth::guard('user')->user()->with_sale)
    @if(Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0 && $product->sale_price === '')
        <span class="price">{{ number_format($unitEffective * $minOrderPriceMultiplier, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @elseif($product->sale_price !== '' || Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0)
        <span class="price sale-product-price" style="color: #ee0000">{{ number_format($unitEffective * $minOrderPriceMultiplier, 2, ',', '') }} {{__('theme.MDL')}}</span>
        <span class="old_price sale-product-old-price" style="color: #848484">{{ number_format(round((float) $product->price, 2) * $minOrderPriceMultiplier, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @else
        <span class="price">{{ number_format($unitEffective * $minOrderPriceMultiplier, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @endif
@else
    @if(Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0 && $product->sale_price === '')
        <span class="price">{{ number_format($unitEffective * $minOrderPriceMultiplier, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @elseif($product->sale_price !== '' || Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0)
        <span class="price sale-product-price" style="color: #ee0000">{{ number_format($unitEffective * $minOrderPriceMultiplier, 2, ',', '') }} {{__('theme.MDL')}}</span>
        <span class="old_price sale-product-old-price" style="color: #848484">{{ number_format(round((float) $product->price * (float) $product->price_koef, 2) * $minOrderPriceMultiplier, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @else
        <span class="price">{{ number_format($unitEffective * $minOrderPriceMultiplier, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @endif
@endif
