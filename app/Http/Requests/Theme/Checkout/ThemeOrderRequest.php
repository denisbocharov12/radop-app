<?php

namespace App\Http\Requests\Theme\Checkout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $fio
 * @property string $recommended_time
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property int $city_id
 * @property int $filial_id
 * @property string $note
 * @property string $payment_method
 * @property string $delivery_method
 * @property string $delivery_charge
 * @property string $company_name
 * @property string $reserve_phone
 * @property string $bank
 * @property string $idno
 * @property string $tva
 * @property string $registered_city
 * @property string $iur_address
 * @property string $shipping_address
 */
final class ThemeOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name'       => ['nullable', 'string', 'max:255'],
            'last_name'        => ['nullable', 'string', 'max:255'],
            'fio'              => ['required', 'string', 'max:255'],
            'recommended_time' => ['nullable', 'string', 'max:100'],
            'email'            => ['required', 'email:rfc,dns', 'max:255'],
            'phone'            => ['required', 'string', 'max:30'],
            'address'          => ['nullable', 'string', 'max:500'],
            'city_id'          => ['nullable', 'integer', 'min:1'],
            'filial_id'        => ['nullable', 'integer', 'min:1'],
            'note'             => ['nullable', 'string', 'max:1000'],
            'payment_method'   => ['required', 'string', 'max:100'],
            'delivery_method'  => ['nullable', 'string', 'max:100'],
            'delivery_charge'  => ['nullable', 'numeric', 'min:0'],
            // Legal entity (iur) fields — all optional
            'company_name'     => ['nullable', 'string', 'max:255'],
            'reserve_phone'    => ['nullable', 'string', 'max:30'],
            'bank'             => ['nullable', 'string', 'max:255'],
            'idno'             => ['nullable', 'string', 'max:50'],
            'tva'              => ['nullable', 'string', 'max:50'],
            'registered_city'  => ['nullable', 'string', 'max:255'],
            'iur_address'      => ['nullable', 'string', 'max:500'],
            'shipping_address' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Add cross-field validation: either city_id or filial_id must be present.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            $cityId   = $this->input('city_id');
            $filialId = $this->input('filial_id');

            if (empty($cityId) && empty($filialId)) {
                $v->errors()->add('city_id', __('validation.checkout.city_or_filial_required'));
            }
        });
    }

    public function messages(): array
    {
        return [
            'email.email'            => __('validation.email'),
            'fio.required'           => __('validation.required'),
            'phone.required'         => __('validation.required'),
            'payment_method.required'=> __('validation.required'),
        ];
    }

    public function validationFailed()
    {
        return redirect()->back()->withErrors($this->validator)->withInput();
    }
}
