<?php

namespace App\Services\Attachments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

final class AttachmentsManager
{
    private const MEDIA_DISK = 'media';
    private const FILE_DISK = 'files';

    public function storeToMediaAttachmentsFromRequestToModel(Request $request, Model $model)
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $key => $mediaItem) {
                $model->addMedia($request->attachments[$key])->toMediaCollection(self::MEDIA_DISK);
            }
        }
    }

    public function storeToFilesAttachmentsFromRequestToModel(Request $request, Model $model)
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $key => $mediaItem) {
                $model->addMedia($request->attachments[$key])->toMediaCollection(self::FILE_DISK);
            }
        }
    }

    public function storeToFilesAttachmentsFromRequestToModelWithResponsiveImages(Request $request, Model $model)
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $key => $mediaItem) {
                $model->addMedia($request->attachments[$key])->toMediaCollection(self::FILE_DISK);
            }
        }
    }

    public function syncAttachmentsFromRequestToModel()
    {

    }

    public function deleteAttachmentsFromModel(Model $model, int $mediaId)
    {
        $model->deleteMedia($mediaId);
    }
}
