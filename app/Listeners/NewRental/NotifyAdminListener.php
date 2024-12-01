<?php

namespace App\Listeners\NewRental;

use App\Mail\NewRental\NewBookingAdmin;
use App\Models\Branch;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminListener implements ShouldQueue
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
    public function handle(object $event): void
    {
        $user = User::query()->where('role','admin')->first();
        $event->rental->vehicle = $event->rental->vehicle;
        $event->rental->vehicle->category = Category::query()->find($event->rental->vehicle->category_id);
        $event->rental->branch = Branch::query()->where('id', $event->rental->vehicle->pickup_loc)->first();
        $event->rental->supplier = User::query()->where('id', $event->rental->vehicle->supplier)->first();
        $event->rental->customer = User::query()->where('id', $event->rental->customer_id)->first();
        $event->rental->branch = Branch::query()->where('id', $event->rental->vehicle->pickup_loc)->first();
        $body = $event->rental;
        $status = Mail::to("admin@autours.net")->send(new NewBookingAdmin($body));
    }
}
