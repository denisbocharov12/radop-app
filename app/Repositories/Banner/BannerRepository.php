<?php

namespace App\Repositories\Banner;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final class BannerRepository
{
    private const COUNT_OF_PAGINATION = 20;

    public function getAllPaginated(): LengthAwarePaginator
    {
        return Banner::orderBy('order')
            ->paginate(self::COUNT_OF_PAGINATION)
            ->appends(request()->query());
    }

    public function getAllActiveForFront(): Collection
    {
        return Banner::where('active', true)->orderBy('order')->get();
    }
}
