<?php

namespace App\Mail;

use App\Excel\Order\OrderExport;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class AdminOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private readonly Order $order,
    ) {
    }

    public function build(): AdminOrderMail
    {
        $filePath = "orders/order_{$this->order->id}.xlsx";
        Excel::store(new OrderExport($this->order), $filePath, 'local');
        $products = $this->order->products;

        return $this->subject(__('theme.order-new-order') . '' . $this->order->order_number)
            ->view('frontend.v1.mail.order', ['order' => $this->order, 'products' => $products])
            ->attach(storage_path("app/{$filePath}"));
    }
}
