<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class ThemeBrandsFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if ($value === null) {
            return;
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        if (empty($value)) {
            return;
        }

        $query->where(function ($query) use ($value) {
            $query->whereIn('products.brand_id', $value);
        });
    }
}
