<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;


class OrderRepository
{
    private const COUNT_OF_PAGINATION = 12;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Order::query();

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

    public function getById($orderId): ?Order
    {
        return Order::query()->find($orderId);
    }
//
//    public function getByCode($couponCode): ?Order
//    {
//        return Order::where('code', $couponCode)->first();
//    }
//
//    public function getAll() : Collection
//    {
//        return Order::query()->get();
//    }
}
