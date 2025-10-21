<?php

namespace App\Http\Mappers;

use App\Data\Review\ReviewData;
use App\Http\Requests\Review\ReviewRequest;
use App\Http\Requests\Review\AdminReviewRequest;

final class ReviewDataMapper
{
    public function mapFromRequestToNormalized(ReviewRequest $request): ReviewData
    {
        return new ReviewData(
            $request->user_id,
            $request->product_onec_id,
            $request->text,
            $request->score,
            false,
            false,
        );
    }

    public function mapFromAdminRequestToNormalized(AdminReviewRequest $request): ReviewData
    {
        return new ReviewData(
            $request->user_id,
            $request->product_onec_id,
            $request->text,
            $request->score,
            $request->status ?? false,
            $request->is_verified ?? false,
        );
    }
}

