<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
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

// Route::inertia('/vehicles/{id}', 'VehiclePage');
Route::get('/vehicles/{id}', function () {
    return Inertia::render('VehiclePage');
});

Route::inertia('vehicles', 'Dashboard/Vehicles');
Route::post('/get/vehicle/data', [VehicleController::class, 'getVehicle']);

Route::inertia('company', 'Dashboard/CreateCompany');

Route::get('get/categories', [VehicleController::class, 'getCategories']);
Route::get('get/specifications', [VehicleController::class, 'getSpecifications']);

Route::get('results',  [VehicleController::class, 'index'])->name('results');

Route::inertia('/supplier/login', 'Auth/SupplierLogin');
Route::inertia('/supplier/signup', 'Auth/SupplierRegister');
Route::get('/login', [LoginController::class, 'create'])->name('/login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('post/user/data', [RegisterController::class, 'store']);

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
Route::post('search/vehicles', [VehicleController::class, 'search']);

Route::get('/get/locations', [VehicleController::class, 'getLocations']);

Route::inertia('rentals', 'Dashboard/Rentals');
Route::get('/get/rentals', [VehicleController::class, 'getRentals']);

Route::get('get/photos', [VehicleController::class, 'getPhotos']);

// Authorized only

Route::middleware(['admin'])->group(function () {

    Route::inertia('margin', 'Dashboard/ProfitMargin');

    Route::inertia('categories', 'Dashboard/Categories');
    Route::post('post/categories', [VehicleController::class, 'createCategories']);
    Route::post('delete/categories', [VehicleController::class, 'deleteCategories']);

    Route::inertia('specifications', 'Dashboard/Specifications');
    Route::post('post/specifications', [VehicleController::class, 'createSpecifications']);
    Route::post('delete/specifications', [VehicleController::class, 'deleteSpecifications']);
    
    Route::inertia('memberships', 'Dashboard/Memberships');
    Route::get('get/requests', [UserController::class, 'memberships']);
    Route::post('accept/requests', [UserController::class, 'acceptMemberships']);
    Route::post('delete/requests', [UserController::class, 'deleteMemberships']);

    Route::inertia('photos', 'Dashboard/Photos');
    Route::post('post/photos', [VehicleController::class, 'createPhotos']);
    Route::post('delete/photos', [VehicleController::class, 'deletePhotos']);
});

Route::middleware(['member'])->group(function () {
    Route::inertia('membership', 'Dashboard/Membership');
    Route::post('post/request', [UserController::class, 'membership']);
});

Route::middleware(['active_supplier'])->group(function () {
    Route::inertia('vehicle', 'Dashboard/CreateVehicle');
    Route::post('post/vehicles', [VehicleController::class, 'create']);
    Route::post('delete/vehicles', [VehicleController::class, 'destroy']);

    Route::post('accept/rentals', [VehicleController::class, 'acceptRentals']);
    Route::post('delete/rentals', [VehicleController::class, 'deleteRentals']);
});

Route::middleware(['customer'])->group(function () {
    Route::post('/book/vehicles', [VehicleController::class, 'book']);
});



