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
            if (is_array($value[0])) $value = $value[0];
            $attributeProductsIds = AttributeValue::query()
                ->whereIn('value->'.str_replace('_', '-', app()->getLocale()), $value)
                ->get()
//                ->pluck('id')
                ->pluck('product_onec_id')
                ->toArray()
            ;

        foreach ($value as $val) {
            $query
                ->whereHas('values', function ($q) use ($query, $attributeProductsIds, $value, $val) {
                    $q->where('attribute_values.value->'.str_replace('_', '-', app()->getLocale()), $val);
                });
        }

//        $query
//        ->whereHas('values', function ($q) use ($query, $attributeProductsIds, $value) {
//            $q->whereIn('attribute_values.product_onec_id', array_values(array_unique($attributeProductsIds, SORT_NUMERIC)));
//        });
    }
}
