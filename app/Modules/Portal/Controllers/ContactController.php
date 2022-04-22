<?php

namespace App\Modules\Portal\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    public function contact_us()
    {
        return view('site.contact_us');
    }


    public function contactSave(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name'	=> 'required|max:100',
            'code'	=> 'max:100',
            'city'	=> 'max:100',
            'phone'	=> 'max:15',
            'email'	=> 'required|email|max:100',
            'message' => 'required|string',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $send_message = Contact::create([
            'code' => $request->contact_type,
            'name' => $request->name,
            'phone'	=> $request->phone,
            'email'	=> $request->email,
            'city'	=> $request->city,
            'message' => $request->message
        ]);

        if($send_message) {
            return  redirect()->back()->with('success', _i('Message  Sent Success'));
        } else {
            return  redirect()->back()->with('error', _i('Please Try Again Later'));
        }
    }
}
