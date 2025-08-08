<?php

namespace App\Repositories\User;

use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class UserReportRepository
{
    /**
     * @param string $startDate
     * @param string $endDate
     * @param int $userId
     * @return Collection
     */
    public function getUserOrderItemsForReport(string $startDate, string $endDate, int $userId): Collection
    {
        return OrderItem::query()
            ->with(['order.user.profile', 'order.user.type', 'product'])
            ->whereHas('order', function ($query) use ($startDate, $endDate, $userId) {
                $query->where('user_id', $userId)
                    ->whereBetween('created_at', [
                        Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay(),
                        Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay(),
                    ]);
            })
            ->get()
            ->sortByDesc(function ($item) {
                return $item->order?->created_at;
            });
    }
}
