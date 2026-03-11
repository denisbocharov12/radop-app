<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdatedSendEmailEvent;
use App\Mail\OrderUpdatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class SendOrderStatusUpdatedEmailEventListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderStatusUpdatedSendEmailEvent $event): void
    {
        try {
            Mail::to($event->order->email)->send(new OrderUpdatedMail($event->order));
        } catch (\Throwable $e) {
            Log::error('SendOrderStatusUpdatedEmailEventListener failed', [
                'order_id' => $event->order->id,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
