<?php

declare(strict_types=1);

namespace App\Data\Menu;

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
final class MenuItemData
{
    public int $menu_id;
    public ?int $parent_id;
    public int $order;
    public string $type;
    public string $title;
    public ?string $link;
    public string $target;
    public ?string $icon_class;
    public ?array $content_data;
    public bool $is_active;

    public function __construct(
        int     $menu_id,
        ?int    $parent_id,
        int     $order,
        string  $type,
        string  $title,
        ?string $link,
        string  $target,
        ?string $icon_class,
        ?array  $content_data,
        bool    $is_active
    )
    {
        $this->menu_id = $menu_id;
        $this->parent_id = $parent_id;
        $this->order = $order;
        $this->type = $type;
        $this->title = $title;
        $this->link = $link;
        $this->target = $target;
        $this->icon_class = $icon_class;
        $this->content_data = $content_data;
        $this->is_active = $is_active;
    }
}

