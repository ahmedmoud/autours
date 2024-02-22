<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    protected function store(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {

        try {
            if ($request->supplier === 1) {
                $role = 'supplier';
            } else {
                $role = 'customer';
            }

            User::create([
                'name' => $request->name,
                'phone_num' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $role,
            ]);
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
            }

            return response()->json([
                'data' => [],
                'status' => true
            ], StatusCodes::SUCCESS);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => false
            ], StatusCodes::SERVER_ERROR);
        }

    }
}
