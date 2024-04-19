<?php

namespace App\Data\Attribute;

/**
 * @property string $attributeOnecId
 * @property string $productOnecId
 * @property string $value
 * @property string $price
 */
final class AttributeValueData
{
    public function __construct(
        public readonly ?string $attributeOnecId,
        public readonly string $productOnecId,
        public readonly string $value,
        public readonly string $price,
    )
    {
    }
}
