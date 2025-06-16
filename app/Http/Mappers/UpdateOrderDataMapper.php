<?php

namespace App\Http\Mappers;

use App\Data\Order\UpdateOrderStatusesData;
use App\Http\Requests\Order\UpdateOrderStatusesRequest;

final class UpdateOrderDataMapper
{
    public function mapFromRequestToNormalized(UpdateOrderStatusesRequest $request): UpdateOrderStatusesData
    {
        return new UpdateOrderStatusesData(
            $request->order_ids,
            $request->status,
        );
    }
}
