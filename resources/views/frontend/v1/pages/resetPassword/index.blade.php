@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="reset-password" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="reset-password__title title">{{ __('theme.reset-password') }}</h1>
            <div class="reset-password__wrapper">
                <div class="reset-password__form">
                    <form action="{{ route('theme.passwords.reset') }}" method="POST">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <label for="email" style="margin-bottom: 4px">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required
                                   placeholder="Email"
                                   value="{{ old('email') }}" autofocus>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" style="margin-bottom: 4px">{{ __('theme.new-password') }}</label>
                            <input type="password" id="password" name="password" class="form-control" required
                                   placeholder="{{ __('theme.enter-new-password') }}">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" style="margin-bottom: 4px">{{ __('theme.confirm-password') }}</label>
                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" required
                                   placeholder="{{ __('theme.confirm-new-password') }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-3">{{ __('theme.reset-password-button') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
