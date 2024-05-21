<?php

namespace App\Filters\Theme;

use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
            ->whereIn('onec_id', $value)
            ->get()
            ->pluck('id')
        ;
        dd($attributeIds);
        if ($value !== null)
            $query->where(function ($query) use ($value) {
                $query
                    ->whereIn('products.brand_id',  $value)
                ;
            });
    }
}
