<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class PersonalSaleWasChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private readonly User $user,)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Radop Moldova - Reduceri personale pe sait-ul nostru!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'frontend.v1.mail.sale_was_changed',
            with: [
                'user' => $this->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
