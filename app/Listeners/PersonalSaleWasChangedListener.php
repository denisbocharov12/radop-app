<?php

namespace App\Listeners;

use App\Events\PersonalSaleWasChangedEvent;
use App\Mail\PersonalSaleWasChangedMail;
use Illuminate\Support\Facades\Mail;

class PersonalSaleWasChangedListener
{
    public function __construct()
    {
    }

    public function handle(PersonalSaleWasChangedEvent $event): void
    {
        Mail::to($event->user->email)->send(new PersonalSaleWasChangedMail($event->user));
    }
}
