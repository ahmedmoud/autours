<?php

namespace App\Listeners\CancelRental;

use App\Events\CancelRental;
use App\Mail\CancelRental\NewSupplierEmailToSupplier;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class CancelRentalSupplierListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CancelRental $event): void
    {
        $user = User::query()->find($event->rental->vehicle->supplier);
        $event->rental->vehicle = $event->rental->vehicle;
        $event->rental->branch = Branch::query()->where('id', $event->rental->vehicle->pickup_Loc)->first();
        $event->rental->supplier = User::query()->where('id', $event->rental->vehicle->supplier)->first();
        $event->rental->customer = User::query()->where('id', $event->rental->customer_id)->first();

        $body = $event->rental;
        $status = Mail::to($user->email)->send(new NewSupplierEmailToSupplier($body));
    }
}
