<?php

namespace App\Http\Mappers;

use App\Data\Client\ClientData;
use App\Http\Requests\Client\ClientRequest;

final class ClientDataMapper
{
    public function mapFromRequestToNormalized(ClientRequest $request): ClientData
    {
        return new ClientData(
            $request->firstName,
            $request->lastName,
            $request->email,
            $request->phone,
            $request->role,
            $request->password,
            $request->status,
            $request->address,
            $request->organization_name,
            $request->cod_fiscal,
            $request->contact_name,
        );
    }
}
