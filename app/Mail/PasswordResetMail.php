<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class PasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly string $token)
    {
    }

    public function build(): self
    {
        return $this->view('frontend.v1.emails.password-reset')->with(['token' => $this->token]);
    }
}
