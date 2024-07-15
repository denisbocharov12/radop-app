<?php

namespace App\Data\Category;

/**
 * @property string $onec_id
 * @property int $parentId
 * @property string $name_ro
 * @property string $name_ru
 * @property string $summary
 * @property bool $status
 * @property int $order
 * @property array $attachments
 */
final class CategoryData
{
    public ?string $onec_id;
    public ?int $parentId;
    public string $name_ro;
    public string $name_ru;
    public ?string $summary;
    public string $status;
    public ?int $order;
    public ?array $attachments;

    public function __construct(
        ?string  $onec_id,
        ?int    $parentId,
        string  $name_ro,
        string  $name_ru,
        ?string $summary,
        string  $status,
        ?int    $order,
        ?array  $attachments
    )
    {
        $this->onec_id = $onec_id;
        $this->parentId = $parentId;
        $this->name_ro = $name_ro;
        $this->name_ru = $name_ru;
        $this->summary = $summary;
        $this->status = $status;
        $this->order = $order;
        $this->attachments = $attachments;
    }
}
