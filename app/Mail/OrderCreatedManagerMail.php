<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class OrderCreatedManagerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Radop Moldova - Your client make order',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'frontend.v1.mail.order-manager-created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
