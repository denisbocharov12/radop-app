<?php

namespace App\Services\Order;

use App\Data\Order\AssignManagerData;
use App\Data\Order\OrderData;
use App\Data\Order\UpdateOrderStatusesData;
use App\Enums\OrderStatus;
use App\Events\OrderStatusUpdatedSendEmailEvent;
use App\Excel\Order\OrderExport;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\Order\ManagerNotFoundException;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderUniqueCodeException;
use App\Exceptions\Order\UserNotFoundException;
use App\Http\Requests\Order\OrderDeleteRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use App\Repositories\City\CityRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

final class OrderManager
{
    private const IUR_TYPE = 'iur';
    private OrderRepository $orderRepository;
    private UserRepository $userRepository;

    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        private readonly OrderStatus $orderStatus,
        private readonly CityRepository $cityRepository,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    public function update(OrderData $orderData, Order $order): void
    {
        $orderStatus = $order->status;

        if ($orderData->userId !== null) {
            $existedUser = $this->userRepository->getById($orderData->userId);

            if ($existedUser === null) {
                throw new UserNotFoundException();
            }
        }

        if ($orderData->managerId !== null) {
            $existedManager = $this->userRepository->getById($orderData->managerId);

            if ($existedManager === null) {
                throw new ManagerNotFoundException();
            }
        }

        $existedCity = $this->cityRepository->getById($orderData->city);

        if ($existedCity === null) {
            throw new CityNotFoundException();
        }

        $order->update([
            'email' => $orderData->email,
            'phone' => $orderData->phone,
            'address' => $orderData->address,
            'user_type' => $orderData->userType,
            'note' => $orderData->note,
            'user_id' => $orderData->userId,
            'manager_id' => $orderData->managerId,
            'payment_method' => $orderData->paymentMethod,
            'payment_status' => $orderData->paymentStatus,
            'status' => $orderData->status,
            'subtotal' => $orderData->subtotal,
            'discount' => $orderData->discount,
            'total' => $orderData->total,
            'delivery_charge' => $orderData->deliveryCharge,
            'city' => $orderData->city,
            'filial_id' => $orderData->filialId,
        ]);

        if ($orderData->userType === self::IUR_TYPE){
            $order->profile->update([
                'company_name' => $orderData->companyName,
                'reserve_phone' => $orderData->reservePhone,
                'bank' => $orderData->bank,
                'idno' => $orderData->idno,
                'tva' => $orderData->tva,
                'registered_city' => $orderData->registeredCity,
                'iur_address' => $orderData->iurAddress,
                'shipping_address' => $orderData->shippingAddress
            ]);
        }

        if ($orderData->status === $this->orderStatus->getCanceledStatus() && $orderStatus !== $orderData->status){
            event(new OrderStatusUpdatedSendEmailEvent($order));
        }
    }

    public function delete(OrderDeleteRequest $request): void
    {
        $orderId = (int)$request->order_id;

        $order = $this->orderRepository->getById($orderId);

        if ($order === null) {
            throw new OrderNotFoundException();
        }

        $order->delete();
    }

    public function viewPDF(Order $order)
    {
        $existedOrder = $this->orderRepository->getById($order->id);

        if ($existedOrder === null){
            throw new OrderNotFoundException();
        }

        $pdf = PDF::loadView('frontend.v1.mail.order', ([
            'order' => $order,
            'products' => $order->products,
        ]));

        return $pdf->stream();
    }

    public function downloadPDF(Order $order)
    {
        $existedOrder = $this->orderRepository->getById($order->id);

        if ($existedOrder === null){
            throw new OrderNotFoundException();
        }

        $pdf = PDF::loadView('frontend.v1.mail.order', ([
            'order' => $order,
            'products' => $order->products,
        ]));

        return $pdf->download();
    }

    public function viewInvoice(Order $order)
    {
        $existedOrder = $this->orderRepository->getById($order->id);

        if ($existedOrder === null){
            throw new OrderNotFoundException();
        }

        $pdf = PDF::loadView('invoice.order-printing', compact([
            'order'
        ]));

        return $pdf->stream();
    }

    public function downloadInvoice(Order $order)
    {
        $existedOrder = $this->orderRepository->getById($order->id);

        if ($existedOrder === null){
            throw new OrderNotFoundException();
        }

        $pdf = PDF::loadView('invoice.order-printing', compact([
            'order'
        ]));

        return $pdf->download();
    }

    public function downloadExcel(Order $order)
    {
        $existedOrder = $this->orderRepository->getById($order->id);

        if ($existedOrder === null){
            throw new OrderNotFoundException();
        }

        $filePath = "order_{$order->id}.xls";

        $order->update([
            'status' =>  $this->orderStatus->getProcessingStatus()
        ]);

        return Excel::download(new OrderExport($order), $filePath, \Maatwebsite\Excel\Excel::XLS);
    }

    public function updateOrderStatuses(UpdateOrderStatusesData $data): void
    {
        $orders = $this->orderRepository->getOrdersByIds($data);
        $canceledStatus = $this->orderStatus->getCanceledStatus();

        foreach ($orders as $order) {
            $oldStatus = $order->status;
            $order->update(
                [
                    'status' => $data->status
                ],
            );
            $order->status = $data->status;
            $order->save();
            if ($data->status === $canceledStatus && $oldStatus !== $data->status) {
                event(new OrderStatusUpdatedSendEmailEvent($order));
            }
        }
    }

    public function assignManager(AssignManagerData $data): array
    {
        $order = $this->orderRepository->getById($data->order_id);
        if ($order === null) {
            throw new OrderNotFoundException();
        }

        $manager = $this->userRepository->getById($data->manager_id);
        if ($manager === null) {
            throw new ManagerNotFoundException();
        }

        $order->manager_id = $manager->id;
        $order->save();

        $manager->load('profile');

        return [
            'order' => $order,
            'manager' => $manager,
        ];
    }
}
