<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class PasswordChangedMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function build(): self
    {
        return $this->view('frontend.v1.emails.password-has-been-reset');
    }
}
