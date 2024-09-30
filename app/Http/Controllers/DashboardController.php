<?php

namespace App\Http\Controllers;

use App\Enums\RentalStatuses;
use App\Enums\StatusCodes;
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

            $charts->supplierRevenue = $supplierRevenue;
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
