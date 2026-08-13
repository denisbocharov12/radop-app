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
use App\Exceptions\User\UserNotFoundException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderProfile;
use App\Models\User;
use App\Repositories\City\CityRepository;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class ThemeCheckoutManager
{
    private const FIZ = 'fiz';

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

        // ── Guard: cart must not be empty ──────────────────────────────────
        if (\Cart::session($sessionId)->isEmpty()) {
            Log::channel('checkout')->warning('Checkout attempted with empty cart', [
                'user_id'    => $user?->id,
                'session_id' => $sessionId,
            ]);
            throw new OrderErrorException('Cart is empty');
        }

        // ── Resolve authenticated user context ─────────────────────────────
        $managerId = null;
        $userId    = null;
        $userType  = self::FIZ;

        // Supplement order (дозаказ): a new order attached to the user's
        // previous one when placed within the supplement window.
        $isSupplement       = false;
        $supplementParentId = null;

        if ($user !== null) {
            $authUser  = $this->checkForExistedUser($user->id);
            $userId    = $authUser->id;
            $managerId = $user->manager_id;
            $userType  = $authUser->type->key_name;

            $lastOrder   = Order::where('user_id', $authUser->id)->latest('id')->first();
            $windowHours = (int) config('app.supplement_order_window_hours', 8);

            if ($lastOrder !== null
                && $lastOrder->created_at !== null
                && $lastOrder->created_at->copy()->addHours($windowHours)->isFuture()
            ) {
                $isSupplement       = true;
                // Attach to the ROOT order so all supplements group together.
                $supplementParentId = $lastOrder->parent_order_id ?? $lastOrder->id;
            }
        }

        // ── Validate payment method ────────────────────────────────────────
        if (!array_key_exists($orderData->payment_method, $this->orderPaymentMethods->getAll())) {
            Log::channel('checkout')->warning('Checkout: invalid payment method', [
                'payment_method' => $orderData->payment_method,
                'user_id'        => $userId,
            ]);
            throw new OrderErrorException('Invalid payment method');
        }

        // ── Resolve filial / city ──────────────────────────────────────────
        $existedFilial = null;
        $existedCity   = null;

        if ($orderData->filialId !== null) {
            $existedFilial = $this->filialRepository->getById($orderData->filialId);
            if ($existedFilial === null) {
                Log::channel('checkout')->warning('Checkout: filial not found', ['filial_id' => $orderData->filialId]);
                throw new FilialNotFoundException();
            }
            $existedCity = $existedFilial->city;
        }

        if ($existedCity === null) {
            $existedCity = $this->cityRepository->getById($orderData->cityId);
            if ($existedCity === null) {
                Log::channel('checkout')->warning('Checkout: city not found', ['city_id' => $orderData->cityId]);
                throw new CityNotFoundException();
            }
        }

        // required_sum / delivery_sum must be numeric (not null)
        if ($existedCity->required_sum === null || $existedCity->delivery_sum === null) {
            Log::channel('checkout')->warning('Checkout: city missing required_sum or delivery_sum', [
                'city_id'      => $existedCity->id,
                'required_sum' => $existedCity->required_sum,
                'delivery_sum' => $existedCity->delivery_sum,
            ]);
            throw new ThemeCityErrorRequiredSumException();
        }

        $cartSubtotal = $this->getCartSubtotalValue();

        // Minimum order for this city. Skipped entirely for supplements
        // (дозаказ), which attach to a recent order regardless of cart sum.
        // The per-city required_sum is the authoritative minimum here
        // (checkout is available to authenticated users only).
        if (!$isSupplement && $existedFilial === null && $cartSubtotal < (float) $existedCity->required_sum) {
            Log::channel('checkout')->info('Checkout: cart subtotal below city required_sum', [
                'subtotal'     => $cartSubtotal,
                'required_sum' => $existedCity->required_sum,
                'city_id'      => $existedCity->id,
            ]);
            throw new MinOrderSumException();
        }

        // ── Delivery charge ────────────────────────────────────────────────
        // Supplements attach to a recent order and never add a second delivery.
        $deliverySum = (float) $existedCity->delivery_sum;
        if ($isSupplement || $cartSubtotal >= (float) $existedCity->required_sum || $existedFilial !== null) {
            $deliverySum = 0.0;
        }

        // ── Address & city id ──────────────────────────────────────────────
        $orderAddress = $orderData->address;
        $cityId       = $orderData->cityId;

        if ($existedFilial !== null) {
            $orderAddress = $existedFilial->address;
            $cityId       = $existedFilial->city_id;
        }

        // ── Create order inside a DB transaction ───────────────────────────
        Log::channel('checkout')->info('Checkout: starting order creation', [
            'user_id'     => $userId,
            'user_type'   => $userType,
            'city_id'     => $cityId,
            'filial_id'   => $orderData->filialId,
            'subtotal'    => $cartSubtotal,
            'delivery'    => $deliverySum,
            'payment'     => $orderData->payment_method,
        ]);

        $order = DB::transaction(function () use (
            $orderData, $userId, $managerId, $userType,
            $orderAddress, $cityId, $deliverySum, $cartSubtotal, $sessionId,
            $supplementParentId
        ) {
            // Lock to prevent duplicate order_number race condition
            $orderNumber = $this->getLatestOrderNumber($userType);

            $order = Order::create([
                'fio'            => $orderData->fio,
                'order_number'   => $orderNumber,
                'first_name'     => $orderData->fio,
                'last_name'      => $orderData->fio,
                'email'          => $orderData->email,
                'phone'          => $orderData->phone,
                'address'        => $orderAddress,
                'city'           => $cityId,
                'note'           => $orderData->note,
                'payment_method' => $orderData->payment_method,
                'delivery_method'=> __('theme.default_delivery_method'),
                'payment_status' => $this->orderPaymentStatus->getUnpaidPaymentStatus(),
                'status'         => $this->orderStatus->getNewStatus(),
                'delivery_charge'=> $deliverySum,
                'user_id'        => $userId,
                'manager_id'     => $managerId,
                'user_type'      => $userType,
                'subtotal'       => $cartSubtotal,
                'total'          => $cartSubtotal + $deliverySum,
                'discount'       => 0,
                'recommended_time' => $orderData->recommendedTime,
                'filial_id'      => $orderData->filialId,
                'parent_order_id'=> $supplementParentId,
            ]);

            OrderProfile::create([
                'order_id'        => $order->id,
                'company_name'    => $orderData->company_name,
                'reserve_phone'   => $orderData->reserve_phone,
                'bank'            => $orderData->bank,
                'idno'            => $orderData->idno,
                'tva'             => $orderData->tva,
                'registered_city' => $orderData->registered_city,
                'iur_address'     => $orderData->iur_address,
                'shipping_address'=> $orderData->shipping_address,
            ]);

            $this->addProductsToOrder($order, $sessionId);

            return $order;
        });

        Log::channel('checkout')->info('Checkout: order created successfully', [
            'order_id'     => $order->id,
            'order_number' => $order->order_number,
            'total'        => $order->total,
            'user_id'      => $userId,
            'items_count'  => $order->products()->count(),
        ]);

        // ── Clear cart after successful commit ─────────────────────────────
        Session()->forget('coupon');
        \Cart::session($sessionId)->clear();

        // ── Dispatch email notifications (non-critical) ────────────────────
        if ($managerId !== null) {
            $existedManager = $this->userRepository->getManagerById($managerId);
            if ($existedManager !== null && $existedManager->email !== null) {
                try {
                    event(new OrderCreatedSendManagerEmailEvent($existedManager));
                } catch (\Throwable $e) {
                    Log::channel('checkout')->error('Order created but manager email failed', [
                        'order_id'   => $order->id,
                        'manager_id' => $existedManager->id,
                        'error'      => $e->getMessage(),
                        'trace'      => $e->getTraceAsString(),
                    ]);
                }
            }
        }

        try {
            event(new OrderCreatedSendAdminEmailEvent(config('mail.admin_email'), $order));
        } catch (\Throwable $e) {
            Log::channel('checkout')->error('Order created but admin email failed', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);
        }

        return $order;
    }

    private function addProductsToOrder(Order $order, string|int $sessionId): void
    {
        $items = \Cart::session($sessionId)->getContent();

        if ($items->isEmpty()) {
            Log::channel('checkout')->error('addProductsToOrder: cart is empty at item insertion step', [
                'order_id'   => $order->id,
                'session_id' => $sessionId,
            ]);
            throw new \RuntimeException('Cannot create order items: cart is empty');
        }

        foreach ($items as $item) {
            $productId = $item->associatedModel?->id ?? $item->id;

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'quantity'   => (int) $item->quantity,
                'price'      => $item->price,
            ]);
        }

        Log::channel('checkout')->debug('addProductsToOrder: items inserted', [
            'order_id' => $order->id,
            'count'    => $items->count(),
        ]);
    }

    private function getCartSubtotalValue(): float
    {
        return \Cart::session($this->getSessionId())->getTotal();
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
        $orderPrefix = $userType === 'iur' ? 'PJ-1' : 'PF-1';

        // Lock the orders table row to prevent duplicate order_number
        // under concurrent requests (must run inside DB::transaction).
        $maxId       = Order::withTrashed()->lockForUpdate()->max('id') ?? 0;
        $nextCounter = $maxId + 1;

        return $orderPrefix . str_pad((string) $nextCounter, 3, '0', STR_PAD_LEFT);
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
