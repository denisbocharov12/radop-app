<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

final class BrandRoExport implements FromView, ShouldAutoSize, WithTitle, WithColumnWidths, WithStyles
{
    public function __construct(
        private readonly Collection $products,
    ) {
    }

    public function view(): View
    {
        app()->setLocale('ro');

        return view('frontend.v1.exports.brands_ro', [
            'products' => $this->products,
        ]);
    }

    public function title(): string
    {
        return 'RO';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 0.5,  // Пустой столбец
            'B' => 4,    // №
            'C' => 10,   // Код
            'D' => 50,   // Наименование
            'E' => 15,   // Бренд
            'F' => 20,   // Штрихкод
            'G' => 40,   // Фото
            'H' => 10,   // Упаковка (пачка)
            'I' => 10,   // Упаковка (короб)
            'J' => 50,   // Характеристики
            'K' => 15,   // Цена
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        $productsCount = $this->products->count();
        $startRow = 4; // С какой строки начинаются товары (строка 3)
        $endRow = $startRow + $productsCount - 1;

        for ($row = $startRow; $row <= $endRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(120);
        }

        $sheet->getStyle("A2:K{$endRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        return [];
    }
}
