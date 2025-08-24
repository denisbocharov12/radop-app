<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $banner_id
 */
class BannerDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'banner_id' => ['integer', 'required']
        ];
    }
} 