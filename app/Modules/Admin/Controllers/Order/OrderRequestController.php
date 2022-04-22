<?php

namespace App\Modules\Admin\Controllers\Order;

use App\Bll\Lang;
use App\Models\Language;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Modules\Portal\Models\OrderRquest;

class OrderRequestController extends Controller
{
    protected function index()
    {
        $order_request = OrderRquest::get();
        if (request()->ajax()) {

            return DataTables::of($order_request)
                ->addColumn('options', function ($query) {
                    // dd($query->id);
                    $html = "<a href='" . route('order_request.show', $query->id) . "' class='btn waves-effect waves-light btn-primary text-center mr-1 ml-1'>" . _i('Details') . "</a>";

                    return $html;
                })

                ->rawColumns([
                    'options',
                ])
                ->make(true);
        }
        return view('admin.order_request.index');
    }

    protected function show($id)
    {
        $lang = Language::get();

        $order_request = OrderRquest::where('id' , $id)
                ->with(['products' => function($query) {

                    $query->with(['detailes' => function($query) {
                        $query->select('product_id' ,'title');
                    }]);
                }])->first();

            return view('admin.order_request.details' , compact('order_request'));
    }
}
