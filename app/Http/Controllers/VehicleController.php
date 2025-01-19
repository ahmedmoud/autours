<?php

namespace App\Http\Controllers;

use App\Enums\StatusCodes;
use App\Events\NewRental;
use App\Http\Requests\BookCarRequest;
use App\Http\Requests\CreateEditVehicle;
use App\Http\Requests\EditVehiclePrice;
use App\Http\Requests\FilterVehicleRequest;
use App\Http\Requests\GetVehiclePageRequest;
use App\Models\CurrencyRate;
use App\Models\Included;
use App\Models\LocationTypeVehicle;
use App\Models\SupplierRentalTerm;
use App\Models\VehicleIncluded;
use App\Models\VehicleSpecification;
use App\Services\VehicleService;
use Illuminate\Database\Query\Builder;
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
use stdClass;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public VehicleService $vehicleService;


    public function index()
    {
        return Inertia::render('ResultsPage');
    }


    public function filter(FilterVehicleRequest $request)
    {
        try {

            $location = $request->pickupLoc;
            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;

            $timeFrom = $request->time_from;
            $timeTo = $request->time_to;


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
            $query = $filteredVehicles->with('category', 'fuelPolicy', 'supplier.rentals.rentalRates', 'profit', 'included', 'branch', 'locationType', 'specifications');

            if ($request->priceRange && $request->priceRange !== 0) {
                $query->where('price', '<=', ($request->priceRange));
            }
            if ($request->category) {
                $query->whereIn('category', $request->category);
            }
            if ($request->supplier) {

                $query->whereIn('supplier', $request->supplier);
            }
            if ($request->location_type_id) {

                $query->whereHas('locationType', function (\Illuminate\Database\Eloquent\Builder $query) use ($request) {
                    $query->whereIn('location_type_id', $request->location_type_id);
                });
            }

            if ($request->specifications) {
                $specifications = $request->specifications;
                foreach ($specifications as $specification) {
                    if ($specification && isset($specification['option']) && is_array($specification['option']) && count($specification['option']) > 0) {
                        $query->whereRelation('specifications', 'name', $specification['name'])
                            ->whereRelation('specifications', 'value', $specification['option']);
                    }
                }
            }

            $maxPrice = 0;
            $minPrice = 10000000;


            $locationTypes = LocationTypeVehicle::query()
                ->join('vehicles', 'vehicles.id', '=', 'location_type_vehicle.vehicle_id')
                ->join('location_types', 'location_types.id', '=', 'location_type_vehicle.location_type_id')
                ->select(['location_types.id as id', 'location_types.name as name'])
                ->distinct('location_types.id')->get();


            $branches = Branch::query()->where('location', $location)->get();
            $suppliers = User::query()->whereIn('id', $branches->pluck('company_id'))->get();

            $vehicles = $query->where('activation', true)->has('profit')->get();
            foreach ($locationTypes as $locationType) {
                $locationType->vehicle_count = 0;
                foreach ($vehicles as $vehicle) {
                    if (isset($vehicle->locationType) && count($vehicle->locationType) && $vehicle->locationType[0]->id == $locationType->id) {
                        $locationType->vehicle_count++;
                    }
                }
            }
            $categories = Category::query()
                ->join('vehicles', 'vehicles.category', '=', 'categories.id')
                ->join('branches', 'branches.id', '=', 'vehicles.pickup_loc')
                ->where('branches.location', $location)
                ->whereIn('vehicles.id', $vehicles->pluck('id')->toArray())
                ->select(['categories.id as id', 'categories.name as name', 'categories.photo as photo', 'categories.sort'])
                ->orderBy('sort')
                ->distinct('categories.id', 'sort')->get();
            foreach ($categories as $category) {
                $category->vehicle_count = 0;
                foreach ($vehicles as $vehicle) {
                    if (isset($vehicle->category) && $vehicle->category == $category->id) {
                        $category->vehicle_count++;
                    }
                }
            }
            foreach ($suppliers as $supplier) {
                $supplier->vehicle_count = 0;
                foreach ($vehicles as $vehicle) {
                    if ($vehicle->supplier == $supplier->id) {
                        $supplier->vehicle_count++;
                    }
                }
            }
            $startDate = Carbon::parse($dateFrom);
            $endDate = Carbon::parse($dateTo);

            $diffInDays = $startDate->diffInDays($endDate);
            foreach ($vehicles as $vehicle) {
                if ($diffInDays >= '1' && $diffInDays < '3') {
                    $vehicle->final_price = ($vehicle->price + (($vehicle->price * $vehicle->profit->per_day_profit) / 100)) * $diffInDays;
                    $priceTax = $vehicle->profit->per_day_profit;
                } else if ($diffInDays >= '3' && $diffInDays <= '7') {

                    $vehicle->final_price = ($vehicle->week_price + (($vehicle->week_price * $vehicle->profit->per_week_profit) / 100)) * $diffInDays;
                    $priceTax = $vehicle->profit->per_week_profit;
                } else if ($diffInDays >= 8) {
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


            $count = $vehicles->count();

            foreach ($vehicles as $vehicle) {
                $vehicle->promo = DB::select('SELECT what_is_included as promotion FROM promos JOIN included ON included.id = promos.included_id  WHERE vehicle_id = :vehicle_id', ['vehicle_id' => $vehicle->id]);
                if ($vehicle->promo && count($vehicle->promo)) {
                    $vehicle->promo = $vehicle->promo[0]->promotion;
                }
                $rentals = Rental::query()->where('supplier_id', $vehicle->supplier)->with('rentalRates.question')->whereNotNull('rate')->get();
                $vehicle->questions_rate = DB::select('SELECT objective, sum(rental_rates.rate)/count(rental_rates.id)  as total_rate FROM rentals
                                        JOIN rental_rates on rental_rates.rental_id = rentals.id
                                        JOIN rate_questions on rate_questions.id = rental_rates.question_id
                                        WHERE supplier_id = :supplier_id
                                        Group By rate_questions.objective', ['supplier_id' => $vehicle->supplier]);
                $vehicle->supplier_rate = round($rentals->sum('rate') / ($rentals->count() <= 0 ? 1 : $rentals->count()), 1);
                $vehicle->supplier_number_of_reviews = $rentals->count();
                $vehicle->rental_terms = SupplierRentalTerm::query()->where('supplier_id', $vehicle->supplier)->join('rental_terms', 'rental_terms.id', '=', 'supplier_rental_terms.rental_term_id')->select(['title', 'description'])->get();
            }
            $vehicles = $vehicles->toArray();


            usort($vehicles, function ($a, $b) {
                if ($a["final_price"] == $b["final_price"])
                    return (0);
                return (($a["final_price"] < $b["final_price"]) ? -1 : 1);
            });
            if ($minPrice >= $maxPrice) $minPrice = 0;
            return [
                'location' => $location,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'filteredVehicles' => $vehicles,
                'filteredCategories' => $categories,
                'filteredSuppliers' => $suppliers,
                'filteredLocationTypes' => $locationTypes,
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
        dd($request->all());
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

    public function updatePrice(EditVehiclePrice $request)
    {
        try {

            $existingVehicle = Vehicle::find($request->id);

            if ($request->has('price')) {
                $existingVehicle->price = $request->price;
            }

            if ($request->has('week_price')) {
                $existingVehicle->week_price = $request->week_price;
            }

            if ($request->has('month_price')) {
                $existingVehicle->month_price = $request->month_price;
            }
            $existingVehicle->save();
            return response()->json([
                'data' => $existingVehicle,
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([], StatusCodes::SERVER_ERROR);
        }
    }

    public function create(CreateEditVehicle $request)
    {
        DB::beginTransaction();
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
            if ($request->has('fuel_policy')) {
                $existingVehicle->fuel_policy_id = $request->fuel_policy;
            }

            if ($request->has('month_price')) {
                $existingVehicle->month_price = $request->month_price;
            }
            if ($request->has('instant_confirmation')) {
                $existingVehicle->instant_confirmation = $request->instant_confirmation == 'false' ? 0 : 1;
            }


            if ($request->has('pickupLoc')) {
                $existingVehicle->pickup_loc = Branch::query()->where('name', $request->pickupLoc)->first()->id;
            }

            if ($request->has('category')) {
                $existingVehicle->category = $request->get('category');
            }


            if ($request->has('location_types')) {
                LocationTypeVehicle::query()->where('vehicle_id', $existingVehicle->id)->delete();
                LocationTypeVehicle::query()->insert([
                    'vehicle_id' => $existingVehicle->id,
                    'location_type_id' => $request->location_types
                ]);
            }

            $existingVehicle->save();
            if ($request->has('specifications')) {
                VehicleSpecification::query()->where('vehicle_id', $existingVehicle->id)->delete();
                $specifications = json_decode($request->specifications);
                foreach ($specifications as $specification) {
                    if ($specification->selectedOption !== "") {
                        VehicleSpecification::insert(
                            [
                                'vehicle_id' => $existingVehicle->id,
                                'name' => isset($specification->name) ? $specification->name : '',
                                'value' => isset($specification->selectedOption) ? $specification->selectedOption : '',
                                'icon' => isset($specification->icon) ? $specification->icon : '',
                                'created_at' => Carbon::now()->toDateTimeString(),
                                'updated_at' => Carbon::now()->toDateTimeString()
                            ]
                        );
                    }
                }
            }
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
            if ($request->has('instant_confirmation')) {
                $item->instant_confirmation = $request->instant_confirmation ? 1 : 0;
            }
            $item->supplier = auth()->user()->id;

            if ($request->has('price')) {
                $item->price = $request->price;
            }
            if ($request->has('fuel_policy')) {
                $item->fuel_policy_id = $request->fuel_policy;
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


            $item->save();
            if ($request->has('location_types')) {
                LocationTypeVehicle::query()->insert([
                    'vehicle_id' => $item->id,
                    'location_type_id' => $request->location_types
                ]);
            }
            if ($request->has('specifications')) {
                $specifications = json_decode($request->specifications);
                foreach ($specifications as $specification) {
                    VehicleSpecification::insert(
                        [
                            'vehicle_id' => $item->id,
                            'name' => $specification->name,
                            'value' => $specification->option,
                            'icon' => $specification->icon,
                        ]
                    );
                }
            }
            if ($request->has('included')) {
                $included = explode(',', $request->included);
                foreach ($included as $include) {
                    VehicleIncluded::insert(['vehicle_id' => $item->id, 'included_id' => $include]);
                }
            }
        }
        DB::commit();
        return response()->json([
            'data' => $item,
            'status' => true
        ]);
    }





    public function getFilteredSpecifications(Request $request)
    {
        $specifications = Specification::query()->get();

        if ($request->has('vehicle_ids')) {
            foreach ($specifications as $specification) {
                $arrayX = [];
                foreach ($specification->options as $option) {
                    $x = new \stdClass();
                    $x->value = $option;
                    $x->vehicle_count = VehicleSpecification::query()
                        ->where('name', $specification->name)
                        ->where('value', $option)
                        ->whereIn('vehicle_id', $request->vehicle_ids)
                        ->count();
                    $arrayX[] = $x;
                }
                $specification->options = $arrayX;
            }
        }
        return response()->json($specifications);

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


    public function getLocations()
    {
        $locations = Branch::query()->orderBy('location')->get()->unique('location');
        return response()->json($locations);

    }

    public function show(Request $request)
    {
        $vehicles = Vehicle::query();

        $user = auth()->user();
        $branchId = null;
        $supplierId = null;
        if ($request->has('branch_id')) {
            $branchId = $request->branch_id;
        }
        if ($request->has('supplier')) {
            $supplierId = $request->supplier;
        }
        if ($user) {
            $id = $user->id;
            $role = $user->role;


            if ($role === 'active_supplier') {
                $vehicles->where('supplier', $id);
            }
        }

        if (!is_null($supplierId)) {
            $vehicles->where('supplier', $supplierId);
        }

        if ($branchId != null) {
            $vehicles->where('pickup_loc', $branchId);
        }
        $data = $vehicles->with('category', 'supplier', 'branch', 'fuelPolicy')->orderBy('id')->get();
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

    public function getVehicle(GetVehiclePageRequest $request)
    {
        try {

            $location = $request->location;
            $currency = $request->currency;
            $selectedVehicle = Vehicle::where('id', $request->id)->with('locationType','category', 'fuelPolicy', 'branch', 'included', 'specifications', 'supplier.fuelPolicy', 'supplier.rentals.rentalRates','supplier.paymentMethods', 'fuelPolicy')->first();

            $startDate = Carbon::parse($request->date_from);
            $endDate = Carbon::parse($request->date_to);
            $diffInDays = $startDate->diffInDays($endDate);

            if ($diffInDays >= '1' && $diffInDays < '3') {
                $selectedVehicle->final_price = ($selectedVehicle->price + (($selectedVehicle->price * $selectedVehicle->profit->per_day_profit) / 100)) * $diffInDays;
            } else if ($diffInDays >= '3' && $diffInDays <= '7') {
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

            $rentals = Rental::query()->where('supplier_id', $selectedVehicle->supplier)->whereNotNull('rate')->get();
            $selectedVehicle->supplier_rate = round($rentals->sum('rate') / ($rentals->count() <= 0 ? 1 : $rentals->count()), 1);
            $selectedVehicle->supplier_number_of_reviews = $rentals->count();

            return response()->json([
                'data' => [
                    'vehicle' => $selectedVehicle,
                    'date_from' => $startDate->toDateString(),
                    'date_to' => $endDate->toDateString(),
                    'time_from' => $endDate->toTimeString(),
                    'time_to' => $endDate->toTimeString(),
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
        $vehicle = Vehicle::query()->with(['branch', 'category', 'included', 'locationType', 'fuelPolicy'])->find($id);
        $vehicle->what_is_included = $vehicle->included->pluck('what_is_included');
        $vehicle->specifications = VehicleSpecification::query()->where("vehicle_id", $id)->orderBy('name')->get();
        $specs = Specification::query()->orderBy('name')->get();
        foreach ($specs as $spec) {
            $spec->selectedOption = "";
            foreach ($vehicle->specifications as $specification) {
                if ($specification['name'] == $spec->name) {
                    $spec->selectedOption = $specification['value'];
                }
            }
        }
        $vehicle->specifications = $specs;
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
    public function destroy($id)
    {
        try {

            Vehicle::query()->where('id', $id)->delete();
            return response([
                'status' => true,
                'message' => 'deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
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
