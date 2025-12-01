<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

final class ThemeTitleSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $locale = app()->getLocale();
        
        $query->orderByRaw("
            COALESCE(
                JSON_UNQUOTE(JSON_EXTRACT(products.title, ?)),
                JSON_UNQUOTE(JSON_EXTRACT(products.title, '$.ru')),
                JSON_UNQUOTE(JSON_EXTRACT(products.title, '$.ro')),
                products.title
            ) $direction
        ", ["$.{$locale}"])
        ->orderBy('products.onec_id');
    }
}

