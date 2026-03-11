<?php

namespace App\Listeners;

use App\Events\OrderCreatedSendAdminEmailEvent;
use App\Mail\AdminOrderMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class SendAdminOrderEmailListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderCreatedSendAdminEmailEvent $event): void
    {
        try {
            Mail::to($event->email)->send(new AdminOrderMail($event->order));
        } catch (\Throwable $e) {
            Log::error('SendAdminOrderEmailListener failed', [
                'order_id' => $event->order->id,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
