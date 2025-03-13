<?php

namespace App\Filters\Theme;

use App\Models\Attribute;
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

//        if ($value !== null && !empty($value))
//            if (is_array($value[0])) $value = $value[0];
//
//            foreach ($value as $key => $item) {
//                if ($this->isStringFloat($item)) {
//                    $value[$key] = str_replace('.',',', $item);
//                }
//            }

        foreach ($value as $attributeId => $attributeValueIds) {
            $query
                ->whereHas('values', function ($q) use ($query, $attributeValueIds) {
                    $q->where('attribute_values.value->'.str_replace('_', '-', app()->getLocale()), $attributeValueIds);
                });

        }

//        $query
//        ->whereHas('values', function ($q) use ($query, $attributeProductsIds, $value) {
//            $q->whereIn('attribute_values.product_onec_id', array_values(array_unique($attributeProductsIds, SORT_NUMERIC)));
//        });
    }

    private function isStringFloat($string) {
        if(is_numeric($string)) {
            $val = $string+0;

            return is_float($val);
        }

        return false;
    }
}
