<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class PasswordChangedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Radop Moldova - Reset password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'frontend.v1.emails.password-has-been-reset',
        );
    }
}
