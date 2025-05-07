<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;


class OrderRepository
{
    private const COUNT_OF_PAGINATION = 20;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Order::query();

        return QueryBuilder::for($query)
            ->allowedFilters([

            ])
            ->defaultSort('-id')
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

    public function getByOrderNumber($orderCode): ?Order
    {
        return Order::where('order_number', $orderCode)->first();
    }

    public function getAllByFilialId(int $filialId): ?Collection
    {
        return Order::where('filial_id', $filialId)->get();
    }

    public function getByUserIdPaginated(int $userId): LengthAwarePaginator
    {
        $query = Order::query();

        return QueryBuilder::for($query)
            ->allowedFilters([
            ])
            ->where('user_id', $userId)
            ->defaultSort('-id')
            ->allowedSorts([
                'id',
            ])
            ->paginate(self::COUNT_OF_PAGINATION)
        ;
    }
}
