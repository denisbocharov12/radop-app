<?php

declare(strict_types=1);

namespace App\Excel\Order;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * @param Collection<int, array{number: int, onec_id: string|null, title: string, total_quantity: int, total_sum: float}> $rows
 */
final class ProductReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    use Exportable;

    public function __construct(
        private readonly Collection $rows,
        private readonly string $startDate = '',
        private readonly string $endDate = '',
    ) {
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->rows;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            ['Отчет по товарам (продажи)'],
            ['Период: ' . $this->getPeriodInfo()],
            [''],
            [
                '№',
                'Код товара',
                'Название',
                'Кол-во продаж',
                'Сумма продаж',
            ],
        ];
    }

    /**
     * @param array{number: int, onec_id: string|null, title: string, total_quantity: int, total_sum: float} $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row['number'],
            $row['onec_id'] ?? '-',
            $row['title'],
            $row['total_quantity'],
            number_format((float) $row['total_sum'], 2, '.', ' '),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => 'center'],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'left'],
            ],
            4 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'D' => [
                'alignment' => ['horizontal' => 'right'],
            ],
            'E' => [
                'alignment' => ['horizontal' => 'right'],
            ],
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $worksheet = $event->sheet->getDelegate();
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->mergeCells('A2:E2');
                $highestRow = $worksheet->getHighestRow();
                $totalSum = 0;
                for ($row = 5; $row <= $highestRow; $row++) {
                    $val = $worksheet->getCell('E' . $row)->getValue();
                    if (is_string($val)) {
                        $val = str_replace(' ', '', $val);
                    }
                    $totalSum += (float) $val;
                }
                $totalRow = $highestRow + 2;
                $worksheet->setCellValue('A' . $totalRow, 'ИТОГО:');
                $worksheet->setCellValue('E' . $totalRow, number_format($totalSum, 2, '.', ' '));
                $worksheet->getStyle('A' . $totalRow . ':E' . $totalRow)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E8F4FD'],
                    ],
                ]);
            },
        ];
    }

    private function getPeriodInfo(): string
    {
        if ($this->startDate && $this->endDate) {
            $start = Carbon::createFromFormat('Y-m-d', $this->startDate)->format('d.m.Y');
            $end = Carbon::createFromFormat('Y-m-d', $this->endDate)->format('d.m.Y');
            return $start . ' - ' . $end;
        }
        return '-';
    }
}
