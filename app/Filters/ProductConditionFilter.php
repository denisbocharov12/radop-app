<?php

namespace App\Filters;

use App\Models\ProductProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * Admin products filter — by marketing condition.
 *
 * Accepts a ProductProfile.condition value (new / popular / hot / featured /
 * winter / regular) or the pseudo-value 'sale' (products with an active
 * discount: sale_price set and price_koef not null).
 */
final class ProductConditionFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if ($value === 'sale') {
            $query->where('sale_price', '!=', 0)->whereNotNull('price_koef');
            return;
        }

        $productIds = ProductProfile::where('condition', $value)->pluck('product_id');

        $query->whereIn('onec_id', $productIds);
    }
}
