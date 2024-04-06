<?php

namespace App\Data\Category;

/**
 * @property string $onec_id
 * @property int $parentId
 * @property string $name
 * @property string $summary
 * @property bool $status
 * @property int $order
 */
final class CategoryData
{
    public ?string $onec_id;
    public ?int $parentId;
    public string $name;
    public ?string $summary;
    public string $status;
    public ?int $order;

    public function __construct(
        ?string  $onec_id,
        ?int    $parentId,
        string  $name,
        ?string $summary,
        string  $status,
        ?int    $order
    )
    {
        $this->onec_id = $onec_id;
        $this->parentId = $parentId;
        $this->name = $name;
        $this->summary = $summary;
        $this->status = $status;
        $this->order = $order;
    }
}
