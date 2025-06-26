<?php

namespace App\Services\Manager;

use App\Data\Filial\FilialData;
use App\Data\Manager\ManagerCreateData;
use App\Data\Manager\ManagerUpdateData;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\Filial\FilialNotFoundException;
use App\Exceptions\Filial\FilialNotPermittedToStoreException;
use App\Exceptions\User\UserNotFoundException;
use App\Http\Requests\Filial\FilialDeleteRequest;
use App\Models\Filial;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\City\CityRepository;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;
use App\Services\EntityStatusManager;
use Illuminate\Support\Facades\Hash;

class ManagerListManager
{
    public function __construct
    (
        private readonly UserRepository $userRepository,
        private readonly EntityStatusManager $entityStatusManager,
    ) {
    }

    public function store(ManagerCreateData $data): void
    {
        $lastUserNumber = User::query()->withTrashed()->get()->count() + 1;

        $userName =  strtolower($data->firstName[0].'_'.$data->lastName.'_'. 'manager' .'_'.$lastUserNumber);

        $user = User::create([
            'name' => $userName,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'status' => true,
            'email_verified_at' => now(),
            'city_id' => $data->cityId,
        ]);

        Profile::query()->create([
            'user_id' => $user->id,
            'first_name' => $data->firstName,
            'last_name' => $data->lastName,
            'phone' => $data->phone,
        ]);

        $user->assignRole('manager');

        $user->save();
    }

    public function update(ManagerUpdateData $data, $user)
    {
        $manager = $this->userRepository->getById($user);

        if ($manager === null) {
            throw new UserNotFoundException();
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($data->status);

        $manager->update([
            'email' => $data->email,
            'city_id' => $data->cityId,
            'status' => $status,
        ]);

        $manager->profile()->update([
            'first_name' => $data->firstName,
            'last_name' => $data->lastName,
            'phone' => $data->phone,
        ]);

        return $manager;
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
