<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Manager;

use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Manager\ManagerCreateDataMapper;
use App\Http\Mappers\Manager\ManagerUpdateDataMapper;
use App\Http\Requests\Manager\ManagerCreateRequest;
use App\Http\Requests\Manager\ManagerUpdateRequest;
use App\Repositories\City\CityRepository;
use App\Repositories\User\UserRepository;
use App\Services\Manager\ManagerListManager;
use Illuminate\Http\Request;

class ManagerListController extends Controller
{
    public function __construct(
        private readonly ManagerCreateDataMapper $managerCreateDataMapper,
        private readonly ManagerUpdateDataMapper $managerUpdateDataMapper,
        private readonly CityRepository $cityRepository,
        private readonly UserRepository $userRepository,
        private readonly ManagerListManager $managerListManager,
    ) {
    }

    public function index()
    {
        $managers = $this->userRepository->getManagersPaginated();
        $cities = $this->cityRepository->getAllSorted();

        return view('v1.manager.index', [
            'managers' => $managers,
            'cities' => $cities,
        ]);
    }

    /**
     * @throws UserNotFoundValidationException
     */
    public function store(ManagerCreateRequest $request)
    {
        $data = $this->managerCreateDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->managerListManager->store($data);

            return redirect()->route('manager.list.index')->with('success', 'Менеджер успешно создан.');
        } catch (UserNotFoundException) {
            throw new UserNotFoundValidationException();
        }
    }

    public function show($user)
    {
        $manager = $this->userRepository->getById($user);

        return view('v1.manager.show', ['manager' => $manager]);
    }

    public function editForm($user)
    {
        $manager = $this->userRepository->getById($user);
        $cities = $this->cityRepository->getAllSorted();

        return view('v1.manager.edit', [
            'manager' => $manager,
            'cities' => $cities,
        ]);
    }

    /**
     * @throws UserNotFoundValidationException
     */
    public function updateForm(ManagerUpdateRequest $request, $user)
    {
        $data = $this->managerUpdateDataMapper->mapFromRequestToNormalized($request);

        try {
            $manager = $this->managerListManager->update($data, $user);

            return redirect()->route('manager.list.index', $manager->id);
        } catch (UserNotFoundException) {
            throw new UserNotFoundValidationException();
        }
    }

    public function destroy(Request $request)
    {
        $user = $this->userRepository->getById($request->user_id);

        if ($user) {
            $user->delete();
            return response()->json(['success' => 'Менеджер успешно удален.']);
        }

        return response()->json(['error' => 'Менеджер не найден.'], 404);
    }
}
