<?php

namespace App\Repositories\DiscountPeriod;

use App\Models\DiscountPeriod;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class DiscountPeriodRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = DiscountPeriod::query();

        return QueryBuilder::for($query)
            ->defaultSort('order')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
        ;
    }

    public function getById($id): ?DiscountPeriod
    {
        return DiscountPeriod::query()->find($id);
    }

    public function getAllForSort(): Collection
    {
        return DiscountPeriod::orderBy('order')
            ->get()
        ;
    }
}
