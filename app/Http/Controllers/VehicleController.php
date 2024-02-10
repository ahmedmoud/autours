<?php

namespace App\Http\Controllers;

use App\Enums\StatusCodes;
use App\Http\Requests\CreateEditVehicle;
use App\Models\CurrencyRate;
use App\Models\Included;
use App\Models\SupplierRentalTerm;
use App\Models\VehicleIncluded;
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

    public function filter(Request $request)
    {
        try {

            $location = $request->pickupLoc;
            $date = $request->date;

            $filteredVehicles = Vehicle::query();

            if ($location) {
                $filteredVehicles->whereRelation('branch', 'location', $location);
            }
            $priceTax = 0;


            $currency = $request->currency;
            info("Session get ");

            if ($filteredVehicles == null) {
                return response()->json([
                    'data' => ['message' => 'There is no chosen '],
                    'status' => false
                ]);
            }
            $query = $filteredVehicles->with('category', 'supplier', 'profit', 'included', 'branch');

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

            $maxPrice = 0;
            $minPrice = 10000000;

            $categories = Category::query()
                ->join('vehicles', 'vehicles.category','=','categories.id')
                ->join('branches', 'branches.id','=','vehicles.pickup_loc')
                ->where('branches.location',$location)
                ->select(['categories.id as id', 'categories.name as name','categories.photo as photo'])
                ->distinct('categories.id')->get();


            $suppPluck = $query->pluck('supplier')->unique();
            $suppliers = User::whereIn('id', $suppPluck)->get();

            $vehicles = $query->where('activation', true)->has('profit')->get();

            if ($date && $date !== null) {
                if(is_string($date))
                    $date = explode( ',', $date) ;
                $startDate = Carbon::parse($date[0]);
                $endDate = Carbon::parse($date[1]);
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

                    $vehicle->final_price = round($vehicle->final_price, 2);
                    if ($currency != $vehicle->branch->currency) {
                        $rate = CurrencyRate::query()->where('currency_from', $vehicle->branch->currency)->where('currency_to', $currency)->first();
                        if ($rate != null) {
                            $vehicle->final_price *= $rate->rate;
                            $vehicle->final_price = round($vehicle->final_price, 2);
                        }
                    }
                    if ($vehicle->final_price >= $maxPrice) $maxPrice = round($vehicle->final_price) + 1;
                    if ($vehicle->final_price <= $minPrice) $minPrice = round($vehicle->final_price);

                }
            } else {
                foreach ($vehicles as $vehicle) {
                    $vehicle->final_price = $vehicle->price + (($vehicle->price * $vehicle->profit->per_day_profit) / 100);

                }
            }

            $count = $vehicles->count();

            foreach ($vehicles as $vehicle) {
                $vehicle->rental_terms = SupplierRentalTerm::query()->where('supplier_id', $vehicle->supplier)->join('rental_terms', 'rental_terms.id', '=', 'supplier_rental_terms.rental_term_id')->select(['title', 'description'])->get();
            }
            $vehicles = $vehicles->toArray();
            usort($vehicles, function($a, $b)
            {
                if ($a["final_price"] == $b["final_price"])
                    return (0);
                return (($a["final_price"] < $b["final_price"]) ? -1 : 1);
            });
            if ($minPrice >= $maxPrice) $minPrice = 0;

            return  [
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
        } catch (\Exception $e) {
            return response()->json([
                'data' => ['message' => $e->getMessage()],
                'status' => false
            ], StatusCodes::SERVER_ERROR);
        }
    }

    public function search(Request $request)
    {
        $location = $request->pickupLoc;
        $date = $request->date;

        $vehicles = Vehicle::query();

        if ($location) {
            $vehicles->whereRelation('branch', 'location', $location);
        }

//         if ($date && $date !== null) {
//             $startDate = $date[0];
//             $endDate = $date[1];
//
//             $rented = Rental::query()
//             ->where('end_date', '>', $endDate)
//             ->orWhere('end_date', '>', $startDate);
//
//             $exclude = $rented->pluck('vehicle_id')->unique();
//
//             $vehicles->whereNotIn('id', $exclude);
//
//         }

//         $vehicles = $vehicles->where(function ($query) use ($startDate, $endDate) {
//             $query->where('start_date', '<=', $startDate)
//                   ->where('end_date', '>=', $endDate);
//         });

        $results = $vehicles->with(['category', 'supplier'])->get();


        Session::put([
            'filteredVehicles' => $results,
            'location' => $location,
            'date' => $date,
            'currency' => $request->currency
        ]);

        return redirect()->intended('results');
    }

    public function create(CreateEditVehicle $request)
    {
        if ($request->update === '1') {

            $existingVehicle = Vehicle::find($request->id);
            $item = $existingVehicle;
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
                $existingVehicle->pickup_loc = Branch::query()->where('name', $request->pickupLoc)->first()->id;
            }

            if ($request->has('category')) {
                $existingVehicle->category = Category::query()->where('name', $request->category)->first()->id;
            }

            if ($request->has('specifications')) {
                $existingVehicle->specifications = json_decode($request->specifications);
            }

            $existingVehicle->save();
            if ($request->has('included')) {
                $included = explode(',', $request->included);
                VehicleIncluded::query()->where('vehicle_id', $request->id)->delete();
                foreach ($included as $include) {
                    $includeId = Included::query()->where('what_is_included', $include)->first()->id;
                    VehicleIncluded::insert(['vehicle_id' => $request->id, 'included_id' => $includeId]);
                }
            }

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
            if ($request->has('included')) {
                $included = explode(',', $request->included);
                foreach ($included as $include) {
                    VehicleIncluded::insert(['vehicle_id' => $item->id, 'included_id' => $include]);
                }
            }
        }

        return response()->json([
            'data' => $item,
            'status' => true
        ]);
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
            $vehicle->activation = $vehicle->activation == 1 ? true : false;

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
        try {
            if (!$request->has('id')|| !is_int((int)$request->id)) {
                throw new \Exception('The id is invalid');
            }
            $location = $request->location;
            $date = $request->date;
            $currency = $request->currency;
            $selectedVehicle = Vehicle::where('id', $request->id)->with('category', 'supplier', 'branch', 'included')->first();

            if($date == null) {
                return response()->json([
                    'message' => 'please select date range',
                    'status' => false
                ], StatusCodes::SERVER_ERROR);
            }
            $startDate = Carbon::parse($date[0]);
            $endDate = Carbon::parse($date[1]);
            $diffInDays = $startDate->diffInDays($endDate);

            if ($diffInDays >= '1' && $diffInDays < '3') {
                $selectedVehicle->final_price = ($selectedVehicle->price + (($selectedVehicle->price * $selectedVehicle->profit->per_day_profit) / 100)) * $diffInDays;
            } else if ($diffInDays >= '3' && $diffInDays < '7') {
                $selectedVehicle->final_price = ($selectedVehicle->week_price + (($selectedVehicle->week_price * $selectedVehicle->profit->per_week_profit) / 100)) * $diffInDays;
            } else if ($diffInDays >= '8' && $diffInDays < '30') {
                $selectedVehicle->final_price = ($selectedVehicle->month_price + (($selectedVehicle->month_price * $selectedVehicle->profit->per_month_profit) / 100)) * $diffInDays;
            }


            if ($currency != $selectedVehicle->branch->currency) {
                $rate = CurrencyRate::query()->where('currency_from', $selectedVehicle->branch->currency)->where('currency_to', $currency)->first();
                if ($rate != null) {
                    $selectedVehicle->final_price *= $rate->rate;
                }
            }
            $selectedVehicle->final_price = round($selectedVehicle->final_price, 2);
            $selectedVehicle->rental_terms = SupplierRentalTerm::query()->where('supplier_id', $selectedVehicle->supplier)->join('rental_terms', 'rental_terms.id', '=', 'supplier_rental_terms.rental_term_id')->select(['title', 'description'])->get();

            return response()->json([
                'data' => [
                    'vehicle' => $selectedVehicle,
                    'date' => $date,
                    'days' => $diffInDays,
                    'currency' => $currency,
                    'location' => $location
                ],
                'status' => true
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'status' => false
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
        if (!is_numeric($id) || !is_int((int)$id)) {
            return response()->json([
                'data' => ['message' => 'id is not valid id'],
                'status' => false
            ], StatusCodes::SERVER_ERROR);
        }
        $vehicle = Vehicle::query()->with(['branch', 'category', 'included'])->find($id);
        $vehicle->what_is_included = $vehicle->included->pluck('what_is_included');
        return response()->json([
            'data' => $vehicle,
            'status' => true
        ]);

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
        return $this->show($request->id);
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
