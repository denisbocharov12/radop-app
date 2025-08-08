<?php

declare(strict_types=1);

namespace App\Excel\Order;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class OrderReportExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    use Exportable;

    public function __construct(
        private readonly Collection $orders,
    ) {
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->orders;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '№',
            'ID',
            'Клиент',
            'Фискальный код',
            'Дата',
            'Номер телефона',
            'Город',
            'Филиал',
            'Сумма',
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    public function map($order): array
    {
        if($order->user?->type?->key_name === 'fiz') {
            if($order->fio === null) {
                $order->fio = $order->user?->profile?->fio ?? '-';
            } else {
                $order->fio = $order->user->profile->first_name . ' ' . $order->user->profile->last_name;
            }
        } else {
            $order->fio = $order->user?->profile?->organization_name ?? '-';
        }

        if (number_format((float)$order?->user?->profile?->cod_fiscal, 0, '.', ' ') === '0') {
            $fiscCode = '-';
        } else {
            $fiscCode = number_format((float)$order?->user?->profile?->cod_fiscal, 0, '.', ' ');
        }

        return [
            $order->order_number,
            $order->id,
            $order->fio,
            $fiscCode,
            $order->created_at->format('d.m.Y'),
            $order->phone,
            $order->cityModel?->name ?? $order->city,
            $order->filial?->address ?? '-',
            number_format((float)$order->total, 2, '.', ' '),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => DataType::TYPE_STRING,
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
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'I'  => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'right'],
            ],
            'D'  => [
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
            AfterSheet::class => function(AfterSheet $event) {
                $worksheet = $event->sheet->getDelegate();
                $highestRow = $worksheet->getHighestRow();

                $totalSum = 0;
                for ($row = 2; $row <= $highestRow; $row++) {
                    $sumValue = $worksheet->getCell('G' . $row)->getValue();
                    if (is_string($sumValue)) {
                        $sumValue = str_replace(' ', '', $sumValue);
                    }
                    $totalSum += (float)$sumValue;
                }

                $totalRow = $highestRow + 2;
                $worksheet->setCellValue('A' . $totalRow, 'ИТОГО:');
                $worksheet->setCellValue('G' . $totalRow, number_format($totalSum, 2, '.', ' '));

                $worksheet->getStyle('A' . $totalRow . ':G' . $totalRow)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E8F4FD']
                    ]
                ]);

                $worksheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal('right');
                $worksheet->getStyle('G' . $totalRow)->getAlignment()->setHorizontal('right');
            }
        ];
    }
}
