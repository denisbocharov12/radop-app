<?php

namespace App\Services\Order;

use App\Data\Order\OrderData;
use App\Enums\OrderPaymentMethods;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;

final class OrderManager
{
    private OrderRepository $orderRepository;

    public function __construct(
        OrderRepository $orderRepository,
    )
    {
        $this->orderRepository = $orderRepository;
    }

    public function update(OrderData $orderData, Order $order, OrderRequest $request): void
    {
//        if ($category->name !== $categoryData->name) {
//            $existedCategory = $this->categoryRepository->getByName($categoryData->name);
//
//            if ($existedCategory !== null) {
//                throw new CategoryUniqueNameException();
//            }
//        }

//        $status = $this->entityStatusManager->getEntityStatusFromRequest($categoryData->status);

//        $order->update([
//            'name' => $categoryData->name,
//            'parent_id' => $categoryData->parentId,
//            'status' => $status,
//            'summary' => $categoryData->summary
//        ]);

//        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $category);

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

}
