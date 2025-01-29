<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

final class ThemeConditionSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $query->orderByRaw("
            CASE
                WHEN `condition` = 'new' THEN 0
                ELSE 1
            END
        ");
    }
}
