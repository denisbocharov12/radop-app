<?php

namespace App\Listeners;

use App\Events\PasswordChangedEmailEvent;
use App\Mail\PasswordChangedMail;
use Illuminate\Support\Facades\Mail;

final class PasswordChangedEmailListener
{
    public function handle(PasswordChangedEmailEvent $event): void
    {
        Mail::to($event->user->email)->send(new PasswordChangedMail());
    }
}
