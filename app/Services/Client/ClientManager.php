<?php

namespace App\Services\Client;

use App\Data\Client\ClientData;
use App\Data\Client\ClientUpdateData;
use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\UserNotFoundException;
use App\Http\Requests\User\UserDeleteRequest;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\EntityStatusManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientManager
{
    private UserRepository $userRepository;
    private EntityStatusManager $entityStatusManager;

    public function __construct
    (
        UserRepository $userRepository,
        EntityStatusManager $entityStatusManager
    )
    {
        $this->userRepository = $userRepository;
        $this->entityStatusManager = $entityStatusManager;
    }

    public function store(ClientData $clientData): void
    {
        $status = $this->entityStatusManager->getEntityStatusFromRequest($clientData->status);
        $lastUserNumber = User::query()->get()->last()->id + 1;

        $userName =  strtolower($clientData->firstName[0].'_'.$clientData->lastName.'_'.$clientData->role.'_'.$lastUserNumber);

        $existedUserEmail = $this->userRepository->getFirstByEmailWithTrashed($clientData->email);

        if ($existedUserEmail !== null) {
            throw new DuplicatedUserEmailException();
        }

        $user = User::create([
            'name' => $userName,
            'email' => $clientData->email,
            'password' => Hash::make($clientData->password),
            'email_verified_at' => now(),
            'status' => $status,
            'type_id' => $clientData->typeId,
            'sale' => (float)$clientData->sale,
        ]);

        $user->assignRole($clientData->role);

        $user->save();

        Profile::create([
            'user_id' => $user->id,
            'first_name' => $clientData->firstName,
            'last_name' => $clientData->lastName,
            'phone' => $clientData->phone,
            'address' => $clientData->address,
            'organization_name' => $clientData->organizationName,
            'cod_fiscal' => $clientData->codFiscal,
            'contact_name' => $clientData->contactName,
        ]);

    }

    public function update(ClientUpdateData $clientData, User $user)
    {
        $status = $this->entityStatusManager->getEntityStatusFromRequest($clientData->status);
        $verifiedStatus = $this->entityStatusManager->getEntityStatusFromRequest($clientData->verifiedStatus);

        $user->update([
            'email' => $clientData->email,
            'status' => $status,
            'verified_status' => $verifiedStatus,
            'type_id' => $clientData->typeId,
            'sale' => (float)$clientData->sale,
        ]);

        $user->assignRole($clientData->role);

        $user->save();

        $user->profile->update([
            'first_name' => $clientData->firstName,
            'last_name' => $clientData->lastName,
            'phone' => $clientData->phone,
            'address' => $clientData->address,
            'organization_name' => $clientData->organizationName,
            'cod_fiscal' => $clientData->codFiscal,
            'contact_name' => $clientData->contactName,
        ]);
    }

    public function delete(UserDeleteRequest $request): void
    {
        $userId = (int)$request->user_id;

        $user = $this->userRepository->getById($userId);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $user->delete();
        $user->profile()->delete();
    }

    public function generateNewPassword(User $user): array
    {
        $password = Str::random(10);

        $user->update([
            'password' => Hash::make($password),
        ]);

        $data = $user->toArray();
        $data['profile'] = $user->profile->toArray();
        $data['password'] = $password;

        return $data;
    }
}
