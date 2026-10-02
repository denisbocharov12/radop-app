<?php

namespace App\Support\Catalog;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Границы ползунка цены по товарам текущей выборки (ТЗ 41): в разделе ручек
 * покупателю нужен диапазон ручек, а не общий для всего каталога.
 */
final class PriceBounds
{
    /**
     * @param  array<int, string>  $productOnecIds
     * @return array{min: int, max: int}
     */
    public static function for(array $productOnecIds): array
    {
        if ($productOnecIds === []) {
            return ['min' => 0, 'max' => 0];
        }

        // Оптовики видят цену без коэффициента, поэтому границы у них свои.
        $wholesale = (int) (bool) optional(\Illuminate\Support\Facades\Auth::guard('user')->user())->with_sale;
        $cacheKey = 'sf_price_bounds_' . $wholesale . '_' . md5(implode(',', $productOnecIds));

        return Cache::remember($cacheKey, 3600, static function () use ($productOnecIds): array {
            $price = DisplayPrice::sql();

            $row = DB::table('products')
                ->whereIn('onec_id', $productOnecIds)
                // Товары без цены не должны опускать нижнюю границу до нуля.
                ->selectRaw("MIN(NULLIF($price, 0)) as min_price, MAX($price) as max_price")
                ->first();

            return [
                'min' => (int) floor((float) ($row->min_price ?? 0)),
                'max' => (int) ceil((float) ($row->max_price ?? 0)),
            ];
        });
    }
}
