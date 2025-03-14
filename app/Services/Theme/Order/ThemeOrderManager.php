<?php

declare(strict_types=1);

namespace App\Services\Theme\Order;

use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\UserIsNotCustomerException;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Order\OrderRepository;
use PDF;

final class ThemeOrderManager
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
    )
    {
    }

    public function viewInvoice(Order $order, User $user)
    {
        $existedOrder = $this->orderRepository->getById($order->id);

        if ($existedOrder === null){
            throw new OrderNotFoundException();
        }

        if (!$user->can('view', $order))
            throw new UserIsNotCustomerException();

        if ($user->can('view', $order)) {
            $pdf = PDF::loadView('frontend.v1.mail.order', ([
                'order' => $order,
                'products' => $order->products,
            ]));

            return $pdf->stream();
        }
    }

    public function downloadInvoice(Order $order, User $user)
    {
        $existedOrder = $this->orderRepository->getById($order->id);

        if ($existedOrder === null){
            throw new OrderNotFoundException();
        }

        if (!$user->can('view', $order))
            throw new UserIsNotCustomerException();

        if ($user->can('view', $order)) {
            $pdf = PDF::loadView('frontend.v1.mail.order', ([
                'order' => $order,
                'products' => $order->products,
            ]));

            return $pdf->download();
        }
    }
}
