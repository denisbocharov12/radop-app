<?php

namespace App\Http\Mappers;

use App\Data\FIlial\FilialData;
use App\Http\Requests\Filial\FilialRequest;

class FilialDataMapper
{
    public function mapFromRequestToNormalized(FilialRequest $request): FilialData
    {
        return new FilialData(
            (int) $request->user_id,
            $request->address,
            $request->phone,
            $request->city_id,
        );
    }
}
