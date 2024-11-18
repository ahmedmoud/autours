<?php

namespace App\Providers;

use App\Events\CancelRental;
use App\Events\NewRental;
use App\Events\NewRentalRequest;
use App\Events\NewSupplier;
use App\Events\SendEmailEvent;
use App\Events\UpdateRental;
use App\Listeners\CancelRental\CancelRentalAdminListener;
use App\Listeners\CancelRental\CancelRentalCustomerListener;
use App\Listeners\CancelRental\CancelRentalSupplierListener;
use App\Listeners\NewRental\NewSupplierToAdmin;
use App\Listeners\NewRental\NotifySupplierListener;
use App\Listeners\RentalRequest\RentalRequestNotifySupplierListener;
use App\Listeners\SendEmail;
use App\Listeners\UpdateRental\UpdateRentalNotifyAdminListener;
use App\Listeners\UpdateRental\UpdateRentalNotifyCustomerListener;
use App\Listeners\UpdateRental\UpdateRentalNotifySupplierListener;
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
        NewRental::class => [
            NotifySupplierListener::class,
            NotifySupplierListener::class,
            NewSupplierToAdmin::class
        ],
        CancelRental::class => [
            CancelRentalCustomerListener::class,
            CancelRentalSupplierListener::class,
            CancelRentalAdminListener::class,
        ],
        NewRentalRequest::class => [
            RentalRequestNotifySupplierListener::class
        ],
        UpdateRental::class => [
            UpdateRentalNotifyCustomerListener::class,
            UpdateRentalNotifySupplierListener::class,
            UpdateRentalNotifyAdminListener::class

        ],
        SendEmailEvent::class => [
            SendEmail::class,
        ],
        NewSupplier::class => [
            SendEmail::class,
        ]
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
