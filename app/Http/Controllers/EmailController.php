<?php

namespace App\Http\Controllers;

use App\Events\SendEmailEvent;
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
            event(new SendEmailEvent($request->type, $request->email));
        }
        if ($request->type == 'supplier') {
            event(new SendEmailEvent($request->type, $request->email));
        }
        return response()->json(['status' => 1]);
    }

}
