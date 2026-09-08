@props([
    'product',
    'listId' => null,
    'listName' => null,
])

@php
    use App\Services\Theme\Product\ThemeProductManager;
    use Illuminate\Support\Str;

    /*
     * One card for the whole storefront (home rails, category grid, search,
     * wishlist, brand pages). It replaces the previous arrangement of ten
     * @include partials that each re-derived the cart session and the price.
     */
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

    $condition = $product?->data?->condition;
    $step = (int) ($product->min_order ?: 1);

    // GA4 payload: identical keys to the markup it replaces so existing
    // dataLayer listeners keep working.
    $ga4Title = $product->getTranslation('title', app()->getLocale(), false);
    $ga4Title = strip_tags(is_string($ga4Title) && $ga4Title !== '' ? $ga4Title : (string) $product->title);

    $image = $product->hasMedia('products')
        ? $product->getFirstMediaUrl('products', 'medium')
        : (\App\Services\Product\ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id)[0] ?? null);
    if ($image && ! Str::startsWith($image, ['http://', 'https://'])) {
        $image = config('app.url') . '/' . ltrim($image, '/');
    }

    $url = route('theme.product.index', $product->slug);
    $inWishlist = app('wishlist')->get($product->id) !== null;
@endphp

<article
    class="sf-product group"
    id="col-product-{{ $product->id }}"
    data-ga4-item-id="{{ e((string) ($product->onec_id ?? $product->id)) }}"
    data-ga4-item-name="{{ e($ga4Title) }}"
    data-ga4-price="{{ $unitPrice }}"
    @if($listId) data-ga4-item-list-id="{{ $listId }}" @endif
    @if($listName) data-ga4-item-list-name="{{ $listName }}" @endif
>
    <div class="sf-product-media">
        <div class="sf-product-flags">
            @if($hasSale)
                <span class="sf-badge-sale">-{{ ThemeProductManager::getProductSaleForLabel($product) }}%</span>
            @endif
            @if($condition === 'new')
                <span class="sf-badge-new">{{ __('theme.label_new') }}</span>
            @elseif($condition === 'popular')
                <span class="sf-badge-hit">{{ __('theme.label_popular') }}</span>
            @elseif($condition === 'hot')
                <span class="sf-badge-sale">{{ __('theme.label_hot') }}</span>
            @elseif($condition === 'featured')
                <span class="sf-badge-hit">{{ __('theme.label_featured') }}</span>
            @elseif($condition === 'winter')
                <span class="sf-badge-neutral">{{ __('theme.label_winter') }}</span>
            @endif
        </div>

        <div
            data-sf-island="wishlist-button"
            data-sf-props="{{ json_encode([
                'productId' => $product->id,
                'active' => $inWishlist,
                'labelAdd' => __('theme.add-to-wishlist'),
                'labelRemove' => __('theme.remove-from-wishlist'),
            ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) }}"
            v-cloak
        ></div>

        <a href="{{ $url }}" tabindex="-1" aria-hidden="true">
            @if($image)
                <img
                    src="{{ $image }}"
                    alt="{{ $product->title }}"
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
    </div>

    <div class="sf-product-body">
        <p class="text-2xs text-ink-400">
            {{ __('theme.code') }}:
            <button
                type="button"
                class="font-medium text-ink-500 hover:text-brand-600"
                data-copy-value="{{ $product->onec_id }}"
                data-copy-message="{{ __('theme.product_code_copied') }}"
            >{{ $product->onec_id }}</button>
        </p>

        <h3 class="sf-product-title">
            <a href="{{ $url }}" class="after:absolute after:inset-0 after:content-['']">
                {{ Str::limit($product->title, 80) }}
            </a>
        </h3>

        <div class="flex items-baseline gap-2">
            <span @class(['sf-product-price', 'text-accent-600' => $hasSale])>
                {{ number_format($displayPrice, 2, ',', ' ') }}
            </span>
            <span class="text-xs text-ink-500">{{ __('theme.MDL') }}</span>
            @if($hasSale)
                <span class="sf-product-price-old">{{ number_format($oldPrice, 2, ',', ' ') }}</span>
            @endif
        </div>

        {{-- The cart control sits above the card's stretched link. --}}
        <div
            class="relative z-10"
            data-sf-island="add-to-cart"
            data-sf-props="{{ json_encode([
                'productId' => $product->id,
                'step' => $step,
                'stock' => (int) $product->stock,
                'price' => $unitPrice,
                'inCart' => $cartLine ? (int) $cartLine->quantity : 0,
                'currency' => __('theme.MDL'),
                'labelAdd' => __('theme.add-to-cart'),
                'labelInCart' => __('theme.in-cart'),
                'labelTotal' => __('theme.total'),
            ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) }}"
            v-cloak
        >
            {{-- Without JS the card still leads to the product page. --}}
            <noscript>
                <a href="{{ $url }}" class="sf-btn-primary sf-btn-sm sf-btn-block">{{ __('theme.add-to-cart') }}</a>
            </noscript>
        </div>
    </div>
</article>
