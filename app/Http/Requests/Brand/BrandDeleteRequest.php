<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $brand_id
 */
class BrandDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'brand_id' => ['integer', 'required']
        ];
    }
}
