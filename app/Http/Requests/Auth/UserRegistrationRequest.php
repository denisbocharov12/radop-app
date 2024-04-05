<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class UserRegistrationRequest extends BaseRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'username' => ['required' , 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'confirmed'],
            'email_confirmation'=> ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['nullable', 'integer'],
            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'min:2', 'max:255'],
            'bio' => ['nullable', 'string', 'min:2', 'max:255'],
        ];
    }
}
