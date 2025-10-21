<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Review;

use App\Http\Controllers\Controller;
use App\Http\Mappers\ReviewDataMapper;
use App\Http\Requests\Review\ReviewRequest;
use App\Repositories\Review\ReviewRepository;
use App\Services\Review\ReviewManager;
use Illuminate\Http\Request;

final class ThemeReviewController extends Controller
{
    public function __construct(
        private readonly ReviewManager $reviewManager,
        private readonly ReviewRepository $reviewRepository,
        private readonly ReviewDataMapper $reviewDataMapper,
    )
    {
    }

    public function store(ReviewRequest $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.review_login_required')
            ], 401);
        }

        $hasReviewed = $this->reviewRepository->hasUserReviewedProduct(
            auth()->id(),
            $request->product_onec_id
        );

        if ($hasReviewed) {
            return response()->json([
                'success' => false,
                'message' => __('theme.review_already_exists')
            ], 400);
        }

        try {
            $reviewData = $this->reviewDataMapper->mapFromRequestToNormalized($request);
            $this->reviewManager->store($reviewData);

            return response()->json([
                'success' => true,
                'message' => __('theme.review_success_message')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('theme.review_error_message')
            ], 500);
        }
    }

    public function getProductReviews(Request $request, string $productOnecId)
    {
        $perPage = $request->input('per_page', 10);
        $reviews = $this->reviewRepository->getApprovedByProductOnecIdPaginated($productOnecId, $perPage);
        $averageScore = $this->reviewRepository->getAverageScoreByProductOnecId($productOnecId);
        $totalCount = $this->reviewRepository->getCountByProductOnecId($productOnecId);

        return response()->json([
            'reviews' => $reviews,
            'average_score' => round($averageScore, 1),
            'total_count' => $totalCount,
        ]);
    }
}

