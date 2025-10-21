<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Review;

use App\Http\Controllers\Controller;
use App\Http\Mappers\ReviewDataMapper;
use App\Http\Requests\Review\AdminReviewRequest;
use App\Http\Requests\Review\ReviewDeleteRequest;
use App\Http\Requests\Review\ReviewUpdateStatusRequest;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Review\ReviewRepository;
use App\Services\Review\ReviewManager;

final class AdminReviewController extends Controller
{
    public function __construct(
        private readonly ReviewManager $reviewManager,
        private readonly ReviewRepository $reviewRepository,
        private readonly ReviewDataMapper $reviewDataMapper,
    )
    {
    }

    public function index()
    {
        $reviews = $this->reviewRepository->getAllPaginatedWithFilters();
        $pendingCount = $this->reviewRepository->getPendingReviewsCount();

        return view('review.index', compact('reviews', 'pendingCount'));
    }

    public function create()
    {
        $users = User::query()->orderBy('name')->get();
        $products = Product::query()->orderBy('title')->get();

        return view('review.create', compact('users', 'products'));
    }

    public function store(AdminReviewRequest $request)
    {
        $reviewData = $this->reviewDataMapper->mapFromAdminRequestToNormalized($request);

        try {
            $this->reviewManager->store($reviewData);
            return redirect()->route('review.index')->with('success', 'Отзыв успешно создан');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Review $review)
    {
        $users = User::query()->orderBy('name')->get();
        $products = Product::query()->orderBy('title')->get();

        return view('review.edit', compact('review', 'users', 'products'));
    }

    public function update(AdminReviewRequest $request, Review $review)
    {
        $reviewData = $this->reviewDataMapper->mapFromAdminRequestToNormalized($request);

        try {
            $this->reviewManager->update($reviewData, $review);
            return redirect()->route('review.index')->with('success', 'Отзыв успешно обновлен');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(ReviewDeleteRequest $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'Not an AJAX request'], 400);
        }

        try {
            $this->reviewManager->delete($request);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateStatus(ReviewUpdateStatusRequest $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'Not an AJAX request'], 400);
        }

        try {
            $this->reviewManager->updateStatus($request);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

