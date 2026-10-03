@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        $sfJson = static fn (array $data): string => json_encode(
            $data,
            JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
        );

        $heroSlides = collect($banners ?? [])->map(fn ($banner) => [
            'id' => $banner->id,
            'url' => $banner->linkForLocale(),
            'image' => asset('storage/' . ($locale === 'ro' ? $banner->image_path_ro : $banner->image_path_ru)),
            'alt' => 'Radop',
        ])->values()->all();

        /*
         * The three home rails are identical apart from their data, heading and
         * GA4 list id, so they are declared once and rendered in a loop rather
         * than copy-pasted three times as they were before.
         */
        $rails = [
            [
                'id' => 'new-products-home-anchor',
                'title' => __('theme.new-products'),
                'url' => route('theme.shop.new'),
                'products' => $newProducts ?? collect(),
                'list' => ['home_new', 'Home new'],
            ],
            [
                'id' => 'popular-products-home-anchor',
                'title' => __('theme.popular-products'),
                'url' => route('theme.shop.popular'),
                'products' => $popularProducts ?? collect(),
                'list' => ['home_popular', 'Home popular'],
            ],
            [
                'id' => 'discount-products-home-anchor',
                'title' => __('theme.on-discount'),
                'url' => route('theme.shop.sale'),
                'products' => $discountProducts ?? collect(),
                'list' => ['home_sale', 'Home sale'],
            ],
        ];
    @endphp

    <h1 class="sf-sr-only">{{ __('seo.home_h1') }}</h1>

    @if(! empty($heroSlides))
        <div class="sf-container pt-4 lg:pt-6">
            <div
                data-sf-island="hero-slider"
                data-sf-props="{{ $sfJson(['slides' => $heroSlides, 'autoplay' => (int) ($autoplaySpeed ?? 0)]) }}"
                v-cloak
            >
                {{-- Pre-hydration and no-JS: the first banner is still shown and linked. --}}
                <a href="{{ $heroSlides[0]['url'] }}">
                    <img
                        src="{{ $heroSlides[0]['image'] }}"
                        alt="Radop"
                        class="aspect-[1232/400] w-full rounded-lg object-cover"
                        fetchpriority="high"
                        decoding="async"
                    />
                </a>
            </div>
        </div>
    @endif

    @foreach($rails as $rail)
        @continue($rail['products']->isEmpty())
        <section class="sf-section" id="{{ $rail['id'] }}">
            <div class="sf-container" data-sf-rail>
                <div class="sf-section-head">
                    <h2 class="sf-section-title">
                        <a href="{{ $rail['url'] }}" class="hover:text-brand-600">{{ $rail['title'] }}</a>
                    </h2>
                    <div class="flex items-center gap-2">
                        <a href="{{ $rail['url'] }}" class="sf-section-link">{{ __('theme.view-all') }}</a>
                        <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 lg:inline-flex" data-sf-rail-prev aria-label="←">
                            <x-sf-icon name="chevronLeft" :size="16" />
                        </button>
                        <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 lg:inline-flex" data-sf-rail-next aria-label="→">
                            <x-sf-icon name="chevronRight" :size="16" />
                        </button>
                    </div>
                </div>

                <div class="sf-rail">
                    @foreach($rail['products'] as $product)
                        <x-sf-product-card
                            :product="$product"
                            :list-id="$rail['list'][0]"
                            :list-name="$rail['list'][1]"
                        />
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach

    <x-sf-brand-rail :brands="$themeBrands ?? []" id="brands-home-anchor" />
@endsection

@section('scripts')
    @include('frontend.v1.analytics.ga4-item-lists')
    {{-- Показ баннеров считает сам слайдер — по факту появления на экране,
         один раз на баннер (см. HeroSlider.vue). --}}
@endsection
