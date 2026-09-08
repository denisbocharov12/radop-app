@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <div class="sf-container flex justify-center py-12 lg:py-20">
        <div class="sf-card w-full max-w-sm p-6">
            <h1 class="mb-6 text-center text-lg font-bold text-ink-900">{{ __('theme.reset-password') }}</h1>

            <form action="{{ route('theme.passwords.reset') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <label class="block">
                    <span class="sf-label">Email</span>
                    <input
                        type="email"
                        name="email"
                        class="sf-field @error('email') sf-field-error @enderror"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        autofocus
                    />
                    @error('email')<span class="sf-error">{{ $message }}</span>@enderror
                </label>

                <label class="block">
                    <span class="sf-label">{{ __('theme.new-password') }}</span>
                    <input
                        type="password"
                        name="password"
                        class="sf-field @error('password') sf-field-error @enderror"
                        placeholder="{{ __('theme.enter-new-password') }}"
                        autocomplete="new-password"
                        required
                    />
                    @error('password')<span class="sf-error">{{ $message }}</span>@enderror
                </label>

                <label class="block">
                    <span class="sf-label">{{ __('theme.confirm-password') }}</span>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="sf-field"
                        placeholder="{{ __('theme.confirm-new-password') }}"
                        autocomplete="new-password"
                        required
                    />
                </label>

                <button type="submit" class="sf-btn-primary sf-btn-block sf-btn-lg">
                    {{ __('theme.reset-password-button') }}
                </button>
            </form>
        </div>
    </div>
@endsection
