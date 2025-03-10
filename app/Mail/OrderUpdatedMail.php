<?php

namespace App\Mail;

use App\Models\Order;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Order\OrderRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class OrderUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly Order $order,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Starea comenzii dvs. nr. №'. $this->order->order_number .' a fost schimbat la ' . __(
                'theme.' . $this->order->status, [], 'ro'
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'frontend.v1.mail.order_status',
            with: [
                'order' => $this->order,
                'products' => $this->order->products,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
