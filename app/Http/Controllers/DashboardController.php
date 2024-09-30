<?php

namespace App\Http\Controllers;

use App\Enums\RentalStatuses;
use App\Enums\StatusCodes;
use App\Models\Rental;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {

    }

    public function index()
    {
        try {
            $charts = new StdClass();
            $supplierRevenue = DB::select('SELECT SUM(price - supplier_price) as profit,
                                                supplier_id,
                                                users.name as supplier_name
                                            FROM rentals
                                            JOIN users on users.id = rentals.supplier_id
                                            WHERE order_status IN (:confirmed, :reconciled)
                                            GROUP BY rentals.supplier_id,users.name
                                            ORDER BY supplier_id desc
                                             ',
                ['confirmed'=> RentalStatuses::CONFIRMED, 'reconciled'=> RentalStatuses::RECONCILED]);

            $NumberOfActiveSuppliers = new StdClass();
            $NumberOfActiveSuppliers->currentYear = DB::select('SELECT EXTRACT(YEAR FROM created_at) as year,COUNT(*) as count FROM users
                                                                    WHERE role = :role
                                                                    AND EXTRACT(YEAR FROM created_at) = :year
                                                                    GROUP BY EXTRACT(YEAR FROM created_at)
                                                   ',
                ['role'=> 'active_supplier', 'year'=> Carbon::now()->year]);


            $NumberOfActiveSuppliers->monthly = DB::select('SELECT EXTRACT(MONTH FROM created_at) as month,COUNT(*) as count FROM users
                                                  WHERE role = :role
                                                   GROUP BY EXTRACT(MONTH FROM created_at)',
                                                 ['role'=> 'active_supplier']);
            $numberOfRentalsMonthly = new StdClass();
            $numberOfRentalsMonthly->cancelled = DB::select('SELECT COUNT(*) as count, EXTRACT(MONTH FROM created_at) AS month FROM rentals
                                                                    WHERE order_status = :cancelled
                                                                    GROUP BY EXTRACT(MONTH FROM created_at)',
                ['cancelled'=> RentalStatuses::CANCELED]);
            $numberOfRentalsMonthly->done = DB::select('SELECT COUNT(*) as count, EXTRACT(MONTH FROM created_at) AS month FROM rentals
                                                                    WHERE order_status <> :cancelled
                                                                    GROUP BY EXTRACT(MONTH FROM created_at)',
                ['cancelled'=> RentalStatuses::CANCELED]);
            $charts->supplierRevenue = $supplierRevenue;
            $charts->NumberOfActiveSuppliers = $NumberOfActiveSuppliers;
            $charts->numberOfRentalsMonthly = $numberOfRentalsMonthly;
            $charts->latestRentalsTransactions = Rental::query()->orderBy('updated_at', 'desc')->limit(5)->get();
            $charts->latestVehicles = Vehicle::query()->orderBy('created_at', 'desc')->limit(4)->get();
            return response()->json([
                "status" => true,
                "data" => $charts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ], StatusCodes::SERVER_ERROR);
        }
    }
}
