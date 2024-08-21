<?php

namespace App\Http\Mappers;

use App\Data\Favorite\FavoriteData;
use App\Http\Requests\Favorite\FavoriteRequest;

class FavoriteDataMapper
{
    public function mapFromRequestToNormalized(FavoriteRequest $request): FavoriteData
    {
        return new FavoriteData(
            (int) $request->product_id,
        );
    }
}
