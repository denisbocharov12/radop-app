<?php

namespace App\Services\Coupon;

use App\Data\Coupon\CouponData;
use App\Exceptions\Coupon\CouponUniqueNameException;
use App\Http\Requests\Coupon\CouponRequest;
use App\Models\Coupon;
use App\Repositories\Coupon\CouponRepository;
use App\Services\EntityStatusManager;

class CouponManager
{
    private CouponRepository $couponRepository;
    private EntityStatusManager $entityStatusManager;

    public function __construct(
        CouponRepository    $couponRepository,
        EntityStatusManager $entityStatusManager,
    )
    {
        $this->couponRepository = $couponRepository;
        $this->entityStatusManager = $entityStatusManager;
    }

    public function store(CouponData $couponData, CouponRequest $request): void
    {
        $existedCoupon = $this->couponRepository->getById($couponData->code);

        if ($existedCoupon !== null) {
            throw new CouponUniqueNameException();
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($couponData->status);

        Coupon::create([
            'user_id' => $couponData->user_id,
            'code' => $couponData->code,
            'type' => $couponData->type,
            'value' => $couponData->value,
            'status' => $status,
            'minimal_total' => $couponData->minimal_total,
            'start_date' => $couponData->start_date,
            'end_date' => $couponData->end_date
        ]);
    }

    public function update(CouponData $couponData, Coupon $coupon, CouponRequest $request): void
    {
        if ($coupon->code !== $couponData->code) {
            $existedCoupon = $this->couponRepository->getByCode($couponData->code);

            if ($existedCoupon !== null) {
                throw new CouponUniqueNameException();
            }
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($couponData->status);

        $coupon->update([
            'user_id' => $couponData->user_id,
            'code' => $couponData->code,
            'type' => $couponData->type,
            'value' => $couponData->value,
            'status' => $status,
            'minimal_total' => $couponData->minimal_total,
            'start_date' => $couponData->start_date,
            'end_date' => $couponData->end_date
        ]);
    }

    public function delete(CouponDeleteRequest $request): void
    {
        $couponCode = $request->code;

        $brand = $this->couponRepository->getByCode($couponCode->code);

        if ($brand === null) {
            throw new CouponNotFoundException();
        }

        $brand->delete();
    }
}
