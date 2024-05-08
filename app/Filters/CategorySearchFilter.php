<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class CategorySearchFilter implements Filter
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
                ->where('categories.name', 'like', "%{$value}%")
                ->orWhere('categories.onec_id', 'like', "%{$value}%")
            ;
        });
    }
}
