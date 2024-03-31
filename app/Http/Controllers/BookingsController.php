<?php

namespace App\Http\Controllers;

use App\Enums\RentalStatuses;
use App\Enums\StatusCodes;
use App\Events\CancelRental;
use App\Events\NewRental;
use App\Events\NewRentalRequest;
use App\Http\Requests\BookCarRequest;
use App\Http\Requests\CancelBookingRequest;
use App\Services\VehicleService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Specification;
use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\VehiclesPhotos;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function index(Request $request)
    {
        $rentals = Rental::query()
            ->where('customer_id', \auth()->user()->id)
            ->with(['customer', 'vehicle'])
            ->get();
        return $rentals;

    }

    public function cancelBooking(CancelBookingRequest $request)
    {
        try {
            $rental = Rental::query()->find($request->id);
            $today = Carbon::today();
            if ($rental->order_status == RentalStatuses::CANCELED) {
                return response()->json([
                    'data' => [],
                    'message' => "Rental Already Cancelled."
                ], StatusCodes::FORBIDDEN);
            }
            if ($today->isAfter(new Carbon($rental->start_date))) {
                return response()->json([
                    'data' => [],
                    'message' => "it's not allowed to change this booking."
                ], StatusCodes::FORBIDDEN);
            }
            $rental->start_date = new Carbon($rental->start_date);

            if ($rental->start_date->diffInDays($today) <= 2 && !$rental->fareApproval) {
                return response()->json([
                    'data' => [],
                    'message' => "There will be a fare to cancel"
                ], StatusCodes::FORBIDDEN);
            }
            $rental->update(['order_status' => RentalStatuses::CANCELED]);

            event(new CancelRental($rental->id));

            return response()->json([
                'data' => [],
                'message' => "Order has benn canceled"
            ], StatusCodes::SUCCESS);

        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], StatusCodes::SERVER_ERROR);
        }
    }

    public function getRentals()
    {
        $user = auth()->user();
        $id = $user->id;
        $role = $user->role;

        $rentals = Rental::query();

        if ($role === 'customer') {
            $rentals->where('customer_id', $id);
        }

        if ($role === 'active_supplier') {
            $vehicles = Vehicle::where('supplier', $id)->pluck('id')->unique();
            $data = $rentals->whereIn('vehicle_id', $vehicles)->get();
        }

        $data = $rentals->with('vehicle.supplier', 'vehicle.branch', 'status', 'customer')->orderBy('id', 'desc')->get();

        return response()->json($data);
    }

    public function book(BookCarRequest $request)
    {
        try {
            $startDate = Carbon::parse($request->date_from);
            $endDate = Carbon::parse($request->date_to);
            $diffInDays = $startDate->diffInDays($endDate);

            DB::beginTransaction();
            $vehicleWithPrice = $this->vehicleService->calculatePrice($request->currency, $request->id, $diffInDays);
//            if($vehicleWithPrice->stock <= 0 ) {
//                throw new \Exception("Sorry There is no enough stock to book this car!");
//            }
            $vehicle = Vehicle::query()->find($request->id);
            $item = new Rental();
            $item->customer_id = auth()->user()->id;
            $item->order_status = $vehicle->instant_confirmation >= 1 ? RentalStatuses::CONFIRMED : RentalStatuses::PENDING;
            $item->order_number = '#ATRS-' . Rental::query()->count();
            $item->vehicle_id = $request->id;
            $item->price = $vehicleWithPrice->final_price;
            $item->start_date = Carbon::parse($request->date_from);
            $item->end_date = Carbon::parse($request->date_to);
            $item->start_time = Carbon::parse($request->time_from);
            $item->end_time = Carbon::parse($request->time_to);
            $item->currency = $request->currency;
            $item->number_of_days = $diffInDays;

            $item->save();

            DB::commit();

            if ($vehicle->instant_confirmation)
                event(new NewRental($item->id));
            else
                event(new NewRentalRequest($item->id));

            return response()->json([
                'data' => $item,
                'status' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                ],
                'message' => $e->getMessage(),
                'status' => false
            ], StatusCodes::SERVER_ERROR);
        }
    }

    public function updateBookingStatus(Request $request)
    {
        $rental_request = json_decode(base64_decode($request->get("request")));

        $rental = Rental::query()->find($rental_request->rental_id);
        $rental->order_status= $request->status;
        $rental->save();
        if($request->status == RentalStatuses::CONFIRMED) {
            event(new NewRental($rental->id));
        }
        if($request->status == RentalStatuses::REJECTED) {
            event(new CancelRental($rental->id));
        }
        return "rental updated";
    }
}
