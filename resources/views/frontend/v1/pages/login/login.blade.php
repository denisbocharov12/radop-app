@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <div class="sf-container flex justify-center pt-8 lg:pt-12">
        <div class="sf-card w-full max-w-sm p-6">
            <img
                src="{{ asset('/v1/frontend/assets') }}/images/logo.svg"
                alt="Radop"
                class="mx-auto mb-4 h-12 w-auto"
            />
            <h1 class="mb-6 text-center text-lg font-bold text-ink-900">{{ __('theme.log-in-account') }}</h1>

            <p id="auth-response" class="mb-3 hidden rounded-md bg-danger-50 p-3 text-sm text-danger-600"></p>

            <form id="loginForm" method="POST" action="{{ route('user.login') }}" class="space-y-3">
                @csrf

                <label class="block">
                    <span class="sf-label">Email</span>
                    <input type="text" id="username" name="username" class="sf-field" required autocomplete="username" />
                </label>

                <label class="block">
                    <span class="sf-label">{{ __('theme.password') }}</span>
                    <input type="password" id="password" name="password" class="sf-field" required autocomplete="current-password" />
                </label>

                <button type="submit" class="sf-btn-primary sf-btn-block sf-btn-lg">{{ __('theme.enter') }}</button>
            </form>

            <p class="mt-5 text-center text-sm text-ink-500">
                <a href="{{ route('user.registration.index') }}" class="font-medium text-brand-600 hover:text-brand-700">
                    {{ __('theme.registration') }}
                </a>
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            var box = document.getElementById('auth-response');
            var fail = function (message) {
                box.textContent = message;
                box.hidden = false;
                box.classList.remove('hidden');
            };

            try {
                var response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                var result = await response.json();

                if (!result.status) {
                    fail(@json(__('theme.login-error')));
                    return;
                }

                var keys = window.radopAnalyticsJsonPayloadKeys || {};
                var loginKey = keys.customer_account_login_succeeded;
                if (loginKey && result[loginKey]
                    && typeof window.radopGa4EventPush === 'function'
                    && window.radopAnalyticsDataLayerEventNames) {
                    window.radopGa4EventPush(
                        window.radopAnalyticsDataLayerEventNames.customer_account_login_succeeded,
                        result[loginKey]
                    );
                }

                window.location.href = '/orders';
            } catch (error) {
                fail(@json(__('theme.error-message')));
            }
        });
    </script>
@endsection
