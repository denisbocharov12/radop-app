<?php

declare(strict_types=1);

namespace App\Services\Export;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Groups a flat product collection by category so that the "new", "sale",
 * "popular" and "brand" catalogs can be rendered with the same category
 * sub-headers as the category catalog (export task §5).
 *
 * Each product is filed under its first category. Products with no category
 * fall into a trailing "other" group so nothing is silently dropped.
 */
final class ProductCategoryGrouper
{
    /**
     * @return array<int, array{category_name: string, products: Collection<int, Product>}>
     */
    public function group(Collection $products, string $locale): array
    {
        /** @var array<string, list<Product>> $buckets */
        $buckets = [];
        /** @var list<Product> $uncategorised */
        $uncategorised = [];

        foreach ($products as $product) {
            $category = $product->categories->first();

            if ($category === null) {
                $uncategorised[] = $product;
                continue;
            }

            $name = $category->getTranslation('name', $locale);
            if (!is_string($name) || $name === '') {
                $name = (string) $category->name;
            }

            $buckets[$name][] = $product;
        }

        ksort($buckets, SORT_NATURAL | SORT_FLAG_CASE);

        $groups = [];
        foreach ($buckets as $name => $items) {
            $groups[] = [
                'category_name' => $name,
                'products'      => new Collection($items),
            ];
        }

        if ($uncategorised !== []) {
            $groups[] = [
                'category_name' => __('theme.export_other_category'),
                'products'      => new Collection($uncategorised),
            ];
        }

        return $groups;
    }
}
