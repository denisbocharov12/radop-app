<?php

namespace App\Filters\Theme;

use App\Services\Search\SearchQueryNormalizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

final class ThemeProductSearchFilter implements Filter
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

        $query->where(function ($query) use ($value, $words, $variants) {
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
            ;
        });
    }
}
