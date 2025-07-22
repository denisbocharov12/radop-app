<?php

declare(strict_types=1);

namespace App\Excel\Order;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
}
