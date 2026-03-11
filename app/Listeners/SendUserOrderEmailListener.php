<?php

namespace App\Listeners;

use App\Events\OrderCreatedSendEmailEvent;
use App\Mail\OrderCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class SendUserOrderEmailListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderCreatedSendEmailEvent $event): void
    {
        try {
            Mail::to($event->order->email)->send(new OrderCreatedMail($event->order));
        } catch (\Throwable $e) {
            Log::error('SendUserOrderEmailListener failed', [
                'order_id' => $event->order->id,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
