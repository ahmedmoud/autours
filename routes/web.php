<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\IncludedController;
use App\Http\Controllers\ProfitsController;
use App\Http\Controllers\RentalTermsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Models\Branch;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia::render('LandingPage');
});

Route::get('/v2', function () {
    return Inertia::render('LandingPagev2');
});

// Route::inertia('/vehicles/{id}', 'VehiclePage');
Route::get('/vehicles/book', function () {
    return Inertia::render('VehiclePage');
});

Route::post('/get/vehicle/data', [VehicleController::class, 'getVehicle']);
Route::get('/get/countries', [CountryController::class, 'index']);

Route::inertia('/my-profile', 'MyProfile');
Route::get('/my-current-user-profile', [UserController::class, 'profile']);

Route::inertia('company', 'Dashboard/CreateCompany');
Route::inertia('index', 'Dashboard/Index')->middleware('admin_or_supplier');
Route::inertia('suppliers', 'Dashboard/Suppliers');

Route::get('get/categories', [VehicleController::class, 'getCategories']);
Route::get('get/specifications', [VehicleController::class, 'getSpecifications']);
Route::post('get/filtered/specifications', [VehicleController::class, 'getFilteredSpecifications']);

Route::get('results',  [VehicleController::class, 'index'])->name('results');

Route::inertia('/supplier/login', 'Auth/SupplierLogin');
Route::inertia('/supplier/signup', 'Auth/SupplierRegister');
Route::get('/login', [LoginController::class, 'create'])->name('/login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'create'])->name('register');

Route::post('/post/user/data', [RegisterController::class, 'store']);

Route::get('/get/logos', [UserController::class, 'getLogos']);
Route::get('get/priceTax', [UserController::class, 'priceTax']);
Route::get('/get/user/data', [UserController::class, 'index']);
Route::get('get/user/role', [UserController::class, 'role']);
Route::post('upload', [UserController::class, 'upload']);

Route::post('/upload/branch', [UserController::class, 'createBranch']);
Route::get('get/branches', [UserController::class, 'getBranch']);
Route::post('delete/branches', [UserController::class, 'deleteBranch']);

Route::post('filter/vehicles', [VehicleController::class, 'filter']);
Route::get('get/vehicles', [VehicleController::class, 'show']);
Route::post('/search/vehicles', [VehicleController::class, 'search']);

Route::get('/get/locations', [VehicleController::class, 'getLocations']);

Route::inertia('rentals', 'Dashboard/Rentals');
Route::get('/get/rentals', [BookingsController::class, 'getRentals']);

Route::get('get/photos', [VehicleController::class, 'getPhotos']);
Route::get('get/rental-terms', [RentalTermsController::class, 'index']);
Route::get('get/currencies', [CurrencyController::class, 'index']);
Route::get('get/included', [IncludedController::class, 'index']);

// Authorized only

Route::middleware(['admin'])->group(function () {

    Route::inertia('margin', 'Dashboard/ProfitMargin');

    Route::inertia('categories', 'Dashboard/Categories');
    Route::post('post/categories', [VehicleController::class, 'createCategories']);
    Route::post('delete/categories', [VehicleController::class, 'deleteCategories']);

    Route::inertia('specifications', 'Dashboard/Specifications');
    Route::post('post/specifications', [VehicleController::class, 'createSpecifications']);
    Route::post('delete/specifications', [VehicleController::class, 'deleteSpecifications']);


    Route::inertia('included', 'Dashboard/Included');
    Route::post('post/included', [IncludedController::class, 'store']);
    Route::post('delete/included', [IncludedController::class, 'delete']);

    Route::inertia('rental-terms', 'Dashboard/RentalTerms');
    Route::post('post/rental-terms', [RentalTermsController::class, 'insert']);
    Route::post('delete/rental-terms', [RentalTermsController::class, 'destroy']);
    Route::post('edit/rental-terms', [RentalTermsController::class, 'edit']);
    Route::post('show/rental-terms', [RentalTermsController::class, 'show']);



    Route::inertia('memberships', 'Dashboard/Memberships');
    Route::get('get/requests', [UserController::class, 'memberships']);
    Route::get('get/suppliers', [UserController::class, 'suppliers']);
    Route::post('accept/requests', [UserController::class, 'acceptMemberships']);
    Route::post('delete/requests', [UserController::class, 'deleteMemberships']);
    Route::post('profit/upload', [ProfitsController::class, 'upload']);
    Route::get('get/profit', [ProfitsController::class, 'show']);

    Route::inertia('photos', 'Dashboard/Photos');
    Route::post('post/photos', [VehicleController::class, 'createPhotos']);
    Route::post('delete/photos', [VehicleController::class, 'deletePhotos']);
});

Route::middleware(['member'])->group(function () {
    Route::inertia('membership', 'Dashboard/Membership');
    Route::post('post/request', [UserController::class, 'membership']);
});

Route::middleware(['active_supplier'])->group(function () {
    Route::inertia('vehicle', 'Dashboard/Vehicles/CreateVehicle');
    Route::post('post/vehicles', [VehicleController::class, 'create']);
    Route::post('update/vehicles/activation', [VehicleController::class, 'updateActivation']);
    Route::post('delete/vehicles', [VehicleController::class, 'destroy']);
    Route::get('edit/vehicles/{id}', [VehicleController::class, 'edit']);
    Route::inertia('vehicles', 'Dashboard/Vehicles/Vehicles');
    Route::inertia('edit/vehicle', 'Dashboard/Vehicles/EditVehicle');

    Route::inertia('price-list', 'Dashboard/PriceList');

    Route::inertia('supplier-rental-terms', 'Dashboard/SupplierRentalTerms');
    Route::post('select-rental-terms', [RentalTermsController::class, 'assignRentalTerms']);



    Route::post('accept/rentals', [VehicleController::class, 'acceptRentals']);
    Route::post('delete/rentals', [VehicleController::class, 'deleteRentals']);
});

Route::middleware(['customer'])->group(function () {
    Route::post('/book/vehicles', [BookingsController::class, 'book']);
        Route::inertia('/my-bookings','MyBookings' );
        Route::post('/cancel/booking',[BookingsController::class, 'cancelBooking'] );
});
$user = User::query()->find(3);
$rental = Rental::query()->find(11);
$rental->vehicle = $rental->vehicle;
$rental->branch = Branch::query()->where('id', $rental->vehicle->pickup_loc)->first();
$rental->supplier = User::query()->where('id', $rental->vehicle->supplier)->first();
$rental->customer = User::query()->where('id', $rental->customer_id)->first();
$rental->request = new \stdClass();
$rental->request->rental_id =  11;
$rental->request->api_key = env('api-key');
$rental->request->timestamp = Carbon::now()->toDateTime();


Route::view('/email', 'email.booking.request.supplier',['body' =>  $rental]);
Route::get('/booking/update-status', [BookingsController::class, 'updateBookingStatus']);

