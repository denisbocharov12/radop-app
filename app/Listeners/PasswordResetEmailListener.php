<?php

namespace App\Listeners;

use App\Events\PasswordResetEmailEvent;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;

final class PasswordResetEmailListener
{
    public function handle(PasswordResetEmailEvent $event): void
    {
        Mail::to($event->user->email)->send(new PasswordResetMail($event->token));
    }
}
