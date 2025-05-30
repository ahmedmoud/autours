<?php

namespace App\Listeners\NewRental;

use App\Events\NewRental;
use App\Mail\NewRental\NewBookingCustomer;
use App\Models\Branch;
use App\Models\Included;
use App\Models\LocationType;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleIncluded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyCustomerListener implements ShouldQueue
{
    /*
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(NewRental $event): void
    {
        $user = User::query()->find($event->rental->customer_id);
        $event->rental->location_type = Vehicle::query()->where('id', $event->rental->vehicle->id)->with('locationType')->first();
        $event->rental->vehicle = $event->rental->vehicle;
        $event->rental->paymentMethod = PaymentMethod::query()->find($event->rental->payment_method_id);
        $event->rental->branch = Branch::query()->where('id', $event->rental->vehicle->pickup_loc)->first();
        $event->rental->supplier = User::query()->where('id', $event->rental->vehicle->supplier)->first();
        $event->rental->customer = User::query()->where('id', $event->rental->customer_id)->first();
        $event->rental->fuelPolicy = Vehicle::query()->where('id', $event->rental->vehicle->id)->with('fuelPolicy')->first();
        $event->rental->cancelationPolicy = Included::query()->whereIn('id', VehicleIncluded::query()->where('vehicle_id', $event->rental->vehicle->id)->get()->pluck('id')->toArray())->get();

        $body = $event->rental;

        $status = Mail::to($user->email)->send(new NewBookingCustomer($body));
    }
}
