<?php

namespace App\Http\Mappers\Manager;

use App\Data\Manager\ManagerUpdateData;
use App\Http\Requests\Manager\ManagerUpdateRequest;

final class ManagerUpdateDataMapper
{
    public function mapFromRequestToNormalized(ManagerUpdateRequest $request): ManagerUpdateData
    {
        return new ManagerUpdateData(
            firstName: $request->first_name,
            lastName: $request->last_name,
            email: $request->email,
            phone: $request->phone,
            status: $request->status,
            cityId: (int) $request->city_id,
        );
    }
}
