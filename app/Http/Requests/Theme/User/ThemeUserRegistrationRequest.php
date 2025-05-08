<?php

namespace App\Http\Requests\Theme\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email_fiz
 * @property string $email_iur
 * @property string $phone_fiz
 * @property string $phone_iur
 * @property string $password_fiz
 * @property string $password_iur
 * @property string $address_fiz
 * @property string $address_iur
 * @property string $organization_name
 * @property string $cod_fiscal
 * @property string $contact_name
 * @property string $type_id
 * @property int $city_id_fiz
 * @property int $city_id_iur
 */
final class ThemeUserRegistrationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['required_if:type_id,1', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z]+$/u'],
            'last_name' => ['required_if:type_id,1', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z]+$/u'],
            'email_fiz' => ['required_if:type_id,1', 'string', 'email'],
            'email_iur' => ['required_if:type_id,2', 'string', 'email'],
            'phone_fiz' => ['required_if:type_id,1', 'string'],
            'phone_iur' => ['required_if:type_id,2', 'string'],
            'password_fiz' => ['required_if:type_id,1', 'string', 'min:8'],
            'password_iur' => ['required_if:type_id,2', 'string', 'min:8'],
            'password_confirmation_iur' => 'required_with:password_iur|same:password_iur|min:8',
            'password_confirmation_fiz' => 'required_with:password_fiz|same:password_fiz|min:8',
            'address_fiz' => ['required_if:type_id,1', 'string'],
            'address_iur' => ['required_if:type_id,2', 'string'],
            'type_id' => ['required', 'integer', 'exists:user_types,id'],
            'city_id_fiz' => ['required_if:type_id,1', 'integer'],
            'city_id_iur' => ['required_if:type_id,2', 'integer'],
            'organization_name' => ['required_if:type_id,2', 'string'],
            'cod_fiscal' => ['nullable', 'string'],
        ];
    }

//    public function messages()
//    {
//        return [
//            'password.required' => 'Поле обязательно для заполнения',
//            'password.min:6' => 'Пароль должен содержать не менее 6 знаков',
//            'rule.required' => 'Поле обязательно к согласию',
//            'rule_iur.required' => 'Поле обязательно к согласию'
//        ];
//    }

    public function validationFailed() {
        return redirect()->back()->withErrors($this->validator)->withInput();
    }
}
