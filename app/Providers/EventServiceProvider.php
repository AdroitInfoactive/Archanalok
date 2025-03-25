<?php

namespace App\Providers;

use App\Events\OrderNotificationEvent;
use App\Events\QuantityReduceEvent;
use App\Events\UrlRedirectCreateEvent;
use App\Listeners\OrderNotificationListener;
use App\Listeners\QuantityReduceListener;
use App\Listeners\SaveUrlRedirectListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        UrlRedirectCreateEvent::class => [
            SaveUrlRedirectListener::class,
        ],
        OrderNotificationEvent::class => [
            OrderNotificationListener::class,
        ],
        QuantityReduceEvent::class=> [
            QuantityReduceListener::class,
        ],
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\SyncCartOnLogin::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
