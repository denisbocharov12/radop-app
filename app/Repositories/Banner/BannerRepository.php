<?php

namespace App\Repositories\Banner;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class BannerRepository
{
    private const COUNT_OF_PAGINATION = 20;

    public function getAllPaginated(): LengthAwarePaginator
    {
        return Banner::orderBy('order')
            ->paginate(self::COUNT_OF_PAGINATION)
            ->appends(request()->query());
    }

    /**
     * @return Collection
     */
    public function getAllActiveForFront(): Collection
    {
        $cacheKey = 'banners_active_front_' . app()->getLocale();
        
        return Cache::remember($cacheKey, 3600, function () {
            return Banner::where('active', true)
                ->orderBy('order')
                ->get();
        });
    }

    public function checkIfBannedWithSameOrderExists(string $order, Banner $banner): bool
    {
        return Banner::where('order', $order)
            ->where('active', true)
            ->where('id', '!=', $banner->id)
            ->exists();
    }

    public function getById(int $id): ?Banner
    {
        return Banner::find($id);
    }
}
