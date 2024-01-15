<?php

namespace App\Http\Controllers;

use App\Models\Profit;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;

class ProfitsController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $supplierIds = null;
            $branchIds = null;
            $vehicles = null;
            if ($request->has('country')) {
                $branchIds = Branch::query()->select(['id'])->where('country', $request->country)->get()->pluck('id')->toArray();
                $vehicles = Vehicle::query()->whereIn('pickup_loc', $branchIds)->get();
            }
            if ($request->has('supplier')) {
                $supplierIds = User::query()->select(['id'])->where('id', $request->supplier)->get()->pluck('id')->toArray();
                $vehicles = Vehicle::query()->whereIn('supplier', $supplierIds)->get();

            }
            if ($request->has('branch')) {
                $branchIds = Branch::query()->select(['id'])->where('id', $request->branch)->first();
                $vehicles = Vehicle::query()->whereIn('pickup_loc', $branchIds)->get();

            }
            if ($request->has('selectedVehicles')) {
                $vehicles = Vehicle::query()->whereIn('id', explode(',',$request->selectedVehicles ))->get();
            }
            foreach ($vehicles as $vehicle) {
                Profit::query()->where('vehicle_id', $vehicle->id)->delete();
                $profit = new Profit();
                $profit->supplier_id = $vehicle->supplier;
                $profit->vehicle_id = $vehicle->id;
                $profit->branch_id = $vehicle->pickup_loc;
                $profit->per_day_profit = $request->priceTax;
                $profit->per_week_profit = $request->weekPriceTax;
                $profit->per_month_profit = $request->monthPriceTax;
                $profit->weekend_profit = $request->weekendPriceTax;
                $profit->save();
            }
            return response()->json([
                'data' => [],
                'message' => 'profit updated'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $query = Profit::query();
            if ($request->has('country')) {
                $supplierIds = User::query()->select(['id'])->where('country', $request->country)->get()->pluck('id')->toArray();
                $query->whereIn('supplier_id', $supplierIds);
            }
            if ($request->has('supplier')) {
                $query->where('supplier_id', $request->supplier);
            }
            if ($request->has('branch')) {
                $query->where('branch_id', $request->branch);
            }
            if ($request->has('selectedVehicles')) {
                $query->whereIn('vehicle_id', explode(',',$request->selectedVehicles));
            }
            $query->
              rightJoin('vehicles', 'profits.vehicle_id', '=','vehicles.id' )
            ->leftJoin('branches', 'branches.id', '=', 'profits.branch_id');
            $data = $query->select([
                'vehicles.id as vehicle_id',
                'profits.per_day_profit',
                'profits.per_week_profit',
                'profits.per_month_profit',
                'profits.weekend_profit',
                'vehicles.photo',
                'vehicles.name as vehicle_name',
                'branches.name as branch_name',
                'branches.country as branch_country',

            ])->get();
            return response()->json([
                'data' => $data,
                'message' => 'profits returned successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'message' => 'there is an error'
            ], 200);
        }
    }

}
