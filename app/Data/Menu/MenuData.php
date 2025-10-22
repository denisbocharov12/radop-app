<?php

declare(strict_types=1);

namespace App\Data\Menu;

/**
 * @property string $code
 * @property string $name
 * @property string|null $link
 * @property string|null $description
 * @property bool $is_active
 */
final class MenuData
{
    public string $code;
    public string $name;
    public ?string $link;
    public ?string $description;
    public bool $is_active;

    public function __construct(
        string  $code,
        string  $name,
        ?string $link,
        ?string $description,
        bool    $is_active
    )
    {
        $this->code = $code;
        $this->name = $name;
        $this->link = $link;
        $this->description = $description;
        $this->is_active = $is_active;
    }
}

