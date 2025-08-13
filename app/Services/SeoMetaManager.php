<?php

namespace App\Services;

use App\Data\SeoMeta\SeoMetaData;
use App\Exceptions\Attachments\AttachmentNotFoundException;
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Http\Requests\SeoMeta\SeoMetaRequest;
use App\Http\Requests\SeoMeta\SeoMetaUpdateRequest;
use App\Models\SeoMeta;
use App\Repositories\Attachments\AttachmentsRepository;
use App\Services\Attachments\AttachmentsManager;

final class SeoMetaManager
{
    public function __construct(
        private readonly AttachmentsManager $attachmentsManager,
        private readonly AttachmentsRepository $attachmentsRepository,
    )
    {
    }

    /**
     * @param SeoMetaData $data
     * @return SeoMeta
     */
    public function create(SeoMetaData $data, SeoMetaRequest $request): SeoMeta
    {
        $seoMeta = SeoMeta::create((array) $data);

        $this->attachmentsManager->storeToFilesAttachmentsFromRequestToModelWithResponsiveImages(
            $request,
            $seoMeta
        );

        return $seoMeta;
    }

    /**
     * @param SeoMeta $seoMeta
     * @param SeoMetaData $data
     * @return SeoMeta
     */
    public function update(SeoMeta $seoMeta, SeoMetaData $data, SeoMetaUpdateRequest $request): SeoMeta
    {
        $seoMeta->update((array) $data);

        $this->attachmentsManager->storeToFilesAttachmentsFromRequestToModelWithResponsiveImages(
            $request,
            $seoMeta
        );

        return $seoMeta;
    }

    public function deleteMediaFromBrand(ModelMediaDeleteRequest $request, SeoMeta $seoMeta): void
    {
        $existedAttachment = $this->attachmentsRepository->getById($seoMeta, (int)$request->id);

        if ($existedAttachment === null)
        {
            throw new AttachmentNotFoundException();
        }

        $this->attachmentsManager->deleteAttachmentsFromModel($seoMeta, (int)$request->id);
    }
}
