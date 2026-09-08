@php
    $user = auth()->guard('user')->user();

    $authProps = json_encode([
        'loginAction' => route('user.login'),
        'forgotAction' => route('theme.passwords.forget'),
        'registerUrl' => route('user.registration.index'),
        'logo' => asset('/v1/frontend/assets') . '/images/logo.svg',
        'csrf' => csrf_token(),
        't' => [
            'signIn' => __('theme.log-in-account'),
            'password' => __('theme.password'),
            'enter' => __('theme.enter'),
            'or' => __('theme.or'),
            'register' => __('theme.registration'),
            'forgot' => __('theme.forget-password'),
            'recovery' => __('theme.password-recovery'),
            'recoveryHint' => __('theme.password-recovery-enter-email'),
            'send' => __('theme.send'),
            'close' => __('theme.notification_close_btn_text'),
        ],
    ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
@endphp

{{--
    Anything on the page can open this dialog with `data-sf-auth-open`
    (or `data-sf-auth-open="forgot"`); the basket's checkout button keeps its
    legacy `.cart-auth-modal-btn` hook, which the component also listens for.
    Signed-in visitors have the account menu in the header, so no dialog is
    rendered for them.
--}}
@unless($user)
    <div data-sf-island="auth-modal" data-sf-props="{{ $authProps }}" v-cloak></div>
@endunless
