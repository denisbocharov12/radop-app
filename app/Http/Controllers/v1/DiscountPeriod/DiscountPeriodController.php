<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\DiscountPeriod;

use App\Exceptions\DeliveryMethod\DeliveryMethodNotFoundException;
use App\Exceptions\DeliveryMethod\DeliveryMethodNotFoundValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\DeliveryMethodDataMapper;
use App\Http\Mappers\DiscountPeriodDataMapper;
use App\Http\Requests\DeliveryMethod\DeliveryMethodDeleteRequest;
use App\Http\Requests\DeliveryMethod\DeliveryMethodRequest;
use App\Http\Requests\DiscountPeriod\DiscountPeriodDeleteRequest;
use App\Http\Requests\DiscountPeriod\DiscountPeriodRequest;
use App\Models\DeliveryMethod;
use App\Models\DiscountPeriod;
use App\Repositories\DeliveryMethod\DeliveryMethodRepository;
use App\Repositories\DiscountPeriod\DiscountPeriodRepository;
use App\Services\DeliveryMethod\DeliveryMethodManager;
use App\Services\DiscountPeriod\DiscountPeriodManager;
use Illuminate\Http\Request;

class DiscountPeriodController extends Controller
{
    public function __construct(
        private readonly DiscountPeriodRepository $discountPeriodRepository,
        private readonly DiscountPeriodDataMapper $discountPeriodDataMapper,
        private readonly DiscountPeriodManager $discountPeriodManager
    )
    {
    }

    public function index(Request $request)
    {
        $query = $request->query('filter');

        $discountPeriods = $this->discountPeriodRepository->getAllPaginatedWithFilters();

        return view('discount_period.index', compact([
            'discountPeriods',
            'query'
        ]));
    }

    public function store(DiscountPeriodRequest $request)
    {
        $discountPeriodData = $this->discountPeriodDataMapper->mapFromRequestToNormalized($request);

        $this->discountPeriodManager->store($discountPeriodData);

        return redirect()->route('discount-period.index');
    }

    public function edit(DiscountPeriod $discountPeriod)
    {
        return view('discount_period.edit', compact([
            'discountPeriod',
        ]));
    }

    public function update(DiscountPeriodRequest $request, DiscountPeriod $discountPeriod)
    {
        $discountPeriodData = $this->discountPeriodDataMapper->mapFromRequestToNormalized($request);

        $this->discountPeriodManager->update($discountPeriodData, $discountPeriod);

        return redirect()->route('discount-period.index');
    }

    public function destroy(DiscountPeriodDeleteRequest $request)
    {
        if (!$request->ajax()) {
            throw new NotAjaxRequestException();
        }

        try {
            $this->discountPeriodManager->delete($request);

            return response()->json(['id' => $request->deliveryMethod_id]);
        } catch (DeliveryMethodNotFoundException $e) {
            throw new DeliveryMethodNotFoundValidationException();
        }
    }

    public function sortDiscountPeriod()
    {
        $discountPeriods = $this->discountPeriodRepository->getAllForSort();

        return view('discount_period.sort', compact([
            'discountPeriods',
        ]));
    }

    public function sortDiscountPeriodOrder(Request $request)
    {
        $discountPeriods = $this->discountPeriodRepository->getAllForSort();

        foreach ($discountPeriods as $discountPeriod) {
            foreach ($request->order as $order) {
                if ($order['id'] == $discountPeriod->id) {
                    $discountPeriod->update(['order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Период скидок успешно отсортированы']);
    }
}
