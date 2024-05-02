<div class="cart-block icon-block mini-shopping-cart">
    <a href="#" class="cart icon-block-link">
        Корзина
        <i class="icon-cart-radop"></i>
        <span class="count">{{Cart::instance('cart')->count()}}</span>
    </a>
    <div class="wrap-shopping-cart">
        <div class="heading-shopping-cart">
            <span class="sc-subtotal">К оплате: <span class="fw-600">{{Cart::instance('cart')->total()}} MDL</span></span>
            <span class="sc-count">{{Cart::instance('cart')->count()}} ед.</span>
        </div>
        <div class="contents-shopping-cart" id="cart-update">
            @include('frontend.v1.components.mini-cart')
        </div>
        <div class="bottom-shopping-cart">
            <a href="#" class="btn-shopping-cart">Продолжить покупки</a>
            <a href="#" class="btn-shopping-cart red">Оформить заказ</a>
        </div>
    </div>
</div>
