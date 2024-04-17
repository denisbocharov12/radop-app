<?php

namespace App\Services\Order;

use App\Data\Order\OrderData;
use App\Exceptions\Order\ManagerNotFoundException;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderUniqueCodeException;
use App\Exceptions\Order\UserNotFoundException;
use App\Http\Requests\Order\OrderDeleteRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;

final class OrderManager
{
    private OrderRepository $orderRepository;
    private UserRepository $userRepository;

    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    public function update(OrderData $orderData, Order $order, OrderRequest $request): void
    {
        if ($order->order_number !== $orderData->order_number) {
            $existedOrder = $this->orderRepository->getByOrderNumber($orderData->order_number);

            if ($existedOrder !== null) {
                throw new OrderUniqueCodeException();
            }
        }

        if ($order->user_id !== $orderData->user_id) {
            $existedUser = $this->userRepository->getById($orderData->user_id);

            if ($existedUser === null) {
                throw new UserNotFoundException();
            }
        }

        if ($order->manager_id !== $orderData->manager_id) {
            $existedManager = $this->userRepository->getById($orderData->manager_id);

            if ($existedManager === null) {
                throw new ManagerNotFoundException();
            }
        }

        $order->update([
            'order_number' => $orderData->order_number,
            'first_name' => $orderData->first_name,
            'last_name' => $orderData->last_name,
            'email' => $orderData->email,
            'phone' => $orderData->phone,
            'address' => $orderData->address,
            'note' => $orderData->note,
            'user_id' => $orderData->user_id,
            'manager_id' => $orderData->manager_id,
            'payment_method' => $orderData->payment_method,
            'payment_status' => $orderData->payment_status,
            'status' => $orderData->status,
            'subtotal' => $orderData->subtotal,
            'discount' => $orderData->discount,
            'total' => $orderData->total,
            'delivery_charge' => $orderData->delivery_charge,
        ]);
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

}
