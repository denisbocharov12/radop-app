<!-- sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
        <div class="nk-sidebar-brand">
            <a href="{{route('dashboard.index')}}" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{asset('/v1/dashboard')}}/assets/images/logo_white_radop.svg" alt="logo">
                <img class="logo-dark logo-img" src="{{asset('/v1/dashboard')}}/assets/images/logo_colored_radop.svg" alt="logo-dark">
            </a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        <a href="{{route('dashboard.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Панель управления</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        @hasrole('admin')
                        <a href="{{route('order.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart"></em></span>
                            <span class="nk-menu-text">Заказы</span>
                        </a>
                        @endhasrole
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                {{--                                <a href="{{route('technic.index')}}" class="nk-menu-link"><span class="nk-menu-text">Вся техника</span></a>--}}
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        @hasrole('manager')
                        <a href="{{route('order.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart"></em></span>
                            <span class="nk-menu-text">Заказы</span>
                        </a>
                        @endhasrole
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                            <span class="nk-menu-text">Склад</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                <a href="{{route('category.index')}}" class="nk-menu-link"><span class="nk-menu-text">Категории</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('brand.index')}}" class="nk-menu-link"><span class="nk-menu-text">Бренды</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('product.index')}}" class="nk-menu-link"><span class="nk-menu-text">Товары</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('attribute.index')}}" class="nk-menu-link"><span class="nk-menu-text">Атрибуты</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('city.index')}}" class="nk-menu-link"><span class="nk-menu-text">Города</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('deliveryMethod.index')}}" class="nk-menu-link"><span class="nk-menu-text">Методы доставки</span></a>
                            </li>
                            @endhasrole

                            @hasrole('manager')
                            <li class="nk-menu-item">
                                <a href="{{route('category.index')}}" class="nk-menu-link"><span class="nk-menu-text">Категории</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('brand.index')}}" class="nk-menu-link"><span class="nk-menu-text">Бренды</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('product.index')}}" class="nk-menu-link"><span class="nk-menu-text">Товары</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('attribute.index')}}" class="nk-menu-link"><span class="nk-menu-text">Атрибуты</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('city.index')}}" class="nk-menu-link"><span class="nk-menu-text">Города</span></a>
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        @hasrole('admin')
                        <a href="{{route('coupon.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-percent"></em></span>
                            <span class="nk-menu-text">Купоны</span>
                        </a>
                        @endhasrole

                        @hasrole('manager')
                        <a href="{{route('coupon.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-percent"></em></span>
                            <span class="nk-menu-text">Купоны</span>
                        </a>
                        @endhasrole
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
{{--                                <a href="{{route('technic.index')}}" class="nk-menu-link"><span class="nk-menu-text">Вся техника</span></a>--}}
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        @hasrole('admin')
                        <a href="{{route('import-export-data.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-upload"></em></span>
                            <span class="nk-menu-text">Импорт</span>
                        </a>
                        @endhasrole
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                {{--                                <a href="{{route('technic.index')}}" class="nk-menu-link"><span class="nk-menu-text">Вся техника</span></a>--}}
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Пользователи</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                <a href="{{route('client.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все пользователи</span></a>
                            </li>
                            @endhasrole

                            @hasrole('manager')
                            <li class="nk-menu-item">
                                <a href="{{route('client.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все пользователи</span></a>
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-tile-thumb-fill"></em></span>
                            <span class="nk-menu-text">Менеджеры</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                <a href="{{route('manager.index')}}" class="nk-menu-link"><span class="nk-menu-text">Назначить менеджера</span></a>
                            </li>
                            @endhasrole

                            @hasrole('manager')
                            <li class="nk-menu-item">
                                <a href="{{route('manager.index')}}" class="nk-menu-link"><span class="nk-menu-text">Назначить менеджера</span></a>
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        @hasrole('admin')
                        <a href="{{route('languages.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-text"></em></span>
                            <span class="nk-menu-text">Переводы</span>
                        </a>
                        @endhasrole
                    </li><!-- .nk-menu-item -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->
