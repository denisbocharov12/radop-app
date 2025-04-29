@if(Auth::guard('user')->user() !== null && Auth::guard('user')->user()->with_sale)
    @if(Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0 && $product->sale_price === '')
        <span class="price">{{number_format((float)$product->price - (float)$product->price * (Auth::guard('user')->user()->sale / 100), 2, ',', '')}} {{__('theme.MDL')}}</span>
    @elseif($product->sale_price !== '' || Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0)
        <span class="price" style="color: #ee0000">{{ number_format($product->sale_price, 2, ',', '') }} {{__('theme.MDL')}}</span>
        <span class="old_price" style="color: #848484">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @else
        <span class="price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @endif
@else
    @if(Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0 && $product->sale_price === '')
        <span class="price">{{number_format((float)$product->price * (float)$product->price_koef - (float)$product->price * (float)$product->price_koef * (Auth::guard('user')->user()->sale / 100), 2, ',', '')}} {{__('theme.MDL')}}</span>
    @elseif($product->sale_price !== '' || Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0)
        <span class="price" style="color: #ee0000">{{ number_format($product->sale_price, 2, ',', '') }} {{__('theme.MDL')}}</span>
        <span class="old_price" style="color: #848484">{{ number_format($product->price * (float)$product->price_koef, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @else
        <span class="price">{{ number_format($product->price * (float)$product->price_koef, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @endif
@endif

