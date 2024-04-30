<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $user_id
 */
class UserDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['integer', 'required']
        ];
    }
}
