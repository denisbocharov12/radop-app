@extends('frontend.v1.layouts.layout')

@section('content')
    <div class="section-standart section-register">
        <div class="container">
            <div class="row">
                <div class="col-12 col-register-wrap">
                    <div id="tabs">
                        <div class="tab-block">
                            <div class="tab active">{{__('theme.physical-person')}}</div>
                            <div class="tab">{{__('theme.legal-person')}}</div>
                        </div>
                        <div class="tabContent">
                            <form id="form-fiz-submit" action="{{route('user.registration.store')}}" method="POST">
                                @csrf
                                @php
                                    $userTypeFiz = \App\Models\UserType::where('key_name', 'fiz')->first();
                                @endphp
{{--                                <input type="hidden" name="type_id" value="{{$userTypeFiz->id}}">--}}
                                <div class="form-content">
                                    <div class="left">
                                        <div class="form-control form-control-direction">
                                            <input
                                                class=""
                                                type="text"
                                                name="first_name"
                                                id="first_name_fiz"
                                                placeholder="{{__('theme.first-name')}}"
                                            />
                                            @error('first_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-control form-control-direction">
                                            <input
                                                class=""
                                                type="text"
                                                name="last_name"
                                                id="last_name_fiz"
                                                placeholder="{{__('theme.second-name')}}"
                                            />
                                            @error('last_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-control form-control-direction">
                                            <input
                                                class=""
                                                type="text"
                                                name="address"
                                                id="address_fiz"
                                                placeholder="{{__('theme.address')}}"
                                            />
                                            @error('address')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="form-control form-control-direction">
                                            <input
                                                class=""
                                                type="text"
                                                name="phone"
                                                id="phone_fiz"
                                                placeholder="{{__('theme.phone-number')}}"
                                            />
                                            @error('phone')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-control form-control-direction">
                                            <input
                                                type="email"
                                                class=""
                                                name="email"
                                                id="email_fiz"
                                                placeholder="Email"
                                            />
                                            @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-control form-password form-control-direction">
                                            <a href="#" class="qu eye eye_fiz"><i class="fa fa-eye-slash"></i></a>
                                            <input
                                                class="password"
                                                type="password"
                                                name="password"
                                                id="password_fiz"
                                                placeholder="{{__('theme.password')}}"
                                            />
                                            @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="center">
                                    <div class="form-control form-control-direction" style="text-align: center">
                                        <div class="wrap">
                                            <input
                                                type="checkbox"
                                                class="custom-checkbox"
                                                id="policy_fiz"
                                                name="rule"
                                                value="1"
                                                checked
                                            />
                                            <label for="policy_fiz"
                                            >{{__('theme.agree-with')}}
                                                <a
                                                        data-fancybox
                                                        data-src="#rules-register-page"
                                                        data-touch="false"
                                                        href="javascript:;"
                                                >
                                                    {{__('theme.terms-of-use')}}
                                                </a></label
                                            >
                                        </div>
                                        @error('rule')
                                        <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="block-botton">
                                    <button id="form_submit_fiz" type="submit" class="btn">
                                        {{__('theme.sign-up')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tabContent">
                            <form id="form-iur-submit" action="{{route('user.registration.store')}}" method="POST">
                                @csrf
                                @php
                                    $userTypeIur = \App\Models\UserType::where('key_name', 'iur')->first();
                                @endphp
{{--                                <input type="hidden" name="type_id" value="{{$userTypeIur->id}}">--}}
                                <div class="form-content">
                                    <div class="left">
{{--                                        <div class="form-control form-control-direction">--}}
{{--                                            <input--}}
{{--                                                class=""--}}
{{--                                                type="text"--}}
{{--                                                name="first_name"--}}
{{--                                                id="first_name_iur"--}}
{{--                                                placeholder="Имя"--}}
{{--                                            />--}}
{{--                                            @error('first_name')--}}
{{--                                            <span class="invalid-feedback d-block" role="alert">--}}
{{--                                                        <strong>{{ $message }}</strong>--}}
{{--                                                    </span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <div class="form-control form-control-direction">--}}
{{--                                            <input--}}
{{--                                                class=""--}}
{{--                                                type="text"--}}
{{--                                                name="last_name"--}}
{{--                                                id="last_name_iur"--}}
{{--                                                placeholder="Фамилия"--}}
{{--                                            />--}}
{{--                                            @error('last_name')--}}
{{--                                            <span class="invalid-feedback d-block" role="alert">--}}
{{--                                                        <strong>{{ $message }}</strong>--}}
{{--                                                    </span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
                                        <div class="form-control form-control-direction">
                                            <input
                                                class=""
                                                type="text"
                                                name="organization_name"
                                                id="organization_name"
                                                placeholder="{{__('theme.company-name')}}"
                                            />
                                            @error('organization_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-control form-control-direction">
                                            <input
                                                class=""
                                                type="text"
                                                name="address"
                                                id="address_iur"
                                                placeholder="{{__('theme.address')}}"
                                            />
                                            @error('address')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-control form-control-direction">
                                            <input
                                                class=""
                                                type="text"
                                                name="contact_name"
                                                id="contact_name"
                                                placeholder="{{__('theme.contact-person')}}"
                                            />
                                            @error('contact_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="form-control form-control-direction">
                                            <input
                                                class=""
                                                type="text"
                                                name="phone"
                                                id="phone_iur"
                                                placeholder="{{__('theme.phone-number')}}"
                                            />
                                            @error('phone')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-control form-control-direction">
                                            <input
                                                type="email"
                                                class=""
                                                name="email"
                                                id="email_iur"
                                                placeholder="Email"
                                            />
                                            @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-control form-control-direction">
                                            <input
                                                class=""
                                                type="text"
                                                name="cod_fiscal"
                                                id="cod_fiscal"
                                                placeholder="{{__('theme.fiscal-code')}}"
                                            />
                                            @error('cod_fiscal')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-control form-password form-control-direction">
                                            <a href="#" class="qu eye eye_iur"><i class="fa fa-eye-slash"></i></a>
                                            <input
                                                class="password"
                                                type="password"
                                                name="password"
                                                id="password_iur"
                                                placeholder="{{__('theme.password')}}"
                                            />
                                            @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="center">
                                    <div class="form-control form-control-direction" style="text-align: center">
                                        <div class="wrap">
                                            <input
                                                type="checkbox"
                                                class="custom-checkbox"
                                                id="policy_iur"
                                                name="rule_iur"
                                                value="1"
                                                checked
                                            />
                                            <label for="policy_iur"
                                            >{{__('theme.agree-with')}}
                                                <a
                                                    data-fancybox
                                                    data-src="#rules-register-page"
                                                    data-touch="false"
                                                    href="javascript:;"
                                                >
                                                    {{__('theme.terms-of-use')}}
                                                </a></label
                                            >
                                        </div>
                                        @error('rule_iur')
                                        <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="block-botton">
                                    <button id="form_submit_iur" type="submit" class="btn">
                                        {{__('theme.sign-up')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        var tab; // заголовок вкладки
        var tabContent; // блок содержащий контент вкладки

        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);
        };

        document.getElementById('tabs').onclick = function (event) {
            var target = event.target;
            if (target.className == 'tab') {
                for (var i = 0; i < tab.length; i++) {
                    if (target == tab[i]) {
                        showTabsContent(i);
                        break;
                    }
                }
            }
        };

        function hideTabsContent(a) {
            for (var i = a; i < tabContent.length; i++) {
                tabContent[i].classList.remove('show');
                tabContent[i].classList.add('hide');
                tab[i].classList.remove('active');
            }
        }

        function showTabsContent(b) {
            if (tabContent[b].classList.contains('hide')) {
                hideTabsContent(0);
                tab[b].classList.add('active');
                tabContent[b].classList.remove('hide');
                tabContent[b].classList.add('show');
            }
        }
    </script>
@endsection
