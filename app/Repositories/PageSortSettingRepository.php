<?php

namespace App\Repositories;

use App\Models\PageSortSetting;
use Illuminate\Database\Eloquent\Collection;

class PageSortSettingRepository
{
    /**
     * @param string $page
     * @return PageSortSetting|null
     */
    public function getByPage(string $page): ?PageSortSetting
    {
        return PageSortSetting::where('page', $page)->first();
    }

    /**
     * @param string $page
     * @param string $defaultSort
     * @return PageSortSetting
     */
    public function setDefaultSort(string $page, string $defaultSort): PageSortSetting
    {
        return PageSortSetting::updateOrCreate(
            ['page' => $page],
            ['default_sort' => $defaultSort]
        );
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return PageSortSetting::all();
    }

    /**
     * @return string
     */
    public function getDefaultSortValueForCategoryPage(): string
    {
        return PageSortSetting::where('page', 'category')->value('default_sort') ?? 'price';
    }

    /**
     * @return string
     */
    public function getDefaultSortValueForBrandPage(): string
    {
        return PageSortSetting::where('page', 'brand')->value('default_sort') ?? 'price';
    }

    /**
     * @return string
     */
    public function getDefaultSortValueForShopPage(): string
    {
        return PageSortSetting::where('page', 'shop')->value('default_sort') ?? 'price';
    }

    /**
     * @return string
     */
    public function getDefaultSortValueForNewProductsPage(): string
    {
        return PageSortSetting::where('page', 'new')->value('default_sort') ?? 'condition';
    }

    /**
     * @return string
     */
    public function getDefaultSortValueForPopularProductsPage(): string
    {
        return PageSortSetting::where('page', 'popular')->value('default_sort') ?? 'popular_order';
    }

    /**
     * @return string
     */
    public function getDefaultSortValueForSaleProductsPage(): string
    {
        return PageSortSetting::where('page', 'sale')->value('default_sort') ?? 'price';
    }
}