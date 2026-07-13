<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Admin products Excel export. Rows already filtered by the caller
 * (ProductRepository::getAllForAdminExport applies the admin filters).
 * Excel keeps intentional multiple spaces in titles verbatim (no HTML collapse).
 */
final class AdminProductsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private const CONDITION_LABELS = [
        'new'      => 'Новинка',
        'popular'  => 'Популярный',
        'hot'      => 'Hit',
        'featured' => 'Рекомендуемый',
        'winter'   => 'Зимний',
        'regular'  => 'Обычный',
    ];

    public function __construct(
        private readonly Collection $products,
    ) {
    }

    public function collection(): Collection
    {
        return $this->products;
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'Код 1С',
            'Название (RU)',
            'Название (RO)',
            'Бренд',
            'Категории',
            'Цена',
            'Цена со скидкой',
            'Остаток',
            'Состояние',
            'Статус выгрузки',
            'Статус сайта',
        ];
    }

    /**
     * @param Product $product
     * @return array<int, mixed>
     */
    public function map($product): array
    {
        $condition = $product->data?->condition;

        return [
            (string) $product->onec_id,
            $product->getTranslation('title', 'ru', false),
            $product->getTranslation('title', 'ro', false),
            $product->brand?->getTranslation('title', 'ru', false) ?? '',
            $product->categories->pluck('name')->unique()->values()->implode(', '),
            (string) $product->price,
            $product->sale_price ? (string) $product->sale_price : '',
            (string) $product->stock,
            $condition ? (self::CONDITION_LABELS[$condition] ?? $condition) : '',
            $product->status ? 'Активный' : 'Неактивный',
            $product->site_status ? 'Активный' : 'Неактивный',
        ];
    }

    /**
     * @return array<int|string, mixed>
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
