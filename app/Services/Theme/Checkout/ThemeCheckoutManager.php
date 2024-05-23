<?php
declare(strict_types=1);

namespace App\Services\Theme\Checkout;

use App\Data\Theme\Order\ThemeOrderData;
use App\Enums\OrderPaymentMethods;
use App\Enums\OrderPaymentStatus;
use App\Enums\OrderStatus;
use App\Events\OrderCreatedSendManagerEmailEvent;
use App\Exceptions\Checkout\OrderErrorException;
use App\Exceptions\User\UserNotFoundException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderProfile;
use App\Models\User;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserTypeRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Session;

final class ThemeCheckoutManager
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly OrderRepository $orderRepository,
        private readonly UserTypeRepository $userTypeRepository,
        private readonly OrderPaymentStatus $orderPaymentStatus,
        private readonly OrderStatus $orderStatus,
        private readonly OrderPaymentMethods $orderPaymentMethods
    )
    {
    }

    public function store(ThemeOrderData $orderData, ?Authenticatable $user): Order
    {
        $sessionId = $this->getSessionId();

        $authUser = null;
        $managerId = null;
        $userId = null;
        $discount = Session::get('coupon.value');
        $userType = 'fiz';

        if ($user !== null) {
            $authUser = $this->checkForExistedUser($user->id);
            $userId = $authUser->id;
            $managerId = $user->manager_id;
            $userType = $authUser->type->name;
        }

        if (!array_key_exists($orderData->payment_method, $this->orderPaymentMethods->getAll()))
        {
            throw new OrderErrorException();
        }

        $order = Order::create([
            'order_number' => $this->getLatestOrderNumber(),
            'first_name' => $orderData->first_name,
            'last_name' => $orderData->last_name,
            'email' => $orderData->email,
            'phone' => $orderData->phone,
            'address' => $orderData->address,
            'city' => $orderData->city,
            'note' => $orderData->note,
            'payment_method' => $orderData->payment_method,
            'payment_status' => $this->orderPaymentStatus->getUnpaidPaymentStatus(),
            'status' => $this->orderStatus->getProcessingStatus(),
            'delivery_charge' => $orderData->delivery_charge,
            'user_id' => $userId,
            'manager_id' => $managerId,
            'user_type' => $userType,
            'subtotal' => $this->getCartSubtotalValue(),
            'total' => $this->getCartSubtotalValue() - $discount,
            'discount' => $discount
        ]);

        $orderProfile = OrderProfile::create([
            'order_id' => $order->id,
            'company_name' => $orderData->company_name,
            'reserve_phone' => $orderData->reserve_phone,
            'bank' => $orderData->bank,
            'idno' => $orderData->idno,
            'tva' => $orderData->tva,
            'registered_city' => $orderData->registered_city,
            'iur_address' => $orderData->iur_address,
            'shipping_address' => $orderData->shipping_address
        ]);

        $this->addProductsToOrder($order);

        Session()->forget('coupon');
        \Cart::session($sessionId)->clear();

        if ($managerId !== null)
        {
            $existedManager = $this->userRepository->getManagerById($managerId);

            if ($existedManager->email !== null)
            {
                event(new OrderCreatedSendManagerEmailEvent($existedManager));
            }
        }

        return $order;
    }

    private function addProductsToOrder(Order $order): void
    {
        $sessionId = $this->getSessionId();

        foreach (\Cart::session($sessionId)->getContent() as $item)
        {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->associatedModel->id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);
        }
    }

    private function getCartSubtotalValue(): float
    {
        $sessionId = $this->getSessionId();

        return \Cart::session($sessionId)->getTotal();
    }

    private function getSessionId(): string|int
    {
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        return $sessionId;
    }

    private function getLatestOrderNumber(): string
    {
        $latestOrder = 1;

        $orderCount = Order::withTrashed()->count();

        if($orderCount !== 0)
        {
            $latestOrder = Order::withTrashed()->get()->last()->id + 1;
        }

        $orderNumber = 'ORD-'.str_pad((string)$latestOrder, 6, "0", STR_PAD_LEFT);

        return $orderNumber;
    }

    private function checkForExistedUser(int $userId): ?User
    {
        $existedUser = $this->userRepository->getById($userId);

        if ($existedUser === null)
        {
            throw new UserNotFoundException();
        }

        return $existedUser;
    }
}
