<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

final class ThemePriceSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query->orderByRaw("CAST(REPLACE(price, ',', '.') AS DECIMAL(10,2)) $direction");
    }
}
