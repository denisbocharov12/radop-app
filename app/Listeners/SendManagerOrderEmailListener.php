<?php

namespace App\Listeners;

use App\Events\OrderCreatedSendManagerEmailEvent;
use App\Mail\OrderCreatedManagerMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class SendManagerOrderEmailListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderCreatedSendManagerEmailEvent $event): void
    {
        try {
            Mail::to($event->user->email)->send(new OrderCreatedManagerMail());
        } catch (\Throwable $e) {
            Log::error('SendManagerOrderEmailListener failed', [
                'user_id' => $event->user->id,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
