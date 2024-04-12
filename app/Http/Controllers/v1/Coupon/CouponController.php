<?php

namespace App\Http\Controllers\v1\Coupon;

use App\Exceptions\Coupon\CouponNotFoundException;
use App\Exceptions\Coupon\CouponNotFoundValidationException;
use App\Exceptions\Coupon\CouponUniqueNameException;
use App\Exceptions\Coupon\CouponUniqueNameValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\CouponDataMapper;
use App\Http\Requests\Coupon\CouponDeleteRequest;
use App\Http\Requests\Coupon\CouponRequest;
use App\Models\Coupon;
use App\Repositories\Coupon\CouponRepository;
use App\Services\Coupon\CouponManager;


class CouponController extends Controller
{
    private CouponManager $couponManager;
    private CouponDataMapper $couponDataMapper;
    private CouponRepository $couponRepository;

    public function __construct(
        CouponManager $couponManager,
        CouponDataMapper $couponDataMapper,
        CouponRepository $couponRepository,
    )
    {
        $this->couponManager = $couponManager;
        $this->couponDataMapper = $couponDataMapper;
        $this->couponRepository = $couponRepository;
    }

    public function index()
    {
        $coupons = $this->couponRepository->getAllPaginatedWithFilters();

        return view('coupon.index', compact([
            'coupons'
        ]));
    }

    public function store(CouponRequest $request)
    {
        $categoryData = $this->couponDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->couponManager->store($categoryData, $request);

            return redirect()->route('category.index');
        } catch (CouponUniqueNameException $e) {
            throw new CouponUniqueNameValidationException();
        }
    }

    public function edit(Coupon $coupon)
    {
        return view('coupon.edit', compact([
            'coupon'
        ]));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        $couponData = $this->couponDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->couponManager->update($couponData, $coupon, $request);

            return redirect()->route('coupon.index');
        } catch (CouponUniqueNameException $e) {
            throw new CouponUniqueNameValidationException();
        }
    }

    public function destroy(CouponDeleteRequest $request)
    {
        if (!$request->ajax())
        {
            throw new NotAjaxRequestException();
        }

        try {
            $this->couponManager->delete($request);

            return response()->json(['id' => $request->coupon_id]);
        } catch (CouponNotFoundException $e) {
            throw new CouponNotFoundValidationException();
        }
    }
}
