@props([
    'product',
    'listId' => null,
    'listName' => null,
])

@php
    use Illuminate\Support\Str;

    /*
     * One card for the whole storefront (home rails, category grid, search,
     * wishlist, brand pages, AJAX filter responses). Price, image and badge
     * rules come from StorefrontProductPresenter so the card, quick view,
     * mini-cart and basket cannot disagree.
     *
     * Works in both catalogue layouts: a column in the grid, a row when the
     * surrounding grid is switched to `[data-sf-view=list]`.
     */
    $card = app(\App\Services\Storefront\StorefrontProductPresenter::class)->present($product);

    $user = auth()->guard('user')->user();
    $cartSession = $user ? $user->id : config('shopping_cart.default_session_id');
    $cartLine = \Cart::session($cartSession)->get($product->id);
    $inWishlist = app('wishlist')->get($product->id) !== null;

    $json = static fn (array $data): string => json_encode(
        $data,
        JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
    );

    $badge = match ($card['condition']) {
        'new' => ['sf-badge-new', __('theme.label_new')],
        'popular' => ['sf-badge-hit', __('theme.label_popular')],
        'hot' => ['sf-badge-sale', __('theme.label_hot')],
        'featured' => ['sf-badge-hit', __('theme.label_featured')],
        'winter' => ['sf-badge-neutral', __('theme.label_winter')],
        default => null,
    };
@endphp

{{-- id + data-ga4-* are read by the select_item listener in scripts.blade.php. --}}
<article
    class="sf-product group"
    id="col-product-{{ $card['id'] }}"
    data-ga4-item-id="{{ $card['code'] ?: $card['id'] }}"
    data-ga4-item-name="{{ $card['title'] }}"
    data-ga4-price="{{ $card['unitPrice'] }}"
    @if($card['brand'] ?? null) data-ga4-item-brand="{{ $card['brand']['title'] ?? $card['brand'] }}" @endif
    @if($listId) data-ga4-item-list-id="{{ $listId }}" @endif
    @if($listName) data-ga4-item-list-name="{{ $listName }}" @endif
