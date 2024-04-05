<header>
    <section class="section-header">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3 col-header-logo">
                    <div class="header-logo-wrap">
                        <a class="link" href="{{route('user.login')}}">
                            <img src="{{asset('/v1/frontend/assets')}}/images/logo.svg" alt="Bay Kus">
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-9 col-header-menu">
                    <div class="header-menu-wrap">
                        <ul class="list">
                            <li class="item"><a href="https://baykus.md/contacts/" target="_blank" class="link">Контакты</a></li>
{{--                            <li class="item"><a href="#" class="link">Услуги</a></li>--}}
                            @if(\Illuminate\Support\Facades\Auth::guard('user')->check())
                                <li class="item item-has-child-menu">
                                    <a href="{{route('user.login')}}" class="link link-has-child-menu"><i class="icon-account"></i> Акканут</a>
                                    @include('user.v1.header.components.desktop-child-menu-item')
                                </li>
                            @else
                                <li class="item item-has-child-menu">
                                    <a href="{{route('user.login')}}" class="link link-has-child-menu"><i class="icon-account"></i> Войти</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="mobile-menu-toggle"><i class="icon-burger-menu"></i></div>
                    <nav role="navigation" class="nav-mobile-menu">
                        <ul class="list mobile-menu">
                            <li class="item"><a href="https://baykus.md/contacts/" target="_blank" class="link">Контакты</a></li>
                            @if(\Illuminate\Support\Facades\Auth::guard('user')->check())
                                <li class="item mobile-item-has-child-menu ">
                                    <a class="link mobile-link-has-child-menu" href="javascript:void(0)">
                                        <i class="icon-account"></i>
                                        Аккаунт
                                        <i class="icon-arrow"></i>
                                    </a>
                                    @include('user.v1.header.components.mobile-child-menu-item')
                                </li>
                            @else
                                <li class="item mobile-item-has-child-menu">
                                    <a class="link mobile-link-has-child-menu" href="{{route('user.login')}}">
                                        <i class="icon-account"></i>
                                        Войти
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</header>
