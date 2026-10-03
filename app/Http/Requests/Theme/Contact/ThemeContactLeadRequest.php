<?php

declare(strict_types=1);

namespace App\Http\Requests\Theme\Contact;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Заявка со страницы контактов.
 *
 * Телефон или почта — хотя бы одно: часть покупателей оставляет только номер.
 * Поле company — ловушка для роботов: человек его не видит и не заполняет.
 */
final class ThemeContactLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'email' => ['nullable', 'email:rfc', 'max:150', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'max:40', 'required_without:email'],
            'message' => ['required', 'string', 'min:5', 'max:2000'],
            'company' => ['nullable', 'size:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('contact.form_name'),
            'email' => __('contact.form_email'),
            'phone' => __('contact.form_phone'),
            'message' => __('contact.form_message'),
        ];
    }
}
