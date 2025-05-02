<?php

namespace App\Providers;

use App\Events\OrderIsPaid;
use App\Listeners\SendEmailToCustomer;
use App\Listeners\SendMessageToCustomer;
use App\Models\Extra;
use App\Models\Invite;
use App\Models\Magazine;
use App\Models\MagazineOffer;
use App\Models\Order;
use App\Models\Ticket;
use App\Observers\ExtraObserver;
use App\Observers\InviteObserver;
use App\Observers\MagazineOfferObserver;
use App\Observers\OrderObserver;
use App\Observers\TicketObserver;
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
        OrderIsPaid::class => [
            SendMessageToCustomer::class,
            SendEmailToCustomer::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Invite::observe(InviteObserver::class);
        Order::observe(OrderObserver::class);
        MagazineOffer::observe(MagazineOfferObserver::class);
        Extra::observe(ExtraObserver::class);
        Ticket::observe(TicketObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
