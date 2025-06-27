<?php

declare(strict_types=1);

namespace App\Http\Mappers;

use App\Data\Order\AssignManagerData;
use App\Http\Requests\Order\AssignManagerRequest;

final class AssignManagerDataMapper
{
    public function mapFromRequestToNormalized(AssignManagerRequest $request): AssignManagerData
    {
        return new AssignManagerData(
            order_id: (int) $request->order_id,
            manager_id: (int) $request->manager_id,
        );
    }
}
