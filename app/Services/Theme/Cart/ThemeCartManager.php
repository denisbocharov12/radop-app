<?php

declare(strict_types=1);

namespace App\Services\Theme\Cart;

use App\Data\Theme\Coupon\CouponData;
use App\Enums\CouponTypes;
use App\Exceptions\Coupon\CouponMinimalValueException;
use App\Exceptions\Coupon\CouponNotFoundException;
use App\Exceptions\Coupon\CouponOwnerException;
use App\Exceptions\User\UserNotFoundException;
use App\Models\Coupon;
use App\Models\User;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;

final class ThemeCartManager
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly CouponRepository $couponRepository,
        private readonly CouponTypes $couponTypes,
    )
    {
    }

    public function coupon(CouponData $couponData, ?Authenticatable $user)
    {
        $authUser = null;

        if ($user !== null) {
            $authUser = $this->checkForExistedUser($user->id);
        }

        $existedCoupon = $this->couponRepository->getActiveByCode($couponData->code);

        if ($existedCoupon === null)
        {
            throw new CouponNotFoundException();
        }

        if ($existedCoupon->user_id !== null)
        {
            throw new CouponOwnerException();
        }

        if ($authUser !== null && $existedCoupon->user_id !== null) {
            $this->checkForCouponOwner($existedCoupon, $authUser);
        }

        if ($existedCoupon->start_date !== null && $existedCoupon->end_date !== null)
        {
            $this->checkForCouponStartAndEndDate($existedCoupon);
        }

        if ($existedCoupon->minimal_total !== null)
        {
            $this->checkForCouponMinimalTotal($existedCoupon);
        }

        $this->putCouponToSessionStorage($existedCoupon);

    }

    private function putCouponToSessionStorage(Coupon $coupon)
    {
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        $cartTotal = \Cart::session($sessionId)->getTotal();

        Session()->forget('coupon');

        Session()->put('coupon',[
            'id' => $coupon->id,
            'code' => $coupon->code,
            'value' => $this->discount($coupon, $cartTotal)
        ]);
    }

    private function checkForCouponMinimalTotal(Coupon $coupon)
    {
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        $cartTotal = \Cart::session($sessionId)->getTotal();

        if ($coupon->minimal_total > $cartTotal)
        {
            Session()->forget('coupon');
            throw new CouponMinimalValueException();
        }
    }

    private function checkForExistedUser(int $userId): ?User
    {
        $existedUser = $this->userRepository->getById($userId);

        if ($existedUser === null)
        {
            Session()->forget('coupon');
            throw new UserNotFoundException();
        }

        return $existedUser;
    }

    private function checkForCouponStartAndEndDate(Coupon $coupon)
    {
        $currentDate = Carbon::now();

        $dateCoupon = $this->couponRepository->getActiveBetweenStartAndEndDateByCode($coupon->code, $currentDate);

        if ($dateCoupon === null)
        {
            Session()->forget('coupon');
            throw new CouponOwnerException();
        }
    }

    private function checkForCouponOwner(Coupon $coupon, User $user)
    {
        if ($coupon->user_id !== $user->id)
        {
            Session()->forget('coupon');
            throw new CouponOwnerException();
        }
    }

    private function discount(Coupon $coupon, $total): float
    {
        if ($coupon->type === $this->couponTypes->getFixedType())
        {
            return (int)$coupon->value;
        }

        if ($coupon->type === $this->couponTypes->getPercentType())
        {
            return intval($coupon->value) / 100 * $total;
        }

        return 0;
    }
}
