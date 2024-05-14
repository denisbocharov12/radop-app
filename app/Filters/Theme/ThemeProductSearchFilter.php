<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class ThemeProductSearchFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {

        $query->where(function ($query) use ($value) {
            $query
                ->where('products.title', 'like', "%{$value}%")
                ->orWhere('products.onec_id', 'like', "%{$value}%")
            ;
        });
    }
}
