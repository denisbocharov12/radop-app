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
 *   - NEW   when data.condition === 'new'     (label_new     => "New")   green
 *   - HIT   when data.condition === 'popular' (label_popular => "Hit")   blue
 *
 * Priority when several apply: SALE then NEW then HIT.
 */
final class ProductExcelStatusResolver
{
    public const COLOR_GREEN = 'FF2EA560'; // #2ea560 — NEW
    public const COLOR_BLUE  = 'FF0701DC'; // #0701dc — HIT
    public const COLOR_RED   = 'FFE63F48'; // #e63f48 — SALE

    // Light tints used to fill the whole product row (dark text stays readable).
    public const FILL_GREEN = 'FFD4F4E1'; // NEW
    public const FILL_BLUE  = 'FFD6E4F5'; // HIT
    public const FILL_RED   = 'FFF8D7DA'; // SALE

    /**
     * @return array{label: string, argb: string, fill: string}|null
     */
    public static function resolve(Product $product): ?array
    {
        if (self::isOnSale($product)) {
            return ['label' => 'SALE', 'argb' => self::COLOR_RED, 'fill' => self::FILL_RED];
        }

        $condition = $product->data?->condition;

        if ($condition === 'new') {
            return ['label' => 'NEW', 'argb' => self::COLOR_GREEN, 'fill' => self::FILL_GREEN];
        }

        if ($condition === 'popular') {
            return ['label' => 'HIT', 'argb' => self::COLOR_BLUE, 'fill' => self::FILL_BLUE];
        }

        return null;
    }

    public static function fill(Product $product): ?string
    {
        return self::resolve($product)['fill'] ?? null;
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
