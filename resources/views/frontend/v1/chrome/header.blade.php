@php
    $user = Auth::guard('user')->user();

    $cartSession = config('shopping_cart.default_session_id');
    if ($user) {
        $cartSession = $user->id;
    }
    $cartTotal = \Cart::session($cartSession)->getTotal();
    // Distinct lines, not units — this is what addToCart returns as
    // `cart_count`, so the badge stays consistent after an AJAX update.
    $cartCount = \Cart::session($cartSession)->getContent()->count();

    $locales = collect(LaravelLocalization::getSupportedLocales())
        ->map(fn ($props, $code) => [
            'code' => strtoupper($code),
            'url' => LaravelLocalization::getLocalizedURL($code, null, [], true),
            'active' => LaravelLocalization::getCurrentLocale() === $code,
        ])
        ->values();

    // Burger menu sections: the old mobile "Other" tab's shop, company and
    // information pages.
    $mobileGroups = [
        [
            'title' => __('theme.sf-shop'),
            'links' => [
                ['label' => __('theme.show-all-categories'), 'url' => route('theme.shop.catalog')],
                ['label' => __('theme.new-products'), 'url' => route('theme.shop.new')],
                ['label' => __('theme.popular-products'), 'url' => route('theme.shop.popular')],
                ['label' => __('theme.on-discount'), 'url' => route('theme.shop.sale')],
                ['label' => __('theme.home-brands'), 'url' => route('theme.brand.catalog')],
            ],
        ],
        [
            'title' => __('theme.sf-company'),
            'links' => [
                ['label' => __('theme.about-us'), 'url' => route('theme.about-us')],
                ['label' => __('theme.delivery'), 'url' => route('theme.delivery.index')],
                ['label' => __('theme.how-to-order'), 'url' => route('theme.order-guide.index')],
                ['label' => __('theme.contact'), 'url' => route('theme.contacts.index')],
            ],
        ],
        [
            'title' => __('theme.information'),
            'links' => [
                ['label' => __('theme.terms-of-use'), 'url' => route('theme.terms-and-conditions.index')],
                ['label' => __('theme.privacy-policy'), 'url' => route('theme.privacy-policy.index')],
                ['label' => __('theme.cookie'), 'url' => route('theme.cookie.index')],
                ['label' => __('theme.return_and_exchange_products'), 'url' => route('theme.return-rules.index')],
            ],
        ],
    ];

    // Island props are encoded here rather than inline: Blade's @json directive
    // cannot parse a multi-line array literal inside an attribute.
    $sfProps = static fn (array $data): string => json_encode(
        $data,
        JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
    );

    $searchProps = $sfProps([
        'action' => route('theme.search.index'),
        'value' => (string) (request('search') ?? request('filter.search') ?? ''),
        'placeholder' => __('theme.search-on-site'),
    ]);

    $megaProps = $sfProps([
        'code' => 'main_menu',
        'label' => __('theme.header-catalog-text'),
    ]);

    $mobileNavProps = $sfProps([
        'code' => 'main_menu',
        'label' => __('theme.header-catalog-text'),
        'groups' => $mobileGroups,
        'account' => [
            'authenticated' => $user !== null,
            'url' => route('theme.user.orders.index'),
            'label' => __('theme.account_text'),
            'signInLabel' => __('theme.login_register'),
        ],
        'locales' => $locales,
        'phones' => ['079 782 112', '022 782 112'],
        'email' => 'support@radop.md',
        't' => [
            'menu' => __('theme.sf-menu'),
            'close' => __('theme.notification_close_btn_text'),
            'back' => __('theme.sf-back'),
            'viewAll' => __('theme.view-all'),
        ],
    ]);
@endphp

