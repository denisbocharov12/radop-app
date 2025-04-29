<?php

namespace App\Services\Theme\Filial;

use App\Data\Theme\Filial\ThemeFilialData;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\Filial\FilialNotPermittedToViewException;
use App\Models\Filial;
use App\Repositories\City\CityRepository;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\Order\OrderRepository;
use Illuminate\Contracts\Auth\Authenticatable;

final class ThemeFilialManager
{
    public function __construct
    (
        private readonly OrderRepository $orderRepository,
        private readonly CityRepository $cityRepository,
    ) {
    }

    public function store(ThemeFilialData $themeFilialData, Authenticatable $user): void
    {
        $existedCity = $this->cityRepository->getById($themeFilialData->cityId);

        if ($existedCity === null) {
            throw new CityNotFoundException();
        }

        $filial = Filial::create([
            'address' => $themeFilialData->address,
            'phone' => $themeFilialData->phone,
            'user_id' => $user->id,
            'city_id' => $themeFilialData->cityId,
        ]);
    }

    public function update(Filial $filial, ThemeFilialData $themeFilialData, Authenticatable $user): void
    {
        if (!$user->can('view', $filial))
            throw new FilialNotPermittedToViewException();

        $existedCity = $this->cityRepository->getById($themeFilialData->cityId);

        if ($existedCity === null) {
            throw new CityNotFoundException();
        }

        $filial->update([
            'address' => $themeFilialData->address,
            'phone' => $themeFilialData->phone,
            'city_id' => $themeFilialData->cityId,
        ]);
    }

    public function delete(Filial $filial, Authenticatable $user): void
    {
        if (!$user->can('view', $filial))
            throw new FilialNotPermittedToViewException();

        $orders = $this->orderRepository->getAllByFilialId($filial->id);

        foreach ($orders as $order) {
            $order->update(['filial_id' => null]);
        }

        $filial->delete();
    }
}
