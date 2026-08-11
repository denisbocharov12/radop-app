<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $image_ru
 * @property string $image_ro
 * @property string $link
 * @property string $active
 * @property int $order
 */
class BannerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image_ru' => 'nullable|image|mimes:jpeg,jpg|max:2048',
            'image_ro' => 'nullable|image|mimes:jpeg,jpg|max:2048',
            'link' => 'nullable|string',
            'link_ru' => 'nullable|string|max:1000',
            'link_ro' => 'nullable|string|max:1000',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:1',
        ];
    }
}
