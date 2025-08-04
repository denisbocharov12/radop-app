<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class BrandExport implements FromView, WithTitle, WithColumnWidths, WithStyles
{
    public function __construct(
        private readonly Collection $products,
    ) {
    }

    public function view(): View
    {
        return view('frontend.v1.exports.brands_export', [
            'products' => $this->products,
        ]);
    }

    public function title(): string
    {
        return app()->getLocale() === 'ru' ? 'RU' : 'RO';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 0.5,
            'B' => 4,
            'C' => 10,
            'D' => 50,
            'E' => 15,
            'F' => 20,
            'G' => 10,
            'H' => 10,
            'I' => 50,
            'J' => 15,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $productsCount = $this->products->count();
        $startRow = 4;
        $endRow = $startRow + $productsCount - 1;

        for ($row = $startRow; $row <= $endRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(120);
        }

        $sheet->getStyle("A2:J{$endRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $sheet->getStyle("A2:J{$endRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color(Color::COLOR_BLACK));

        return [];
    }
}
