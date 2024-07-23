<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $city_id
 */
class CityDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'city_id' => ['integer', 'required']
        ];
    }
}
