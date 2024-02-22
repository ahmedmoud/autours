<?php

namespace App\Listeners;

use App\Events\CancelRental;
use App\Mail\CancelBookingAdmin;
use App\Mail\CancelBookingCustomer;
use App\Mail\NewBookingAdmin;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class CancelRentalAdminListener
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
        $user = User::query()->where('role','admin')->first();
        $event->rental->vehicle = $event->rental->vehicle;
        $event->rental->branch = Branch::query()->where('id', $event->rental->vehicle->pickLoc)->first();
        $event->rental->supplier = User::query()->where('id', $event->rental->vehicle->supplier)->first();
        $event->rental->customer = User::query()->where('id', $event->rental->customer_id)->first();

        $body = $event->rental;
        $status = Mail::to($user->email)->send(new CancelBookingAdmin($body));
    }
}
