@php
    $user = auth()->guard('user')->user();

    $authProps = json_encode([
        'loginAction' => route('user.login'),
        'forgotAction' => route('theme.passwords.forget'),
        'registerUrl' => route('user.registration.index'),
        'redirectUrl' => route('theme.user.orders.index'),
        'logo' => asset('/v1/frontend/assets') . '/images/logo.svg',
        't' => [
            'signIn' => __('theme.log-in-account'),
            'password' => __('theme.password'),
            'enter' => __('theme.enter'),
            'or' => __('theme.or'),
            'register' => __('theme.registration'),
            'forgot' => __('theme.forget-password'),
            'recovery' => __('theme.password-recovery'),
            'recoveryHint' => __('theme.password-recovery-enter-email'),
            'recoverySent' => __('theme.password-recovery-sent'),
            'send' => __('theme.send'),
            'close' => __('theme.notification_close_btn_text'),
            'loginError' => __('theme.login-error'),
            'genericError' => __('theme.error-message'),
        ],
    ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
@endphp

{{--
    Anything on the page can open this dialog with `data-sf-auth-open`
    (or `data-sf-auth-open="forgot"`, or `?auth=login` in the URL); the
    basket's checkout button keeps its legacy `.cart-auth-modal-btn` hook.
    Signed-in visitors reach their account from the header and the bottom
    bar, so no dialog is rendered for them.
--}}
@unless($user)
    <div data-sf-island="auth-modal" data-sf-props="{{ $authProps }}" v-cloak></div>
@endunless
