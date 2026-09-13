<?php

declare(strict_types=1);

namespace App\Services\Storefront;

use App\Models\Product;
use App\Services\Product\ProductImagesManager;
use App\Services\Theme\Product\ThemeProductManager;
use Illuminate\Support\Str;

/**
 * Single source of truth for how a product is shown on the storefront.
 *
 * The effective price (customer discount, sale coefficient, minimum-order
 * multiplier), the image fallback chain and the badges were previously
 * re-derived in every card partial, the cart table, the mini-cart and the
 * product page. The product card, quick view, mini-cart and basket all read
 * from here now, so the rules cannot drift between them.
 */
final class StorefrontProductPresenter
{
    /** Stock at or below which the card warns that few units are left. */
    private const LOW_STOCK = 10;

    /**
     * Card-level data: everything a listing, quick view or basket line needs.
     *
     * @return array<string, mixed>
     */
    public function present(Product $product): array
    {
        $user = auth()->guard('user')->user();

        // Effective unit price for this visitor: sale price, personal discount
        // and per-customer category/product discounts are all applied here.
        $unitPrice = (float) ThemeProductManager::getProductTotalSum($product);
        $multiplier = ThemeProductManager::getMinOrderDisplayMultiplier($product);

        $onSale = $product->sale_price !== null && $product->sale_price !== '';

        // The visitor's list price before any discount. Wholesale customers
        // (`with_sale`) are priced from `price`, everyone else from price × koef
        // — the same bases the legacy templates used for the struck-out price.
        $listUnit = $user && $user->with_sale
            ? round((float) $product->price, 2)
            : round((float) $product->price * (float) $product->price_koef, 2);

        $discounted = $listUnit > 0 && $unitPrice < $listUnit - 0.004;

        // A discount that is not the catalogue sale is the customer's own
        // (personal percentage or a customer-specific category/product rate).
        // The legacy card showed only the reduced number, so customers could
        // not tell they were getting their price.
        $personal = $discounted && ! $onSale && $user !== null;

        $stock = (int) $product->stock;

        return [
            'id' => (int) $product->id,
            'code' => (string) $product->onec_id,
            'article' => $product->article ?: null,
            'barcode' => $product->shtrih_code ?: null,
            'title' => $this->title($product),
            'url' => route('theme.product.index', $product->slug),
            'image' => $this->images($product)[0] ?? null,
            'unitPrice' => $unitPrice,
            // Shown price covers the minimum order quantity, as before.
            'displayPrice' => $unitPrice * $multiplier,
            'oldPrice' => $discounted ? $listUnit * $multiplier : null,
            'salePercent' => $onSale && $product->price_koef !== null
                ? ThemeProductManager::getProductSaleForLabel($product)
                : null,
            'personalPercent' => $personal ? (int) round((1 - $unitPrice / $listUnit) * 100) : null,
            'condition' => $product?->data?->condition,
            'step' => max(1, (int) ($product->min_order ?: 1)),
            'minOrder' => $multiplier > 1 ? $multiplier : null,
            'stock' => $stock,
            'lowStock' => $stock > 0 && $stock <= self::LOW_STOCK ? $stock : null,
            'brand' => $product->brand && trim((string) $product->brand->title) !== ''
                ? ['title' => $product->brand->title, 'url' => route('theme.brand.index', $product->brand->onec_id)]
                : null,
            // `value` is a string column: sortBy('value') ordered "4000" before
            // "50". Sort numerically so the smallest pack comes first.
            'packages' => $product->packages->isNotEmpty()
                ? $product->packages->sortBy(static fn ($pack) => (float) $pack->value)->pluck('value')->implode('/')
                : null,
        ];
    }

    /**
     * Quick-view payload: card data plus the gallery and the specification
     * table.
     *
     * @return array<string, mixed>
     */
    public function presentDetailed(Product $product): array
    {
        return $this->present($product) + [
            'images' => $this->images($product),
            'specs' => $product->values
                ->filter(static fn ($value) => $value->attribute !== null && $value->value !== null && $value->value !== '')
                ->map(static fn ($value) => ['name' => $value->attribute->name, 'value' => (string) $value->value])
                ->values()
                ->all(),
        ];
    }

    /**
     * Media library first, the legacy absolute-path store second.
     *
     * @return list<string>
     */
    public function images(Product $product): array
    {
        if ($product->hasMedia('products')) {
            return $product->getMedia('products')
                ->map(static fn ($file) => $file->getUrl())
                ->values()
                ->all();
        }

        return collect(ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id))
            ->map(static fn ($path) => Str::startsWith($path, ['http://', 'https://'])
                ? $path
                : '/' . ltrim((string) $path, '/'))
            ->values()
            ->all();
    }

    public function title(Product $product): string
    {
        $title = $product->getTranslation('title', app()->getLocale(), false);

        return strip_tags(is_string($title) && $title !== '' ? $title : (string) $product->title);
    }
}
