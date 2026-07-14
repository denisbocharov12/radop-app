<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Admin products Excel export. Rows already filtered by the caller
 * (ProductRepository::getAllForAdminExport applies the admin filters).
 *
 * The "Код 1С" (onec_id, column A) is forced to strict TEXT — like every other
 * product export in the app (see ManagerExcelProductsExport et al. which set the
 * onec_id column to NumberFormat::FORMAT_TEXT + DataType::TYPE_STRING). This keeps
 * leading zeros (e.g. "01091057") and stops purely-numeric codes (e.g. "27060153")
 * from being written as numbers.
 *
 * Money columns use a comma decimal separator ("9,76"), matching the rest of the app.
 * Excel also keeps intentional multiple spaces in titles verbatim (no HTML collapse).
 */
final class AdminProductsExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnFormatting, WithCustomValueBinder, ShouldAutoSize
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
            number_format((float) $product->price, 2, ',', ''),
            $product->sale_price ? number_format((float) $product->sale_price, 2, ',', '') : '',
            (string) $product->stock,
            $condition ? (self::CONDITION_LABELS[$condition] ?? $condition) : '',
            $product->status ? 'Активный' : 'Неактивный',
            $product->site_status ? 'Активный' : 'Неактивный',
        ];
    }

    /**
     * Force the onec_id column (A) to text so no code is ever stored as a number.
     *
     * @return array<string, string>
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
     * Bind column A (onec_id) explicitly as a string; everything else uses the default binder.
     */
    public function bindValue(Cell $cell, $value): bool
    {
        if ($cell->getColumn() === 'A') {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
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
