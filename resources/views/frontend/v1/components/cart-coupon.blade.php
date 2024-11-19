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
