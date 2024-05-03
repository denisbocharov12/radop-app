<?php

namespace App\Listeners;

use App\Events\UserActivationSendEmailEvent;
use App\Mail\UserActivationGenerateMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

final class SendUserActivationEmailListener
{
    public function __construct()
    {
    }

    public function handle(UserActivationSendEmailEvent $event): void
    {
        Mail::to($event->user->email)->send(new UserActivationGenerateMail($event->token));
    }
}
