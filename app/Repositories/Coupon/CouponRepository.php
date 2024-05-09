<?php

namespace App\Repositories\Coupon;

use App\Models\Coupon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;


final class CouponRepository
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
        return Coupon::find($couponId);
    }

    public function getByCode($couponCode): ?Coupon
    {
        return Coupon::where('code', $couponCode)->first();
    }

    public function getActiveByCode($couponCode): ?Coupon
    {
        return Coupon::where('code', $couponCode)->where('status', true)->first();
    }

    public function getActiveBetweenStartAndEndDateByCode(string $couponCode, Carbon $date): Coupon
    {
        return Coupon::where('code', $couponCode)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first()
        ;
    }

    public function getAll() : Collection
    {
        return Coupon::query()->get();
    }
}
