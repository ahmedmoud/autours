<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\FuelPolicyController;
use App\Http\Controllers\IncludedController;
use App\Http\Controllers\LocationTypesController;
use App\Http\Controllers\ProfitsController;
use App\Http\Controllers\RatesController;
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

Route::group(['prefix' => '/booking'], function () {
    Route::get('/{id}', [BookingsController::class, 'show'])->middleware('customer');

});

// Route::inertia('/vehicles/{id}', 'VehiclePage');
Route::get('/vehicles/book', function () {
    return Inertia::render('VehiclePage');
});
Route::get('get/suppliers', [UserController::class, 'suppliers']);

Route::post('/get/vehicle/data', [VehicleController::class, 'getVehicle']);
Route::get('/get/countries', [CountryController::class, 'index']);

Route::inertia('/my-profile', 'MyProfile');
Route::inertia('/update-booking', 'UpdateBooking');
Route::get('/my-current-user-profile', [UserController::class, 'profile']);

Route::inertia('company', 'Dashboard/CreateCompany');
Route::inertia('index', 'Dashboard/Index')->middleware('admin_or_supplier');
Route::inertia('suppliers', 'Dashboard/Suppliers');

Route::get('get/categories', [VehicleController::class, 'getCategories']);
Route::get('get/specifications', [VehicleController::class, 'getSpecifications']);
Route::post('get/filtered/specifications', [VehicleController::class, 'getFilteredSpecifications']);

Route::get('results', [VehicleController::class, 'index'])->name('results');

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

Route::get('/get/rentals', [BookingsController::class, 'getRentals']);

Route::get('get/photos', [VehicleController::class, 'getPhotos']);
Route::get('get/rental-terms', [RentalTermsController::class, 'index']);
Route::get('get/currencies', [CurrencyController::class, 'index']);
Route::get('get/fuel-policies', [FuelPolicyController::class, 'index']);
Route::get('get/included', [IncludedController::class, 'index']);

// Authorized only
Route::middleware(['admin_or_supplier'])->group(function () {

    Route::inertia('rentals/admin', 'Dashboard/AdminRentals');
    Route::inertia('rentals/supplier', 'Dashboard/Rentals');
    Route::post('post/rental-terms', [RentalTermsController::class, 'insert']);

});
Route::middleware(['admin'])->group(function () {
    Route::get('/get/rentals/admin', [BookingsController::class, 'getAdminRentals']);
    Route::get('/get/supplier/invoice', [BookingsController::class, 'getSupplierInvoices']);

    Route::inertia('margin', 'Dashboard/ProfitMargin');
    Route::inertia('customers', 'Dashboard/Customers');
    Route::get('/get/customers', [UserController::class, 'getCustomers']);

    Route::inertia('categories', 'Dashboard/Categories');
    Route::post('post/categories', [CategoriesController::class, 'createCategories']);
    Route::post('update/categories', [CategoriesController::class, 'updateCategories']);
    Route::post('delete/categories', [VehicleController::class, 'deleteCategories']);

    Route::inertia('specifications', 'Dashboard/Specifications');
    Route::post('post/specifications', [VehicleController::class, 'createSpecifications']);
    Route::post('delete/specifications', [VehicleController::class, 'deleteSpecifications']);
    Route::post('rentals/reconcile', [BookingsController::class, 'reconcile']);


    Route::inertia('included', 'Dashboard/Included');
    Route::post('post/included', [IncludedController::class, 'store']);
    Route::post('delete/included', [IncludedController::class, 'delete']);

    Route::inertia('rental-terms', 'Dashboard/RentalTerms');
    Route::post('delete/rental-terms', [RentalTermsController::class, 'destroy']);
    Route::post('edit/rental-terms', [RentalTermsController::class, 'edit']);
    Route::post('show/rental-terms', [RentalTermsController::class, 'show']);
    Route::post('update/rental-terms/status', [RentalTermsController::class, 'approveOrReject']);


    Route::inertia('memberships', 'Dashboard/Memberships');
    Route::get('get/requests', [UserController::class, 'memberships']);
    Route::post('accept/requests', [UserController::class, 'acceptMemberships']);
    Route::post('delete/requests', [UserController::class, 'deleteMemberships']);
    Route::post('profit/upload', [ProfitsController::class, 'upload']);
    Route::get('get/profit', [ProfitsController::class, 'show']);

    Route::inertia('photos', 'Dashboard/Photos');
    Route::post('post/photos', [VehicleController::class, 'createPhotos']);
    Route::post('delete/photos', [VehicleController::class, 'deletePhotos']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/get/subscribers', [SubscriberController::class, 'index']);
    Route::inertia('/subscribers','Dashboard/SubscribersList');

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
    Route::inertia('promos', 'Dashboard/Promos');
    Route::get('get/location-types', [LocationTypesController::class, 'index']);
    Route::get('/rental/rate/{id}', [BookingsController::class, 'getRate']);

    Route::inertia('price-list', 'Dashboard/PriceList');

    Route::inertia('supplier-rental-terms', 'Dashboard/SupplierRentalTerms');
    Route::post('select-rental-terms', [RentalTermsController::class, 'assignRentalTerms']);


    Route::post('accept/rentals', [VehicleController::class, 'acceptRentals']);
    Route::post('delete/rentals', [VehicleController::class, 'deleteRentals']);
    Route::get('/supplier-dashboard', [DashboardController::class, 'supplierDashboard']);

});

Route::middleware(['customer'])->group(function () {
    Route::post('/book/vehicles', [BookingsController::class, 'book']);
    Route::inertia('/my-bookings', 'MyBookings');
    Route::post('/cancel/booking', [BookingsController::class, 'cancelBooking']);
    Route::get('/invoice/booking/{id}', [BookingsController::class, 'bookingInvoice']);
});

Route::get('/booking/update-status', [BookingsController::class, 'updateBookingStatus']);
Route::inertia('/rentals/rate', 'RentalRate');
Route::get('/get/rating/questions', [RatesController::class, 'index']);
Route::post('/rating', [RatesController::class, 'store']);
Route::post('/forget-password', [UserController::class, 'forgetPassword']);
Route::inertia('/new-password-form', 'Auth/NewPasswordForm');
Route::post('/validate-forget-password-key', [UserController::class, 'validateForgetPasswordKey']);
Route::post('/save-new-password', [UserController::class, 'setNewPassword']);
Route::inertia('/contact-us', 'ContactUs' );
Route::inertia('/about-us', 'AboutUs' );
Route::post('/send-email',[SubscriberController::class,'sendEmail']);

