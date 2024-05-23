<?php

namespace App\Listeners;

use App\Events\OrderCreatedSendManagerEmailEvent;
use App\Mail\OrderCreatedManagerMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

final class SendManagerOrderEmailListener
{
    public function __construct()
    {
    }

    public function handle(OrderCreatedSendManagerEmailEvent $event): void
    {
        Mail::to($event->user->email)->send(new OrderCreatedManagerMail());
    }
}
