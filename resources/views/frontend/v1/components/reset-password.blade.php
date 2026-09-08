<div style="display: none; max-width: 500px" id="loginModal">
    @if(auth()->guard('user')->user() !== null && auth()->guard('user')->user()->hasRole('user'))
    <div class="login-modal-wrap">
        <div class="login-logo d-flex align-items-center justify-content-center">
            <img style="width: 90px; height: auto" src="{{asset('/v1/frontend/assets')}}/images/logo.svg" alt="Radop Logo" />
        </div>
        <div class="login-head d-flex align-items-center justify-content-center">
            <h3>{{__('theme.сontrol-panel')}}</h3>
        </div>
        <a class="p-3 bg-light d-block rounded-1 mb-2" href="{{route('theme.user.account.index')}}">{{__('theme.profile')}}</a>
        <a class="p-3 bg-light d-block rounded-1 mb-2" href="{{route('theme.user.orders.index')}}">{{__('theme.my-orders')}}</a>
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
                        <button type="submit" class="login-btn" id="login-btn-modal">{{__('theme.enter')}}</button>
                    </div>
                </form>
            </div>
            <div class="login-separator">
                <p>{{__('theme.or')}}</p>
            </div>
            <a href="{{route('user.registration.index')}}" class="login-btn login-btn-any register">{{__('theme.registration')}}</a>
            <div class="login-separator no-text">
            </div>
            <div class="account-helpers-wrap">
                <a href="#" class="helper-account-activate">{{__('theme.activate-account')}}</a>
                <a href="{{route('theme.passwords.forget')}}" class="helper-account-psw">{{__('theme.forget-password')}}</a>
            </div>
        </div>
    @endif
</div>
