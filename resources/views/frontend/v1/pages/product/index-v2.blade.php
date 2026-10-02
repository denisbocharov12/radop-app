@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        use App\Services\Product\ProductImagesManager;
        use App\Services\Theme\Product\ThemeProductManager;
        use Illuminate\Support\Str;

        $sfJson = static fn (array $data): string => json_encode(
            $data,
            JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
        );

        $user = auth()->guard('user')->user();
        $cartSession = $user ? $user->id : config('shopping_cart.default_session_id');
        $cartLine = \Cart::session($cartSession)->get($product->id);

        $unitPrice = (float) ThemeProductManager::getProductTotalSum($product);
        $priceMultiplier = ThemeProductManager::getMinOrderDisplayMultiplier($product);
        $displayPrice = $unitPrice * $priceMultiplier;

        $hasSale = $product->sale_price !== '' && $product->price_koef !== null;
        $oldPrice = $user && $user->with_sale
            ? round((float) $product->price, 2) * $priceMultiplier
            : round((float) $product->price * (float) $product->price_koef, 2) * $priceMultiplier;

        // Media library first, absolute-path fallback second — the same order
        // the old gallery partial used, expressed once.
        if ($product->hasMedia('products')) {
            $galleryImages = $product->getMedia('products')
                ->map(fn ($file) => ['url' => $file->getUrl(), 'thumb' => $file->getUrl()])
                ->values()
                ->all();
        } else {
            $galleryImages = collect(ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id))
                ->map(fn ($path) => [
                    'url' => Str::startsWith($path, ['http://', 'https://'])
                        ? $path
                        : config('app.url') . '/' . ltrim($path, '/'),
                ])
                ->map(fn ($image) => $image + ['thumb' => $image['url']])
                ->values()
                ->all();
        }

        $summary = $product->data?->getTranslation('summary', app()->getLocale());
        $condition = $product?->data?->condition;

        // Same framed chips as the product card (code orange, article blue),
        // plus the barcode, which only the product page shows in full.
        $codes = array_values(array_filter([
            ['label' => __('theme.code'), 'value' => $product->onec_id, 'variant' => 'sf-code-chip-code'],
            ['label' => __('theme.barcode'), 'value' => $product->shtrih_code, 'variant' => 'sf-code-chip-barcode'],
            ['label' => __('theme.article'), 'value' => $product->article, 'variant' => 'sf-code-chip-article'],
        ], static fn ($code) => $code['value'] !== null && $code['value'] !== ''));
    @endphp

    <x-sf-breadcrumbs :items="collect($breadcrumbs ?? [])->push(['url' => null, 'name' => $product->title])" />
    @include('frontend.v1.components.breadcrumb-schema', ['items' => $breadcrumbs ?? [], 'leaf' => $product])

    <div class="sf-container pb-10">
        <h1 class="mb-3 mt-2 text-xl font-bold leading-snug text-ink-900 lg:text-2xl">{{ $product->title }}</h1>

        <div class="mb-5 flex flex-wrap items-center gap-x-2 gap-y-2">
            @foreach($codes as $code)
                <button
                    type="button"
                    class="sf-code-chip sf-code-chip-lg {{ $code['variant'] }}"
                    data-copy-value="{{ $code['value'] }}"
                    data-copy-message="{{ __('theme.product_code_copied') }}"
                    title="{{ __('theme.sf-copy-code') }}"
                >
                    <span>{{ $code['label'] }}:</span>
                    <b>{{ $code['value'] }}</b>
                </button>
            @endforeach

            @if($product->brand && trim((string) ($product->brand->title ?? '')) !== '')
                <p class="sf-product-brand sf-product-brand-lg sm:ml-2">
                    <span>{{ __('theme.brand') }}:</span>
                    <a href="{{ route('theme.brand.index', $product->brand->onec_id) }}">{{ $product->brand->title }}</a>
                </p>
            @endif
        </div>

        <div class="grid gap-6 lg:grid-cols-12 lg:gap-8">
            {{-- Gallery --}}
            <div class="relative lg:col-span-5">
                @php
                    // Badges are handed to the gallery so they sit on the main
                    // image, not on the thumbnail column beside it.
                    // Percentage from the presenter, i.e. from the prices shown in
                    // the buy box beside it (the legacy label helper disagreed).
                    $card ??= app(\App\Services\Storefront\StorefrontProductPresenter::class)->present($product);
                    $galleryBadges = array_values(array_filter([
                        $card['salePercent'] ? ['label' => '-' . $card['salePercent'] . '%', 'class' => 'sf-badge-sale'] : null,
                        match ($condition) {
                            'new' => ['label' => __('theme.label_new'), 'class' => 'sf-badge-new'],
                            'popular' => ['label' => __('theme.label_popular'), 'class' => 'sf-badge-hit'],
                            'hot' => ['label' => __('theme.label_hot'), 'class' => 'sf-badge-sale'],
                            'featured' => ['label' => __('theme.label_featured'), 'class' => 'sf-badge-hit'],
                            'winter' => ['label' => __('theme.label_winter'), 'class' => 'sf-badge-neutral'],
                            default => null,
                        },
                    ]));
                @endphp

                @if(! empty($galleryImages))
                    <div
                        data-sf-island="product-gallery"
                        data-sf-props="{{ $sfJson(['images' => $galleryImages, 'alt' => $product->title, 'badges' => $galleryBadges, 'infoBadges' => $card['photoBadges'] ?? []]) }}"
                        v-cloak
                    >
                        <img
                            src="{{ $galleryImages[0]['url'] }}"
                            alt="{{ $product->title }}"
                            class="aspect-square w-full rounded-lg border border-ink-200 object-contain p-6"
                            fetchpriority="high"
                        />
                    </div>
                @else
                    <div class="flex aspect-square items-center justify-center rounded-lg border border-ink-200 text-ink-300">
                        <x-sf-icon name="box" :size="56" />
                    </div>
                @endif
            </div>

            {{-- Specifications --}}
            <div class="lg:col-span-4">
                <h2 class="mb-3 text-md font-bold text-ink-900">{{ __('theme.product-details') }}</h2>
                @if($product->values->isNotEmpty())
                    <dl class="divide-y divide-ink-100 rounded-lg border border-ink-200">
                        @foreach($product->values as $value)
                            {{-- ТЗ 27: «Diametrul gaurii, mm» + «8» → «Diametrul gaurii» и «8 mm». --}}
                            @php($spec = \App\Support\Catalog\SpecUnits::split($value->attribute?->name))
                            <div class="flex gap-3 px-3 py-2 text-sm">
                                <dt class="w-1/2 shrink-0 text-ink-500">{{ $spec['name'] }}</dt>
                                <dd class="min-w-0 flex-1 font-medium text-ink-800">{{ \App\Support\Catalog\SpecUnits::value($value->value, $spec['unit']) }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @else
                    <p class="text-sm text-ink-500">{{ __('theme.no-description') }}</p>
                @endif
            </div>

            {{-- Buy box --}}
            <div class="lg:col-span-3">
                {{-- Sticky only beside the gallery on desktop; on phones it must
                     scroll away so the bottom buy bar can take over. --}}
                <div class="sf-card space-y-4 p-4 lg:sticky lg:top-24" id="buy-box">
                    @php($card ??= app(\App\Services\Storefront\StorefrontProductPresenter::class)->present($product))
                    {{-- ТЗ 61, 64: цена слева, сердечко справа на её уровне. --}}
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                        <div class="flex flex-wrap items-baseline gap-2">
                            <span @class(['font-num text-3xl font-bold leading-none text-ink-900', 'text-accent-600' => $card['oldPrice']])>
                                {{ number_format($card['displayPrice'], 2, ',', ' ') }}
                            </span>
                            <span class="text-sm text-ink-500">
                                {{ __('theme.MDL') }}@if($card['minOrder']) / {{ $card['minOrder'] }} {{ __('theme.min_order_unit') }}@endif
                            </span>
                            @if($card['oldPrice'])
                                <span class="sf-product-price-old">{{ number_format($card['oldPrice'], 2, ',', ' ') }}</span>
                            @endif
                        </div>

                        @if($card['minOrder'])
                            <p class="mt-1 text-xs text-ink-500">
                                {{ number_format($card['unitPrice'], 2, ',', ' ') }} {{ __('theme.MDL') }} / {{ __('theme.min_order_unit') }}
                            </p>
                        @endif

                        @if($card['personalPercent'])
                            <p class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">
                                <x-sf-icon name="star" :size="13" style="fill: currentColor" />
                                {{ __('theme.sf-personal-price') }} −{{ $card['personalPercent'] }}%
                            </p>
                        @endif
                        </div>

                        <div
                            class="shrink-0"
                            data-sf-island="wishlist-button"
                            data-sf-props="{{ $sfJson([
                                'productId' => $product->id,
                                'active' => app('wishlist')->get($product->id) !== null,
                                'labelAdd' => __('theme.add-to-wishlist'),
                                'labelRemove' => __('theme.remove-from-wishlist'),
                                'variant' => 'icon',
                            ]) }}"
                            v-cloak
                        ></div>
                    </div>

                    {{-- Витрина показывает только товары с положительным остатком,
                         поэтому отдельная строка «в наличии» не нужна (ТЗ 29, 65, 66).
                         Остаётся предупреждение, когда остаток заканчивается. --}}
                    @if($product->stock > 0 && $card['lowStock'])
                        <p class="flex items-center gap-1.5 text-sm">
                            <x-sf-icon name="clock" :size="15" class="text-accent-600" />
                            <span class="font-medium text-accent-700">{{ __('theme.sf-low-stock', ['qty' => $card['lowStock']]) }}</span>
                        </p>
                    @elseif($product->stock <= 0)
                        <p class="flex items-center gap-1.5 text-sm">
                            <x-sf-icon name="info" :size="15" class="text-ink-400" />
                            <span class="text-ink-600">{{ __('theme.out-of-stock') }}</span>
                        </p>
                    @endif

                    <div
                        data-sf-island="add-to-cart"
                        data-sf-props="{{ $sfJson([
                            'productId' => $product->id,
                            'step' => (int) ($product->min_order ?: 1),
                            'stock' => (int) $product->stock,
                            'price' => $unitPrice,
                            'inCart' => $cartLine ? (int) $cartLine->quantity : 0,
                            'currency' => __('theme.MDL'),
                            'labelAdd' => __('theme.add-to-cart'),
                            'labelInCart' => __('theme.in-cart'),
                            'labelTotal' => __('theme.total'),
                            'disabled' => (int) $product->stock <= 0,
                        ]) }}"
                        v-cloak
                    ></div>

                    @include('frontend.v1.components.packages_card_wrap')

                    <div class="space-y-2 border-t border-ink-100 pt-3 text-xs text-ink-600">
                        <p class="flex items-center gap-2">
                            <x-sf-icon name="truck" :size="15" class="text-brand-600" />
                            {{ __('theme.footer_usp_delivery_text') }}
                        </p>
                        <p class="flex items-center gap-2">
                            <x-sf-icon name="shield" :size="15" class="text-brand-600" />
                            {{ __('theme.footer_usp_quality_text') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Пустое описание прячем целиком, без заглушки (ТЗ 34). --}}
        @if($summary !== null && ! empty(strip_tags($summary)))
            <section class="sf-section">
                <h2 class="sf-section-title mb-3">{{ __('theme.description') }}</h2>
                <div class="sf-prose">{!! $summary !!}</div>
            </section>
        @endif
    </div>

    {{-- Phones: once the buy box scrolls away, keep price + CTA under the thumb,
         just above the tab bar. Tapping it brings the buy box back. --}}
    <div
        class="fixed inset-x-0 bottom-[calc(3.5rem+env(safe-area-inset-bottom))] z-header translate-y-full border-t border-ink-200 bg-white/95 px-4 py-2.5 opacity-0 shadow-pop backdrop-blur transition-all duration-200 ease-sf data-[visible=true]:translate-y-0 data-[visible=true]:opacity-100 lg:hidden"
        data-sf-sticky-when-hidden="#buy-box"
        data-visible="false"
        aria-hidden="true"
    >
        <div class="mx-auto flex max-w-lg items-center gap-3">
            <div class="min-w-0 flex-1">
                <p class="truncate text-xs text-ink-500">{{ $product->title }}</p>
                <p class="font-num text-lg font-bold leading-tight {{ $hasSale ? 'text-accent-600' : 'text-ink-900' }}">
                    {{ number_format($displayPrice, 2, ',', ' ') }} <span class="text-xs font-medium text-ink-500">{{ __('theme.MDL') }}</span>
                </p>
            </div>
            <a href="#buy-box" class="sf-btn-primary h-11 shrink-0 px-5" tabindex="-1">
                <x-sf-icon name="cart" :size="17" />{{ __('theme.add-to-cart') }}
            </a>
        </div>
    </div>

    @include('frontend.v1.pages.product.components.reviews')

    @if(! empty($similarProducts) && count($similarProducts))
        <section class="sf-section">
            <div class="sf-container" data-sf-rail>
                <div class="sf-section-head">
                    <h2 class="sf-section-title">{{ __('theme.similar-products') }}</h2>
                    <div class="flex items-center gap-2">
                        <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 lg:inline-flex" data-sf-rail-prev aria-label="←">
                            <x-sf-icon name="chevronLeft" :size="16" />
                        </button>
                        <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 lg:inline-flex" data-sf-rail-next aria-label="→">
                            <x-sf-icon name="chevronRight" :size="16" />
                        </button>
                    </div>
                </div>

                <div class="sf-rail">
                    @foreach($similarProducts as $similar)
                        <x-sf-product-card :product="$similar" list-id="product_similar" list-name="Similar products" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
    @if(!empty($ga4ViewItem))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof window.radopGa4EcommercePush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                    window.radopGa4EcommercePush(
                        window.radopAnalyticsDataLayerEventNames.product_detail_page_viewed,
                        @json($ga4ViewItem)
                    );
                }
            });
        </script>
    @endif
@endsection
