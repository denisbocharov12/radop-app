<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Setting\DeliverySettingUpdateRequest;
use App\Repositories\Setting\DeliverySettingRepository;
use App\Services\Setting\DeliverySettingManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DeliverySettingController extends Controller
{
    public function __construct(
        private readonly DeliverySettingRepository $deliverySettingRepository,
        private readonly DeliverySettingManager $deliverySettingManager,
    ) {
    }

    public function edit(): View
    {
        $settings = $this->deliverySettingRepository->getSettings();

        return view('setting.delivery', compact('settings'));
    }

    public function update(DeliverySettingUpdateRequest $request): RedirectResponse
    {
        $this->deliverySettingManager->update($request);

        return redirect()->route('setting.delivery.edit')->with('success', 'Настройки доставки обновлены.');
    }
}
