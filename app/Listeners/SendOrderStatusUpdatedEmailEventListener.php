<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdatedSendEmailEvent;
use App\Mail\OrderUpdatedMail;
use Illuminate\Support\Facades\Mail;

final class SendOrderStatusUpdatedEmailEventListener
{
    public function handle(OrderStatusUpdatedSendEmailEvent $event): void
    {
        Mail::to($event->order->email)->send(new OrderUpdatedMail($event->order));
    }
}
