<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Cart;
use App\Exceptions\Coupon\CouponMinimalValueException;
use App\Exceptions\Coupon\CouponMinimalValueValidationException;
use App\Exceptions\Coupon\CouponNotFoundException;
use App\Exceptions\Coupon\CouponNotFoundValidationException;
use App\Exceptions\Coupon\CouponOwnerException;
use App\Exceptions\Coupon\CouponOwnerValidationException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserTypeNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeCouponDataMapper;
use App\Http\Requests\Theme\Coupon\ThemeCouponRequest;
use App\Services\Theme\Cart\ThemeCartManager;
use Illuminate\Support\Facades\Auth;

final class ThemeCartController extends Controller
{
    public function __construct(
        private readonly ThemeCartManager $themeCartManager,
        private readonly ThemeCouponDataMapper $themeCouponDataMapper
    )
    {
    }

    public function index()
    {
        return view('frontend.v1.pages.cart.index');
    }

    public function coupon(ThemeCouponRequest $request)
    {
        $couponData = $this->themeCouponDataMapper->mapFromRequestToNormalized($request);
        $user = Auth::guard('user')->user();

        try {
            $this->themeCartManager->coupon($couponData, $user);

        } catch (UserNotFoundException) {
            throw new UserTypeNotFoundValidationException();
        } catch (CouponNotFoundException) {
            throw new CouponNotFoundValidationException();
        } catch (CouponMinimalValueException) {
            throw new CouponMinimalValueValidationException();
        } catch (CouponOwnerException) {
            throw new CouponOwnerValidationException();
        }

        toastr()->success('Купон успешно применен!','Успех');
        return redirect()->back();
    }
}
