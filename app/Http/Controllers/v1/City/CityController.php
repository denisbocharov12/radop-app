<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\City;

use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\CityNotFoundValidationException;
use App\Exceptions\City\CityUniqueNameException;
use App\Exceptions\City\CityUniqueNameValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\CityDataMapper;
use App\Http\Requests\City\CityDeleteRequest;
use App\Http\Requests\City\CityRequest;
use App\Models\City;
use App\Repositories\City\CityRepository;
use App\Services\City\CityManager;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private CityRepository $cityRepository;
    private CityManager $cityManager;
    private CityDataMapper $cityDataMapper;

    public function __construct(
        CityRepository $cityRepository,
        CityManager $cityManager,
        CityDataMapper $cityDataMapper
    )
    {
        $this->cityRepository = $cityRepository;
        $this->cityManager = $cityManager;
        $this->cityDataMapper = $cityDataMapper;
    }

    public function index(Request $request)
    {
        $query = $request->query('filter');

        $cities = $this->cityRepository->getAllPaginatedWithFilters();

        return view('city.index', compact([
            'cities',
            'query'
        ]));
    }

    public function store(CityRequest $request)
    {
        $cityData = $this->cityDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->cityManager->store($cityData);

            return redirect()->route('city.index');
        } catch (CityUniqueNameException $e) {
            throw new CityUniqueNameValidationException();
        }
    }

    public function edit(City $city)
    {
        $cities = $this->cityRepository->getAllIgnored($city);

        return view('city.edit', compact([
            'city', 'cities'
        ]));
    }

    public function update(CityRequest $request, City $city)
    {
        $cityData = $this->cityDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->cityManager->update($cityData, $city);

            return redirect()->route('city.index');
        } catch (CityUniqueNameException) {
            throw new CityUniqueNameValidationException();
        }
    }

    public function destroy(CityDeleteRequest $request)
    {
        if (!$request->ajax()) {
            throw new NotAjaxRequestException();
        }

        try {
            $this->cityManager->delete($request);

            return response()->json(['id' => $request->city_id]);
        } catch (CityNotFoundException $e) {
            throw new CityNotFoundValidationException();
        }
    }

    public function sort()
    {
        $cities = $this->cityRepository->getAllSorted();

        return view('city.sort', compact([
            'cities',
        ]));
    }

    public function sortOrder(Request $request)
    {
        $cities = $this->cityRepository->getAllSorted();

        foreach ($cities as $city) {
            foreach ($request->order as $order) {
                if ($order['id'] == $city->id) {
                    $city->update(['order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Города успешно отсортированы']);
    }
}
