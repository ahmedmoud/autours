<?php

namespace App\Http\Controllers;

use App\Events\SendEmail;
use App\Http\Requests\SendEmailRequest;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
    }

    public function sendEmail(SendEmailRequest $request)
    {
        if ($request->type == 'offers') {
            event(new SendEmail($request->type, $request->email));
        }
        return response()->json(['status' => 1]);
    }

}
