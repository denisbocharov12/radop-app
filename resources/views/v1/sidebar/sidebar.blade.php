<!-- sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
        <div class="nk-sidebar-brand">
            <a href="{{route('dashboard.index')}}" class="logo-link nk-sidebar-logo">
                <img style="width: 40px" src="{{asset('/v1/frontend/assets')}}/images/logo.svg" alt="Radop Logo" />
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
                            <span class="nk-menu-text">Заказы <span id="new_orders" class="badge badge-danger round"></span></span>
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
                            <span class="nk-menu-text">Заказы <span id="new_orders" class="badge badge-danger round">4</span></span>
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
                                <a href="{{route('brand.sort.index')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка брэндов</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('product.index')}}" class="nk-menu-link"><span class="nk-menu-text">Товары</span></a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{route('attribute.index')}}" class="nk-menu-link"><span class="nk-menu-text">Атрибуты</span></a>
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
                            <li class="nk-menu-item">
                                <a href="{{route('city.sort.index')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка городов</span></a>
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-sort-v"></em></span>
                            <span class="nk-menu-text">Сортировка</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                <a href="{{route('category.sort.index')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка категорий</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('category.sort.index.catalog')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка категорий каталога</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('brand.sort.index')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка брэндов</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('product.sort.index.featured')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка "Featured" товаров</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('product.sort.index.popular')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка "Popular" товаров</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('product.sort.index.sale')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка "Sale" товаров</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('product.sort.index.hot')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка "Hot" товаров</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('product.sort.index.new')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка "New" товаров</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('attribute.sort.index')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка аттрибутов</span></a>
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
                            <li class="nk-menu-item">
                                <a href="{{route('city.sort.index')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка городов</span></a>
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-map-pin"></em></span>
                            <span class="nk-menu-text">Города</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                <a href="{{route('city.index')}}" class="nk-menu-link"><span class="nk-menu-text">Города</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('city.sort.index')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка городов</span></a>
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
                            <span class="nk-menu-icon"><em class="icon ni ni-building-fill"></em></span>
                            <span class="nk-menu-text">Филиалы</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                <a href="{{route('filial.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все филиалы</span></a>
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
                                <a href="{{route('manager.list.index')}}" class="nk-menu-link"><span class="nk-menu-text">Все менеджеры</span></a>
                            </li>
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
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-reports"></em></span>
                            <span class="nk-menu-text">Период скидок</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                <a href="{{route('discount-period.index')}}" class="nk-menu-link"><span class="nk-menu-text">Периоды скидок</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('discount-period.sort.index')}}" class="nk-menu-link"><span class="nk-menu-text">Сортировка периода скидок</span></a>
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link  nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-table-view"></em></span>
                            <span class="nk-menu-text">Отчеты</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                <a href="{{route('reports.orders.index')}}" class="nk-menu-link"><span class="nk-menu-text">Отчёты по заказам</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('reports.users.index')}}" class="nk-menu-link"><span class="nk-menu-text">Отчёты по клиенту</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('reports.orders-city.index')}}" class="nk-menu-link"><span class="nk-menu-text">Отчёты по городу</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('reports.orders-status.index')}}" class="nk-menu-link"><span class="nk-menu-text">Отчёты по статусу заказов</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('reports.orders-user-type.index')}}" class="nk-menu-link"><span class="nk-menu-text">Отчёты по типам пользователей</span></a>
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    <li class="nk-menu-item has-sub">
                        @hasrole('admin')
                        <a href="{{route('languages.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-text"></em></span>
                            <span class="nk-menu-text">Переводы</span>
                        </a>
                        @endhasrole
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                            <span class="nk-menu-text">Настройки сайта</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @hasrole('admin')
                            <li class="nk-menu-item">
                                <a href="{{route('banner.index')}}" class="nk-menu-link"><span class="nk-menu-text">Баннеры</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('banner.sort.index')}}" class="nk-menu-link"><span class="nk-menu-text">Порядок отображения баннеров</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('banner.banner-settings.edit')}}" class="nk-menu-link"><span class="nk-menu-text">Настройка скорости переключения</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('page-setting.page-sort-settings.index') }}" class="nk-menu-link"><span class="nk-menu-text">Настройки сортировки страниц</span></a>
                            </li>
                            @endhasrole
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->
