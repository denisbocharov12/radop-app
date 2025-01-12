@if(Auth::guard('user')->user() && Auth::guard('user')->user()->sale !== null && Auth::guard('user')->user()->sale !== 0.0)
    <span class="price">{{number_format((float)$product->price - (float)$product->price * (Auth::guard('user')->user()->sale / 100), 2, ',', '')}} {{__('theme.MDL')}}</span>
    <span class="old_price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
@else
    @if($product->sale_price !== '')
        <span class="price">{{ number_format($product->sale_price, 2, ',', '') }} {{__('theme.MDL')}}</span>
        <span class="old_price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @else
        <span class="price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
    @endif
@endif
