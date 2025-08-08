<?php

declare(strict_types=1);

namespace App\Excel\User;

use App\Models\OrderItem;
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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class UserReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    use Exportable;

    public function __construct(
        private readonly Collection $orderItems,
        private readonly string $startDate = '',
        private readonly string $endDate = '',
    ) {
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->orderItems;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $user = $this->orderItems->first()?->order?->user;
        $userInfo = $this->getUserInfo($user);

        return [
            ['Отчет по заказам пользователя'],
            ['Период: ' . $this->getPeriodInfo()],
            ['Пользователь: ' . $userInfo['name']],
            [''],
            [
                'Код товара',
                'Наименование товара',
                'Цена',
                'Кол-во',
                'Сумма'
            ]
        ];
    }

    /**
     * @param OrderItem $item
     * @return array
     */
    public function map($item): array
    {
        $calculatedPrice = (float)$item->price;
        $quantity = (int)$item->quantity;
        $sum = $calculatedPrice * $quantity;

        return [
            $item->product?->onec_id ?? '-',
            $item->product?->getTranslation('title', app()->getLocale()) ?? '-',
            number_format($calculatedPrice, 2, '.', ' '),
            $quantity,
            number_format($sum, 2, '.', ' '),
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
            'C' => [
                'alignment' => ['horizontal' => 'right'],
            ],
            'D' => [
                'alignment' => ['horizontal' => 'center'],
            ],
            'E' => [
                'alignment' => ['horizontal' => 'right'],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->mergeCells('A2:E2');
                $event->sheet->mergeCells('A3:E3');
            },
        ];
    }

    /**
     * @param mixed $user
     * @return array
     */
    private function getUserInfo($user): array
    {
        if (!$user) {
            return ['name' => '-'];
        }

        if ($user->type?->key_name === 'fiz') {
            $name = $user->profile?->fio ?? $user->profile?->first_name . ' ' . $user->profile?->last_name ?? '-';
        } else {
            $name = $user->profile?->organization_name ?? '-';
        }

        return [
            'name' => $name,
            'type' => $user->type?->key_name ?? '-'
        ];
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

        $firstItem = $this->orderItems->first();
        if (!$firstItem) {
            return '-';
        }

        $startDate = $firstItem->order?->created_at?->format('d.m.Y') ?? '-';
        $endDate = $this->orderItems->last()?->order?->created_at?->format('d.m.Y') ?? '-';

        return $startDate . ' - ' . $endDate;
    }
}
