<footer>
    @include('frontend.v1.components.auth')
    <section class="section-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.navigation-menu')}}</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="#">{{__('theme.home')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.my-account')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.shop')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.cart')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.order-placement')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.help')}}</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="#">{{__('theme.how-to-order')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.delivery')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.payment')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.contact')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.security')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.about-company')}}</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="#">{{__('theme.about-us')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.vacancies')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.contact')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.requisites')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.development')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-legacy">
                        <p>© {{__('theme.all-rights-reserved-according-to')}} <a href="#">{{__('theme.privacy-policy')}}</a></p>
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
