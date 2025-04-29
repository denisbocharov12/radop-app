<?php

namespace App\Services\Filial;

use App\Data\Filial\FilialData;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\Filial\FilialNotFoundException;
use App\Exceptions\Filial\FilialNotPermittedToStoreException;
use App\Exceptions\User\UserNotFoundException;
use App\Http\Requests\Filial\FilialDeleteRequest;
use App\Models\Filial;
use App\Repositories\City\CityRepository;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;

class FilialManager
{
    public function __construct
    (
        private readonly UserRepository $userRepository,
        private readonly FilialRepository $filialRepository,
        private readonly OrderRepository $orderRepository,
        private readonly CityRepository $cityRepository,
    ) {
    }

    public function store(FilialData $filialData): void
    {
        $existedUser = $this->userRepository->getById($filialData->userId);

        if ($existedUser === null) {
            throw new UserNotFoundException();
        }

        if ($existedUser->type->key_name !== 'iur') {
            throw new FilialNotPermittedToStoreException();
        }

        $existedCity = $this->cityRepository->getById($filialData->cityId);

        if ($existedCity === null) {
            throw new CityNotFoundException();
        }

        $filial = Filial::create([
            'address' => $filialData->address,
            'phone' => $filialData->phone,
            'city_id' => $filialData->cityId,
            'user_id' => $existedUser->id,
        ]);
    }

    public function update(Filial $filial, FilialData $filialData): void
    {
        $existedCity = $this->cityRepository->getById($filialData->cityId);

        if ($existedCity === null) {
            throw new CityNotFoundException();
        }

        $filial->update([
            'address' => $filialData->address,
            'phone' => $filialData->phone,
            'city_id' => $filialData->cityId,
        ]);
    }

    public function delete(FilialDeleteRequest $request): void
    {
        $filialId = (int)$request->filial_id;

        $filial = $this->filialRepository->getById($filialId);

        if ($filial === null) {
            throw new FilialNotFoundException();
        }

        $orders = $this->orderRepository->getAllByFilialId($filial->id);

        foreach ($orders as $order) {
            $order->update(['filial_id' => null]);
        }

        $filial->delete();
    }
}
