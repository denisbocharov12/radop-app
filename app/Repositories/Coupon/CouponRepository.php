<?php

namespace App\Repositories\Coupon;

use App\Models\Coupon;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;


class CouponRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Coupon::query();

        return QueryBuilder::for($query)
            ->allowedFilters([

            ])
            ->defaultSort('id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
            ;
    }

    public function getById($couponId): ?Coupon
    {
        return Coupon::query()->find($couponId);
    }

    public function getByCode($couponCode): ?Coupon
    {
        return Coupon::query()->find($couponCode);
    }

    public function getAll() : Collection
    {
        return Coupon::query()->get();
    }
}
