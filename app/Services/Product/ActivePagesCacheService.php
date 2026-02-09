<?php

declare(strict_types=1);

namespace App\Services\Product;

use Illuminate\Support\Facades\Cache;

final class ActivePagesCacheService
{
    private const SHOP_IDS_KEYS = [
        'new' => 'shop_new_product_onec_ids',
        'popular' => 'shop_popular_product_onec_ids',
        'sale' => 'shop_discount_product_onec_ids',
    ];

    /**
     * @return array<int, string>
     */
    private function getSupportedLocales(): array
    {
        $order = config('laravellocalization.localesOrder', []);

        if ($order !== []) {
            return $order;
        }

        $locales = config('laravellocalization.supportedLocales', []);

        return array_keys($locales);
    }

    /**
     * @param string $type 'new'|'popular'|'sale'
     * @return void
     */
    public function clearForType(string $type): void
    {
        if (!isset(self::SHOP_IDS_KEYS[$type])) {
            return;
        }

        Cache::forget(self::SHOP_IDS_KEYS[$type]);

        foreach ($this->getSupportedLocales() as $locale) {
            Cache::forget("theme_shop_filters_{$type}_{$locale}");
            Cache::forget("theme_shop_filter_counts_{$type}_{$locale}");
        }

        foreach ($this->getSupportedLocales() as $locale) {
            $homeKey = match ($type) {
                'new' => 'home_new_products_' . $locale,
                'popular' => 'home_popular_products_' . $locale,
                'sale' => 'home_discount_products_' . $locale,
                default => null,
            };
            if ($homeKey !== null) {
                Cache::forget($homeKey);
            }
        }
    }
}
