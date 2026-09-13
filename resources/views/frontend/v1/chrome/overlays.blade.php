@php
    /*
     * Page-level islands shared by every storefront layout: the quick-view
     * dialog and the mobile tab bar. Kept in one partial so both layouts
     * (with and without the error banner) stay identical.
     */
    $sfUser = auth()->guard('user')->user();
    $sfCartSession = $sfUser ? $sfUser->id : config('shopping_cart.default_session_id');

    $sfActiveTab = match (true) {
        request()->routeIs('theme.home') => 'home',
        request()->routeIs('theme.wishlist.*') => 'wishlist',
        request()->routeIs('theme.cart.*', 'theme.checkout.*') => 'cart',
        request()->routeIs('theme.user.*', 'user.*') => 'account',
        default => '',
    };

    $sfBottomNavProps = json_encode([
        'homeUrl' => route('theme.home'),
        'wishlistUrl' => route('theme.wishlist.index'),
        'accountUrl' => route('theme.user.orders.index'),
        'authenticated' => $sfUser !== null,
        'cartCount' => \Cart::session($sfCartSession)->getContent()->count(),
        'wishlistCount' => app('wishlist')->getContent()->count(),
        'active' => $sfActiveTab,
        't' => [
            'menu' => __('theme.sf-menu'),
            'home' => __('theme.on-homepage'),
            'catalog' => __('theme.header-catalog-text'),
            'wishlist' => __('theme.wishlist'),
            'cart' => __('theme.cart'),
            'account' => __('theme.account'),
            'signIn' => __('theme.log-in-account'),
        ],
    ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
@endphp

<div data-sf-island="quick-view"></div>
<div data-sf-island="bottom-nav" data-sf-props="{{ $sfBottomNavProps }}"></div>
