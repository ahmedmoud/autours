<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Specification;
use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\VehiclesPhotos;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function filter(Request $request)
    {

        $filteredVehicles = Session::get('filteredVehicles');
        $location = Session::get('location');
        $date = Session::get('date');

        $query = Vehicle::query()->whereIn('id', $filteredVehicles->pluck('id'))->with('category', 'supplier', 'profit');


        if ($request->priceRange && $request->priceRange !== 0) {
            $query->where('price', '<=', ($request->priceRange));
        }
        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->supplier) {
            $query->where('supplier', $request->supplier);
        }
        if ($request->specification) {
            $specifications = explode(',', $request->specification);

            foreach ($specifications as $specification) {
                if ($specification) {
                    $query->whereJsonContains('specifications', [
                        ['option' => $specification]
                    ]);
                }
            }
        }

        $prices = $query->pluck('price')->filter();
        $maxPrice = 0;
        $minPrice = 10000000;

        $catPluck = $query->pluck('category')->unique();
        $categories = Category::whereIn('id', $catPluck)->get();

        $suppPluck = $query->pluck('supplier')->unique();
        $suppliers = User::whereIn('id', $suppPluck)->get();

        $vehicles = $query->where('activation', true)->has('profit')->get();

        if ($date && $date !== null) {
            $startDate = Carbon::parse($date[0]);
            $endDate = Carbon::parse($date[1]);
            $priceTax = 0;
            $diffInDays = $startDate->diffInDays($endDate);
            foreach ($vehicles as $vehicle) {

                if ($diffInDays >= '1' && $diffInDays < '3') {
                    $vehicle->final_price = ($vehicle->price + (($vehicle->price * $vehicle->profit->per_day_profit) / 100)) * $diffInDays;
                    $priceTax = $vehicle->profit->per_day_profit;
                } else if ($diffInDays >= '3' && $diffInDays < '7') {
                    $vehicle->final_price = ($vehicle->week_price + (($vehicle->week_price * $vehicle->profit->per_week_profit) / 100)) * $diffInDays;
                    $priceTax = $vehicle->profit->per_week_profit;
                } else if ($diffInDays >= '8' && $diffInDays < '30') {
                    $vehicle->final_price = ($vehicle->month_price + (($vehicle->month_price * $vehicle->profit->per_month_profit) / 100)) * $diffInDays;
                    $priceTax = $vehicle->profit->per_month_profit;
                }
                if($vehicle->final_price >= $maxPrice) $maxPrice = round($vehicle->final_price) + 1;
                if($vehicle->final_price <= $minPrice) $minPrice = round($vehicle->final_price);
                $vehicle->final_price = round($vehicle->final_price, 2);

            }
        } else {
            foreach ($vehicles as $vehicle) {
                $vehicle->final_price = $vehicle->price + (($vehicle->price * $vehicle->profit->per_day_profit) / 100);
            }
        }

        $count = $vehicles->count();
        if($minPrice == $maxPrice) $minPrice = 0;

        return $data = [
            'location' => $location,
            'date' => $date,
            'filteredVehicles' => $vehicles,
            'filteredCategories' => $categories,
            'filteredSuppliers' => $suppliers,
            'count' => $count,
            'max' => $maxPrice,
            'min' => $minPrice,
            'priceTax' => $priceTax,
            'daysNumber' => $diffInDays
        ];
    }

    public function index()
    {
        return Inertia::render('ResultsPage');
    }

    public function book(Request $request): RedirectResponse
    {
        $location = $request->pickupLoc;
        $date = $request->date;
        $user = auth()->user()->id;
        $vehicle = $request->vehicle;
        $price = $request->price;

        $item = new Rental();

        $item->customer_id = $user;
        $item->order_status = '0';
        $item->order_number = 'ATRS#' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        $item->vehicle_id = $vehicle;
        $item->price = $price;
        $item->start_date = Carbon::parse($date[0]);
        $item->end_date = Carbon::parse($date[1]);

        $item->save();

        return redirect()->intended('/');
    }

    public function search(Request $request): RedirectResponse
    {
        $location = $request->pickupLoc;
        $date = $request->date;

        $vehicles = Vehicle::query();

        if ($location) {
            $vehicles->whereRelation('branch', 'location', $location);
        }

        // if ($date && $date !== null) {
        //     $startDate = $date[0];
        //     $endDate = $date[1];

        //     $rented = Rental::query()
        //     ->where('end_date', '>', $endDate)
        //     ->orWhere('end_date', '>', $startDate);

        //     $exclude = $rented->pluck('vehicle_id')->unique();

        //     $vehicles->whereNotIn('id', $exclude);

        // }

        // $vehicles = $vehicles->where(function ($query) use ($startDate, $endDate) {
        //     $query->where('start_date', '<=', $startDate)
        //           ->where('end_date', '>=', $endDate);
        // });

        $results = $vehicles->with('category', 'supplier')->get();

        Session::put([
            'filteredVehicles' => $results,
            'location' => $location,
            'date' => $date
        ]);

        return redirect()->intended('results');
    }

    public function create(Request $request)
    {
        if ($request->update === '1') {

            $existingVehicle = Vehicle::find($request->id);

            if (!$existingVehicle) {
                return response()->json(['error' => 'Vehicle not found'], 404);
            }

            if ($request->has('photo')) {
                $existingVehicle->photo = $request->photo;
            }

            if ($request->has('name')) {
                $existingVehicle->name = $request->name;
            }

            if ($request->has('description')) {
                $existingVehicle->description = $request->description;
            }

            if ($request->has('price')) {
                $existingVehicle->price = $request->price;
            }

            if ($request->has('week_price')) {
                $existingVehicle->week_price = $request->week_price;
            }

            if ($request->has('month_price')) {
                $existingVehicle->month_price = $request->month_price;
            }



            if ($request->has('pickupLoc')) {
                $existingVehicle->pickup_loc = $request->pickupLoc;
            }

            if ($request->has('category')) {
                $existingVehicle->category = $request->category;
            }

            if ($request->has('specifications')) {
                $existingVehicle->specifications = json_decode($request->specifications);
            }
            $existingVehicle->save();

        } else {

            $item = new Vehicle();

            if ($request->has('photo')) {
                $item->photo = $request->photo;
            }

            if ($request->has('name')) {
                $item->name = $request->name;
            }

            if ($request->has('description')) {
                $item->description = $request->description;
            }

            $item->supplier = auth()->user()->id;

            if ($request->has('price')) {
                $item->price = $request->price;
            }

            if ($request->has('week_price')) {
                $item->week_price = $request->week_price;
            }

            if ($request->has('month_price')) {
                $item->month_price = $request->month_price;
            }


            if ($request->has('pickupLoc')) {
                $item->pickup_loc = $request->pickupLoc;
            }

            if ($request->has('category')) {
                $item->category = $request->category;
            }

            if ($request->has('specifications')) {
                $item->specifications = json_decode($request->specifications);
            }

            $item->save();

        }

        return response(1);
    }

    public function createSpecifications(Request $request)
    {
        $item = new Specification();

        if ($request->has('name')) {
            $item->name = $request->name;
        }
        if ($request->has('icon')) {
            $item->icon = $request->icon;
        }
        if ($request->has('options')) {
            $item->options = json_decode($request->options);
        }

        $item->save();

        return response()->json(['message' => 'Added successfully']);
    }

    public function getSpecifications()
    {

        return response()->json(Specification::all());

    }

    public function createCategories(Request $request)
    {
        $item = new Category();

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image_name = $request->file('photo')->getClientOriginalName() . "_" . "_category" . "." . $request->file('photo')->extension();
            $image->move(public_path('img/categories'), $image_name);

            $item->photo = $image_name;
        }

        if ($request->has('name')) {
            $item->name = $request->name;
        }

        $item->save();

        return response()->json(['message' => 'Added successfully']);
    }

    public function getCategories()
    {

        return response()->json(Category::all());

    }

    public function deleteCategories(Request $request)
    {
        Category::where('id', $request->id)->delete();

        return $this->getCategories();

    }

    public function deleteSpecifications(Request $request)
    {
        Specification::where('id', $request->id)->delete();

        return $this->getSpecifications();

    }

    public function getLocations()
    {
        $locations = Branch::pluck('location')->unique();
        return response()->json($locations);

    }

    public function show(Request $request)
    {
        $vehicles = Vehicle::query();

        $user = auth()->user();
        $branchId = null;
        if ($request->has('branch_id')) {
            $branchId = $request->branch_id;
        }
        if ($user) {
            $id = $user->id;
            $role = $user->role;
            $rentals = Rental::all();


            if ($role === 'active_supplier') {
                $vehicles->where('supplier', $id);
            }
        }

        if ($branchId != null) {
            $vehicles->where('pickup_loc', $branchId);
        }
        $data = $vehicles->with('category', 'supplier', 'branch')->orderBy('id')->get();
        foreach ($data as $vehicle) {
            $vehicle->activation =$vehicle->activation == 1 ? true : false;

        }
        $data->each(function ($vehicle) {
            $vehicle->load(['rentals' => function ($query) {
                $query->where('order_status', 1);
            }]);
            $vehicle->setAttribute('rentals_count', $vehicle->rentals->count());
        });

        return response()->json($data);

    }

    public function getVehicle(Request $request)
    {
        return Vehicle::where('id', $request->id)->with('category', 'supplier', 'branch')->first();
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

        $data = $rentals->with('vehicle')->get();

        return response()->json($data);
    }

    public function acceptRentals(Request $request)
    {
        Rental::where('id', $request->id)->update(['order_status' => '1']);
        return $this->getRentals();
    }

    public function deleteRentals(Request $request)
    {
        $rental = Rental::find($request->id);

        if ($rental) {
            if ($rental->order_status === 0) {
                $rental->delete();
            } else {
                $rental->update(['order_status' => '0']);
            }
        }

        return $this->getRentals();
    }

    public function createPhotos(Request $request)
    {
        $item = new VehiclesPhotos();

        if ($request->has('name')) {
            $item->name = $request->name;
        }

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image_name = preg_replace('/\.jpg/', '', str_replace(' ', '_', $request->file('photo')->getClientOriginalName())) . "_" . $request->name . "_vehicle_photo" . "." . $request->file('photo')->extension();
            $image->move(public_path('img/vehicles'), $image_name);

            $item->photo = $image_name;
        }

        $item->save();

        return response(1);
    }

    public function getPhotos()
    {

        return response()->json(VehiclesPhotos::all());

    }

    public function deletePhotos(Request $request)
    {
        $photo = VehiclesPhotos::findOrFail($request->id);
        $photoPath = public_path('img\vehicles\\' . $photo->photo);
        File::delete($photoPath);
        $photo->delete();
        return $this->getPhotos();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Vehicle::where('id', $request->id)->delete();
        return $this->show();
    }

    public function store(Request $request)
    {
        //
    }

    public function updateActivation(Request $request)
    {
        Vehicle::query()->find($request->vehicle_id)->update(['activation' => $request->activation]);
    }
}
