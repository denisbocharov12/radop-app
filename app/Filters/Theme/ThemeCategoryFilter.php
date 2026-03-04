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
            $ids = is_array($value)
                ? $value
                : (str_contains((string) $value, ',') ? array_values(array_filter(explode(',', (string) $value))) : [$value]);
            if ($ids !== []) {
                $query->whereHas('categories', function ($q) use ($ids) {
                    $q->whereIn('categories.onec_id', $ids);
                });
            }
        }
    }
}

