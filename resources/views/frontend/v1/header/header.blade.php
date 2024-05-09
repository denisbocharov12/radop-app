<header id="header">
    <section class="section-header" id="section-header">
        <div class="container">
            <div class="row row-main">
                <div class="header-logo col-auto col-sm-auto col-md-auto col-lg-auto col-xl-auto">
                    <a href="{{route('theme.home')}}" class="link-logo">
                        <img src="{{asset('/v1/frontend/assets')}}/images/logo-white.svg" alt="" />
                    </a>
                </div>
                <div class="header-menu col-lg">
                    <div class="header-main-menu">
                        <ul class="menu w-100 justify-content-center">
                            @if(!empty($themeParentCategories))
                                @foreach($themeParentCategories as $parentCategory)
                                    @include('frontend.v1.header.components.header-menu-item', $parentCategory)
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="header-search col col-md col-xl col-lg">
                    <div class="wrap">
                        <form action="#">
                            <input type="text" class="search" name="search" placeholder="Искать на сайте" />
                            <button type="submit" class="btn-search"><i class="icon-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="header-account col-auto col-sm-auto col-md-auto col-lg-auto">
                    <div class="login-registration-block icon-block">
                        <a
                            class="user icon-block-link"
                            data-fancybox
                            data-src="#loginModal"
                            href="javascript:;"
                        >
                            <i class="icon-user-radop"></i>
                        </a>
                    </div>
                    <div class="wishlist-block icon-block">
                        <a href="#" class="wishlist icon-block-link">
                            <i class="icon-heart-radop"></i>
                        </a>
                    </div>
                    <div class="cart-block icon-block mini-shopping-cart">
                        <a href="#" class="cart icon-block-link">
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
                                                <img class="sc-image" src="" alt="" />
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
                    <div class="mobile-menu-block icon-block">
                        <a href="#" class="hamburger icon-block-link" id="hamburger-open">
                            <i class="icon-bars"></i>
                        </a>
                    </div>
                    <nav class="nav-drill" id="nav-drill">
                        <div class="main-wrap-menu-mobile">
                            <div class="menu-close menu-mobile-account">
                    <span class="hamburger hamburger-close" id="hamburger-close"
                    ><i class="fa fa-times"></i
                        ></span>
                            </div>
                            <ul class="nav-items nav-level-1">
                                <li class="nav-item nav-expand">
                                    <a class="nav-link nav-expand-link" href="#"> Menu </a>
                                    <ul class="nav-items nav-expand-content">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"> Level 2 </a>
                                        </li>
                                        <li class="nav-item nav-expand">
                                            <a class="nav-link nav-expand-link" href="#"> Menu </a>
                                            <ul class="nav-items nav-expand-content">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#"> Level 3 </a>
                                                </li>
                                                <li class="nav-item nav-expand">
                                                    <a class="nav-link nav-expand-link" href="#"> Menu </a>
                                                    <ul class="nav-items nav-expand-content">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#"> Level 4 </a>
                                                        </li>
                                                        <li class="nav-item nav-expand">
                                                            <a class="nav-link nav-expand-link" href="#"> Menu </a>
                                                            <ul class="nav-items nav-expand-content">
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#"> Level 5 Directory </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#"> Level 5 Contact </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#"> Level 5 Quick links </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#"> Level 5 Launchpad </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#"> Level 4 Directory </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#"> Level 4 Contact </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#"> Level 4 Quick links </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#"> Level 4 Launchpad </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#"> Level 3 Directory </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#"> Level 3 Contact </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#"> Level 3 Quick links </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#"> Level 3 Launchpad </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"> Level 2 Directory </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"> Level 2 Contact </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"> Level 2 Quick links </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"> Level 2 Launchpad </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"> Directory </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"> Contact </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"> Quick links </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"> Launchpad </a>
                                </li>
                            </ul>
                        </div>
                        <div class="select-language-mobile"></div>
                    </nav>
                </div>
            </div>
            <div class="row row-menu">
                <div class="header-primary-menu"></div>
            </div>
        </div>
    </section>
</header>
