<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class ViewCountProductReportExport implements FromView, WithTitle, WithColumnWidths, WithStyles
{
    public function __construct(
        private readonly array $reportData,
    ) {
    }

    public function view(): View
    {
        return view('reports.view-count.exports.product-report', [
            'reportData' => $this->reportData,
        ]);
    }

    public function title(): string
    {
        return 'Отчет по просмотрам';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 15,
            'C' => 50,
            'D' => 18,
            'E' => 20,
            'F' => 22,
            'G' => 20,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        $productsCount = count($this->reportData['products']);
        $startRow = 5;
        $endRow = $startRow + $productsCount;

        $sheet->getStyle("A1:G{$endRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $sheet->getStyle("A4:G{$endRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color(Color::COLOR_BLACK));

        $sheet->getStyle('A4:G4')
            ->getFont()
            ->setBold(true);

        $sheet->getStyle('A1:G1')
            ->getFont()
            ->setBold(true)
            ->setSize(14);

        return [];
    }
}

