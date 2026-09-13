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
        <div class="sf-container flex h-16 items-center justify-between gap-4">
            <a href="{{ url('/') }}" aria-label="Radop"><x-sf-logo /></a>
            <a href="tel:+37379782112" class="hidden items-center gap-2 text-sm font-medium text-ink-700 hover:text-brand-600 sm:inline-flex">
                <x-sf-icon name="phone" :size="16" class="text-brand-600" />079 782 112
            </a>
        </div>
    </header>

    <main class="sf-container flex flex-1 items-center justify-center py-12">
        <div class="w-full max-w-lg text-center">
            <p class="text-7xl font-extrabold leading-none tracking-tight text-brand-600/15 sm:text-8xl">@yield('code')</p>
            <h1 class="-mt-6 text-2xl font-bold text-ink-900 sm:-mt-8 sm:text-3xl">@yield('title')</h1>
            <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-ink-600">@yield('message')</p>

            @hasSection('search')
                <form action="{{ url('/search') }}" method="GET" role="search" class="relative mx-auto mt-7 max-w-md">
                    <input type="search" name="search" class="sf-field h-12 pl-11 pr-28" placeholder="{{ __('theme.search-on-site') }}" aria-label="{{ __('theme.search') }}">
                    <x-sf-icon name="search" :size="18" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-ink-400" />
                    <button type="submit" class="sf-btn-primary absolute right-1.5 top-1/2 h-9 -translate-y-1/2 px-4 text-sm">{{ __('theme.search') }}</button>
                </form>
            @endif

            <div class="mt-7 flex flex-col justify-center gap-2 sm:flex-row">
                @yield('actions')
            </div>
        </div>
    </main>

    <footer class="border-t border-ink-200 bg-white py-5">
        <p class="sf-container text-center text-xs text-ink-500">
            &copy; {{ date('Y') }} Radop · <a href="mailto:support@radop.md" class="hover:text-brand-600">support@radop.md</a>
        </p>
    </footer>
</body>
</html>
