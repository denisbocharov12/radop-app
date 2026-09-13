@props([
    'title',
    'subtitle' => null,
])

@php
    /*
     * Customer area frame: breadcrumbs, heading, section navigation and the
     * page body. The navigation is a sidebar on desktop and a horizontally
     * scrolling tab strip on phones, where the legacy stacked list pushed the
     * actual content below the fold.
     */
    $user = auth()->guard('user')->user();
    $isBusiness = $user?->type?->key_name === 'iur';

    $sections = array_values(array_filter([
        ['theme.user.orders.*', route('theme.user.orders.index'), 'receipt', __('theme.my-orders')],
        $isBusiness ? ['theme.user.filial.*', route('theme.user.filial.index'), 'building', __('theme.filials')] : null,
        ['theme.user.coupon.*', route('theme.user.coupon.index'), 'star', __('theme.my-sale')],
        ['theme.user.account.*', route('theme.user.account.index'), 'user', __('theme.account')],
    ]));

    // Nested ternaries with `?:` must be parenthesised on PHP 8, so this is
    // spelled out rather than chained.
    $displayName = '';
    if ($user) {
        $fullName = trim(($user->profile->first_name ?? '') . ' ' . ($user->profile->last_name ?? ''));
        $displayName = $isBusiness
            ? ($user->profile->organization_name ?: $user->email)
            : ($fullName !== '' ? $fullName : $user->email);
    }
@endphp

<x-sf-breadcrumbs :with-shop="false" :items="[['url' => route('theme.user.orders.index'), 'name' => __('theme.my-account')], ['url' => null, 'name' => $title]]" />

<div class="sf-container pb-16">
    <div class="grid gap-6 lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-8">
        <aside class="min-w-0">
            <div class="mb-4 hidden items-center gap-3 lg:flex">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-600 text-md font-bold uppercase text-white">
                    {{ mb_substr($displayName, 0, 1) }}
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-ink-900">{{ $displayName }}</p>
                    <p class="truncate text-xs text-ink-500">{{ $user?->email }}</p>
                </div>
            </div>

            <nav
                class="sf-scrollbar-none -mx-[var(--sf-gutter)] flex gap-2 overflow-x-auto px-[var(--sf-gutter)] pb-1 lg:mx-0 lg:flex-col lg:gap-0.5 lg:overflow-visible lg:px-0"
                aria-label="{{ __('theme.my-account') }}"
            >
                @foreach($sections as [$pattern, $url, $icon, $label])
                    @php($active = request()->routeIs($pattern))
                    <a
                        href="{{ $url }}"
                        @class([
                            'flex shrink-0 items-center gap-2.5 whitespace-nowrap rounded-md px-3 py-2.5 text-sm font-medium transition-colors',
                            'bg-brand-600 text-white lg:bg-brand-50 lg:text-brand-700' => $active,
                            'border border-ink-200 text-ink-700 hover:bg-ink-50 lg:border-transparent' => ! $active,
                        ])
                        @if($active) aria-current="page" @endif
                    >
                        <x-sf-icon :name="$icon" :size="17" />{{ $label }}
                    </a>
                @endforeach

                <a
                    href="{{ route('theme.user.logout') }}"
                    class="flex shrink-0 items-center gap-2.5 whitespace-nowrap rounded-md border border-ink-200 px-3 py-2.5 text-sm font-medium text-ink-600 transition-colors hover:bg-danger-50 hover:text-danger-600 lg:mt-2 lg:border-transparent lg:border-t-ink-100"
                >
                    <x-sf-icon name="logout" :size="17" />{{ __('theme.logout') }}
                </a>
            </nav>
        </aside>

        <section class="min-w-0">
            <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-ink-900">{{ $title }}</h1>
                    @if($subtitle)
                        <p class="mt-1 text-sm text-ink-500">{{ $subtitle }}</p>
                    @endif
                </div>
                {{ $actions ?? '' }}
            </div>

            {{-- Success flashes (profile / password saved) were set by the
                 controllers but never rendered by the legacy templates. --}}
            @if(session('success'))
                <p class="mb-4 flex items-start gap-2 rounded-lg border border-success-500/30 bg-success-50 p-3 text-sm text-success-600" role="status">
                    <x-sf-icon name="check" :size="16" class="mt-0.5" />{{ session('success') }}
                </p>
            @endif

            {{ $slot }}
        </section>
    </div>
</div>
