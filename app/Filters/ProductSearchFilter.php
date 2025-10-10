<?php

namespace App\Filters;

use App\Models\Brand;
use App\Models\Category;
use App\Services\Search\SearchQueryNormalizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class ProductSearchFilter implements Filter
{
    /**
     * @param Builder<Model> $query
     * @param mixed $value
     * @param string $property
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $searchQueryNormalizer = app(SearchQueryNormalizer::class);
        
        $words = $searchQueryNormalizer->extractWords($value);
        $variants = $searchQueryNormalizer->generateSearchVariants($value);

        $brandsIds = Brand::query()
            ->where(function ($brandQuery) use ($variants, $value) {
                foreach ($variants as $variant) {
                    $brandQuery->orWhere('title', 'like', "%{$variant}%");
                }
                $brandQuery->orWhere('title', 'like', "%{$value}%");
            })
            ->get()
            ->pluck('id')
        ;

        $query->where(function ($query) use ($value, $brandsIds, $words, $variants) {
            foreach ($variants as $variant) {
                $query->orWhere('products.title', 'like', "%{$variant}%");
                $query->orWhere('products.onec_id', 'like', "%{$variant}%");
            }

            if (count($words) > 1) {
                $query->orWhere(function ($subQuery) use ($words) {
                    foreach ($words as $word) {
                        $subQuery->where('products.title', 'like', "%{$word}%");
                    }
                });
            }

            $query->orWhere('products.title', 'like', "%{$value}%")
                ->orWhere('products.onec_id', 'like', "%{$value}%")
                ->orWhereIn('products.brand_id', $brandsIds)
            ;
        });
    }
}
