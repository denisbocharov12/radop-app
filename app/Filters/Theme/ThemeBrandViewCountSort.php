<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

final class ThemeBrandViewCountSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'ASC' : 'DESC';

        return $query->leftJoin('product_view_counts', 'products.id', '=', 'product_view_counts.product_id')
            ->select('products.*')
            ->groupBy('products.id')
            ->orderByRaw("COALESCE(SUM(product_view_counts.view_count), 0) {$direction}");
    }
}
