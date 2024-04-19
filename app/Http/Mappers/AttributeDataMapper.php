<?php

namespace App\Http\Mappers;

use App\Data\Attribute\AttributeData;
use App\Http\Requests\Attribute\AttributeRequest;

final class AttributeDataMapper
{
    public function mapFromRequestToNormalized(AttributeRequest $request): AttributeData
    {
        return new AttributeData(
            $request->onec_id,
            $request->name,
            $request->status,
        );
    }
}
