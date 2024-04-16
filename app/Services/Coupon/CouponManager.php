<?php

namespace App\Services\Coupon;

use App\Data\Coupon\CouponData;
use App\Exceptions\Coupon\CouponNotFoundException;
use App\Exceptions\Coupon\CouponUniqueNameException;
use App\Http\Requests\Coupon\CouponDeleteRequest;
use App\Http\Requests\Coupon\CouponRequest;
use App\Models\Coupon;
use App\Repositories\Coupon\CouponRepository;
use App\Services\EntityStatusManager;
use Illuminate\Support\Str;


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
        if ($couponData->code === null) {
            $couponData->code = Str::random(10);
        } else {
            $existedCoupon = $this->couponRepository->getByCode($couponData->code);
            if ($existedCoupon !== null) {
                throw new CouponUniqueNameException();
            }
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

    public function update(CouponData $couponData, Coupon $coupon): void
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
        $couponCode = $request->coupon_id;

        $coupon = $this->couponRepository->getById($couponCode);

        if ($coupon === null) {
            throw new CouponNotFoundException();
        }

        $coupon->delete();
    }
}
