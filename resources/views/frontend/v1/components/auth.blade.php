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
            <a href="javascript:;" class="helper-account-psw">{{__('theme.forget-password')}}</a>
        </div>
        <div style="display: none; max-width: 500px; border-radius: 10px" id="forgetPasswordModal">
            <div class="login-modal-wrap">
                <div class="login-logo d-flex align-items-center justify-content-center">
                    <img style="width: 90px; height: auto" src="{{ asset('/v1/frontend/assets') }}/images/logo.svg" alt="Radop Logo" />
                </div>
                <div class="login-head d-flex align-items-center justify-content-center">
                    <h2 class="mb-3">{{__('theme.password-recovery')}}</h2>
                </div>
                <p class="text-center mb-4">{{__('theme.password-recovery-enter-email')}}</p>
                <div class="login-form-wrap">
                    <form id="forgetPasswordForm" method="POST" class="form-login" action="{{route('theme.passwords.forget')}}">
                        @csrf
                        <div class="form-block-wrap mb-3">
                            <input type="email" name="email" class="input-login" placeholder="Email" required />
                        </div>
                        <div class="form-block-wrap">
                            <button type="submit" class="login-btn">{{__('theme.send')}}</button>
                        </div>
                    </form>
                </div>
            </div>
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
                    @csrf
                    <div class="form-block-wrap">
                        <input type="text" name="username" required class="input-login" placeholder="Email" />
                    </div>
                    <div class="form-block-wrap form-password">
                        <a href="#" class="qu eye eye_password"><i class="fa fa-eye-slash"></i></a>
                        <input
                            type="password"
                            name="password"
                            required
                            class="input-login input-password"
                            placeholder="{{__('theme.password')}}"
                            id="password"
                            style="display: block;"
                        />
                        <input
                            type="text"
                            name="password"
                            required
                            class="input-login input-password"
                            placeholder="{{__('theme.password')}}"
                            id="password_text"
                            style="display: none;"
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
                <a href="javascript:;" class="helper-account-psw">{{__('theme.forget-password')}}</a>
            </div>
            <div style="display: none; max-width: 500px; border-radius: 10px" id="forgetPasswordModal">
                <div class="login-modal-wrap">
                    <div class="login-logo d-flex align-items-center justify-content-center">
                        <img style="width: 90px; height: auto" src="{{ asset('/v1/frontend/assets') }}/images/logo.svg" alt="Radop Logo" />
                    </div>
                    <div class="login-head d-flex align-items-center justify-content-center">
                        <h2 class="mb-3">{{__('theme.password-recovery')}}</h2>
                    </div>
                    <p class="text-center mb-4">{{__('theme.password-recovery-enter-email')}}</p>
                    <div class="login-form-wrap">
                        <form id="forgetPasswordForm" method="POST" class="form-login" action="{{route('theme.passwords.forget')}}">
                            @csrf
                            <div class="form-block-wrap mb-3">
                                <input type="email" name="email" class="input-login" placeholder="Email" required />
                            </div>
                            <div class="form-block-wrap">
                                <button type="submit" class="login-btn">{{__('theme.send')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .form-password {
        position: relative;
    }
    .form-password .eye {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 5;
        color: #000;
        text-decoration: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passInput = document.getElementById("password");
        const textInput = document.getElementById("password_text");

        document.querySelectorAll(".eye_password").forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                const icon = btn.querySelector("i");

                if (passInput.style.display !== "none") {
                    textInput.value = passInput.value;
                    passInput.style.display = "none";
                    textInput.style.display = "block";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                } else {
                    passInput.value = textInput.value;
                    passInput.style.display = "block";
                    textInput.style.display = "none";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                }
            });
        });

        // Синхронизация значений
        passInput.addEventListener("input", function () {
            textInput.value = passInput.value;
        });
        textInput.addEventListener("input", function () {
            passInput.value = textInput.value;
        });

        const loginForm = document.getElementById("form-login-modal");
        if (loginForm) {
            loginForm.addEventListener("submit", function () {
                if (textInput.style.display === "block") {
                    passInput.value = textInput.value;
                    passInput.style.display = "block";
                    textInput.style.display = "none";
                }
            });
        }
    });
</script>
