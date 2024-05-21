<?php

namespace App\Http\Controllers\v1\Order;

use App\Enums\OrderPaymentMethods;
use App\Enums\OrderPaymentStatus;
use App\Enums\OrderStatus;
use App\Exceptions\NotAjaxRequestException;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderNotFoundValidationException;
use App\Exceptions\Order\OrderUniqueCodeException;
use App\Exceptions\Order\OrderUniqueCodeValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\OrderDataMapper;
use App\Http\Requests\Order\OrderDeleteRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\User\UserRepository;
use App\Services\Order\OrderManager;
use Illuminate\Support\Facades\Auth;
use PDF;

class OrderController extends Controller
{
    private OrderDataMapper $orderDataMapper;
    private OrderRepository $orderRepository;
    private OrderManager $orderManager;
    private OrderPaymentMethods $orderPaymentMethods;
    private OrderPaymentStatus $orderPaymentStatus;
    private OrderStatus $orderStatus;
    private UserRepository $userRepository;

    public function __construct(
        OrderDataMapper $orderDataMapper,
        OrderRepository $orderRepository,
        OrderManager $orderManager,
        OrderPaymentMethods $orderPaymentMethods,
        OrderPaymentStatus $orderPaymentStatus,
        OrderStatus $orderStatus,
        UserRepository $userRepository
    )
    {
        $this->orderDataMapper = $orderDataMapper;
        $this->orderRepository = $orderRepository;
        $this->orderManager = $orderManager;
        $this->orderPaymentMethods = $orderPaymentMethods;
        $this->orderPaymentStatus = $orderPaymentStatus;
        $this->orderStatus = $orderStatus;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $userId = Auth::guard()->user()->id;
        $orders = $this->orderRepository->getAllPaginatedWithFilters();

        $user = $this->userRepository->getById($userId);

        return view('order.index', compact([
            'orders',
            'user'
        ]));
    }

    public function edit(Order $order, Product $product)
    {
        $paymentMethods = $this->orderPaymentMethods->getAll();
        $paymentStatus = $this->orderPaymentStatus->getAll();
        $orderStatus = $this->orderStatus->getAll();
        $users = $this->userRepository->getUsers();
        $managers = $this->userRepository->getManagers();
        $userTypes = $this->userRepository->getAllTypes();

        return view('order.edit', compact([
            'order',
            'paymentMethods',
            'paymentStatus',
            'orderStatus',
            'users',
            'managers',
            'userTypes',
            'product'
        ]));
    }

    public function update(OrderRequest $request, Order $order)
    {
        $orderData = $this->orderDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->orderManager->update($orderData, $order, $request);

            return redirect()->route('order.index');
        } catch (OrderUniqueCodeException $e) {
            throw new OrderUniqueCodeValidationException();
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

    public function viewPDF(Order $order) {
        try {
            return $this->orderManager->viewPDF($order);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }

    public function downloadPDF(Order $order){
        try {
            return $this->orderManager->downloadPDF($order);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }

    public function viewInvoice(Order $order){
        try {
            return $this->orderManager->viewInvoice($order);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }

    public function downloadInvoice(Order $order){
        try {
            return $this->orderManager->downloadInvoice($order);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }

}
