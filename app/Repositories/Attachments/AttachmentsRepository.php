<?php

namespace App\Repositories\Attachments;

use Illuminate\Database\Eloquent\Model;

final class AttachmentsRepository
{
    public function getById(Model $model, int $id): bool
    {
        if (!empty($model->getMedia()->where('id',$id)->first())){
            return true;
        }

        return false;
    }
}