>
    <div class="sf-product-media">
        <div class="sf-product-flags">
            @if($card['salePercent'])
                <span class="sf-badge-sale">-{{ $card['salePercent'] }}%</span>
            @endif
            @if($badge)
                <span class="{{ $badge[0] }}">{{ $badge[1] }}</span>
            @endif
        </div>

        <div
            data-sf-island="wishlist-button"
            data-sf-props="{{ $json([
                'productId' => $card['id'],
                'active' => $inWishlist,
                'labelAdd' => __('theme.add-to-wishlist'),
                'labelRemove' => __('theme.remove-from-wishlist'),
            ]) }}"
            v-cloak
        ></div>

        <a href="{{ $card['url'] }}" tabindex="-1" aria-hidden="true" class="block h-full">
            @if($card['image'])
                <img
                    src="{{ $card['image'] }}"
                    alt="{{ $card['title'] }}"
                    class="sf-product-img"
                    loading="lazy"
                    decoding="async"
                    width="240"
                    height="240"
                    data-sf-card-image
                />
            @else
                <span class="flex h-full w-full items-center justify-center text-ink-300">
                    <x-sf-icon name="box" :size="40" />
                </span>
            @endif
        </a>

        {{-- ТЗ 70: точки под снимком переключают фото прямо в карточке — наводим
             на точку, снимок меняется; высота карточки при этом не меняется.
             Точки появляются только там, где есть наведение (см. css). --}}
        @if(count($card['gallery'] ?? []) > 1)
            <div class="sf-product-dots" data-sf-card-dots>
                @foreach($card['gallery'] as $i => $src)
                    <button
                        type="button"
                        @class(['sf-product-dot', 'is-active' => $i === 0])
                        data-src="{{ $src }}"
                        aria-label="{{ __('theme.sf-photo-n', ['n' => $i + 1]) }}"
                    ></button>
                @endforeach
            </div>
        @endif

        {{-- Quick view: revealed on hover/focus on pointer devices; on touch
             the card's own link is the faster path, so it stays hidden. --}}
        <button
            type="button"
            class="sf-product-quick"
            data-sf-quick-view="{{ $card['id'] }}"
            aria-label="{{ __('theme.sf-quick-view') }}: {{ $card['title'] }}"
        >
            <x-sf-icon name="eye" :size="15" />
            <span>{{ __('theme.sf-quick-view') }}</span>
        </button>
    </div>

    <div class="sf-product-body">
        <div class="sf-product-info">
            {{-- Code and article as the old card's two framed chips, left and
                 right; each copies its value on click. --}}
            <div class="sf-product-codes-row">
                <button
                    type="button"
                    class="sf-code-chip sf-code-chip-code"
                    data-copy-value="{{ $card['code'] }}"
                    data-copy-message="{{ __('theme.product_code_copied') }}"
                    title="{{ __('theme.sf-copy-code') }}"
                >
                    <span>{{ __('theme.code') }}:</span>
                    <b>{{ $card['code'] }}</b>
                </button>
                @if($card['article'])
                    <button
                        type="button"
                        class="sf-code-chip sf-code-chip-article"
                        data-copy-value="{{ $card['article'] }}"
                        data-copy-message="{{ __('theme.product_code_copied') }}"
                        title="{{ __('theme.sf-copy-code') }}"
                    >
                        <span>{{ __('theme.article') }}:</span>
                        <b>{{ $card['article'] }}</b>
                    </button>
                @endif
            </div>

            {{-- ТЗ 16: название в карточке обрезано, полное показываем подсказкой
                 при наведении — высота карточки от этого не меняется. --}}
            <h3 class="sf-product-title">
                <a
                    href="{{ $card['url'] }}"
                    class="after:absolute after:inset-0 after:content-['']"
                    title="{{ $card['title'] }}"
                >
                    {{-- Обрезку по длине оставляем страховкой от совсем длинных
                         названий: три строки отмеряет сама вёрстка. --}}
                    {{ Str::limit($card['title'], 120) }}
                </a>
            </h3>

            {{-- Brand link, as the old card's "Brand: MONDI"; above the card's
                 stretched link so it opens the brand, not the product. --}}
            @if($card['brand'])
                <p class="sf-product-brand">
                    <span>{{ __('theme.brand') }}:</span>
                    <a href="{{ $card['brand']['url'] }}">{{ $card['brand']['title'] }}</a>
                </p>
            @endif

            {{-- ТЗ 17: в виде «список» слева остаётся место — заполняем его
                 характеристиками товара. Значения уже загружены вместе с товаром,
                 названия характеристик не тянем, чтобы не плодить запросы. --}}
            @php($specs = $product->values
                ->pluck('value')
                ->map(static fn ($v) => trim((string) $v))
                // «Da»/«Nu» и одиночные цифры без названия характеристики ничего не говорят.
                ->reject(static fn ($v) => $v === '' || preg_match('/^(da|nu|да|нет|yes|no|\d{1,2})$/iu', $v))
                ->unique()
                ->take(4))
            @if($specs->isNotEmpty())
                <p class="sf-product-specs">{{ $specs->implode(' · ') }}</p>
            @endif

            @if($card['barcode'])
                <p class="sf-product-codes">
                    <span>{{ __('theme.barcode') }}: {{ $card['barcode'] }}</span>
                </p>
            @endif
        </div>

        <div class="sf-product-pricing">
            <span @class(['sf-product-price', 'text-accent-700' => $card['oldPrice']])>
                {{ number_format($card['displayPrice'], 2, ',', ' ') }}
            </span>
            <span class="text-xs text-ink-600">
                {{ __('theme.MDL') }}@if($card['minOrder']) / {{ $card['minOrder'] }} {{ __('theme.min_order_unit') }}@endif
            </span>
            @if($card['oldPrice'])
                <span class="sf-product-price-old">{{ number_format($card['oldPrice'], 2, ',', ' ') }}</span>
            @endif
        </div>

        {{-- Buying conditions: personal price, minimum order, pack size, stock.
             The legacy card printed pack size and minimum order under the
             price; the personal-discount hint and stock state are new. --}}
        <ul class="sf-product-meta">
            @if($card['personalPercent'])
                <li class="font-semibold text-brand-700">
                    <x-sf-icon name="star" :size="12" style="fill: currentColor" />
                    <span>{{ __('theme.sf-personal-price') }} −{{ $card['personalPercent'] }}%</span>
                </li>
            @endif
            @if($card['minOrder'])
                <li>
                    <x-sf-icon name="box" :size="12" />
                    <span>
                        {{ __('theme.package-min-to-order') }}: {{ $card['minOrder'] }}&nbsp;{{ __('theme.min_order_unit') }}
                        <span class="block whitespace-nowrap text-ink-500">{{ number_format($card['unitPrice'], 2, ',', ' ') }}&nbsp;{{ __('theme.MDL') }}/{{ __('theme.min_order_unit') }}</span>
                    </span>
                </li>
            @endif
            @if($card['packages'])
                <li>
                    <x-sf-icon name="box" :size="12" />
                    <span>{{ __('theme.package') }}: {{ $card['packages'] }}&nbsp;{{ __('theme.package_unit') }}</span>
                </li>
            @endif
            @if($card['stock'] <= 0)
                <li class="font-medium text-ink-500">
                    <x-sf-icon name="info" :size="12" /><span>{{ __('theme.out-of-stock') }}</span>
                </li>
            @elseif($card['lowStock'])
                <li class="font-medium text-accent-700">
                    <x-sf-icon name="clock" :size="12" /><span>{{ __('theme.sf-low-stock', ['qty' => $card['lowStock']]) }}</span>
                </li>
            @endif
        </ul>

        {{-- The cart control sits above the card's stretched link and is pushed
             to the bottom (mt-auto), so steppers line up across a row. --}}
        <div
            class="sf-product-cart relative z-10 mt-auto pt-1"
            data-sf-island="add-to-cart"
            data-sf-props="{{ $json([
                'productId' => $card['id'],
                'step' => $card['step'],
                'stock' => $card['stock'],
                'price' => $card['unitPrice'],
                'inCart' => $cartLine ? (int) $cartLine->quantity : 0,
                'currency' => __('theme.MDL'),
                'labelAdd' => __('theme.add-to-cart'),
                'labelInCart' => __('theme.in-cart'),
                'labelRemove' => __('theme.sf-remove-from-cart'),
                'labelTotal' => __('theme.total'),
                'disabled' => $card['stock'] <= 0,
                'compact' => true,
            ]) }}"
            v-cloak
        >
            {{-- Without JS the card still leads to the product page. --}}
            <noscript>
                <a href="{{ $card['url'] }}" class="sf-btn-primary sf-btn-sm sf-btn-block">{{ __('theme.add-to-cart') }}</a>
            </noscript>
        </div>
    </div>
</article>
