<?php

declare(strict_types=1);

namespace App\Services\Export;

use App\Models\Product;

/**
 * Resolves a product's catalog status badge for the "Nota" column of the
 * Excel exports.
 *
 * Mapping (mirrors the storefront badges, see the product label blade and
 * the theme lang files):
 *   - SALE  when sale_price is set            (label_on_sale => "Sale")  red
 *   - NEW   when data.condition === 'new'     (label_new     => "New")   dark blue
 *   - HIT   when data.condition === 'popular' (label_popular => "Hit")   dark blue
 *
 * Priority when several apply: SALE then NEW then HIT.
 */
final class ProductExcelStatusResolver
{
    public const COLOR_BLUE = 'FF002060'; // dark blue for NEW / HIT
    public const COLOR_RED  = 'FFC00000'; // red for SALE

    /**
     * @return array{label: string, argb: string}|null
     */
    public static function resolve(Product $product): ?array
    {
        if (self::isOnSale($product)) {
            return ['label' => 'SALE', 'argb' => self::COLOR_RED];
        }

        $condition = $product->data?->condition;

        if ($condition === 'new') {
            return ['label' => 'NEW', 'argb' => self::COLOR_BLUE];
        }

        if ($condition === 'popular') {
            return ['label' => 'HIT', 'argb' => self::COLOR_BLUE];
        }

        return null;
    }

    public static function label(Product $product): string
    {
        return self::resolve($product)['label'] ?? '';
    }

    public static function argb(Product $product): ?string
    {
        return self::resolve($product)['argb'] ?? null;
    }

    private static function isOnSale(Product $product): bool
    {
        $salePrice = $product->sale_price;

        return $salePrice !== null && $salePrice !== '';
    }
}
