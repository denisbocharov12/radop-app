<footer>
    @include('frontend.v1.components.auth')
    <section class="section-footer">
        <div class="container position-relative">
            <button type="button" class="scroll_to_top_btn" id="scroll_to_top_btn"><i class="icon-arrow-radop-right"></i>{{__('theme.scroll_to_top_btn')}}</button>
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <ul class="footer-menu">
                            <li class="item item-site-name"><h5>{{__('theme.footer_site_name')}}</h5></li>
                            <li class="item"><p>{{__('theme.footer_site_desc')}}</p></li>
                            <li class="item mt-4"><p>{{__('theme.footer_site_address')}}</p></li>
                            <li class="item"><p>{{__('theme.footer_info_address')}}</p></li>
                            <li class="item"><p>{!! __('theme.footer_info_phone') !!}</p></li>
                            <li class="item"><p>{!! __('theme.footer_info_gsm')!!}</p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer vertical-divider">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.footer_catalog_title')}}</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="{{route('theme.shop.catalog')}}">{{__('theme.header-catalog-text')}}</a></li>
                            <li class="item"><a href="{{ route('theme.home') }}#popular-products-home-anchor" class="scroll-element" data-anchor="popular-products-home-anchor">{{__('theme.popular-products')}}</a></li>
                            <li class="item"><a href="{{ route('theme.home') }}#new-products-home-anchor" class="scroll-element" data-anchor="new-products-home-anchor">{{__('theme.new-products')}}</a></li>
                            <li class="item"><a href="{{ route('theme.home') }}#discount-products-home-anchor" class="scroll-element" data-anchor="discount-products-home-anchor">{{__('theme.promotion')}}</a></li>
                            <li class="item"><a href="{{ route('theme.home') }}#brands-home-anchor" class="scroll-element" data-anchor="brands-home-anchor">{{__('theme.home-brands')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-site-footer">
                    <div class="wrap-footer-menu">
                        <h5>{{__('theme.about-company')}}</h5>
                        <ul class="footer-menu">
                            <li class="item"><a href="{{route('theme.contacts.index')}}">{{__('theme.contact')}}</a></li>
                            <li class="item"><a href="{{route('theme.delivery.index')}}">{{__('theme.footer_terms_and_conditions')}}</a></li>
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
                            <li class="item"><a href="{{route('theme.return-rules.index')}}">{{__('theme.return_and_exchange_products')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>
