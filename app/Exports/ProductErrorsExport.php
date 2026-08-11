<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\ProductError;
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
 * Excel export of the product-error listing, respecting the active filters.
 * "Код 1С" (onec_id, column A) is forced to strict TEXT like the other product
 * exports so leading zeros / numeric codes survive.
 */
final class ProductErrorsExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnFormatting, WithCustomValueBinder, ShouldAutoSize
{
    public function __construct(
        private readonly Collection $errors,
    ) {
    }

    public function collection(): Collection
    {
        return $this->errors;
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return ['Код 1С', 'Товар', 'Серьёзность', 'Тип ошибки', 'Описание'];
    }

    /**
     * @param ProductError $error
     * @return array<int, mixed>
     */
    public function map($error): array
    {
        return [
            (string) $error->product_onec_id,
            (string) $error->product_title,
            ProductError::labelForSeverity($error->severity),
            ProductError::labelForType($error->type),
            $error->localizedMessage(),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function columnFormats(): array
    {
        return ['A' => NumberFormat::FORMAT_TEXT];
    }

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
        return [1 => ['font' => ['bold' => true]]];
    }
}
