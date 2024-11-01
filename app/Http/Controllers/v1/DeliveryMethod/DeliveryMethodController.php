<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\DeliveryMethod;

use App\Exceptions\DeliveryMethod\DeliveryMethodNotFoundException;
use App\Exceptions\DeliveryMethod\DeliveryMethodNotFoundValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\DeliveryMethodDataMapper;
use App\Http\Requests\DeliveryMethod\DeliveryMethodDeleteRequest;
use App\Http\Requests\DeliveryMethod\DeliveryMethodRequest;
use App\Models\DeliveryMethod;
use App\Repositories\DeliveryMethod\DeliveryMethodRepository;
use App\Services\DeliveryMethod\DeliveryMethodManager;
use Illuminate\Http\Request;

class DeliveryMethodController extends Controller
{
    private DeliveryMethodRepository $deliveryMethodRepository;
    private DeliveryMethodManager $deliveryMethodManager;
    private DeliveryMethodDataMapper $deliveryMethodDataMapper;

    public function __construct(
        DeliveryMethodRepository $deliveryMethodRepository,
        DeliveryMethodManager $deliveryMethodManager,
        DeliveryMethodDataMapper $deliveryMethodDataMapper
    )
    {
        $this->deliveryMethodRepository = $deliveryMethodRepository;
        $this->deliveryMethodManager = $deliveryMethodManager;
        $this->deliveryMethodDataMapper = $deliveryMethodDataMapper;
    }

    public function index(Request $request)
    {
        $query = $request->query('filter');

        $deliveryMethods = $this->deliveryMethodRepository->getAllPaginatedWithFilters();

        return view('deliveryMethod.index', compact([
            'deliveryMethods',
            'query'
        ]));
    }

    public function store(DeliveryMethodRequest $request)
    {
        $deliveryMethodData = $this->deliveryMethodDataMapper->mapFromRequestToNormalized($request);

        $this->deliveryMethodManager->store($deliveryMethodData);

        return redirect()->route('deliveryMethod.index');
    }

    public function edit(DeliveryMethod $deliveryMethod)
    {
        $deliveryMethods = $this->deliveryMethodRepository->getAllIgnored($deliveryMethod);

        return view('deliveryMethod.edit', compact([
            'deliveryMethod', 'deliveryMethods'
        ]));
    }

    public function update(DeliveryMethodRequest $request, DeliveryMethod $deliveryMethod)
    {
        $deliveryMethodData = $this->deliveryMethodDataMapper->mapFromRequestToNormalized($request);

        $this->deliveryMethodManager->update($deliveryMethodData, $deliveryMethod);

        return redirect()->route('deliveryMethod.index');
    }

    public function destroy(DeliveryMethodDeleteRequest $request)
    {
        if (!$request->ajax()) {
            throw new NotAjaxRequestException();
        }

        try {
            $this->deliveryMethodManager->delete($request);

            return response()->json(['id' => $request->deliveryMethod_id]);
        } catch (DeliveryMethodNotFoundException $e) {
            throw new DeliveryMethodNotFoundValidationException();
        }
    }
}
