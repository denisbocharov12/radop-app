<?php

namespace App\Listeners;

use App\Events\OrderCreatedSendEmailEvent;
use App\Mail\OrderCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

final class SendUserOrderEmailListener
{
    public function __construct()
    {
    }

    public function handle(OrderCreatedSendEmailEvent $event): void
    {
        Mail::to($event->order->email)->send(new OrderCreatedMail($event->order));
    }
}
