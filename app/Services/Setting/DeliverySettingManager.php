<?php

declare(strict_types=1);

namespace App\Services\Setting;

use App\Http\Requests\Setting\DeliverySettingUpdateRequest;
use App\Models\DeliverySetting;
use App\Repositories\Setting\DeliverySettingRepository;

final class DeliverySettingManager
{
    public function __construct(
        private readonly DeliverySettingRepository $deliverySettingRepository,
    ) {
    }

    public function update(DeliverySettingUpdateRequest $request): DeliverySetting
    {
        return $this->deliverySettingRepository->save($request->toAttributes());
    }
}
