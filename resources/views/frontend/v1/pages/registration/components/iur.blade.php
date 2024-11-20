<div class="tabContent">
    <form id="form-iur-submit" action="{{route('user.registration.store')}}" method="POST">
        @csrf
        @php
            $userTypeIur = \App\Models\UserType::where('key_name', 'iur')->first();
        @endphp
        <input type="hidden" name="type_id" value="{{$userTypeIur->id}}">
        <div class="form-content">
            <div class="left">
                <div class="form-control form-control-direction">
                    <input
                        class="@error('organization_name') input-error-validation @enderror"
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
                        class="@error('address_iur') input-error-validation @enderror"
                        type="text"
                        name="address_iur"
                        id="address_iur"
                        placeholder="{{__('theme.address')}}"
                    />
                    @error('address_iur')
                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                    @enderror
                </div>
                <div class="form-control form-control-direction">
                    <input
                        class="@error('contact_name') input-error-validation @enderror"
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
                        class="@error('phone_iur') input-error-validation @enderror"
                        type="text"
                        name="phone_iur"
                        id="phone_iur"
                        placeholder="{{__('theme.phone-number')}}"
                    />
                    @error('phone_iur')
                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                    @enderror
                </div>
                <div class="form-control form-control-direction">
                    <input
                        type="email"
                        class="@error('email_iur') input-error-validation @enderror"
                        name="email_iur"
                        id="email_iur"
                        placeholder="Email"
                    />
                    @error('email_iur')
                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                    @enderror
                </div>
                <div class="form-control form-control-direction">
                    <input
                        class="@error('cod_fiscal') input-error-validation @enderror"
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
                        class="password @error('password_iur') input-error-validation @enderror"
                        type="password"
                        name="password_iur"
                        id="password_iur"
                        placeholder="{{__('theme.password')}}"
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
