<?php

namespace App\Http\Controllers\v1\Client;

use App\Events\PersonalSaleWasChangedEvent;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\CityNotFoundValidationException;
use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\DuplicatedUserEmailValidationException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\ClientDataMapper;
use App\Http\Mappers\ClientUpdateDataMapper;
use App\Http\Requests\Client\ClientRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Http\Requests\User\UserDeleteRequest;
use App\Models\User;
use App\Repositories\City\CityRepository;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\User\UserRepository;
use App\Exceptions\NotAjaxRequestException;
use App\Services\Client\ClientManager;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ClientDataMapper $clientDataMapper,
        private readonly ClientManager $clientManager,
        private readonly ClientUpdateDataMapper $clientUpdateDataMapper,
        private readonly CityRepository $cityRepository,
        private readonly FilialRepository $filialRepository,
    ) {
    }

    public function index(Request $request)
    {
        $query = $request->query('filter');

        $users = $this->userRepository->getUsersPaginatedWithFilters();
        $roles = $this->userRepository->getAllRoles();
        $userTypes = $this->userRepository->getAllUserTypes();
        $cities = $this->cityRepository->getAllSorted();

        return view('client.index', compact([
            'users',
            'roles',
            'userTypes',
            'cities',
            'query'
        ]));
    }

    /**
     * @throws CityNotFoundValidationException
     * @throws DuplicatedUserEmailValidationException
     */
    public function store(ClientRequest $request)
    {
        $clientData = $this->clientDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->clientManager->store($clientData);

            return redirect()->route('client.index');

        } catch (DuplicatedUserEmailException $e) {
            throw new DuplicatedUserEmailValidationException();
        } catch (CityNotFoundException $e) {
            throw new CityNotFoundValidationException();
        }
    }

    /**
     * @throws DuplicatedUserEmailValidationException
     * @throws CityNotFoundValidationException
     */
    public function update(User $user, ClientUpdateRequest $request)
    {
        $clientData = $this->clientUpdateDataMapper->mapFromRequestToNormalized($request);
        $personalSale = $user->sale;

        try {

            $this->clientManager->update($clientData, $user);

            if ($personalSale !== (float) $clientData->sale) {
                event(new PersonalSaleWasChangedEvent($user));
            }

            return redirect()->route('client.index');

        } catch (DuplicatedUserEmailException $e) {
            throw new DuplicatedUserEmailValidationException();
        }  catch (CityNotFoundException $e) {
            throw new CityNotFoundValidationException();
        }

    }

    public function edit(User $user)
    {
        $users = $this->userRepository->getAllUsers();
        $roles = $this->userRepository->getAllRoles();
        $userTypes = $this->userRepository->getAllUserTypes();
        $cities = $this->cityRepository->getAllSorted();

        return view('client.edit', compact([
            'roles',
            'userTypes',
            'user',
            'users',
            'cities'
        ]));
    }

    public function show(User $user)
    {
        $filials = $this->filialRepository->getAllByUserId($user->id);
        $userTypes = $this->userRepository->getAllUserTypes();

        return view('client.show', compact([
            'user',
            'userTypes',
            'filials'
        ]));
    }

    /**
     * @throws UserNotFoundValidationException
     * @throws NotAjaxRequestException
     */
    public function destroy(UserDeleteRequest $request)
    {
        if (!$request->ajax()) {
            throw new NotAjaxRequestException();
        }

        try {
            $this->clientManager->delete($request);

            return response()->json(['id' => $request->user_id]);
        } catch (UserNotFoundException $e) {
            throw new UserNotFoundValidationException();
        }
    }

    /**
     * @throws UserNotFoundValidationException
     */
    public function restore(Request $request)
    {
        try {
            $this->clientManager->restore((int)$request->input('user_id'));

            return redirect()->route('client.index')->with('success', 'Пользователь успешно восстановлен');
        } catch (UserNotFoundException $e) {
            throw new UserNotFoundValidationException();
        }
    }

    public function generateNewPassword(User $user)
    {
        $data = $this->clientManager->generateNewPassword($user);
        $pdf = Pdf::loadView('pdf.generated_password', $data);

        return $pdf->download('user_'.$user->id.'.pdf');
    }
}
