<?php

namespace App\Data\Product;

/**
 * @property string $onecId
 * @property string $title
 * @property int $stock
 * @property int $unit
 * @property float $price
 * @property float $salePrice
 * @property string $status
 * @property string $siteStatus
 * @property string $brandId
 * @property array $categoryId
 * @property array $attachments
 * @property string $sku
 * @property string $summary
 * @property string $description
 * @property array $uppSale
 * @property string $iurPrice
 * @property string $condition
 */
final class ProductData
{
    public function __construct(
        public readonly ?string $onecId,
        public readonly string $title,
        public readonly ?int $stock,
        public readonly ?int $unit,
        public readonly float $price,
        public readonly ?float $salePrice,
        public readonly string $status,
        public readonly string $siteStatus,
        public readonly ?string $brandId,
        public readonly ?array $categoryId,
        public readonly ?array $attachments,
        public readonly ?string $sku,
        public readonly ?string $summary,
        public readonly ?string $description,
        public readonly ?array $uppSale,
        public readonly ?string $iurPrice,
        public readonly string $condition
    )
    {
    }
}
