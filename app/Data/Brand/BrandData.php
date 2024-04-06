<?php

namespace App\Data\Brand;

/**
 * @property string $onec_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property bool $status
 */
final class BrandData
{
    public ?string $onec_id;
    public string $title;
    public string $slug;
    public ?string $description;
    public string $status;

    public function __construct(
        string $onec_id,
        string $title,
        string $slug,
        string $description,
        string $status
    ) {
        $this->onec_id = $onec_id;
        $this->title = $title;
        $this->slug = $slug;
        $this->description = $description;
        $this->status = $status;
    }
}
