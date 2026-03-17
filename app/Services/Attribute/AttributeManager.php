<?php

namespace App\Services\Attribute;

use App\Data\Attribute\AttributeCategorySortOrderData;
use App\Data\Attribute\AttributeSortByCategoryPageData;
use App\Models\Category;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Category\CategoryRepository;
use App\Services\ToBooleanService;
use Illuminate\Support\Collection;

final class AttributeManager extends ToBooleanService
{
    public function __construct(
        private readonly AttributeRepository $attributeRepository,
        private readonly CategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @param string|null $categoryOnecId
     * @return AttributeSortByCategoryPageData
     */
    public function getSortByCategoryPageData(?string $categoryOnecId): AttributeSortByCategoryPageData
    {
        $categories = $this->categoryRepository->getAllCached();
        $this->assignPathLabels($categories);
        $selectedCategory = $categoryOnecId
            ? Category::where('onec_id', $categoryOnecId)->first()
            : null;
        $attributesForSort = $selectedCategory
            ? $this->attributeRepository->getAttributesForCategorySort($selectedCategory)
            : collect();

        return new AttributeSortByCategoryPageData(
            categories: $categories,
            selectedCategory: $selectedCategory,
            attributesForSort: $attributesForSort,
        );
    }

    /**
     * @param AttributeCategorySortOrderData $data
     * @return void
     */
    public function saveCategoryAttributeOrder(AttributeCategorySortOrderData $data): void
    {
        $category = Category::where('onec_id', $data->categoryOnecId)->firstOrFail();
        $sync = [];
        foreach ($data->order as $item) {
            $sync[$item['id']] = ['sort_order' => $item['position']];
        }
        $category->attributes()->sync($sync);
    }

    /**
     * @param Collection<int, Category> $categories
     * @return void
     */
    private function assignPathLabels(Collection $categories): void
    {
        $byOnec = $categories->keyBy('onec_id');
        $categories->each(function (Category $cat) use ($byOnec): void {
            $path = [$cat->name];
            $current = $cat;
            while ($current->parent_id !== null) {
                $parent = $byOnec->get($current->parent_id);
                if ($parent === null) {
                    break;
                }
                array_unshift($path, $parent->name);
                $current = $parent;
            }
            $cat->path_label = implode(' › ', $path);
        });
    }
}
