<footer>
    @include('frontend.v1.components.auth')
    <section class="section-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>Меню навигации</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="#">{{__('theme.home')}}</a></li>
                            <li class="item"><a href="#">Мой аккаунт</a></li>
                            <li class="item"><a href="#">Магазин</a></li>
                            <li class="item"><a href="#">Корзина</a></li>
                            <li class="item"><a href="#">Оформление заказа</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>Помощь</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="#">Как сделать заказ</a></li>
                            <li class="item"><a href="#">Доставка</a></li>
                            <li class="item"><a href="#">Опалата</a></li>
                            <li class="item"><a href="#">Контакты</a></li>
                            <li class="item"><a href="#">Безопасность</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>О компании</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="#">О нас</a></li>
                            <li class="item"><a href="#">Вакансии</a></li>
                            <li class="item"><a href="#">Контакты</a></li>
                            <li class="item"><a href="#">Реквизиты</a></li>
                            <li class="item"><a href="#">Развитие</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-legacy">
                        <p>© Все права зашищены согласно <a href="#">Политике конфиденциальности</a></p>
                    </div>
                    <div class="wrap-social">
                        <a href="#" class="social-link">
                            <img src="{{asset('/v1/frontend/assets')}}/images/facebook.svg" alt="" />
                        </a>
                        <a href="#" class="social-link">
                            <img src="{{asset('/v1/frontend/assets')}}/images/instagram.svg" alt="" />
                        </a>
                        <a href="#" class="social-link">
                            <img src="{{asset('/v1/frontend/assets')}}/images/viber.svg" alt="" />
                        </a>
                        <a href="#" class="social-link">
                            <img src="{{asset('/v1/frontend/assets')}}/images/telegram.svg" alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>
