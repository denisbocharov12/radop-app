<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $id
 */
class ProductMediaDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['integer', 'required']
        ];
    }
}
