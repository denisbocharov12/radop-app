<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

final class PasswordResetMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly string $token)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Radop Moldova - Reset password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'frontend.v1.emails.password-reset',
            with: [
                'token' => $this->token,
            ],
        );
    }
}
