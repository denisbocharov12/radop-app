<?php

namespace App\Http\Mappers;

use App\Data\Favorite\FavoriteData;
use App\Data\Filial\FilialData;
use App\Http\Requests\Favorite\FavoriteRequest;
use App\Http\Requests\Filial\FilialRequest;

class FilialDataMapper
{
    public function mapFromRequestToNormalized(FilialRequest $request): FilialData
    {
        return new FilialData(
            (int) $request->user_id,
            $request->name,
            $request->address,
            $request->contact_name
        );
    }
}
