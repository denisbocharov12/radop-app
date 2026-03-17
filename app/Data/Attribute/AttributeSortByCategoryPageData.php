<?php

declare(strict_types=1);

namespace App\Data\Attribute;

use App\Models\Category;
use Illuminate\Support\Collection;

/**
 * @property Collection $categories
 * @property Category|null $selectedCategory
 * @property Collection $attributesForSort
 */
final class AttributeSortByCategoryPageData
{
    /**
     * @param Collection<int, Category> $categories
     * @param Collection $attributesForSort
     */
    public function __construct(
        public readonly Collection $categories,
        public readonly ?Category $selectedCategory,
        public readonly Collection $attributesForSort,
    ) {
    }
}
