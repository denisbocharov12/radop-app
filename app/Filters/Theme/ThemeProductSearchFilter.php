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
        $searchRelevanceService = app(\App\Services\Search\SearchRelevanceService::class);
        
        $words = $searchQueryNormalizer->extractWords($value);
        $variants = $searchQueryNormalizer->generateSearchVariants($value);
        $stemmedWords = $searchQueryNormalizer->stemWords($words);
        $normalizedValue = $searchQueryNormalizer->normalize($value);

        $query->where(function ($query) use ($value, $words, $variants, $stemmedWords) {
            foreach ($variants as $variant) {
                $query->orWhere('products.title', 'like', "%{$variant}%");
                $query->orWhere('products.onec_id', 'like', "%{$variant}%");
            }

            foreach ($stemmedWords as $stem) {
                $query->orWhere('products.title', 'like', "%{$stem}%");
            }

            if (count($words) > 1) {
                $query->orWhere(function ($subQuery) use ($words) {
                    foreach ($words as $word) {
                        $subQuery->where('products.title', 'like', "%{$word}%");
                    }
                });
                
                $query->orWhere(function ($subQuery) use ($stemmedWords) {
                    foreach ($stemmedWords as $stem) {
                        $subQuery->where('products.title', 'like', "%{$stem}%");
                    }
                });
            }

            $query->orWhere('products.title', 'like', "%{$value}%")
                ->orWhere('products.onec_id', 'like', "%{$value}%")
            ;
        });

        $relevance = $searchRelevanceService->getRelevanceOrderSql($normalizedValue);
        $query->orderByRaw($relevance['sql'], $relevance['bindings']);
    }
}
