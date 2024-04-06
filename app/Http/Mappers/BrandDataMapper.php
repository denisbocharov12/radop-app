<?php

namespace App\Http\Mappers;

use App\Data\Brand\BrandData;
use App\Http\Requests\Brand\BrandRequest;

final class BrandDataMapper
{
    public function mapFromRequestToNormalized(BrandRequest $request): BrandData
    {
        return new BrandData(
            $request->onec_id,
            $request->title,
            $request->slug,
            $request->description,
            $request->status
        );
    }
}
