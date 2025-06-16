<?php

namespace App\Repositories\Order;

use App\Data\Order\UpdateOrderStatusesData;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;


class OrderRepository
{
    private const COUNT_OF_PAGINATION = 20;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        $query = Order::query();

        if ($search = request('filter.fio')) {
            $query->where(function ($q) use ($search) {
                $q->where('fio', 'like', "%$search%")
                    ->orWhereHas('user.profile', function ($q2) use ($search) {
                        $q2->where('organization_name', 'like', "%$search%");
                    });
            });
        }

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('city'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('payment_status'),
                AllowedFilter::exact('filial_id'),
                AllowedFilter::exact('user_type'),
                AllowedFilter::exact('payment_method'),
                AllowedFilter::exact('fio'),
                'email',
                'order_number',
                'phone',
                'fio',
                'address',
            ])
            ->defaultSort('-id')
            ->allowedSorts([
                'id',
                'city',
                'status',
                'payment_status',
                'user_id',
                'email',
                'order_number',
                'phone',
                'fio',
                'address',
                'filial_id',
                'delivery_charge',
                'total',
                'created_at',
                'updated_at',
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

    /**
     * @return int
     */
    public function getLastTenMinutesOrders(): int
    {
        return Order::query()
            ->whereBetween('created_at', [
                now()->subMinutes(10),
                now(),
            ])
            ->count();
    }

    public function getOrdersByIds(UpdateOrderStatusesData $data): Collection
    {
        return Order::query()->whereIn('id', $data->order_ids)->get();
    }
}
