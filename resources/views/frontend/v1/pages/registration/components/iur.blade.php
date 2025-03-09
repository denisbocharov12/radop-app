<div class="row">
    <div class="col-12 col-register-wrap">
        <div id="tabs">
        <form id="form-iur-submit" action="{{route('user.registration.store')}}" method="POST">
        @csrf
        @php
            $userTypeIur = \App\Models\UserType::where('key_name', 'iur')->first();
        @endphp
        <input type="hidden" name="type_id" value="{{$userTypeIur->id}}">
        <div class="form-content">
            <div class="left">
                <div class="form-control form-control-direction">
                    <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                        <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v12h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm9 12V2H4v12h2v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h2zm-3 0v-3H7v3h2zm-4-9h1V4H5v1zm0 2h1V6H5v1zm0 2h1V8H5v1zm6-4h-1V4h1v1zm-1 2h1V6h-1v1zm1 2h-1V8h1v1z"/>
                    </svg>
                    <input
                        class="@error('organization_name') input-error-validation @enderror"
                        type="text"
                        name="organization_name"
                        id="organization_name"
                        value="{{old('organization_name')}}"
                        placeholder="{{__('theme.company-name')}}"
                        required
                    />
                    @error('organization_name')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-control form-control-direction">
                    <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                        <path d="M8 16s6-5.33 6-10A6 6 0 0 0 2 6c0 4.67 6 10 6 10zm0-12a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/>
                    </svg>
                    <input
                        class="@error('address_iur') input-error-validation @enderror"
                        type="text"
                        name="address_iur"
                        id="address_iur"
                        value="{{old('address_iur')}}"
                        placeholder="{{__('theme.address')}}"
                        required
                    />
                    @error('address_iur')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-control form-control-direction">
                    <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm4.5 1h-9A3.5 3.5 0 0 0 0 12.5V14h16v-1.5A3.5 3.5 0 0 0 12.5 9z"/>
                    </svg>
                    <input
                        class="@error('contact_name') input-error-validation @enderror"
                        type="text"
                        name="contact_name"
                        id="contact_name"
                        value="{{old('contact_name')}}"
                        placeholder="{{__('theme.contact-person')}}"
                        required
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
                    <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 1 .724-.166l2.59.969c.28.105.471.35.515.646l.417 2.974a.678.678 0 0 1-.19.562l-1.099 1.1a10.97 10.97 0 0 0 4.797 4.797l1.1-1.1a.678.678 0 0 1 .562-.19l2.974.417c.297.044.54.235.646.515l.969 2.59a.678.678 0 0 1-.166.724l-2.086 2.087a.678.678 0 0 1-.67.164c-2.017-.601-5.043-2.116-7.519-4.593S1.503 6.361.902 4.344a.678.678 0 0 1 .164-.67L3.654 1.328z"/>
                    </svg>
                    <input
                        class="@error('phone_iur') input-error-validation @enderror"
                        type="text"
                        name="phone_iur"
                        id="phone_iur"
                        value="{{old('phone_iur')}}"
                        placeholder="{{__('theme.phone-number')}}"
                        required
                    />
                    @error('phone_iur')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-control form-control-direction">
                    <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                        <path d="M14.5 2h-13A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zM1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v.4L8 8.2 1 3.9v-.4zm13 9H1.5a.5.5 0 0 1-.5-.5V5.2l7 4.4 7-4.4v6.8a.5.5 0 0 1-.5.5z"/>
                    </svg>
                    <input
                        type="email"
                        class="@error('email_iur') input-error-validation @enderror"
                        name="email_iur"
                        id="email_iur"
                        placeholder="Email"
                        value="{{old('email_iur')}}"
                        required
                    />
                    @error('email_iur')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-control form-control-direction">
                    <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                        <path d="M1 4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h12V4a1 1 0 0 0-1-1H3zm12 3H2v6a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V6zM3 10h2v2H3v-2zm4 0h2v2H7v-2zm4 0h2v2h-2v-2z"/>
                    </svg>
                    <input
                        class="@error('cod_fiscal') input-error-validation @enderror"
                        type="text"
                        name="cod_fiscal"
                        id="cod_fiscal"
                        value="{{old('cod_fiscal')}}"
                        placeholder="{{__('theme.fiscal-code')}}"
                        required
                    />
                    @error('cod_fiscal')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-control form-password form-control-direction">
                    <a href="#" class="qu eye eye_iur"><i class="fa fa-eye-slash"></i></a>
                    <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                        <path d="M8 1a3 3 0 0 1 3 3v2h1a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h1V4a3 3 0 0 1 3-3zm0 2a1 1 0 0 0-1 1v2h2V4a1 1 0 0 0-1-1zm4 5H4v5h8V8z"/>
                    </svg>
                    <input
                        class="password @error('password_iur') input-error-validation @enderror"
                        type="password"
                        name="password_iur"
                        id="password_iur"
                        value="{{old('password_iur')}}"
                        placeholder="{{__('theme.password')}}"
                        required
                    />
                    @error('password_iur')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="center">
            <div class="form-control form-control-direction" style="text-align: center">
                <ul class="password-rules">
                    <li id="length-rule" class="rule">❌ {{__('theme.password-rule-length')}}</li>
                    <li id="uppercase-rule" class="rule">❌ {{__('theme.password-rule-uppercase-letter')}}</li>
                    <li id="symbol-rule" class="rule">❌ {{__('theme.password-rule-special-symbols')}}</li>
                </ul>
                <div class="wrap">
                    <input
                        type="checkbox"
                        class="custom-checkbox rule-checkbox"
                        id="terms"
                        name="terms"
                        value="1"
                    />
                    <label for="policy_iur">
                        {{__('theme.agree-with')}}
                        <a
                            data-fancybox
                            data-src="#rules-register-page"
                            data-touch="false"
                            href="javascript:;"
                        >
                            {{__('theme.terms-of-use')}}
                        </a>
                        <p>{{__('theme.and')}}</p>
                        <a
                            data-fancybox
                            data-src="#rules-register-page"
                            data-touch="false"
                            href="javascript:;"
                        >
                            {{__('theme.refund-policy')}}
                        </a>
                    </label>
                </div>
                <div class="wrap">
                    <input
                            type="checkbox"
                            class="custom-checkbox rule-checkbox"
                            id="data_processing"
                            name="data_processing"
                            value="1"
                    />
                    <label for="data_processing">
                        {{__('theme.personal-data-processing')}}
                    </label>
                </div>
                <div class="wrap">
                    <input
                            type="checkbox"
                            class="custom-checkbox"
                            id="newsletter"
                            name="newsletter"
                            value="1"
                    />
                    <label for="newsletter">
                        {{__('theme.newsletter-of-discounts')}}
                    </label>
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
