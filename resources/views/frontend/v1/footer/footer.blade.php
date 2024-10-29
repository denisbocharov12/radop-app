<footer>
    @include('frontend.v1.components.auth')
    <section class="section-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <a href="{{route('theme.home')}}" class="link-logo">
                            <img src="{{asset('/v1/frontend/assets')}}/images/logo.svg" alt="Radop Logo" />
                        </a>
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
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.navigation-menu')}}</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="#">{{__('theme.about-us')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.delivery')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.news')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.term-of-use')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.confidentiality-policy')}}</a></li>
{{--                            <li class="item"><a href="#">{{__('theme.home')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.my-account')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.shop')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.cart')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.order-placement')}}</a></li>--}}
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.contact')}}</h5>
                        <ul class="footer-menu">
                            <li class="item">
                                <div class="d-flex">
                                    <a href="#"><i class="icon-point"></i>{{__('theme.office-address')}}</a>
                                </div>
                            </li>
                            <li class="item">
                                <p class="footer-text">{{__('theme.sales-department')}}:</p>
                                <div class="d-flex align-items-center">
                                    <a href="tel:+37322782100">+373 22 78 21 00</a> <a href="mailto:sales@radop.md">sales@radop.md</a>
                                </div>
                            </li>
                            <li class="item">
                                <p class="footer-text">{{__('theme.procurement-department')}}:</p>
                                <div class="d-flex align-items-center">
                                    <a href="tel:+37322782102">+ 373 22 78 21 02</a> <a href="mailto:office@radop.md">office@radop.md</a>
                                </div>
                            </li>
                            <li class="item">
                                <p class="footer-text">{{__('theme.tender-department')}}:</p>
                                <div class="d-flex align-items-center">
                                    <a href="tel:+37322782101">+373 22 78 21 01</a> <a href="mailto:sales@radop.md">sales@radop.md</a>
                                </div>
                            </li>
                            <li class="item">
                                <p class="footer-text">{{__('theme.accounting')}}:</p>
                                <div class="d-flex align-items-center">
                                    <a href="tel:+37322782103">+ 373 22 78 21 03</a> <a href="mailto:cont@radop.md">cont@radop.md</a>
                                </div>
                            </li>
                        </ul>
{{--                        <ul class="footer-menu">--}}
{{--                            <li class="item"><a href="#">{{__('theme.how-to-order')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.delivery')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.payment')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.contact')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.security')}}</a></li>--}}
{{--                        </ul>--}}
                    </div>
                </div>
{{--                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">--}}
{{--                    <div class="wrap-footer-menu">--}}
{{--                        <h5>{{__('theme.about-company')}}</h5>--}}
{{--                        <ul class="footer-menu">--}}
{{--                            <li class="item"><a href="#">{{__('theme.about-us')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.vacancies')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.contact')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.requisites')}}</a></li>--}}
{{--                            <li class="item"><a href="#">{{__('theme.development')}}</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-12 col-sm-6 col-lg-2 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.working-hours')}}</h5>
                        <ul class="footer-menu">
                            <li class="item">
                                <p class="footer-text">
                                    {{__('theme.weekdays')}} 8:00 - 17:00
                                </p>
                            </li>
                            <li class="item">
                                <p class="footer-text">
                                    {{__('theme.weekend')}} {{__('theme.closed')}}
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="wrap-legacy mt-4">
                        <p class="footer-text">© {{__('theme.all-rights-reserved-according-to')}} <a href="#">{{__('theme.privacy-policy')}}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>
