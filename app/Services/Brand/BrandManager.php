<?php

namespace App\Services\Brand;

use App\Data\Brand\BrandData;
use App\Exceptions\Brand\BrandNotFoundException;
use App\Exceptions\Brand\BrandUniqueNameException;
use App\Http\Requests\Brand\BrandDeleteRequest;
use App\Models\Brand;
use App\Repositories\Brand\BrandRepository;
use App\Services\EntityStatusManager;

final class BrandManager
{
    private BrandRepository $brandRepository;
//    private EntityStatusManager $entityStatusManager;

    public function __construct(
        BrandRepository $brandRepository,
//        EntityStatusManager $entityStatusManager
    )
    {
        $this->brandRepository = $brandRepository;
//        $this->entityStatusManager = $entityStatusManager;
    }

    public function store(BrandData $brandData): void
    {
        $existedBrand = $this->brandRepository->getByTitle($brandData->title);

        if ($existedBrand !== null) {
            throw new BrandUniqueNameException();
        }

//        $status = $this->entityStatusManager->getEntityStatusFromRequest($brandData->status);

        Brand::create([
            'title' => $brandData->title,
//            'status' => $status
        ]);
    }

    public function update(BrandData $brandData, Brand $brand): void
    {
        if ($brand->title !== $brandData->title)
        {
            $existedBrand = $this->brandRepository->getByTitle($brandData->title);

            if ($existedBrand !== null) {
                throw new BrandUniqueNameException();
            }
        }

//        $status = $this->entityStatusManager->getEntityStatusFromRequest($brandData->status);

        $brand->update([
            'title' => $brandData->title,
//            'status' => $status
        ]);
    }

    public function delete(BrandDeleteRequest $request): void
    {
        $brandId = (int)$request->brand_id;

        $brand = $this->brandRepository->getById($brandId);

        if ($brand === null)
        {
            throw new BrandNotFoundException();
        }

        $brand->delete();
    }
}
