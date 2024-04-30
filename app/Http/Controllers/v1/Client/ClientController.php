<?php

namespace App\Http\Controllers\v1\Client;

use App\Data\Client\ClientData;
use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\DuplicatedUserEmailValidationException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\ClientDataMapper;
use App\Http\Requests\Client\ClientRequest;
use App\Http\Requests\User\UserDeleteRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Exceptions\NotAjaxRequestException;
use App\Services\Client\ClientManager;

class ClientController extends Controller
{
    private UserRepository $userRepository;
    private ClientDataMapper $clientDataMapper;
    private ClientManager $clientManager;

    public function __construct(
        UserRepository $userRepository,
        ClientDataMapper $clientDataMapper,
        ClientManager $clientManager
    )
    {
        $this->userRepository = $userRepository;
        $this->clientDataMapper = $clientDataMapper;
        $this->clientManager = $clientManager;
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
}
