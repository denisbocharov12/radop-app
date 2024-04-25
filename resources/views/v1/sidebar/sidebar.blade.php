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
{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-user-list-fill"></em></span>--}}
{{--                            <span class="nk-menu-text">Контракты</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('contract.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все контракты</span></a>--}}
{{--                            </li>--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
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
{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-task-fill-c"></em></span>--}}
{{--                            <span class="nk-menu-text">Заказы</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('subject.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все обьекты</span></a>--}}
{{--                            </li>--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('schedule.index')}}" class="nk-menu-link"><span class="nk-menu-text">Задачи к объектам</span></a>--}}
{{--                            </li>--}}
{{--                            @hasrole('admin')--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('security-type.index')}}" class="nk-menu-link"><span class="nk-menu-text">Типы сигнализации</span></a>--}}
{{--                            </li>--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('arrival_time.index')}}" class="nk-menu-link"><span class="nk-menu-text">Время прибытия</span></a>--}}
{{--                            </li>--}}
{{--                            @endhasrole--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
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
                            @endhasrole

                            @hasrole('admin')
                                <li class="nk-menu-item">
{{--                                    <a href="{{route('transfer.index')}}" class="nk-menu-link"><span class="nk-menu-text">Трансферы</span></a>--}}
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
{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-clip"></em></span>--}}
{{--                            <span class="nk-menu-text">Инвертарь</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            @hasrole('admin')--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('inventory.index')}}" class="nk-menu-link"><span class="nk-menu-text">Весь инвентарь</span></a>--}}
{{--                            </li>--}}
{{--                            @endhasrole--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Пользователи</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
{{--                                <a href="{{route('user.index')}}" class="nk-menu-link"><span class="nk-menu-text">Рабочие</span></a>--}}
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></span>--}}
{{--                            <span class="nk-menu-text">Выплаты</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            @hasrole('admin')--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('payout.index')}}" class="nk-menu-link"><span class="nk-menu-text">Выплаты по ставкам</span></a>--}}
{{--                            </li>--}}
{{--                            @endhasrole--}}
{{--                            @hasrole('admin')--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('prepayment.index')}}" class="nk-menu-link"><span class="nk-menu-text">Авансы</span></a>--}}
{{--                            </li>--}}
{{--                            @endhasrole--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-hot-fill"></em></span>--}}
{{--                            <span class="nk-menu-text">Топливо</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            @hasrole('admin')--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('fuel.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все топливо</span></a>--}}
{{--                            </li>--}}
{{--                            @endhasrole--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
{{--                    @hasrole('admin')--}}
{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>--}}
{{--                            <span class="nk-menu-text">Пользователи</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('client.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все пользователи</span></a>--}}
{{--                            </li>--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
{{--                    @endhasrole--}}
{{--                    @hasrole('accountant')--}}
{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>--}}
{{--                            <span class="nk-menu-text">Пользователи</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('client.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все пользователи</span></a>--}}
{{--                            </li>--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
{{--                    @endhasrole--}}

{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>--}}
{{--                            <span class="nk-menu-text">Оплата</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('transaction.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все оплаты</span></a>--}}
{{--                            </li>--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('another_service.index')}}" class="nk-menu-link"><span class="nk-menu-text">Другие оплаты (монтажные)</span></a>--}}
{{--                            </li>--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('subscribe.index')}}" class="nk-menu-link"><span class="nk-menu-text">История подписок</span></a>--}}
{{--                            </li>--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-disk"></em></span>--}}
{{--                            <span class="nk-menu-text">Обслуживание</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('maintenance.index')}}" class="nk-menu-link"><span class="nk-menu-text">Обслуживание</span></a>--}}
{{--                            </li>--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
{{--                    @hasrole('admin')--}}
{{--                    <li class="nk-menu-item has-sub">--}}
{{--                        <a href="#" class="nk-menu-link nk-menu-toggle">--}}
{{--                            <span class="nk-menu-icon"><em class="icon ni ni-setting-alt"></em></span>--}}
{{--                            <span class="nk-menu-text">Настройки</span>--}}
{{--                        </a>--}}
{{--                        <ul class="nk-menu-sub">--}}
{{--                            <li class="nk-menu-item">--}}
{{--                                <a href="{{route('template-file.index')}}" class="nk-menu-link"><span class="nk-menu-text">Шаблоны</span></a>--}}
{{--                            </li>--}}
{{--                        </ul><!-- .nk-menu-sub -->--}}
{{--                    </li><!-- .nk-menu-item -->--}}
{{--                    @endhasrole--}}
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->
