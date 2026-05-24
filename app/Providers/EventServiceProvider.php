<?php

namespace App\Providers;

use App\Events\OrderCreatedSendAdminEmailEvent;
use App\Events\OrderCreatedSendEmailEvent;
use App\Events\OrderCreatedSendManagerEmailEvent;
use App\Events\OrderStatusUpdatedSendEmailEvent;
use App\Events\PasswordChangedEmailEvent;
use App\Events\PasswordResetEmailEvent;
use App\Events\PersonalSaleWasChangedEvent;
use App\Events\UserActivationSendEmailEvent;
use App\Listeners\PasswordChangedEmailListener;
use App\Listeners\PasswordResetEmailListener;
use App\Listeners\PersonalSaleWasChangedListener;
use App\Listeners\SendAdminOrderEmailListener;
use App\Listeners\SendManagerOrderEmailListener;
use App\Listeners\SendOrderStatusUpdatedEmailEventListener;
use App\Listeners\SendUserActivationEmailListener;
use App\Listeners\SendUserOrderEmailListener;
use App\Models\Banner;
use App\Models\BannerSetting;
use App\Observers\BannerObserver;
use App\Observers\BannerSettingObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserActivationSendEmailEvent::class => [
            SendUserActivationEmailListener::class
        ],

        OrderCreatedSendEmailEvent::class => [
            SendUserOrderEmailListener::class
        ],

        OrderCreatedSendManagerEmailEvent::class => [
            SendManagerOrderEmailListener::class
        ],

        OrderCreatedSendAdminEmailEvent::class => [
            SendAdminOrderEmailListener::class
        ],

        PasswordResetEmailEvent::class => [
            PasswordResetEmailListener::class
        ],

        PasswordChangedEmailEvent::class => [
            PasswordChangedEmailListener::class
        ],

        PersonalSaleWasChangedEvent::class => [
            PersonalSaleWasChangedListener::class
        ],

        OrderStatusUpdatedSendEmailEvent::class => [
            SendOrderStatusUpdatedEmailEventListener::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Banner::observe(BannerObserver::class);
        BannerSetting::observe(BannerSettingObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
