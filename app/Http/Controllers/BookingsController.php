<?php

namespace App\Http\Controllers;

use App\Enums\RentalStatuses;
use App\Enums\StatusCodes;
use App\Events\CancelRental;
use App\Events\NewRental;
use App\Events\NewRentalRequest;
use App\Http\Requests\BookCarRequest;
use App\Http\Requests\CancelBookingRequest;
use App\Models\CurrencyRate;
use App\Models\RentalStatus;
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

    public function getAdminRentals(Request $request)
    {

        $rentals = Rental::query();
        if ($request->has('supplier_id') && $request->supplier_id) {
            $rentals->where('supplier_id', $request->supplier_id);
        }
        if ($request->has('order_status') && $request->order_status) {
            $rentals->where('order_status', $request->order_status);
        }
        if ($request->has('order_number') && $request->order_number) {
            $rentals->where('order_number', $request->order_number);
        }
        if ($request->has('date_range') && $request->date_range) {
            $rentals->whereBetween('created_at' ,[$request->date_range[0],$request->date_range[1]]);
        }
        $data = $rentals->with('vehicle.supplier', 'vehicle.branch', 'status', 'customer')->orderBy('id', 'desc')->get();

        return response()->json([
            'rentals' => $data,
            'rental_statuses' => RentalStatus::query()->get()
        ]);
    }

    public function getRentals(Request $request)
    {

        $user = auth()->user();
        $id = $user->id;
        $role = $user->role;

        $rentals = Rental::query();

        if ($request->has('order_status') && $request->order_status) {
            $rentals->where('order_status', $request->order_status);
        }
        if ($request->has('order_number') && $request->order_number) {
            $rentals->where('order_number', $request->order_number);
        }
        if ($request->has('date_range') && $request->date_range) {
            $rentals->whereBetween('created_at' ,[$request->date_range[0],$request->date_range[1]]);

        }


        if ($role === 'active_supplier') {
            $vehicles = Vehicle::where('supplier', $id)->pluck('id')->unique();
            $data = $rentals->whereIn('vehicle_id', $vehicles)->get();
        }

        $data = $rentals->with('vehicle.supplier', 'vehicle.branch', 'status', 'customer')->orderBy('id', 'desc')->get();

        return response()->json(
           [
               'rentals' => $data,
               'rental_statuses' => RentalStatus::query()->get()
           ]
        );
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

            $vehicle = Vehicle::query()->with('branch')->find($request->id);
            $item = new Rental();
            $item->customer_id = auth()->user()->id;
            $item->supplier_id = $vehicleWithPrice->supplier;

            $item->order_status = $vehicle->instant_confirmation >= 1 ? RentalStatuses::CONFIRMED : RentalStatuses::PENDING;

            $prefix = $vehicle->branch->country ? strtoupper($vehicle->branch->country[0]) . strtoupper($vehicle->branch->country[1]) : null;
            $count = Rental::query()->count();
            $suffix_count= $count;
            if ($count < 1000) {
                $suffix_count = '0'.$suffix_count;
                if ($count < 100)
                    $suffix_count = '0' . $suffix_count;
                    if ($count < 10)
                        $suffix_count = '0'. $suffix_count;
            }
            $item->order_number =  $prefix.'ATR'.$suffix_count;
            $item->vehicle_id = $request->id;
            $item->price = $vehicleWithPrice->final_price;
            $item->profit_margin = $vehicleWithPrice->rate;
            $item->supplier_price = $vehicleWithPrice->supplier_price;
            $item->start_date = Carbon::parse($request->date_from);
            $item->end_date = Carbon::parse($request->date_to);
            $item->start_time = Carbon::parse($request->time_from);
            $item->end_time = Carbon::parse($request->time_to);
            $item->currency = $request->currency;
            $item->number_of_days = $diffInDays;
            if ($request->old_rental_id) {
                Rental::query()->find($request->old_rental_id)->delete();
                $item->old_rental_id = $request->old_rental_id;
            }
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
        $rental->order_status = $request->status;
        $rental->save();
        if ($request->status == RentalStatuses::CONFIRMED) {
            event(new NewRental($rental->id));
        }
        if ($request->status == RentalStatuses::REJECTED) {
            event(new CancelRental($rental->id));
        }
        return "rental updated";
    }

    public function getSupplierInvoices(Request $request)
    {
        $request->company_id;
        $rentals = Rental::query()
            ->where('supplier_id', $request->company_id)
            ->where('order_status', RentalStatuses::CONFIRMED)
            ->orderBy('id', 'desc')
            ->get();
        $totalPriceUSD = 0;

        foreach ($rentals as $rental) {
            $rate = CurrencyRate::query()
                ->where('currency_from', $rental->currency)
                ->where('currency_to', 'USD')
                ->first();
            $totalPriceUSD += ($rental->supplier_price * $rate->rate);
        }
        $invoice = new \stdClass();
        $invoice->total_price = round($totalPriceUSD, 2);
        $invoice->currency = 'USD';
        $invoice->count_rentals = $rentals->count();
        return response()->json(['data' => $invoice]);
    }

    public function reconcile(Request $request)
    {
        try {
            Rental::query()
                ->where('supplier_id', $request->supplier_id)
                ->where('order_status', RentalStatuses::CONFIRMED)
                ->update(['order_status' => RentalStatuses::RECONCILED]);
            return response()->json([
                "status" => true,
                "data" => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], StatusCodes::SERVER_ERROR);
        }
    }

    public function show($id)
    {
        if (!is_numeric($id)  || $id < 0) {
            return response()->json([
                'status' => 0,
                'data' => [],
                'message' => 'id not valid'
            ], StatusCodes::BAD_REQUEST);
        }
        $rental = Rental::query()->where('id', $id)->with('vehicle','vehicle.branch')->first();
        if (is_null($rental)) {
            return response()->json([
                'status' => 0,
                'data' => [],
                'message' => 'id not valid'
            ], StatusCodes::BAD_REQUEST);
        }
        return response()->json([
            'status' => 1,
            'data' => $rental,
            'message' => ''
        ], StatusCodes::SUCCESS);
    }
}
