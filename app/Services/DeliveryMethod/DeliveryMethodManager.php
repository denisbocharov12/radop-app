<?php

declare(strict_types=1);

namespace App\Services\DeliveryMethod;

use App\Data\DeliveryMethod\DeliveryMethodData;
use App\Exceptions\DeliveryMethod\DeliveryMethodNotFoundException;
use App\Http\Requests\DeliveryMethod\DeliveryMethodDeleteRequest;
use App\Models\DeliveryMethod;
use App\Repositories\DeliveryMethod\DeliveryMethodRepository;
use Illuminate\Support\Str;

final class DeliveryMethodManager
{
    private DeliveryMethodRepository $deliveryMethodRepository;

    public function __construct(
        DeliveryMethodRepository  $deliveryMethodRepository,
    )
    {
        $this->deliveryMethodRepository = $deliveryMethodRepository;
    }

    public function store(DeliveryMethodData $deliveryMethodData): void
    {
        DeliveryMethod::create([
            'name' => [
                'ro' => $deliveryMethodData->name_ro,
                'ru' => $deliveryMethodData->name_ru,
            ],
            'delivery_price' => $deliveryMethodData->delivery_price,
            'min_cart_sum' => $deliveryMethodData->min_cart_sum,
            'status' => $deliveryMethodData->status,
        ]);
    }

    public function update(DeliveryMethodData $deliveryMethodData, DeliveryMethod $deliveryMethod): void
    {
        $deliveryMethod->update([
            'name' => [
                'ro' => $deliveryMethodData->name_ro,
                'ru' => $deliveryMethodData->name_ru,
            ],
            'delivery_price' => $deliveryMethodData->delivery_price,
            'min_cart_sum' => $deliveryMethodData->min_cart_sum,
            'status' => $deliveryMethodData->status,
        ]);
    }

    public function delete(DeliveryMethodDeleteRequest $request): void
    {
        $deliveryMethodId = (int)$request->deliveryMethod_id;

        $deliveryMethod = $this->deliveryMethodRepository->getById($deliveryMethodId);

        if ($deliveryMethod === null) {
            throw new DeliveryMethodNotFoundException();
        }

        $deliveryMethod->delete();
    }
}
