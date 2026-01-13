<?php

declare(strict_types=1);

namespace App\Excel\Order;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

final class OrderExport implements ShouldAutoSize, FromView, WithStyles
{
    public function __construct(
        private readonly Order $order,
    ) {
    }

    public function view(): View
    {
        $products = $this->order->products;

        return view('frontend.v1.excel.order', [
            'order' => $this->order,
            'products' => $products,
        ]);
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        $sheet->getStyle('A:Z')
            ->getAlignment()
            ->setWrapText(true);

        return [];
    }

//    public function registerEvents(): array
//    {
//        return [
//            AfterSheet::class => function (AfterSheet $event) {
//                $sheet = $event->sheet->getDelegate();
//                $highestRow = $sheet->getHighestRow();
//
//                for ($row = 1; $row <= $highestRow; $row++) {
//                    $priceCell = $sheet->getCell('D' . $row);
//                    $sumCell = $sheet->getCell('E' . $row);
//
//                    $priceValue = $priceCell->getValue();
//                    $sumValue = $sumCell->getValue();
//
//                    if ($priceValue !== null && $priceValue !== '' && is_numeric($priceValue)) {
//                        $priceCell->setValueExplicit((float)$priceValue, DataType::TYPE_NUMERIC);
//                        $priceCell->getStyle()
//                            ->getNumberFormat()
//                            ->setFormatCode('#,##0,00');
//                    }
//
//                    if ($sumValue !== null && $sumValue !== '' && is_numeric($sumValue)) {
//                        $sumCell->setValueExplicit((float)$sumValue, DataType::TYPE_NUMERIC);
//                        $sumCell->getStyle()
//                            ->getNumberFormat()
//                            ->setFormatCode('#,##0,00');
//                    }
//                }
//            },
//        ];
//    }
}
