<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use App\Models\MembershipRequest;

class UserController extends Controller
{

    public function upload(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $updateData = $request->all();

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $image_name = Auth::user()->name . "_logo" . "." . $request->file('logo')->extension();
            $image->move(public_path('img'), $image_name);

            $updateData['logo'] = $image_name;
        }


        if ($request->has('newPass')) {
            if ($request->has('oldPass') && Hash::check($request->oldPass, $user->password) && $request->newPass === $request->confirmNewPass) {
                $updateData['password'] = Hash::make($request->newPass);
            } else {
                return response()->json(['message' => 0]);
            }
        }

//        if ($request->has('oldPass') && Hash::check($request->oldPass, $user->password)) {
//
//        } else{
//            return response()->json(['message' => 0]);
//        }

        $user->update($updateData);

        return response()->json(['message' => 1]);

        // return response()->json(['message' => 'No file uploaded'], 400);
    }

    public function role()
    {
        $user = Auth::user();
        $check = Auth::check();
        if($check){
            return json_encode($user->role);
        } else {
            return 'null';
        }

    }

    public function priceTax()
    {
        $priceTax = User::where('role', 'admin')->value('price_tax');
        $weekPriceTax = User::where('role', 'admin')->value('week_price_tax');
        $monthPriceTax = User::where('role', 'admin')->value('month_price_tax');
        $yearPriceTax = User::where('role', 'admin')->value('year_price_tax');

        return json_encode([
            'priceTax' => $priceTax,
            'weekPriceTax' => $weekPriceTax,
            'monthPriceTax' => $monthPriceTax,
            'yearPriceTax' => $yearPriceTax
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if(isset($user->language))
            $user->language = explode(',', auth()->user()->language);
        return $user;

    }

    public function getLogos()
    {
        return User::query()->where('role', 'active_supplier')->whereNotNull('logo')->take(4)->pluck('logo');
    }

    public function membership()
    {

        $user = Auth::user();
        $user->update(['role' => 'under_review']);

        return response()->json(['message' => 'Role updated successfully']);
    }

    public function memberships()
    {
        return User::whereIn('role', ['supplier', 'under_review', 'active_supplier'])->get();
    }

    public function suppliers()
    {
        return User::where('role', 'active_supplier')->get();
    }
    public function acceptMemberships(Request $request)
    {
        User::where('id', $request->id)->update(['role' => 'active_supplier']);
        return User::whereIn('role', ['supplier', 'under_review', 'active_supplier'])->get();
    }

    public function deleteMemberships(Request $request)
    {
        User::where('id', $request->id)->update(['role' => 'supplier']);
        return User::whereIn('role', ['supplier', 'under_review', 'active_supplier'])->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createBranch(Request $request)
    {
        $branch = new Branch();

        $branch->name = $request->name;
        $branch->location = $request->location;
        $branch->adresse = $request->adresse;
        $branch->country = $request->country;
        $branch->city = $request->city;
        $branch->phone = $request->phone;
        $branch->email = $request->email;
        $branch->company_id = auth()->user()->id;
        $branch->currency = $request->currency;

        $branch->save();

        return response(1);
    }

    public function getBranch(Request $request)
    {
        $companyId = auth()->user()->id;
        if ($request->has('company_id')) {
            $companyId = $request->company_id;
        }
        return response()->json(Branch::where('company_id', $companyId)->get());
    }

    public function deleteBranch(Request $request)
    {
        Branch::where('id', $request->id)->delete();
        return $this->getBranch();

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
