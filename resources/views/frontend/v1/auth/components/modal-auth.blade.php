@if(auth()->guard('user')->user() !== null && auth()->guard('user')->user()->hasRole('user'))
<div class="login-modal-wrap">
    <div class="login-head">
        <h3>{{__('theme.сontrol-panel')}}</h3>
    </div>
    <a class="p-3 bg-light d-block rounded-1 mb-2" href="{{route('theme.user.account.index')}}">{{__('theme.profile')}}</a>
    <a class="p-3 bg-light d-block rounded-1 mb-2" href="{{route('theme.user.orders.index')}}">{{__('theme.my-orders')}}</a>
    <a class="p-3 bg-light d-block rounded-1 mb-2" href="{{route('theme.user.coupon.index')}}">{{__('theme.my-coupons')}}</a>
    <a class="p-3 bg-light d-block rounded-1 mb-2" href="{{route('theme.user.logout')}}">{{__('theme.logout')}}</a>
    <div class="account-helpers-wrap mt-4">
        <a href="#" class="helper-account-activate">{{__('theme.activate-account')}}</a>
        <a href="#" class="helper-account-psw">{{__('theme.forget-password')}}</a>
    </div>
</div>
@else
    <div class="login-modal-wrap">
        <div class="login-logo d-flex align-items-center justify-content-center">
            <img style="width: 90px; height: auto" src="{{asset('/v1/frontend/assets')}}/images/logo.svg" alt="Radop Logo" />
        </div>
        <div class="login-head d-flex align-items-center justify-content-center">
            <h3>{{__('theme.log-in-account')}}</h3>
        </div>
        <div class="login-form-wrap">
            <form action="{{route('user.login')}}" id="form-login-modal" method="POST" class="form-login">
                <div class="form-block-wrap">
                    <input type="text" name="username" class="input-login" placeholder="Email" />
                </div>
                <div class="form-block-wrap">
                    <input
                        type="password"
                        name="password"
                        class="input-login input-password"
                        placeholder="{{__('theme.password')}}"
                    />
                </div>
                <div class="form-block-wrap">
                    <button type="submit" class="login-btn" id="login-btn-modal">Войти</button>
                </div>
            </form>
        </div>
        <div class="login-separator">
            <p>{{__('theme.or')}}</p>
        </div>
        <a href="{{route('user.registration.index')}}" class="login-btn login-btn-any register"> Регистрациая </a>
        <button type="button" class="login-btn login-btn-any login-btn-google">
            {{__('theme.enter-with')}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                    <path
                        fill="#4285F4"
                        d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z"
                    />
                    <path
                        fill="#34A853"
                        d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z"
                    />
                    <path
                        fill="#FBBC05"
                        d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z"
                    />
                    <path
                        fill="#EA4335"
                        d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z"
                    />
                </g>
            </svg>
            Google
        </button>
        <div class="login-separator no-text">
        </div>
        <div class="account-helpers-wrap">
            <a href="#" class="helper-account-activate">{{__('theme.activate-account')}}</a>
            <a href="#" class="helper-account-psw">{{__('theme.forget-password')}}</a>
        </div>
    </div>
@endif
