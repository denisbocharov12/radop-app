<div class="cart-block icon-block mini-shopping-cart">
    <a href="#" class="cart icon-block-link">
        Корзина
        <i class="icon-cart-radop"></i>
        <span class="count">3</span>
    </a>
    <div class="wrap-shopping-cart">
        <div class="heading-shopping-cart">
            <span class="sc-subtotal">К оплате: <span class="fw-600">132 MDL</span></span>
            <span class="sc-count">3 ед.</span>
        </div>
        <div class="contents-shopping-cart">
            <ul class="content-shopping-cart">
                <li class="item">
                    <a href="#" class="sc-product-item">
                        <div class="product-info">
                            <img class="sc-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                            <div class="sc-item-info-wrap">
                                <p class="sc-title">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing.
                                </p>
                                <div class="sc-product-qty">
                                    <div class="input-group-btn">
                                        <button
                                            onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                            class="sc-product-decrement minus"
                                            type="button"
                                            id="button-minus"
                                        >
                                            -
                                        </button>
                                    </div>
                                    <input
                                        data-id="1"
                                        id="qty-item-1"
                                        type="number"
                                        min="1"
                                        placeholder="1"
                                        value="1"
                                        class="sc-qty"
                                    />
                                    <!-- <input
                                      type="hidden"
                                      data-id="1"
                                      data-product-stock="9"
                                      id="update-cart-1"
                                    /> -->
                                    <div class="input-group-btn">
                                        <button
                                            onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                            class="sc-product-increment plus"
                                            type="button"
                                            id="button-plus"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="sc-price">32.94 MDL</span>
                        <div class="item-delete"><i class="icon-trash-radop"></i></div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bottom-shopping-cart">
            <a href="#" class="btn-shopping-cart">Продолжить покупки</a>
            <a href="#" class="btn-shopping-cart red">Оформить заказ</a>
        </div>
    </div>
</div>
