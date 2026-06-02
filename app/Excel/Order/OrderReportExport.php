<?php

declare(strict_types=1);

namespace App\Excel\Order;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class OrderReportExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents, WithColumnFormatting
{
    use Exportable;

    /** @var list<int> 1-based sheet rows that are per-client summary rows (grouped mode). */
    private array $summaryRowIndexes = [];

    private float $grandTotal = 0.0;

    public function __construct(
        private readonly Collection $orders,
        private readonly bool $groupByClients = false,
    ) {
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function array(): array
    {
        return $this->groupByClients
            ? $this->buildGroupedRows()
            : $this->buildFlatRows();
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        if ($this->groupByClients) {
            // Grouped: phone / city / filial removed, date -> period.
            return ['№', 'ID', 'Клиент', 'Фискальный код', 'Период', 'Сумма'];
        }

        return ['№', 'ID', 'Клиент', 'Фискальный код', 'Дата', 'Номер телефона', 'Город', 'Филиал', 'Сумма'];
    }

    // ── Row builders ────────────────────────────────────────────────────────

    /**
     * @return array<int, array<int, string>>
     */
    private function buildFlatRows(): array
    {
        $rows = [];
        $this->grandTotal = 0.0;

        foreach ($this->orders as $order) {
            $this->grandTotal += (float) $order->total;

            $rows[] = [
                (string) $order->order_number,
                (string) $order->id,
                $this->resolveClientName($order),
                $this->resolveFiscCode($order),
                $order->created_at?->format('d.m.Y') ?? '-',
                (string) $order->phone,
                (string) ($order->cityModel?->name ?? $order->city),
                (string) ($order->filial?->address ?? '-'),
                $this->formatSum((float) $order->total),
            ];
        }

        return $rows;
    }

    /**
     * @return array<int, array<int, string>>
     */
    private function buildGroupedRows(): array
    {
        $rows = [];
        $this->summaryRowIndexes = [];
        $this->grandTotal = 0.0;

        $groups = $this->orders->groupBy(
            static fn ($order) => $order->user?->id !== null
                ? 'u:' . $order->user->id
                : 'f:' . ($order->fio ?? $order->order_number)
        );

        foreach ($groups as $clientOrders) {
            $sorted = $clientOrders->sortBy(static fn ($o) => $o->created_at)->values();
            $first = $sorted->first();

            $clientName  = $this->resolveClientName($first);
            $fiscCode    = $this->resolveFiscCode($first);
            $clientTotal = 0.0;
            $minDate = null;
            $maxDate = null;

            foreach ($sorted as $order) {
                $clientTotal += (float) $order->total;
                $date = $order->created_at;
                if ($date !== null) {
                    $minDate = ($minDate === null || $date->lt($minDate)) ? $date : $minDate;
                    $maxDate = ($maxDate === null || $date->gt($maxDate)) ? $date : $maxDate;
                }

                $rows[] = [
                    (string) $order->order_number,
                    (string) $order->id,
                    $this->resolveClientName($order),
                    $this->resolveFiscCode($order),
                    $order->created_at?->format('d.m.Y') ?? '-',
                    $this->formatSum((float) $order->total),
                ];
            }

            $this->grandTotal += $clientTotal;

            // Per-client summary row. +2: heading occupies row 1, data starts row 2.
            $this->summaryRowIndexes[] = count($rows) + 2;
            $rows[] = ['', '', $clientName, $fiscCode, $this->formatPeriod($minDate, $maxDate), $this->formatSum($clientTotal)];

            // Blank separator between clients.
            $rows[] = ['', '', '', '', '', ''];
        }

        return $rows;
    }

    // ── Styling ─────────────────────────────────────────────────────────────

    /**
     * @return array<int|string, array<string, mixed>>
     */
    public function styles(Worksheet $sheet): array
    {
        $sumColumn = $this->groupByClients ? 'F' : 'I';

        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            $sumColumn => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'right'],
            ],
            'D' => [
                'alignment' => ['horizontal' => 'right'],
            ],
        ];
    }

    /**
     * @return array<class-string, callable>
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $worksheet  = $event->sheet->getDelegate();
                $highestRow = $worksheet->getHighestRow();
                $lastColumn = $this->groupByClients ? 'F' : 'I';

                // Highlight per-client summary rows (grouped mode only).
                foreach ($this->summaryRowIndexes as $summaryRow) {
                    $worksheet->getStyle("A{$summaryRow}:{$lastColumn}{$summaryRow}")->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'D9F2E6'],
                        ],
                    ]);
                }

                // Grand total row.
                $totalRow = $highestRow + 2;
                $worksheet->setCellValue("A{$totalRow}", 'ИТОГО:');
                $worksheet->setCellValue("{$lastColumn}{$totalRow}", $this->formatSum($this->grandTotal));

                $worksheet->getStyle("A{$totalRow}:{$lastColumn}{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E8F4FD'],
                    ],
                ]);
                $worksheet->getStyle("A{$totalRow}")->getAlignment()->setHorizontal('right');
                $worksheet->getStyle("{$lastColumn}{$totalRow}")->getAlignment()->setHorizontal('right');
            },
        ];
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    private function resolveClientName($order): string
    {
        if ($order->user?->type?->key_name === 'fiz') {
            $profileFio = $order->user?->profile?->fio;
            if ($profileFio !== null && $profileFio !== '') {
                return $profileFio;
            }
            $first = $order->user?->profile?->first_name;
            $last  = $order->user?->profile?->last_name;
            $full  = trim((string) $first . ' ' . (string) $last);

            return $full !== '' ? $full : ($order->fio ?? '-');
        }

        return $order->user?->profile?->organization_name ?? ($order->fio ?? '-');
    }

    /**
     * Fiscal code as a real integer (numeric cell, no separators, no scientific
     * notation, no rounding). Falls back to '-' when missing, or to the raw
     * digit string for values too long for an exact integer (> 15 digits).
     *
     * @return int|string
     */
    private function resolveFiscCode($order): int|string
    {
        $raw = preg_replace('/\D+/', '', (string) ($order->user?->profile?->cod_fiscal ?? ''));

        if ($raw === '' || $raw === '0') {
            return '-';
        }

        return strlen($raw) > 15 ? $raw : (int) $raw;
    }

    /**
     * Force the fiscal-code column (D in both modes) to render as a plain
     * integer — never scientific notation, never thousands separators.
     *
     * @return array<string, string>
     */
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    private function formatSum(float $value): string
    {
        return number_format($value, 2, ',', ' ');
    }

    private function formatPeriod($minDate, $maxDate): string
    {
        if ($minDate === null) {
            return '-';
        }

        $from = $minDate->format('d.m.Y');
        $to   = $maxDate?->format('d.m.Y') ?? $from;

        return $from === $to ? $from : "{$from}-{$to}";
    }
}
