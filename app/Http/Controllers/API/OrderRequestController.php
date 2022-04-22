<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Products\OrderProduct;
use App\Modules\Admin\Models\Products\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderRequestController extends Controller
{

    protected function store(Request $request)
    {

        $errors = [];

        $validator = Validator::make($request->all(), [

            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'is_company' => 'required',
        ]);

        $order_request = OrderRequest::create([

            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'tax_number' => $request->tax_number,
            'cr_number' => $request->cr_number,
            'is_company' => $request->is_company,
        ]);

        foreach ($request->product_id as $key => $product) {
                $order_request_product = OrderProduct::create([

                'order_request_id' => $order_request->id,
                'product_id' => $product,
                'quantity' => $request->quantity[$key],
                "price" => $request->price,
            ]);


        }

        return response(['data' => 'Success', 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);

    }
}
