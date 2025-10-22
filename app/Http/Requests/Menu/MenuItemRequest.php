<?php

declare(strict_types=1);

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $menu_id
 * @property int|null $parent_id
 * @property int $order
 * @property string $type
 * @property string $title
 * @property string|null $link
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
            'type' => ['required', 'in:category,custom_link,promo_block'],
            'title' => ['required', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'target' => ['sometimes', 'string', 'in:_self,_blank,_parent,_top'],
            'icon_class' => ['nullable', 'string', 'max:255'],
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
            'title.required' => __('validation.required', ['attribute' => 'title']),
        ];
    }
}

