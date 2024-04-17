<?php

namespace App\Http\Controllers\v1\Order;

use App\Enums\OrderPaymentMethods;
use App\Enums\OrderPaymentStatus;
use App\Enums\OrderStatus;
use App\Exceptions\NotAjaxRequestException;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\OrderDataMapper;
use App\Http\Requests\Order\OrderDeleteRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Services\Order\OrderManager;

class OrderController extends Controller
{
    private OrderDataMapper $orderDataMapper;
    private OrderRepository $orderRepository;
    private OrderManager $orderManager;
    private OrderPaymentMethods $orderPaymentMethods;
    private OrderPaymentStatus $orderPaymentStatus;
    private OrderStatus $orderStatus;


    public function __construct(
        OrderDataMapper $orderDataMapper,
        OrderRepository $orderRepository,
        OrderManager $orderManager,
        OrderPaymentMethods $orderPaymentMethods,
        OrderPaymentStatus $orderPaymentStatus,
        OrderStatus $orderStatus
    )
    {
        $this->orderDataMapper = $orderDataMapper;
        $this->orderRepository = $orderRepository;
        $this->orderManager = $orderManager;
        $this->orderPaymentMethods = $orderPaymentMethods;
        $this->orderPaymentStatus = $orderPaymentStatus;
        $this->orderStatus = $orderStatus;
    }

    public function index()
    {
        $orders = $this->orderRepository->getAllPaginatedWithFilters();

        return view('order.index', compact([
            'orders',
        ]));
    }

    public function edit(Order $order)
    {
        $paymentMethods = $this->orderPaymentMethods->getAll();
        $paymentStatus = $this->orderPaymentStatus->getAll();
        $orderStatus = $this->orderStatus->getAll();

        return view('order.edit', compact([
            'order',
            'paymentMethods',
            'paymentStatus',
            'orderStatus',
        ]));
    }

    public function update(OrderRequest $request, Order $order)
    {
        $orderData = $this->orderDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->orderManager->update($orderData, $order, $request);

            return redirect()->route('order.index');
        } catch (OrderUniqueNameException $e) {
            throw new OrderUniqueNameValidationException();
        }
    }

    public function destroy(OrderDeleteRequest $request)
    {
        if (!$request->ajax())
        {
            throw new NotAjaxRequestException();
        }

        try {
            $this->orderManager->delete($request);

            return response()->json(['id' => $request->order_id]);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }
}
