<?php

namespace App\Data\Product;

/**
 * @property string|null $onecId
 * @property string $title_ro
 * @property string $title_ru
 * @property int|null $stock
 * @property int|null $unit
 * @property float $price
 * @property float|null $salePrice
 * @property string $status
 * @property string $siteStatus
 * @property string|null $brandId
 * @property array|null $categoryId
 * @property array|null $attachments
 * @property string|null $sku
 * @property string|null $summary_ro
 * @property string|null $summary_ru
 * @property string|null $description
 * @property array|null $uppSale
 * @property string|null $iurPrice
 * @property string $condition
 * @property string|null $shtrih_code
 * @property int|null $minOrder
 */
final class ProductData
{
    public function __construct(
        public readonly ?string $onecId,
        public readonly string $title_ro,
        public readonly string $title_ru,
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
        public readonly ?string $summary_ro,
        public readonly ?string $summary_ru,
        public readonly ?string $description,
        public readonly ?array $uppSale,
        public readonly ?string $iurPrice,
        public readonly string $condition,
        public readonly ?string $shtrih_code,
        public readonly ?int $minOrder,
    )
    {
    }
}
