<?php

namespace App\Http\Controllers\v1\Filial;

use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\CityNotFoundValidationException;
use App\Exceptions\Favorite\FavoriteNotFoundException;
use App\Exceptions\Favorite\FavoriteNotFoundValidationException;
use App\Exceptions\Filial\FilialNotFoundException;
use App\Exceptions\Filial\FilialNotFoundValidationException;
use App\Exceptions\Filial\FilialNotPermittedToStoreException;
use App\Exceptions\Filial\FilialNotPermittedToStoreValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\FilialDataMapper;
use App\Http\Requests\Filial\FilialDeleteRequest;
use App\Http\Requests\Filial\FilialRequest;
use App\Models\Filial;
use App\Repositories\City\CityRepository;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\User\UserRepository;
use App\Services\Filial\FilialManager;

final class FilialController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly FilialDataMapper $filialDataMapper,
        private readonly FilialRepository $filialRepository,
        private readonly FilialManager $filialManager,
        private readonly CityRepository $cityRepository,
    ) {
    }

    public function index()
    {
        $users = $this->userRepository->getAllIur();
        $filials = $this->filialRepository->getAllPaginatedWithFilters();
        $cities = $this->cityRepository->getAll();

        return view('filial.index', compact([
            'filials',
            'users',
            'cities',
        ]));
    }

    public function store(FilialRequest $request)
    {
        $filialData = $this->filialDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->filialManager->store($filialData);

            return redirect()->route('filial.index');

        } catch (UserNotFoundException) {
            throw new UserNotFoundValidationException();
        } catch (FilialNotPermittedToStoreException) {
            throw new FilialNotPermittedToStoreValidationException();
        }  catch (CityNotFoundException) {
            throw new CityNotFoundValidationException();
        }
    }

    public function update(Filial $filial, FilialRequest $request)
    {
        $filialData = $this->filialDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->filialManager->update($filial, $filialData);

            return redirect()->route('filial.index');

        } catch (UserNotFoundException $e) {
            throw new UserNotFoundValidationException();
        }  catch (CityNotFoundException) {
            throw new CityNotFoundValidationException();
        }
    }

    public function edit(Filial $filial)
    {
        $cities = $this->cityRepository->getAll();

        return view('filial.edit', compact([
            'filial',
            'cities'
        ]));
    }

    public function destroy(FilialDeleteRequest $request)
    {
        if (!$request->ajax()) {
            throw new NotAjaxRequestException();
        }

        try {
            $this->filialManager->delete($request);

            return response()->json(['id' => $request->filial_id]);
        } catch (FilialNotFoundException $e) {
            throw new FilialNotFoundValidationException();
        }
    }
}
