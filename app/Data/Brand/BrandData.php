<?php

namespace App\Data\Brand;

/**
 * @property string $onec_id
 * @property string $title
 * @property string $description
 * @property bool $status
 * @property array $attachments
 */
final class BrandData
{
    public ?string $onec_id;
    public string $title;
    public ?string $description;
    public string $status;
    public ?array $attachments;

    public function __construct(
        ?string $onec_id,
        string $title,
        ?string $description,
        string $status,
        ?array $attachments
    ) {
        $this->onec_id = $onec_id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->attachments = $attachments;
    }
}
