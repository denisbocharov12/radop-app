<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class UserActivationGenerateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $token
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activarea contului pe site-ul www.radop.md',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'frontend.v1.mail.registration-activate',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
