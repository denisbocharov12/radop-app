<?php

namespace App\Repositories;

use App\Models\PageSortSetting;
use Illuminate\Database\Eloquent\Collection;

class PageSortSettingRepository
{
    public function getByPage(string $page): ?PageSortSetting
    {
        return PageSortSetting::where('page', $page)->first();
    }

    public function setDefaultSort(string $page, string $defaultSort): PageSortSetting
    {
        return PageSortSetting::updateOrCreate(
            ['page' => $page],
            ['default_sort' => $defaultSort]
        );
    }

    public function getAll(): Collection
    {
        return PageSortSetting::all();
    }

    public function getDefaultSortValueForCategoryPage(): string
    {
        return PageSortSetting::where('page', 'category')->value('default_sort') ?? 'price';
    }

    public function getDefaultSortValueForBrandPage(): string
    {
        return PageSortSetting::where('page', 'brand')->value('default_sort') ?? 'price';
    }

    public function getDefaultSortValueForShopPage(): string
    {
        return PageSortSetting::where('page', 'shop')->value('default_sort') ?? 'price';
    }
}
