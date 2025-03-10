<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name_ro
 * @property string $name_ru
 * @property int $delivery_sum
 */
class CityRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name_ro' => ['required', 'string'],
            'name_ru' => ['required', 'string'],
            'delivery_sum' => ['required', 'integer'],
        ];
    }
}
