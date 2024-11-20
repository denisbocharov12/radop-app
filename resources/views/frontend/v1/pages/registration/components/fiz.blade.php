<div class="tabContent">
    <form id="form-fiz-submit" action="{{route('user.registration.store')}}" method="POST">
        @csrf
        @php
            $userTypeFiz = \App\Models\UserType::where('key_name', 'fiz')->first();
        @endphp
        <input type="hidden" name="type_id" value="{{$userTypeFiz->id}}">
        <div class="form-content">
            <div class="left">
                <div class="form-control form-control-direction">
                    <input
                        class="@error('first_name') input-error-validation @enderror"
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
                        class="@error('last_name') input-error-validation @enderror"
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
                        class="@error('address_fiz') input-error-validation @enderror"
                        type="text"
                        name="address_fiz"
                        id="address_fiz"
                        placeholder="{{__('theme.address')}}"
                    />
                    @error('address_fiz')
                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                    @enderror
                </div>
            </div>
            <div class="right">
                <div class="form-control form-control-direction">
                    <input
                        class="@error('phone_fiz') input-error-validation @enderror"
                        type="text"
                        name="phone_fiz"
                        id="phone_fiz"
                        placeholder="{{__('theme.phone-number')}}"
                    />
                    @error('phone_fiz')
                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                    @enderror
                </div>
                <div class="form-control form-control-direction">
                    <input
                        type="email"
                        class="@error('email_fiz') input-error-validation @enderror"
                        name="email_fiz"
                        id="email_fiz"
                        placeholder="Email"
                    />
                    @error('email_fiz')
                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                    @enderror
                </div>
                <div class="form-control form-password form-control-direction">
                    <a href="#" class="qu eye eye_fiz"><i class="fa fa-eye-slash"></i></a>
                    <input
                        class="password @error('password_fiz') input-error-validation @enderror"
                        type="password"
                        name="password_fiz"
                        id="password_fiz"
                        placeholder="{{__('theme.password')}}"
                    />
                    @error('password_fiz')
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
