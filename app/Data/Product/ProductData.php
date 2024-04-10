<?php

namespace App\Data\Product;

/**
 * @property string $onec_id
 * @property string $title
 * @property int $stock
 * @property int $unit
 * @property float $price
 * @property float $sale_price
 * @property bool $status
 * @property string $brand_id
 * @property array $category_id
 * @property string $currency
 * @property array $attachments
 * @property string $sku
 * @property string $summary
 * @property string $description
 * @property array $upp_sale
 * @property string $iur_price
 * @property string $condition
 */
final class ProductData
{
    public ?string $onec_id;
    public string $title;
    public ?int $stock;
    public ?string $unit;
    public float $price;
    public ?float $sale_price;
    public string $status;
    public ?string $brand_id;
    public ?array $category_id;
    public ?array $attachments;
    public ?string $sku;
    public ?string $summary;
    public ?string $description;
    public ?array $upp_sale;
    public ?string $iur_price;
    public string $condition;
    public function __construct(
        ?string $onec_id,
        string  $title,
        ?int    $stock,
        ?string $unit,
        float   $price,
        ?float  $sale_price,
        string  $status,
        ?string $brand_id,
        ?array  $category_id,
        ?array  $attachments,
        ?string $sku,
        ?string $summary,
        ?string $description,
        ?array $upp_sale,
        ?string $iur_price,
        string $condition
    )
    {
        $this->onec_id = $onec_id;
        $this->title = $title;
        $this->stock = $stock;
        $this->unit = $unit;
        $this->price = $price;
        $this->sale_price = $sale_price;
        $this->status = $status;
        $this->brand_id = $brand_id;
        $this->category_id = $category_id;
        $this->attachments = $attachments;
        $this->sku = $sku;
        $this->summary = $summary;
        $this->description = $description;
        $this->upp_sale = $upp_sale;
        $this->iur_price = $iur_price;
        $this->condition = $condition;
    }
}
