<?php

namespace App\Http\Mappers;

use App\Data\Client\ClientUpdateData;
use App\Http\Requests\Client\ClientUpdateRequest;

final class ClientUpdateDataMapper
{
    public function mapFromRequestToNormalized(ClientUpdateRequest $request): ClientUpdateData
    {
        return new ClientUpdateData(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->phone,
            $request->role,
            $request->status,
            $request->address,
            $request->organization_name,
            $request->cod_fiscal,
            $request->contact_name,
            $request->type_id,
            $request->sale,
            $request->city_id,
        );
    }
}
