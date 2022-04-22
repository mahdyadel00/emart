<?php

namespace App\Modules\Portal\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\MailingList\MailingList;
use Illuminate\Http\Request;

class MailingListController extends Controller
{
    public function store( Request $request )
    {
       // dd($request->all());
    	$request->validate([
    		 'email' => 'required|email'
    	]);

    	$email = MailingList::where('email', $request->email)->first();
    	if( $email == NULL )
    	{
    		MailingList::create(['email' => $request->email ]);
    		return response()->json(['status' => 'success', 'message' => _i('Thank you !')]);
    	}
    	return response()->json(['status' => 'success', 'message' => _i('Thank you !')]);
    }
}
