<?php

namespace App\Repositories\Review;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class ReviewRepository
{
    private const COUNT_OF_PAGINATION = 20;

    public function getAllPaginatedWithFilters(): LengthAwarePaginator
    {
        return Review::query()
            ->with(['user.profile', 'user.type', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(self::COUNT_OF_PAGINATION);
    }

    public function getById(int $reviewId): ?Review
    {
        return Review::query()->find($reviewId);
    }

    public function getByProductOnecId(string $productOnecId): Collection
    {
        return Review::query()
            ->where('product_onec_id', $productOnecId)
            ->where('status', true)
            ->with(['user.profile', 'user.type'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getApprovedByProductOnecIdPaginated(string $productOnecId, int $perPage = 10): LengthAwarePaginator
    {
        return Review::query()
            ->where('product_onec_id', $productOnecId)
            ->where('status', true)
            ->with(['user.profile', 'user.type'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getAverageScoreByProductOnecId(string $productOnecId): float
    {
        return (float) Review::query()
            ->where('product_onec_id', $productOnecId)
            ->where('status', true)
            ->avg('score') ?? 0;
    }

    public function getCountByProductOnecId(string $productOnecId): int
    {
        return Review::query()
            ->where('product_onec_id', $productOnecId)
            ->where('status', true)
            ->count();
    }

    public function hasUserReviewedProduct(int $userId, string $productOnecId): bool
    {
        return Review::query()
            ->where('user_id', $userId)
            ->where('product_onec_id', $productOnecId)
            ->exists();
    }

    public function getByUserId(int $userId): Collection
    {
        return Review::query()
            ->where('user_id', $userId)
            ->with(['product', 'user.profile', 'user.type'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPendingReviewsCount(): int
    {
        return Review::query()
            ->where('status', false)
            ->count();
    }
}

