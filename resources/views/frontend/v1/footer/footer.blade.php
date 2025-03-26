<footer>
    @include('frontend.v1.components.auth')
    <section class="section-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <ul class="footer-menu">
                            <li class="item">«Rădop-OPT» SRL</li>
                            <li class="item">Товары для офиса, школы и творчества</li>
                            <li class="item">MD-2015, мун. Кишинэу</li>
                            <li class="item">ул. Сармизеджетуса 15</li>
                            <li class="item">тел. 0 (22) 78 21 12</li>
                            <li class="item">GSM: +373 79 78 21 12</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer vertical-divider">
                    <div class="wrap-footer-menu">
                        <h5>Каталоги</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="{{route('theme.shop.index')}}">{{__('theme.header-catalog-text')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.popular-products')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.new-products')}}</a></li>
                            <li class="item"><a href="{{ route('theme.home') }}#discount-products-home-anchor">{{__('theme.promotion')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.home-brands')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.about-company')}}</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="{{route('theme.contacts.index')}}">{{__('theme.contact')}}</a></li>
                            <li class="item"><a href="{{route('theme.delivery.index')}}">Условия доставки и оплаты</a></li>
                            <li class="item"><a href="#">{{__('theme.news')}}</a></li>
                            <li class="item"><a href="#">{{__('theme.updates')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.information')}}</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="{{route('theme.order-guide.index')}}">{{__('theme.how-to-order')}}</a></li>
                            <li class="item"><a href="{{route('theme.terms-and-conditions.index')}}">{{__('theme.conditions-of-use')}}</a></li>
                            <li class="item"><a href="{{route('theme.privacy-policy.index')}}">{{__('theme.confidentiality-policy')}}</a></li>
                            <li class="item"><a href="{{route('theme.cookie.index')}}">{{__('theme.cookie')}}</a></li>
                            <li class="item"><a href="{{route('theme.return-rules.index')}}">Возврат и обмен товаров</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>
