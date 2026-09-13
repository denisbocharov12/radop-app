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
 * multiplier), the image fallback chain and the badge were previously
 * re-derived in every card partial, the cart table, the mini-cart and the
 * product page. The product card, quick view, mini-cart and basket all read
 * from here now, so the rules cannot drift between them.
 */
final class StorefrontProductPresenter
{
    /**
     * Card-level data: everything a listing, quick view or basket line needs.
     *
     * @return array<string, mixed>
     */
    public function present(Product $product): array
    {
        $user = auth()->guard('user')->user();

        $unitPrice = (float) ThemeProductManager::getProductTotalSum($product);
        $multiplier = ThemeProductManager::getMinOrderDisplayMultiplier($product);

        $hasSale = $product->sale_price !== '' && $product->price_koef !== null;
        $oldPrice = $user && $user->with_sale
            ? round((float) $product->price, 2) * $multiplier
            : round((float) $product->price * (float) $product->price_koef, 2) * $multiplier;

        return [
            'id' => (int) $product->id,
            'code' => (string) $product->onec_id,
            'article' => $product->article ?: null,
            'barcode' => $product->shtrih_code ?: null,
            'title' => $this->title($product),
            'url' => route('theme.product.index', $product->slug),
            'image' => $this->images($product)[0] ?? null,
            'unitPrice' => $unitPrice,
            'displayPrice' => $unitPrice * $multiplier,
            'oldPrice' => $hasSale ? $oldPrice : null,
            'salePercent' => $hasSale ? ThemeProductManager::getProductSaleForLabel($product) : null,
            'condition' => $product?->data?->condition,
            'step' => max(1, (int) ($product->min_order ?: 1)),
            'stock' => (int) $product->stock,
            'brand' => $product->brand && trim((string) $product->brand->title) !== ''
                ? ['title' => $product->brand->title, 'url' => route('theme.brand.index', $product->brand->onec_id)]
                : null,
            'packages' => $product->packages->isNotEmpty()
                ? $product->packages->sortBy('value')->pluck('value')->implode('/')
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
