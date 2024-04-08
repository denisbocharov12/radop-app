<?php

namespace App\Services\Brand;

use App\Data\Brand\BrandData;
use App\Exceptions\Attachments\AttachmentNotFoundException;
use App\Exceptions\Brand\BrandNotFoundException;
use App\Exceptions\Brand\BrandUniqueNameException;
use App\Http\Requests\Brand\BrandDeleteRequest;
use App\Http\Requests\Brand\BrandRequest;
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Http\Requests\Product\ProductMediaDeleteRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Repositories\Attachments\AttachmentsRepository;
use App\Repositories\Brand\BrandRepository;
use App\Services\Attachments\AttachmentsManager;
use App\Services\EntityStatusManager;
use App\Services\ONEC\ONECManager;
use Illuminate\Support\Str;

final class BrandManager
{
    private BrandRepository $brandRepository;
    private EntityStatusManager $entityStatusManager;
    private AttachmentsManager $attachmentsManager;
    private AttachmentsRepository $attachmentsRepository;

    public function __construct(
        BrandRepository     $brandRepository,
        EntityStatusManager $entityStatusManager,
        AttachmentsManager $attachmentsManager,
        AttachmentsRepository $attachmentsRepository,
        private readonly ONECManager $ONECManager,
    )
    {
        $this->brandRepository = $brandRepository;
        $this->entityStatusManager = $entityStatusManager;
        $this->attachmentsManager = $attachmentsManager;
        $this->attachmentsRepository = $attachmentsRepository;
    }

    public function store(BrandData $brandData, BrandRequest $request): void
    {
        $existedBrand = $this->brandRepository->getByTitle($brandData->title);

        if ($existedBrand !== null) {
            throw new BrandUniqueNameException();
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($brandData->status);

        $brand = Brand::create([
            'title' => $brandData->title,
            'description' => $brandData->description,
            'status' => $status,
            'slug' => Str::slug($brandData->title)
        ]);

        $brand->slug = Str::slug($brandData->title) . '-' . $brand->id;
        $brand->save();

        $brandOneCId = $this->ONECManager->getOneCIdForCreate($brand);

        $brand->update([
            'onec_id' => $brandOneCId
        ]);

        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $brand);

    }

    public function update(BrandData $brandData, Brand $brand, BrandRequest $request): void
    {
        if ($brand->title !== $brandData->title) {
            $existedBrand = $this->brandRepository->getByTitle($brandData->title);

            if ($existedBrand !== null) {
                throw new BrandUniqueNameException();
            }
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($brandData->status);

        $brand->update([
            'title' => $brandData->title,
            'description' => $brandData->description,
            'status' => $status
        ]);

        $brand->slug = Str::slug($brandData->title).'-'.$brand->id;
        $brand->save();

        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $brand);
    }

    public function delete(BrandDeleteRequest $request): void
    {
        $brandId = (int)$request->brand_id;

        $brand = $this->brandRepository->getById($brandId);

        if ($brand === null) {
            throw new BrandNotFoundException();
        }

        $brand->delete();
    }

    public function deleteMediaFromBrand(ModelMediaDeleteRequest $request, Brand $brand): void
    {
        $existedAttachment = $this->attachmentsRepository->getById($brand, (int)$request->id);

        if ($existedAttachment === null)
        {
            throw new AttachmentNotFoundException();
        }

        $this->attachmentsManager->deleteAttachmentsFromModel($brand, (int)$request->id);
    }
}
