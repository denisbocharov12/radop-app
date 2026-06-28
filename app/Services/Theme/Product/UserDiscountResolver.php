<?php

declare(strict_types=1);

namespace App\Services\Theme\Product;

use App\Models\UserCategoryDiscount;
use App\Models\UserProductDiscount;
use Illuminate\Support\Facades\DB;

/**
 * Resolves a per-user category/product discount for a product.
 *
 * Priority (most specific first, no stacking):
 *   1. Product-level discount  — fixed price OR percent off the user's base.
 *   2. Category-level discount — percent off the user's base (whole category).
 *
 * Returns null when no custom discount applies, so the caller keeps the
 * existing pricing logic untouched.
 *
 * The user's discount maps are loaded once per request and cached statically
 * (membership of a product in a discounted category is pre-resolved with a
 * single join query), so there is no N+1 when pricing a product list.
 */
final class UserDiscountResolver
{
    /** @var array<int, array{product: array<string,array{type:string,value:float}>, category: array<string,float>}> */
    private static array $cache = [];

    /**
     * @param  object $product   needs ->onec_id
     * @param  float  $basePrice the user's normal unit price BEFORE personal sale
     * @param  object|null $user the authenticated storefront user
     */
    public static function resolveUnitPrice($product, float $basePrice, $user): ?float
    {
        if ($user === null) {
            return null;
        }

        $maps = self::mapsFor($user);
        $onec = (string) ($product->onec_id ?? '');
        if ($onec === '') {
            return null;
        }

        // 1) Product-level discount.
        if (isset($maps['product'][$onec])) {
            $d = $maps['product'][$onec];

            if ($d['type'] === UserProductDiscount::TYPE_FIXED) {
                return max(0.0, round($d['value'], 2));
            }

            return max(0.0, round($basePrice * (1 - $d['value'] / 100), 2));
        }

        // 2) Category-level discount (percent).
        if (isset($maps['category'][$onec])) {
            return max(0.0, round($basePrice * (1 - $maps['category'][$onec] / 100), 2));
        }

        return null;
    }

    /**
     * @return array{product: array<string,array{type:string,value:float}>, category: array<string,float>}
     */
    private static function mapsFor($user): array
    {
        $uid = (int) $user->id;
        if (isset(self::$cache[$uid])) {
            return self::$cache[$uid];
        }

        // Product-level map: onec_id => [type, value].
        $product = [];
        foreach (UserProductDiscount::where('user_id', $uid)->get() as $row) {
            $product[(string) $row->product_onec_id] = [
                'type'  => (string) $row->discount_type,
                'value' => (float) $row->discount_value,
            ];
        }

        // Category-level map resolved down to product onec_ids (best/highest percent).
        $category = [];
        $catDiscounts = UserCategoryDiscount::where('user_id', $uid)->get();
        if ($catDiscounts->isNotEmpty()) {
            $percentByCategory = []; // category_onec_id => percent
            foreach ($catDiscounts as $cd) {
                $percentByCategory[(string) $cd->category_onec_id] = (float) $cd->discount_percent;
            }

            $rows = DB::table('product_categories')
                ->whereIn('category_id', array_keys($percentByCategory))
                ->get(['product_id', 'category_id']);

            foreach ($rows as $r) {
                $pid = (string) $r->product_id;
                $pct = $percentByCategory[(string) $r->category_id] ?? 0.0;
                if (!isset($category[$pid]) || $pct > $category[$pid]) {
                    $category[$pid] = $pct;
                }
            }
        }

        return self::$cache[$uid] = ['product' => $product, 'category' => $category];
    }

    /** Clear the static cache (e.g. after editing discounts in the same request). */
    public static function flush(): void
    {
        self::$cache = [];
    }
}
