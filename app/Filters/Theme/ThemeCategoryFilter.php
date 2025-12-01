<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class ThemeCategoryFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if ($value !== null) {
            $query->whereHas('categories', function ($q) use ($value) {
                $q->whereIn('categories.onec_id', is_array($value) ? $value : [$value]);
            });
        }
    }
}

