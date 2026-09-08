{{--
    Utility bar — desktop only.
    Secondary navigation, contacts and the language switch, kept off the
    primary header row so the header itself has a single job: find and buy.
--}}
<div class="sf-topbar">
    <div class="sf-container flex items-center justify-between gap-6">
        <nav class="flex items-center gap-5" aria-label="{{ __('theme.navigation-menu') }}">
            <a href="{{ route('theme.about-us') }}" class="sf-topbar-link">{{ __('theme.about-us') }}</a>
            <a href="{{ route('theme.delivery.index') }}" class="sf-topbar-link">{{ __('theme.delivery') }}</a>
            <a href="{{ route('theme.order-guide.index') }}" class="sf-topbar-link">{{ __('theme.how-to-order') }}</a>
            <a href="{{ route('theme.contacts.index') }}" class="sf-topbar-link">{{ __('theme.contact') }}</a>
        </nav>

        <div class="flex items-center gap-5">
            <a href="tel:+37379782112" class="sf-topbar-link inline-flex items-center gap-1.5 font-medium text-ink-700">
                <x-sf-icon name="phone" :size="14" class="text-brand-600" />079 782 112
            </a>
            <a href="tel:+37322782112" class="sf-topbar-link hidden items-center gap-1.5 font-medium text-ink-700 xl:inline-flex">
                <x-sf-icon name="phone" :size="14" class="text-brand-600" />022 782 112
            </a>
            <a href="mailto:support@radop.md" class="sf-topbar-link hidden items-center gap-1.5 xl:inline-flex">
                <x-sf-icon name="mail" :size="14" class="text-brand-600" />support@radop.md
            </a>

            <div class="flex items-center gap-1" role="group" aria-label="Limba">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a
                        rel="alternate"
                        hreflang="{{ $localeCode }}"
                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                        @class([
                            'rounded px-1.5 py-0.5 text-2xs font-bold uppercase transition-colors',
                            'bg-brand-600 text-white' => LaravelLocalization::getCurrentLocale() === $localeCode,
                            'text-ink-500 hover:bg-ink-100 hover:text-ink-800' => LaravelLocalization::getCurrentLocale() !== $localeCode,
                        ])
                    >{{ $localeCode }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
