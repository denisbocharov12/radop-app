<?php

namespace App\Services\ONEC;

use Illuminate\Database\Eloquent\Model;

final class ONECManager
{
    public function getOneCIdForCreate(Model $model): string
    {
        $modelName = class_basename($model);
        $modelPrefix = mb_substr(strtolower($modelName), 0, 3);

        return $modelPrefix.config('product_onec.onec_id').$model->id;
    }
}
