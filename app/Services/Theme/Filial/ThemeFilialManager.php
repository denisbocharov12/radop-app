<?php

namespace App\Services\Theme\Filial;

use App\Data\Theme\Filial\ThemeFilialData;
use App\Exceptions\Filial\FilialNotPermittedToViewException;
use App\Models\Filial;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\Order\OrderRepository;
use Illuminate\Contracts\Auth\Authenticatable;

final class ThemeFilialManager
{
    public function __construct
    (
        private readonly OrderRepository $orderRepository,
    ) {
    }

    public function store(ThemeFilialData $themeFilialData, Authenticatable $user): void
    {
        $filial = Filial::create([
            'name' => $themeFilialData->name,
            'address' => $themeFilialData->address,
            'contact_name' => $themeFilialData->contactName,
            'user_id' => $user->id,
        ]);
    }

    public function update(Filial $filial, ThemeFilialData $themeFilialData, Authenticatable $user): void
    {
        if (!$user->can('view', $filial))
            throw new FilialNotPermittedToViewException();

        $filial->update([
            'name' => $themeFilialData->name,
            'address' => $themeFilialData->address,
            'contact_name' => $themeFilialData->contactName,
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
