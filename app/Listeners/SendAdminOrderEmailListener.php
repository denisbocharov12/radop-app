<?php

namespace App\Listeners;

use App\Events\OrderCreatedSendAdminEmailEvent;
use App\Mail\AdminOrderMail;
use Illuminate\Support\Facades\Mail;

final class SendAdminOrderEmailListener
{
    public function handle(OrderCreatedSendAdminEmailEvent $event): void
    {
        Mail::to($event->email)->send(new AdminOrderMail($event->order));
    }
}
