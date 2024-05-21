<?php

namespace App\Http\Controllers\Frontend\v1\Coupon;

use App\Http\Controllers\Controller;
use App\Repositories\Coupon\CouponRepository;
use Illuminate\Support\Facades\Auth;

final class ThemeCouponController extends Controller
{
    public function __construct(
        private readonly CouponRepository $couponRepository
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        $coupons = $this->couponRepository->getAllByUserId($user->id);

        return view('frontend.v1.pages.coupon.index', compact([
            'user',
            'coupons'
        ]));
    }
}