<header class="sf-header transition-shadow duration-200" data-sf-header>
    <div class="sf-container">
        <div class="sf-header-row">
            {{-- Mobile: catalogue drawer. The wrapper itself must be hidden on
                 desktop, not just the component inside it, or the row's `gap`
                 still reserves space and the logo sits out of line with the
                 container below it. --}}
            <div
                class="lg:hidden"
                data-sf-island="mobile-nav"
                data-sf-props="{{ $mobileNavProps }}"
                v-cloak
            ></div>

            {{-- Logo --}}
            <a href="{{ route('theme.home') }}" class="shrink-0 rounded-md" aria-label="Radop — {{ __('theme.home') }}">
                <x-sf-logo />
            </a>

            {{-- Catalogue + mega menu --}}
            <div
                class="hidden lg:block"
                data-sf-island="mega-menu"
                data-sf-props="{{ $megaProps }}"
                v-cloak
            ></div>

            {{-- Search (desktop) --}}
            <div class="hidden min-w-0 flex-1 lg:block">
                <div
                    data-sf-island="site-search"
                    data-sf-props="{{ $searchProps }}"
                    v-cloak
                >
                    {{-- Server-rendered fallback: search keeps working without JS. --}}
                    <noscript>
                        <form action="{{ route('theme.search.index') }}" method="GET" class="flex gap-2">
                            <input type="search" name="search" class="sf-field h-11" placeholder="{{ __('theme.search-on-site') }}" />
                            <button type="submit" class="sf-btn-primary">{{ __('theme.search') }}</button>
                        </form>
                    </noscript>
                </div>
            </div>

            {{-- Actions --}}
            <div class="ml-auto flex items-center gap-0.5 lg:gap-1">
                <a
                    href="{{ route('theme.wishlist.index') }}"
                    class="sf-icon-btn hidden h-11 w-11 lg:inline-flex"
                    aria-label="{{ __('theme.wishlist') }}"
                >
                    <x-sf-icon name="heart" :size="21" />
                </a>

                @if($user)
                    <div class="group relative hidden lg:block">
                        <a href="{{ route('theme.user.orders.index') }}" class="sf-icon-btn h-11 w-auto gap-2 px-3">
                            <x-sf-icon name="user" :size="21" />
                            <span class="max-w-[9rem] truncate text-sm font-medium">
                                {{ $user->type->key_name === 'fiz'
                                    ? $user->profile->first_name . ' ' . $user->profile->last_name
                                    : $user->profile->organization_name }}
                            </span>
                            <x-sf-icon name="chevronDown" :size="14" class="text-ink-400" />
                        </a>
                        <div class="invisible absolute right-0 top-full z-menu w-56 translate-y-1 rounded-lg border border-ink-200 bg-white p-1.5 opacity-0 shadow-pop transition-all duration-150 ease-sf group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                            <a href="{{ route('theme.user.orders.index') }}" class="flex items-center gap-2.5 rounded px-3 py-2 text-sm text-ink-700 hover:bg-ink-50 hover:text-brand-600">
                                <x-sf-icon name="receipt" :size="16" />{{ __('theme.my-orders') }}
                            </a>
                            @if($user->type->key_name === 'iur')
                                <a href="{{ route('theme.user.filial.index') }}" class="flex items-center gap-2.5 rounded px-3 py-2 text-sm text-ink-700 hover:bg-ink-50 hover:text-brand-600">
                                    <x-sf-icon name="building" :size="16" />{{ __('theme.filials') }}
                                </a>
                            @endif
                            <a href="{{ route('theme.user.account.index') }}" class="flex items-center gap-2.5 rounded px-3 py-2 text-sm text-ink-700 hover:bg-ink-50 hover:text-brand-600">
                                <x-sf-icon name="user" :size="16" />{{ __('theme.account') }}
                            </a>
                            <div class="my-1 h-px bg-ink-100"></div>
                            <a href="{{ route('theme.user.logout') }}" class="flex items-center gap-2.5 rounded px-3 py-2 text-sm text-ink-600 hover:bg-danger-50 hover:text-danger-600">
                                <x-sf-icon name="logout" :size="16" />{{ __('theme.logout') }}
                            </a>
                        </div>
                    </div>
                @else
                    <a
                        href="javascript:;"
                        data-sf-auth-open
                        class="sf-icon-btn h-11 w-auto gap-2 px-3"
                        aria-label="{{ __('theme.log-in-account') }}"
                    >
                        <x-sf-icon name="user" :size="21" />
                        <span class="hidden text-sm font-medium xl:inline">{{ __('theme.log-in-account') }}</span>
                    </a>
                @endif

                {{-- Basket link + hover preview (MiniCart.vue). The server-rendered
                     link is the pre-hydration and no-JS state. --}}
                <div
                    class="ml-1"
                    data-sf-island="mini-cart"
                    data-sf-props="{{ $sfProps([
                        'count' => $cartCount,
                        'total' => number_format($cartTotal, 2, ',', ''),
                        'authenticated' => $user !== null,
                    ]) }}"
                >
                    <a
                        href="{{ route('theme.cart.index') }}"
                        class="relative inline-flex h-11 items-center gap-2.5 rounded-md bg-brand-50 px-3 text-brand-700 sm:px-3.5"
                        aria-label="{{ __('theme.cart') }}"
                    >
                        <x-sf-icon name="cart" :size="21" />
                        <span class="hidden whitespace-nowrap text-sm font-bold sm:inline">
                            {{ number_format($cartTotal, 2, ',', '') }} {{ __('theme.MDL') }}
                        </span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Search (mobile) --}}
        <div class="pb-3 lg:hidden">
            <div
                data-sf-island="site-search"
                data-sf-props="{{ $searchProps }}"
                v-cloak
            ></div>
        </div>
    </div>
</header>
