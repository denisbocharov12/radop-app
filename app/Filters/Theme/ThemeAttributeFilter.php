<?php

namespace App\Filters\Theme;

use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Filters\Filter;

final class ThemeAttributeFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if ($value !== null && !empty($value))
            $attributeProductsIds = AttributeValue::query()
                ->whereIn('value->'.str_replace('_', '-', app()->getLocale()), $value)
                ->get()
                ->pluck('id')
                ->toArray()
            ;

        $query
        ->whereHas('values', function ($q) use ($query, $attributeProductsIds, $value) {
            $q->whereIn('attribute_values.id', $attributeProductsIds);
        });
    }
}
