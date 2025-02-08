<?php

namespace App\Http\Controllers\v1\Client;

use App\Data\Client\ClientData;
use App\Events\PersonalSaleWasChangedEvent;
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
use App\Repositories\User\UserRepository;
use App\Exceptions\NotAjaxRequestException;
use App\Services\Client\ClientManager;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientController extends Controller
{
    private UserRepository $userRepository;
    private ClientDataMapper $clientDataMapper;
    private ClientManager $clientManager;
    private ClientUpdateDataMapper $clientUpdateDataMapper;


    public function __construct(
        UserRepository   $userRepository,
        ClientDataMapper $clientDataMapper,
        ClientManager    $clientManager,
        ClientUpdateDataMapper $clientUpdateDataMapper
    )
    {
        $this->userRepository = $userRepository;
        $this->clientDataMapper = $clientDataMapper;
        $this->clientManager = $clientManager;
        $this->clientUpdateDataMapper = $clientUpdateDataMapper;
    }

    public function index()
    {
        $users = $this->userRepository->getUsers();
        $roles = $this->userRepository->getAllRoles();
        $userTypes = $this->userRepository->getAllUserTypes();

        return view('client.index', compact([
            'users',
            'roles',
            'userTypes'
        ]));
    }

    public function store(ClientRequest $request)
    {
        $clientData = $this->clientDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->clientManager->store($clientData);

            return redirect()->route('client.index');

        } catch (DuplicatedUserEmailException $e) {
            throw new DuplicatedUserEmailValidationException();
        }
    }

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
        }

    }

    public function edit(User $user)
    {
        $users = $this->userRepository->getUsers();
        $roles = $this->userRepository->getAllRoles();
        $userTypes = $this->userRepository->getAllUserTypes();

        return view('client.edit', compact([
            'roles',
            'userTypes',
            'user'
        ]));
    }

    public function show(User $user)
    {
        $userTypes = $this->userRepository->getAllUserTypes();

        return view('client.show', compact([
            'user',
            'userTypes'
        ]));
    }

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

    public function generateNewPassword(User $user)
    {
        $data = $this->clientManager->generateNewPassword($user);
        $pdf = Pdf::loadView('pdf.generated_password', $data);

        return $pdf->download('user_'.$user->id.'.pdf');
    }
}
