<?php

declare(strict_types=1);

namespace App\Services\Theme\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

final class ThemeCategoryManager
{




    public function getBreadcrumbsForCategory(Category $category): ?Collection
    {
        $breadcrumbsCollection = collect();
        $breadcrumbsCollection->add($category);

        $parentCategory = $category->parent;

        while ($parentCategory !== null) {
            $breadcrumbsCollection->add($parentCategory);
            $parentCategory = $parentCategory->parent;
        }

        return $breadcrumbsCollection->reverse();
    }
}
