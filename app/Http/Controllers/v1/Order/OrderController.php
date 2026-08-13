<?php

namespace App\Http\Controllers\v1\Order;

use App\Enums\OrderPaymentMethods;
use App\Enums\OrderPaymentStatus;
use App\Enums\OrderStatus;
use App\Exceptions\NotAjaxRequestException;
use App\Exceptions\Order\ManagerNotFoundException;
use App\Exceptions\Order\ManagerNotFoundValidationException;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderNotFoundValidationException;
use App\Exceptions\Order\OrderUniqueCodeException;
use App\Exceptions\Order\OrderUniqueCodeValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\AssignManagerDataMapper;
use App\Http\Mappers\OrderDataMapper;
use App\Http\Mappers\UpdateOrderDataMapper;
use App\Http\Requests\Order\AssignManagerRequest;
use App\Http\Requests\Order\OrderDeleteRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\UpdateOrderStatusesRequest;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\City\CityRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;
use App\Services\Order\OrderManager;
use Excel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderDataMapper         $orderDataMapper,
        private readonly OrderRepository         $orderRepository,
        private readonly OrderManager            $orderManager,
        private readonly OrderPaymentMethods     $orderPaymentMethods,
        private readonly OrderPaymentStatus      $orderPaymentStatus,
        private readonly OrderStatus             $orderStatus,
        private readonly UserRepository          $userRepository,
        private readonly CityRepository          $cityRepository,
        private readonly UpdateOrderDataMapper   $updateOrderDataMapper,
        private readonly AssignManagerDataMapper $assignManagerMapper,
    ) {
    }

    public function index(Request $request)
    {
        $userId = Auth::guard()->user()->id;
        $orders = $this->orderRepository->getAllPaginatedWithFiltersAndSorts();
        $user = $this->userRepository->getById($userId);
        $cities = $this->cityRepository->getAll();
        $orderStatus = $this->orderStatus->getAll();
        $paymentStatus = $this->orderPaymentStatus->getAll();
        $users = $this->userRepository->getAll();
        $filters = $request->all();
        $sort = $request->get('sort', '-id');
        $userTypes = $this->userRepository->getAllTypes();
        $paymentMethods = $this->orderPaymentMethods->getAll();
        $managers = $this->userRepository->getManagers();

        return view('order.index', compact([
            'orders',
            'user',
            'cities',
            'orderStatus',
            'paymentStatus',
            'users',
            'filters',
            'sort',
            'userTypes',
            'paymentMethods',
            'managers',
        ]));
    }

    public function edit(Order $order, Product $product)
    {
        $paymentMethods = $this->orderPaymentMethods->getAll();
        $paymentStatus = $this->orderPaymentStatus->getAll();
        $orderStatus = $this->orderStatus->getAll();
        $users = $this->userRepository->getAll();
        $managers = $this->userRepository->getManagers();
        $userTypes = $this->userRepository->getAllTypes();

        $cities = $this->cityRepository->getAll();

        $history = $order->orderHistory()->get();

        // Supplement links (дозаказы): parent this order attaches to, and its own supplements.
        $order->load(['parentOrder', 'supplements' => fn ($q) => $q->orderBy('id')]);

        return view('order.edit', compact([
            'order',
            'paymentMethods',
            'paymentStatus',
            'orderStatus',
            'users',
            'managers',
            'userTypes',
            'product',
            'cities',
            'history',
        ]));
    }

    public function update(OrderRequest $request, Order $order)
    {
        $orderData = $this->orderDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->orderManager->update($orderData, $order);

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

    public function viewPDF(Order $order)
    {
        try {
            return $this->orderManager->viewPDF($order);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }

    public function downloadPDF(Order $order)
    {
        try {
            return $this->orderManager->downloadPDF($order);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }

    public function viewInvoice(Order $order)
    {
        try {
            return $this->orderManager->viewInvoice($order);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }

    public function downloadInvoice(Order $order)
    {
        try {
            return $this->orderManager->downloadInvoice($order);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }

    /**
     * @throws OrderNotFoundValidationException
     */
    public function downloadExcel(Order $order)
    {
        try {
            return $this->orderManager->downloadExcel($order);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        }
    }

    public function getStatusByLastTenMinutes()
    {
        $newStatus = $this->orderStatus->getNewStatus();
        $ordersCount = $this->orderRepository->getLastTenMinutesOrders($newStatus);

        return response()->json(['count' => $ordersCount]);
    }

    public function updateOrderStatuses(UpdateOrderStatusesRequest $request): JsonResponse
    {
        $data = $this->updateOrderDataMapper->mapFromRequestToNormalized($request);

        $this->orderManager->updateOrderStatuses($data);

        return response()->json(['status' => 'success']);
    }

    /**
     * @throws ManagerNotFoundValidationException
     * @throws OrderNotFoundValidationException
     */
    public function assignManager(AssignManagerRequest $request): JsonResponse
    {
        $data = $this->assignManagerMapper->mapFromRequestToNormalized($request);

        try {
            $result = $this->orderManager->assignManager($data);

            return response()->json([
                'message' => 'Менеджер успешно назначен',
                'order' => $result['order'],
                'manager' => $result['manager']
            ]);
        } catch (OrderNotFoundException $e) {
            throw new OrderNotFoundValidationException();
        } catch (ManagerNotFoundException $e) {
            throw new ManagerNotFoundValidationException();
        }
    }
}
