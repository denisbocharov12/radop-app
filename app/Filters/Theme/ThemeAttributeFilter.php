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
//        $attributeIds = collect();



//        foreach ($value as $val)
//        {
////            $attributeValue = AttributeValue::query()
////                ->where('id', $val)
////                ->first()
////                ->getTranslations('value')
////            ;
//            $attributeProductsIds = AttributeValue::query()
//                ->where('value->'.str_replace('_', '-', app()->getLocale()), $val)
//                ->get()
//                ->pluck('id')
//                ->toArray()
//            ;
//
//        }


        $attributeIdss = AttributeValue::query()
            ->whereIn('id', $value)
            ->get()
            ->pluck('id')
            ->toArray()
        ;

        if ($value !== null && !empty($value))

            $attributeProductsIds = AttributeValue::query()
                ->whereIn('value->'.str_replace('_', '-', app()->getLocale()), $value)
                ->get()
                ->pluck('id')
                ->toArray()
            ;

//            foreach ($value as $val)
//            {
//                $attributeValue = AttributeValue::query()
//                    ->where('id', $val)
//                    ->first()
//                    ->getTranslations('value')
//                ;
//
//                $attributeProductsIds = AttributeValue::query()
//                    ->where('value', json_encode($attributeValue, JSON_UNESCAPED_UNICODE))
//                    ->get()
//                    ->pluck('id')
//                    ->toArray()
//                ;
//
//            }

        $query
            ->join('attribute_values', 'attribute_values.product_onec_id', '=', 'products.onec_id')
            ->whereIn('attribute_values.id', $attributeProductsIds)
        ;

//            $query
//                ->join('attribute_values', 'attribute_values.product_onec_id', '=', 'products.onec_id')
//                ->whereIn('attribute_values.id', $attributeIds->toArray())
//            ;
    }
}
