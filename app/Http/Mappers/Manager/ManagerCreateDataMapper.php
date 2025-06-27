<?php

namespace App\Http\Mappers\Manager;

use App\Data\Manager\ManagerCreateData;
use App\Http\Requests\Manager\ManagerCreateRequest;

final class ManagerCreateDataMapper
{
    public function mapFromRequestToNormalized(ManagerCreateRequest $request): ManagerCreateData
    {
        return new ManagerCreateData(
            firstName: $request->first_name,
            lastName: $request->last_name,
            email: $request->email,
            phone: $request->phone,
            password: $request->password,
            cityId: (int) $request->city_id,
        );
    }
}
