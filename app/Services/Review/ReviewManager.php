<?php

declare(strict_types=1);

namespace App\Services\Review;

use App\Data\Review\ReviewData;
use App\Http\Requests\Review\ReviewDeleteRequest;
use App\Http\Requests\Review\ReviewUpdateStatusRequest;
use App\Models\Review;
use App\Models\Order;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Review\ReviewRepository;

final class ReviewManager
{
    public function __construct(
        private readonly ReviewRepository $reviewRepository,
        private readonly ProductRepository $productRepository,
    )
    {
    }

    public function store(ReviewData $reviewData): Review
    {
        $isVerified = $this->checkIfUserPurchasedProduct($reviewData->userId, $reviewData->productOnecId);

        $review = Review::create([
            'user_id' => $reviewData->userId,
            'product_onec_id' => $reviewData->productOnecId,
            'text' => $reviewData->text,
            'score' => $reviewData->score,
            'status' => $reviewData->status,
            'is_verified' => $isVerified,
        ]);

        return $review;
    }

    public function update(ReviewData $reviewData, Review $review): Review
    {
        $review->update([
            'text' => $reviewData->text,
            'score' => $reviewData->score,
            'status' => $reviewData->status,
            'is_verified' => $reviewData->isVerified,
        ]);

        return $review;
    }

    public function delete(ReviewDeleteRequest $request): void
    {
        $reviewId = (int)$request->review_id;
        $review = $this->reviewRepository->getById($reviewId);

        if ($review === null) {
            throw new \Exception('Отзыв не найден');
        }

        $review->delete();
    }

    public function updateStatus(ReviewUpdateStatusRequest $request): void
    {
        $reviewId = (int)$request->review_id;
        $review = $this->reviewRepository->getById($reviewId);

        if ($review === null) {
            throw new \Exception('Отзыв не найден');
        }

        $review->update([
            'status' => $request->status,
        ]);
    }

    private function checkIfUserPurchasedProduct(int $userId, string $productOnecId): bool
    {
        $product = $this->productRepository->getByOnecId($productOnecId);

        if (!$product) {
            return false;
        }

        return Order::query()
            ->where('user_id', $userId)
            ->whereHas('products', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('status', '!=', 'canceled')
            ->exists();
    }
}

