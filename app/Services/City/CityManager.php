<?php

declare(strict_types=1);

namespace App\Services\City;

use App\Data\City\CityData;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\CityUniqueNameException;
use App\Http\Requests\City\CityDeleteRequest;
use App\Http\Requests\City\CityRequest;
use App\Models\City;
use App\Repositories\City\CityRepository;
use Illuminate\Support\Str;

final class CityManager
{
    private CityRepository $cityRepository;

    public function __construct(
        CityRepository  $cityRepository,
    )
    {
        $this->cityRepository = $cityRepository;
    }

    public function store(CityData $cityData): void
    {
        $existedCity = $this->cityRepository->getByName($cityData->name_ro);

        if ($existedCity !== null) {
            throw new CityUniqueNameException();
        }

        $city = City::create([
            'name' => [
                'ro' => $cityData->name_ro,
                'ru' => $cityData->name_ru,
            ],
            'delivery_sum' => $cityData->deliverySum,
            'required_sum' => $cityData->requiredSum,
        ]);

        $city->slug = Str::slug($cityData->name_ro) . '-' . $city->id;

        $city->save();
    }

    public function update(CityData $cityData, City $city): void
    {
        if ($city->name !== $cityData->name_ro) {
            $existedCity = $this->cityRepository->getByName($cityData->name_ro);

            if ($existedCity !== null) {
                throw new CityUniqueNameException();
            }
        }

        $city->update([
            'name' => [
                'ro' => $cityData->name_ro,
                'ru' => $cityData->name_ru,
            ],
            'delivery_sum' => $cityData->deliverySum,
            'required_sum' => $cityData->requiredSum,
        ]);

        $city->slug = Str::slug($cityData->name_ro) . '-' . $city->id;

        $city->save();
    }

    public function delete(CityDeleteRequest $request): void
    {
        $cityId = (int)$request->city_id;

        $city = $this->cityRepository->getById($cityId);

        if ($city === null) {
            throw new CityNotFoundException();
        }

        $city->delete();
    }
}
