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

final class OrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly Order $order,
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Radop Moldova - Felicitări, comanda dumneavoastră №'.$this->order->order_number.' a fost plasată cu succes!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'frontend.v1.mail.order',
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
