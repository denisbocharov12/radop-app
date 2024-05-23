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

        $attributeIds = AttributeValue::query()
            ->whereIn('id', $value)
            ->get()
            ->pluck('id')
        ;

        if ($value !== null && !empty($value))
            $query
                ->join('attribute_values', 'attribute_values.product_onec_id', '=', 'products.onec_id')
                ->whereIn('attribute_values.id', $attributeIds)
            ;
    }
}
