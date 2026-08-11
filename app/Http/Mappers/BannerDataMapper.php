<?php

namespace App\Http\Mappers;

use App\Data\BannerData;
use App\Http\Requests\BannerRequest;

final class BannerDataMapper
{
    public function mapFromRequestToNormalized(BannerRequest $request): BannerData
    {
        return new BannerData(
            $request->image_ru,
            $request->image_ro,
            $request->link,
            $request->link_ru,
            $request->link_ro,
            $request->active,
            $request->order,
        );
    }
}
