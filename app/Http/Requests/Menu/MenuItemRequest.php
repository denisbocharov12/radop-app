<?php

declare(strict_types=1);

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $menu_id
 * @property int|null $parent_id
 * @property int $order
 * @property string $type
 * @property string $title_ro
 * @property string $title_ru
 * @property string|null $link_ro
 * @property string|null $link_ru
 * @property string $target
 * @property string|null $icon_class
 * @property array|null $content_data
 * @property bool $is_active
 */
final class MenuItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:menu_items,id'],
            'order' => ['sometimes', 'integer', 'min:0'],
            'type' => ['required', 'in:category,custom_link,promo_block,widget_link'],
            'title_ro' => ['required', 'string', 'max:255'],
            'title_ru' => ['required', 'string', 'max:255'],
            'link_ro' => ['nullable', 'string', 'max:255'],
            'link_ru' => ['nullable', 'string', 'max:255'],
            'target' => ['sometimes', 'string', 'in:_self,_blank,_parent,_top'],
            'icon_class' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:png,svg', 'max:2048'],
            'remove_image' => ['sometimes', 'boolean'],
            'clear_image' => ['nullable', 'boolean'],
            'category_id' => ['nullable', 'string'],
            'content_data' => ['nullable', 'array'],
            'content_data.description' => ['nullable', 'string'],
            'content_data.image' => ['nullable', 'string'],
            'content_data.badge' => ['nullable', 'string'],
            'content_data.link_text' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => __('validation.required', ['attribute' => 'type']),
            'type.in' => __('validation.in', ['attribute' => 'type']),
            'title_ro.required' => __('validation.required', ['attribute' => 'title_ro']),
            'title_ru.required' => __('validation.required', ['attribute' => 'title_ru']),
        ];
    }
}

