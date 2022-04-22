<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\product\meta_tag;
use App\Models\product\metaTagData;
use App\Modules\Admin\Controllers\Admin\Product\Lang;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use function collect;
use function response;
use function view;

// use GuzzleHttp\Psr7\Request;

class MetaProductController extends Controller
{
	public function index()
	{
		$meta_data =meta_tag::all();
		return view('web.' . get_default_template() . '.layouts.index',compact('meta_data'));
	}

	public function store(Request $request)
	{
		$orders = meta_tag::count();
		if ($orders == 0) {

			$val =  $request->value;
			foreach ($val as $key => $value) {



				$meta = meta_tag::create([
					'meta_type' => $key,
					'item_id' => $request->id,
					'module' => 'product',

				]);
				metaTagData::create([
					'value' => $value,
					'meta_id' => $meta->id,
					'lang_id' => Lang::getSelectedLangId()
				]);
			}
		} else {
			$rowData = meta_tag::where('item_id', $request->id)->get();
			meta_tag::whereIn('item_id', collect($request->id))->delete();
			// metaTagData::where('meta_id', collect($rowData->id))->delete();
			$val =  $request->value;
			foreach ($val as $key => $value) {
				$meta = meta_tag::create([
					'meta_type' => $key,
					'item_id' => $request->id,
					'module' => 'product',

				]);
				metaTagData::create([
					'value' => $value,
					'meta_id' => $meta->id,
					'lang_id' => Lang::getSelectedLangId()
				]);
			}
		}
	  return response()->json("SUCCESS");
	}
	public function getData(Request $request) {

		$meta_arr=[];
		$meta = meta_tag::where('item_id', $request->id)->get();
		//dd($meta->id);
	    foreach($meta as $m){
		$meta_arr[] = metaTagData::where('meta_id', $m->id)->first()->value;

	    }
 		if ($meta_arr) {
			return response()->json(['data' => $meta_arr, 'status' => 'success']);
		} else {
			return response()->json(['data' => null, 'status' => 'error']);
		}
	}

}
