{{--
    Minimal storefront shell for HTTP error pages.

    Deliberately independent of the full layout: a 404 for an unmatched URL is
    rendered without the session middleware, so anything that touches the
    cart, the wishlist or the signed-in user would itself throw. This page
    only needs the design-system stylesheet, routes and translations.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="theme-color" content="#0068a7">
    <title>@yield('code') · Radop</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/storefront.css'])
</head>
<body class="flex min-h-screen flex-col bg-ink-50">
    <header class="border-b border-ink-200 bg-white">
        <div class="sf-container flex h-16 items-center justify-between gap-4 lg:h-20">
            <a href="{{ url('/') }}" aria-label="Radop" class="min-w-0"><x-sf-logo /></a>
            <div class="flex items-center gap-2 sm:gap-4">
                <a href="tel:+37379782112" class="sf-icon-btn sm:hidden" aria-label="079 782 112">
                    <x-sf-icon name="phone" :size="18" class="text-brand-600" />
                </a>
                <a href="tel:+37379782112" class="hidden items-center gap-2 text-sm font-medium text-ink-700 hover:text-brand-600 sm:inline-flex">
                    <x-sf-icon name="phone" :size="16" class="text-brand-600" />079 782 112
                </a>
                <a href="{{ url('/shop/catalog') }}" class="sf-btn-primary hidden h-10 px-4 text-sm md:inline-flex">
                    <x-sf-icon name="menu" :size="16" />{{ __('theme.header-catalog-text') }}
                </a>
            </div>
        </div>
    </header>

    <main class="sf-container flex flex-1 items-center justify-center py-8 sm:py-14">
        <div class="relative w-full max-w-xl overflow-hidden rounded-2xl border border-ink-200 bg-white px-5 py-9 text-center shadow-card sm:px-12 sm:py-12">
            {{-- Soft brand wash behind the code; decorative only. --}}
            <div class="pointer-events-none absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-brand-50 to-transparent" aria-hidden="true"></div>

            <div class="relative">
                <p class="bg-gradient-to-b from-brand-600 to-brand-300 bg-clip-text text-6xl font-extrabold leading-none tracking-tight text-transparent sm:text-8xl">@yield('code')</p>
                <h1 class="mt-4 text-xl font-bold text-ink-900 sm:mt-5 sm:text-3xl">@yield('title')</h1>
                <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-ink-600 sm:text-md">@yield('message')</p>

                @hasSection('search')
                    <form action="{{ url('/search') }}" method="GET" role="search" class="relative mx-auto mt-7 max-w-md">
                        <x-sf-icon name="search" :size="18" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-ink-400" />
                        <input
                            type="search"
                            name="search"
                            required
                            class="sf-field h-12 pl-10 pr-14 sm:pr-28"
                            placeholder="{{ __('theme.search-on-site') }}"
                            aria-label="{{ __('theme.search') }}"
                        >
                        <button type="submit" class="sf-btn-primary absolute right-1.5 top-1/2 h-9 -translate-y-1/2 px-3 text-sm sm:px-4" aria-label="{{ __('theme.search') }}">
                            <x-sf-icon name="search" :size="16" class="sm:hidden" />
                            <span class="hidden sm:inline">{{ __('theme.search') }}</span>
                        </button>
                    </form>
                @endif

                <div class="mt-6 grid gap-2 sm:flex sm:justify-center">
                    @yield('actions')
                </div>
            </div>
        </div>
    </main>

    <footer class="border-t border-ink-200 bg-white py-5">
        <div class="sf-container flex flex-col items-center justify-between gap-2 text-xs text-ink-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} Radop</p>
            <a href="mailto:support@radop.md" class="inline-flex items-center gap-1.5 hover:text-brand-600">
                <x-sf-icon name="mail" :size="14" />support@radop.md
            </a>
        </div>
    </footer>
</body>
</html>
