<?php

namespace App\Filters\Theme;

use App\Support\Catalog\DisplayPrice;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

final class ThemePriceSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? 'DESC' : 'ASC';

        // Сортируем по той же цене, что показана в карточке.
        $query->orderByRaw(DisplayPrice::sql() . " $direction")
        ->orderBy('products.onec_id');
    }
}
