<?php

namespace App\Http\Controllers;

use App\Enums\StatusCodes;
use App\Http\Requests\AssignRentalTerm;
use App\Http\Requests\CreateRentalTerms;
use App\Models\RentalRate;
use App\Models\RentalTerms;
use App\Models\SupplierRentalTerm;
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

class RatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        RentalRate::query();
    }

    public function insert(Request $request)
    {

    }

    public function show($id)
    {
    }

    public function edit(Request $request)
    {
    }

    public function destroy(Request $request)
    {
    }

}
