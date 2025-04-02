<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}" class="js">
@include('v1.head.head')
<body class="nk-body bg-white npc-general pg-auth">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content ">
                <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                    <div class="brand-logo pb-4 text-center">
                        <a href="#" class="logo-link">
                            <img src="{{asset('/v1/dashboard/assets')}}/images/logo_colored_radop.svg" alt="Radop" style="width: 160px">
                        </a>
                    </div>
                    <div class="card card-bordered">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h4 class="nk-block-title">Вход</h4>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('auth') }}">
                                @csrf
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="username">Email или Login</label>
                                        @error('username')
                                        <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Enter your email address or username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password">Пароль</label>
                                        <a class="link link-primary link-sm" href="#">Забыли пароль?</a>
                                    </div>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your passcode">
                                        @error('password')
                                        <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block">Войти</button>
                                    @error('role_permission')
                                        <span id="fv-full-name-error" style="text-align: center;
                                                                            padding: 5px 15px;
                                                                            background-color: #ec4e5d;
                                                                            color: white;
                                                                            display: flex;
                                                                            align-items: center;
                                                                            justify-content: center;
                                                                            border-radius: 5px;
                                                                            margin-top: 10px;" class="invalid"
                                        >
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    @error('auth')
                                        <span id="fv-full-name-error" style="text-align: center;
                                                                            padding: 5px 15px;
                                                                            background-color: #ec4e5d;
                                                                            color: white;
                                                                            display: flex;
                                                                            align-items: center;
                                                                            justify-content: center;
                                                                            border-radius: 5px;
                                                                            margin-top: 10px;" class="invalid"
                                        >
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="nk-footer nk-auth-footer-full">
                    <div class="container wide-lg">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="nk-block-content text-center text-lg-center">
                                    <p class="text-soft">&copy; 2025 RĂDOP. All Rights Reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    </div>
    <!-- main @e -->
</div>
<!-- modals -->
@yield('modals')
<!-- modals -->>
<!-- JavaScript -->
@include('v1.scripts.scripts')
</body>
</html>
