<?php

namespace App\Filters\Theme;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class ThemePriceFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if (is_array($value))
            if (isset($value['from']) && !isset($value['to'])) {
                $query->where(function ($query) use ($value) {
                    $query
                        ->where('products.price', '>=',(int)$value['from'])
                    ;
                });
            }
            if (isset($value['to']) && !isset($value['from'])) {
                $query->where(function ($query) use ($value) {
                    $query
                        ->where('products.price', '<=',(int)$value['to'])
                    ;
                });
            }
            if (isset($value['from']) && $value['to'])
            {
                $query->where(function ($query) use ($value) {
                    $query
                        ->whereBetween('products.price', [(int)$value['from'], (int)$value['to']])
                    ;
                });
            }

    }
}
