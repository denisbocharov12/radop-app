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
                />
            @else
                <span class="flex h-full w-full items-center justify-center text-ink-300">
                    <x-sf-icon name="box" :size="40" />
                </span>
            @endif
        </a>

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
            <p class="text-2xs text-ink-400">
                {{ __('theme.code') }}:
                <button
                    type="button"
                    class="relative z-10 font-medium text-ink-500 hover:text-brand-600"
                    data-copy-value="{{ $card['code'] }}"
                    data-copy-message="{{ __('theme.product_code_copied') }}"
                    title="{{ __('theme.product_code_copied') }}"
                >{{ $card['code'] }}</button>
            </p>

            <h3 class="sf-product-title">
                <a href="{{ $card['url'] }}" class="after:absolute after:inset-0 after:content-['']">
                    {{ Str::limit($card['title'], 80) }}
                </a>
            </h3>
        </div>

        <div class="sf-product-pricing">
            <span @class(['sf-product-price', 'text-accent-600' => $card['oldPrice']])>
                {{ number_format($card['displayPrice'], 2, ',', ' ') }}
            </span>
            <span class="text-xs text-ink-500">{{ __('theme.MDL') }}</span>
            @if($card['oldPrice'])
                <span class="sf-product-price-old">{{ number_format($card['oldPrice'], 2, ',', ' ') }}</span>
            @endif
        </div>

        {{-- The cart control sits above the card's stretched link. --}}
        <div
            class="sf-product-cart relative z-10"
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
