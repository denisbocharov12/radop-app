<?php

namespace App\Repositories\Order;

use App\Data\Order\UpdateOrderStatusesData;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Carbon\Carbon;


class OrderRepository
{
    private const COUNT_OF_PAGINATION = 20;

    public function getAllPaginatedWithFiltersAndSorts(): LengthAwarePaginator
    {
        $query = Order::query()
            ->with(['orderHistory' => function($q) { $q->latest()->limit(1); }])
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->leftJoin('users as managers', 'orders.manager_id', '=', 'managers.id')
            ->leftJoin('profiles as manager_profile', 'managers.id', '=', 'manager_profile.user_id')
            ->select('orders.*');

        if ($search = request('filter.fio')) {
            $query->where(function ($q) use ($search) {
                $q->where('orders.fio', 'like', "%$search%")
                    ->orWhere('profiles.organization_name', 'like', "%$search%");
            });
        }
        if ($manager = request('filter.manager')) {
            $query->where(function ($q) use ($manager) {
                $q->where('manager_profile.first_name', 'like', "%$manager%")
                    ->orWhere('manager_profile.last_name', 'like', "%$manager%");
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
                AllowedFilter::exact('manager_id'),
                'email',
                'order_number',
                'phone',
                'fio',
                'address',
                AllowedFilter::callback('created_at', function ($query, $value) {
                    if (preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $value, $matches)) {
                        $date = Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
                        $query->whereDate('created_at', $date);
                    }
                }),
                'updated_at',
                AllowedFilter::callback('cod_fiscal', function ($query, $value) {
                    $query->where('profiles.cod_fiscal', 'like', "%{$value}%");
                }),
                AllowedFilter::callback('manager', function ($query, $value) {
                    $query->where(function ($q) use ($value) {
                        $q->where('manager_profile.first_name', 'like', "%{$value}%");
                    });
                }),
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
                AllowedSort::field('cod_fiscal', 'profiles.cod_fiscal'),
                AllowedSort::field('manager_first_name', 'manager_profile.first_name'),
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
