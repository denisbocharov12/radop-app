<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * Admin products filter — by category onec_id.
 * Products relate to categories via the product_categories pivot (onec_id ↔ onec_id).
 */
final class ProductCategoryFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if ($value === null || $value === '' || $value === []) {
            return;
        }

        $ids = is_array($value) ? $value : [$value];

        $query->whereHas('categories', function (Builder $q) use ($ids): void {
            $q->whereIn('categories.onec_id', $ids);
        });
    }
}
