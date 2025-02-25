<?php

namespace App\Services\Order;

use App\Data\Order\OrderData;
use App\Excel\Order\OrderExport;
use App\Exceptions\Order\ManagerNotFoundException;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderUniqueCodeException;
use App\Exceptions\Order\UserNotFoundException;
use App\Http\Requests\Order\OrderDeleteRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
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
            'user_type' => $orderData->user_type,
            'city' => $orderData->city,
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

        if ($orderData->user_type === self::IUR_TYPE){
            $order->profile->update([
                'company_name' => $orderData->company_name,
                'reserve_phone' => $orderData->reserve_phone,
                'bank' => $orderData->bank,
                'idno' => $orderData->idno,
                'tva' => $orderData->tva,
                'registered_city' => $orderData->registered_city,
                'iur_address' => $orderData->iur_address,
                'shipping_address' => $orderData->shipping_address
            ]);
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

        $pdf = PDF::loadView('pdf.invoice', compact([
            'order'
        ]));

        return $pdf->stream();
    }

    public function downloadPDF(Order $order)
    {
        $existedOrder = $this->orderRepository->getById($order->id);

        if ($existedOrder === null){
            throw new OrderNotFoundException();
        }

        $pdf = PDF::loadView('pdf.invoice', compact([
            'order'
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

        $filePath = "order_{$order->id}.xlsx";

        return Excel::download(new OrderExport($order), $filePath);
    }

}
