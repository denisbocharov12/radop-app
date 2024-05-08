<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class BrandSearchFilter implements Filter
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
                ->where('brands.title', 'like', "%{$value}%")
                ->orWhere('brands.onec_id', 'like', "%{$value}%")
            ;
        });
    }
}
