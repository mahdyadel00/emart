<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected function contact(Request $request)
    {
        $errors = [];

        $contact = new Contact();

        $contact->name    = $request->fullname;
        $contact->email   = $request->email;
        $contact->message = $request->message;

        $contact->save();
       
        return response(['data' => 'Success', 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);

    }
}
