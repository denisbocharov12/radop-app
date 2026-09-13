<footer class="mt-12 border-t border-ink-200 bg-ink-50">
    {{-- Trust strip: the four things a B2B/B2C stationery buyer checks first. --}}
    <div class="border-b border-ink-200 bg-white">
        <div class="sf-container grid grid-cols-2 gap-4 py-6 lg:grid-cols-4 lg:gap-6">
            @foreach([
                ['truck',  __('theme.footer_usp_delivery_title'),  __('theme.footer_usp_delivery_text')],
                ['box',    __('theme.footer_usp_assortment_title'), __('theme.footer_usp_assortment_text')],
                ['shield', __('theme.footer_usp_quality_title'),   __('theme.footer_usp_quality_text')],
                ['phone',  __('theme.footer_usp_support_title'),   __('theme.footer_usp_support_text')],
            ] as [$icon, $title, $text])
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                        <x-sf-icon :name="$icon" :size="20" />
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-ink-900">{{ $title }}</p>
                        <p class="mt-0.5 text-xs text-ink-500">{{ $text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="sf-container grid gap-8 py-10 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <a href="{{ route('theme.home') }}" class="mb-4 inline-block" aria-label="Radop">
                <x-sf-logo variant="footer" />
            </a>
            <p class="text-sm leading-relaxed text-ink-600">{{ __('theme.footer_site_desc') }}</p>
            <address class="mt-4 space-y-2 text-sm not-italic text-ink-600">
                <p>{{ __('theme.footer_info_address') }}</p>
                <a href="tel:+37379782112" class="flex items-center gap-2 font-medium text-ink-800 hover:text-brand-600">
                    <x-sf-icon name="phone" :size="15" class="text-brand-600" />079 782 112
                </a>
                <a href="tel:+37322782112" class="flex items-center gap-2 font-medium text-ink-800 hover:text-brand-600">
                    <x-sf-icon name="phone" :size="15" class="text-brand-600" />022 782 112
                </a>
                <a href="mailto:support@radop.md" class="flex items-center gap-2 hover:text-brand-600">
                    <x-sf-icon name="mail" :size="15" class="text-brand-600" />support@radop.md
                </a>
            </address>
        </div>

        @foreach([
            [__('theme.footer_catalog_title'), [
                [__('theme.header-catalog-text'), route('theme.shop.catalog')],
                [__('theme.popular-products'), route('theme.shop.popular')],
                [__('theme.new-products'), route('theme.shop.new')],
                [__('theme.promotion'), route('theme.shop.sale')],
                [__('theme.brands-catalog'), route('theme.brand.catalog')],
            ]],
            [__('theme.about-company'), [
                [__('theme.about-us'), route('theme.about-us')],
                [__('theme.contact'), route('theme.contacts.index')],
                [__('theme.footer_terms_and_conditions'), route('theme.delivery.index')],
            ]],
            [__('theme.information'), [
                [__('theme.how-to-order'), route('theme.order-guide.index')],
                [__('theme.conditions-of-use'), route('theme.terms-and-conditions.index')],
                [__('theme.confidentiality-policy'), route('theme.privacy-policy.index')],
                [__('theme.cookie'), route('theme.cookie.index')],
                [__('theme.return_and_exchange_products'), route('theme.return-rules.index')],
            ]],
        ] as [$title, $links])
            <nav aria-label="{{ $title }}">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wide text-ink-900">{{ $title }}</h2>
                <ul class="space-y-2">
                    @foreach($links as [$label, $url])
                        <li><a href="{{ $url }}" class="text-sm text-ink-600 hover:text-brand-600">{{ $label }}</a></li>
                    @endforeach
                    @if($loop->last)
                        {{-- Reopens the cookie consent manager (resets the stored
                             choice). Ported from the legacy footer. --}}
                        <li class="sf-cookie-settings">
                            @cookieconsentbutton('reset', __('theme.cookie_settings'), ['class' => 'sf-cookie-settings-form'])
                        </li>
                    @endif
                </ul>
            </nav>
        @endforeach
    </div>

    <div class="border-t border-ink-200">
        <div class="sf-container flex flex-col items-center justify-between gap-3 py-5 text-xs text-ink-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} Radop. {{ __('theme.all-rights-reserved-according-to') }}</p>
            <button
                type="button"
                class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1.5 hover:bg-ink-100 hover:text-ink-800"
                onclick="window.scrollTo({top:0,behavior:'smooth'})"
            >
                <x-sf-icon name="chevronUp" :size="14" />{{ __('theme.scroll_to_top_btn') }}
            </button>
        </div>
    </div>
</footer>

@include('frontend.v1.components.auth')
