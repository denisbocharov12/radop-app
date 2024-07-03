<?php

declare(strict_types=1);

namespace App\Services\Theme\Brand;

use App\Models\Brand;
use Illuminate\Support\Collection;

final class ThemeBrandManager
{
    public function getBreadcrumbsForBrand(Brand $brand): ?Collection
    {
        $breadcrumbsCollection = collect();
        $breadcrumbsCollection->add($brand);

        $parentCategory = $brand->parent;

        while ($parentCategory !== null) {
            $breadcrumbsCollection->add($parentCategory);
            $parentCategory = $parentCategory->parent;
        }

        return $breadcrumbsCollection->reverse();
    }
}
