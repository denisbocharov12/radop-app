<?php

namespace App\Data\Attribute;

/**
 * @property string $onecId
 * @property string $name
 * @property string $status
 */
final class AttributeData
{
    public function __construct(
        public readonly ?string $onecId,
        public readonly string $name,
        public readonly string $status,
    )
    {
    }
}
