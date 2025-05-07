<?php
declare(strict_types=1);

namespace App\Services\Theme\Checkout;

use App\Data\Theme\Order\ThemeOrderData;
use App\Enums\OrderPaymentMethods;
use App\Enums\OrderPaymentStatus;
use App\Enums\OrderStatus;
use App\Events\OrderCreatedSendAdminEmailEvent;
use App\Events\OrderCreatedSendManagerEmailEvent;
use App\Exceptions\Checkout\MinOrderSumException;
use App\Exceptions\Checkout\OrderErrorException;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\ThemeCityErrorRequiredSumException;
use App\Exceptions\Filial\FilialNotFoundException;
use App\Exceptions\Order\ThemeOrderMakeException;
use App\Exceptions\User\UserNotFoundException;
use App\Models\DiscountPeriod;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderProfile;
use App\Models\User;
use App\Repositories\City\CityRepository;
use App\Repositories\DiscountPeriod\DiscountPeriodRepository;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserTypeRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

final class ThemeCheckoutManager
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly OrderPaymentStatus $orderPaymentStatus,
        private readonly OrderStatus $orderStatus,
        private readonly OrderPaymentMethods $orderPaymentMethods,
        private readonly CityRepository $cityRepository,
        private readonly FilialRepository $filialRepository,
    ) {
    }

    public function store(ThemeOrderData $orderData, ?Authenticatable $user): Order
    {
        $sessionId = $this->getSessionId();
        $orderAddress = $orderData->address;
        $existedFilial = null;

        $authUser = null;
        $managerId = null;
        $userId = null;
        $userType = 'fiz';

        if ($user !== null) {
            $authUser = $this->checkForExistedUser($user->id);
            $userId = $authUser->id;
            $managerId = $user->manager_id;
            $userType = $authUser->type->key_name;
        }

        if (!array_key_exists($orderData->payment_method, $this->orderPaymentMethods->getAll()))
        {
            throw new OrderErrorException();
        }

        if ($orderData->filialId !== null) {
            $existedFilial = $this->filialRepository->getById($orderData->filialId);

            if ($existedFilial === null) {
                throw new FilialNotFoundException();
            }

            $existedCity = $existedFilial->city;

            if ((float)$existedFilial->city->required_sum === null || $existedFilial->city->delivery_sum === null) {
                throw new ThemeCityErrorRequiredSumException();
            }

            if($this->getCartSubtotalValue() < (float)$existedFilial->city->required_sum) {
                throw new MinOrderSumException();
            }
        }

        if ($existedFilial === null) {
            $existedCity = $this->cityRepository->getById($orderData->cityId);

            if ($existedCity === null) {
                throw new CityNotFoundException();
            }

            if ((float)$existedCity->required_sum === null || $existedCity->delivery_sum === null) {
                throw new ThemeCityErrorRequiredSumException();
            }

            if($this->getCartSubtotalValue() < (float)$existedCity->required_sum) {
                throw new MinOrderSumException();
            }
        }

        if($this->getCartSubtotalValue() < config('app.min_delivery_sum')) {
            throw new MinOrderSumException();
        }

        $deliverySum = (float)$existedCity->delivery_sum;

        if ((float)$existedCity->required_sum <= $this->getCartSubtotalValue()) {
            $deliverySum = 0;
        }

        $recommendedTime = null;

        if ($orderData->recommendedTime !== null) {
            $recommendedTime = $orderData->recommendedTime;
        }

//        $foundedDiscountPeriod = null;
//
//        foreach (DiscountPeriod::orderBy('order')->get() as $discountPeriod) {
//            if ($discountPeriod->sum_to >= $this->getCartSubtotalValue() && $discountPeriod->sum_from <= $this->getCartSubtotalValue()) {
//                $foundedDiscountPeriod = $discountPeriod;
//            }
//        }
//
//        if ($foundedDiscountPeriod === null) {
//            throw new OrderErrorException;
//        }

//        $discount = $this->getCartSubtotalValue() * $foundedDiscountPeriod->discount_koef / 100;

        $cityId = $orderData->cityId;

        if ($orderData->filialId !== null && $existedFilial !== null) {
            $orderAddress = $existedFilial->address;
            $cityId = $existedFilial->city_id;
        }

        $order = Order::create([
            'fio' => $orderData->fio,
            'order_number' => $this->getLatestOrderNumber($userType),
            'first_name' => $orderData->fio,
            'last_name' => $orderData->fio,
            'email' => $orderData->email,
            'phone' => $orderData->phone,
            'address' => $orderAddress,
            'city' => $cityId,
            'note' => $orderData->note,
            'payment_method' => $orderData->payment_method,
            'delivery_method' => 'theme.default_delivery_method',
            'payment_status' => $this->orderPaymentStatus->getUnpaidPaymentStatus(),
            'status' => $this->orderStatus->getProcessingStatus(),
            'delivery_charge' => $deliverySum,
            'user_id' => $userId,
            'manager_id' => $managerId,
            'user_type' => $userType,
            'subtotal' => $this->getCartSubtotalValue(),
            'total' => $this->getCartSubtotalValue() + $deliverySum,
            'discount' => 0,
            'recommended_time' => $recommendedTime,
            'filial_id' => $orderData->filialId,
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

        event(new OrderCreatedSendAdminEmailEvent(config('mail.admin_email'), $order));

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

    private function getLatestOrderNumber(string $userType): string
    {
        $latestOrder = 1;
        $orderPrefix = 'PF1';
        if ($userType === 'iur') {
            $orderPrefix = 'PJ1';
        }
        $orderCount = Order::withTrashed()->count();

        if($orderCount !== 0)
        {
            $latestOrder = Order::withTrashed()->get()->last()->id + 1;
        }

        return $orderPrefix.str_pad((string)$latestOrder, 3, "0", STR_PAD_LEFT);
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
