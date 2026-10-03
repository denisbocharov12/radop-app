<?php

declare(strict_types=1);

namespace App\Http\Requests\HomeSection;

use App\Models\HomeSection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Секция главной: общие поля плюс настройки своего типа.
 */
final class HomeSectionRequest extends FormRequest
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
            'type' => ['required', Rule::in(array_keys(HomeSection::types()))],
            'title_ro' => ['nullable', 'string', 'max:160'],
            'title_ru' => ['nullable', 'string', 'max:160'],
            'subtitle_ro' => ['nullable', 'string', 'max:255'],
            'subtitle_ru' => ['nullable', 'string', 'max:255'],
            'link_title_ro' => ['nullable', 'string', 'max:80'],
            'link_title_ru' => ['nullable', 'string', 'max:80'],
            'link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0', 'max:10000'],

            'source' => ['nullable', 'string', 'max:40'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:40'],
            'product_codes' => ['nullable', 'string', 'max:4000'],

            // Цвет маски — обычный hex из палитры браузера.
            'overlay_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'overlay_opacity' => ['nullable', 'integer', 'min:0', 'max:100'],
            'heading_style' => ['nullable', Rule::in(['light', 'dark'])],

            'background' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_background' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'type' => 'тип секции',
            'link' => 'ссылка',
            'order' => 'порядок',
            'background' => 'фон',
            'overlay_color' => 'цвет маски',
            'overlay_opacity' => 'прозрачность маски',
        ];
    }
}
