<?php

declare(strict_types=1);

namespace App\Excel\Order;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class CityOrderReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents, WithColumnFormatting
{
    use Exportable;

    public function __construct(
        private readonly Collection $orders,
        private readonly string $startDate = '',
        private readonly string $endDate = '',
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
        $cityName = $this->getCityName();
        
        return [
            ['Отчет по заказам по городу'],
            ['Период: ' . $this->getPeriodInfo()],
            ['Город: ' . $cityName],
            [''],
            [
                '№',
                'ID',
                'Клиент',
                'Фискальный код',
                'Дата',
                'Город',
                'Филиал',
                'Сумма'
            ]
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    public function map($order): array
    {
        $clientName = $this->getClientName($order);
        $fiscCode = $this->getFiscCode($order);

        return [
            $order->order_number,
            $order->id,
            $clientName,
            $fiscCode,
            $order->created_at->format('d.m.Y'),
            $order->cityModel?->name ?? $order->city,
            $order->filial?->address ?? '-',
            number_format((float)$order->total, 2, ',', ' '),
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
            3 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'left'],
            ],
            5 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'G' => [
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
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->mergeCells('A2:H2');
                $event->sheet->mergeCells('A3:H3');
            },
        ];
    }

    /**
     * @param mixed $order
     * @return string
     */
    private function getClientName($order): string
    {
        if ($order->user?->type?->key_name === 'fiz') {
            return $order->user?->profile?->fio ?? $order->user?->profile?->first_name . ' ' . $order->user?->profile?->last_name ?? $order->fio ?? '-';
        } else {
            return $order->user?->profile?->organization_name ?? $order->fio ?? '-';
        }
    }

    /**
     * Fiscal code as a real integer (numeric cell, no separators, no scientific
     * notation, no rounding). '-' when missing; raw digits if > 15 chars.
     *
     * @param mixed $order
     * @return int|string
     */
    private function getFiscCode($order): int|string
    {
        $raw = preg_replace('/\D+/', '', (string) ($order->user?->profile?->cod_fiscal ?? ''));

        if ($raw === '' || $raw === '0') {
            return '-';
        }

        return strlen($raw) > 15 ? $raw : (int) $raw;
    }

    /**
     * @return string
     */
    private function getCityName(): string
    {
        $firstOrder = $this->orders->first();
        if (!$firstOrder) {
            return '-';
        }

        return $firstOrder->cityModel?->name ?? $firstOrder->city ?? '-';
    }

    /**
     * @return string
     */
    private function getPeriodInfo(): string
    {
        if ($this->startDate && $this->endDate) {
            $start = Carbon::createFromFormat('Y-m-d', $this->startDate)->format('d.m.Y');
            $end = Carbon::createFromFormat('Y-m-d', $this->endDate)->format('d.m.Y');
            return $start . ' - ' . $end;
        }

        $firstOrder = $this->orders->first();
        if (!$firstOrder) {
            return '-';
        }

        $startDate = $firstOrder->created_at?->format('d.m.Y') ?? '-';
        $endDate = $this->orders->last()?->created_at?->format('d.m.Y') ?? '-';

        return $startDate . ' - ' . $endDate;
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }
} 