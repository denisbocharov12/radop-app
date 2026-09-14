@props([
    'brands',
    'title' => null,
    /** Milliseconds between automatic advances; 0 disables autoplay. */
    'autoplay' => 3500,
])

{{--
    Brand logos as a slider: native scroll-snap (swipe on touch), prev/next
    buttons and gentle autoplay driven by the `[data-sf-rail]` helper in
    storefront/lib/vitals.js. Autoplay pauses on hover, focus and touch and is
    off for visitors who prefer reduced motion.

    A brand without a logo — or whose logo fails to load — shows its name
    instead of a broken-image icon.
--}}
@if(! empty($brands) && count($brands))
    <section {{ $attributes->merge(['class' => 'sf-section']) }}>
        <div class="sf-container" data-sf-rail data-sf-rail-autoplay="{{ (int) $autoplay }}">
            <div class="sf-section-head">
                <h2 class="sf-section-title">
                    <a href="{{ route('theme.brand.catalog') }}" class="hover:text-brand-600">{{ $title ?? __('theme.home-brands') }}</a>
                </h2>
                <div class="flex items-center gap-2">
                    <a href="{{ route('theme.brand.catalog') }}" class="sf-section-link">{{ __('theme.view-all') }}</a>
                    <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 sm:inline-flex" data-sf-rail-prev aria-label="←">
                        <x-sf-icon name="chevronLeft" :size="16" />
                    </button>
                    <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 sm:inline-flex" data-sf-rail-next aria-label="→">
                        <x-sf-icon name="chevronRight" :size="16" />
                    </button>
                </div>
            </div>

            <ul class="sf-rail sf-rail-brands" role="list">
                @foreach($brands as $brand)
                    @php($logo = $brand->getFirstMediaUrl('media', 'thumb'))
                    <li>
                        <a
                            href="{{ route('theme.brand.index', $brand->onec_id) }}"
                            class="group/brand flex h-24 items-center justify-center rounded-lg border border-ink-200 bg-white px-4 py-3 transition-all duration-200 hover:border-brand-300 hover:shadow-card"
                            title="{{ $brand->title }}"
                        >
                            @if($logo)
                                <img
                                    src="{{ $logo }}"
                                    alt="{{ $brand->title }}"
                                    class="max-h-12 w-auto max-w-full object-contain opacity-80 grayscale transition duration-200 group-hover/brand:opacity-100 group-hover/brand:grayscale-0 [&[hidden]]:hidden"
                                    loading="lazy"
                                    decoding="async"
                                    onerror="this.hidden=true;this.nextElementSibling.hidden=false"
                                />
                            @endif
                            {{-- `[&[hidden]]:hidden`: line-clamp sets display:-webkit-box, which
                                 beat the plain [hidden] rule — the name showed beside every logo. --}}
                            <span
                                class="line-clamp-2 text-center text-sm font-bold uppercase tracking-wide text-ink-500 transition-colors group-hover/brand:text-brand-600 [&[hidden]]:hidden"
                                @if($logo) hidden @endif
                            >{{ $brand->title }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif
