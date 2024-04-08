<?php

namespace App\Services\ONEC;

use Illuminate\Database\Eloquent\Model;

final class ONECManager
{
    public function getOneCIdForCreate(Model $model): string
    {
        return config('product_onec.onec_id').$model->id;
    }
}
