<?php

declare(strict_types=1);

namespace App\Excel\Order;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

final class OrderExport implements ShouldAutoSize, FromView
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
}
