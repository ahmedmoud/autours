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

class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

      return Branch::query()->where('company_id', Auth::id())->get();

    }

    public function edit(){
        try {
            return Inertia::render('Dashboard/Branches/Edit');
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json([
                'error' => 'Not Found'
            ], 404);
        }
    }
    public function show($id){
        try {
            $branch = Branch::query()->find($id);
            return  response()->json([
                'data' => $branch
            ]);
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json([
                'error' => 'Not Found'
            ], 404);
        }
    }



}
