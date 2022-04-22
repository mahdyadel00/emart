<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Import\Card;
use App\Import\CardImport;
use App\Import\CardTemplateImport;
use App\Models\Product_card;
use App\Models\Product_digital;
use App\Models\Product_donation;
use App\Models\Product_type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use function _i;
use function App\Modules\Admin\Controllers\Admin\Product\get_store_id;
use function App\Modules\Admin\Controllers\Admin\Product\public_path;
use function redirect;
use function request;
use function response;
use function validator;
use function view;

class ProductTypeController extends Controller {

	public function all()
	{
        return view('admin.products.product_type.index');
    }

	public function datatableProductType()
	{
        $guard = Utility::get_guard();
        $product_types = Product_type::select(['id', 'title', 'description', 'store_id', 'created_at'])
                ;

        return DataTables::of($product_types)
                        ->addColumn('action', function ($p ) {
                            return $this->generateHtmlEdit_Delete([$p->id, $p->title, $p->description], $p->id);
                        })
                        ->make(true);
    }

    public function store(Request $request) {

        $sessionStore = get_store_id();
        if ($sessionStore == \App\Bll\Utility::$demoId) {
            return redirect()->back()->with('flash_message', _i('Added Successfully'));
        }
        $guard = Utility::get_guard();
        $rules = [
            'title' => 'required|max:150|unique:product_types'
        ];

        $validator = validator()->make($request->all(), $rules);
		if ($validator->fails())
		{
            return redirect()->back()->withErrors($validator)->withInput();
		}

        $product_type = Product_type::create([
			'title' => $request->title,
			'description' => $request->description,

			'lang_id' => 1,
        ]);
        return redirect()->back()->with('flash_message', _i('Added Successfully'));
    }

    public function update(Request $request) {

        $product_type = Product_type::where("id", $request->id)->first();
        if ($product_type == null) {
            return response()->json(['fail' => _i('not found')]);
        }

        $rules = [
            'title' => ['required', 'max:150', Rule::unique('product_types')->ignore($product_type->id)]
        ];

        $validator = validator()->make($request->all(), $rules);
		if ($validator->fails())
		{
            return redirect()->back()->with('error', _i('Failed not unique'));
		}

		if ($product_type)
		{
            $product_type->title = $request->title;
            $product_type->description = $request->description;
            $product_type->save();
            return redirect()->back()->with('flash_message', _i('Updated Successfully'));
		}
		else
		{
            return redirect()->back()->with('flash_message', _i('Not Found !'));
        }
	}

	public function delete(Request $request)
	{

        $product_type = Product_type::where("id", $request->id)->first();
		if ($product_type == null)
		{
            return response()->json(['fail' => _i('not found')]);
        }

		if ($product_type)
		{
            $product_type->delete();
            return redirect()->back()->with('flash_message', _i('Deleted Successfully !'));
		}
		else
		{
            return redirect()->back()->with('flash_message', _i('Not Found !'));
        }
    }

	public function getCard(Request $request)
	{
        $data = Product_card::where('product_id', $request->product_id)->get();
		return $data;
    }

	public function postCard(Request $request)
	{


		foreach( $request->fields AS $code => $field )
		{
			$field = (object) $field;

			if( empty( $field->card ) ) continue;

			Product_card::updateOrCreate(
				[
					'code' => $code
				],
				[
					'card' => $field->card,
					'sort' => $field->sort,
					'product_id' => $request->product_id,
					'code' => $code,

				]
			);
		}
		return response()->json('success');
    }

    public function delete_card(Request $request) {


        Product_card::where("code", $request->code)->delete();
        return response()->json('success');
    }

	public function getdigital(Request $request)
	{
		$data = Product_digital::where('product_id', $request->product_id)
			->get();
		return $data;
    }

    public function postdigital(Request $request) {


		foreach( $request->fields AS $code => $field )
		{
			$field = (object) $field;
			$file_field_name = 'fields.' . $code . '.file';

			$row = Product_digital::updateOrCreate(
				[
					'code' => $code
				],
				[
					'title' => $field->title,
					'sort' => $field->sort,
					'product_id' => $request->product_id,
					'code' => $code,

				]
			);

			if( $request->hasFile($file_field_name) )
			{
				$request->validate([
					$file_field_name => 'mimes:jpeg,png,jpg,gif,svg,pdf,mp4,mp3',
				]);

				$file = $request->file($file_field_name);
				$path = public_path("/uploads/products/{$request->product_id}/digitals");
				$filename = rand(11111, 99999) . $file->getClientOriginalName();
				$file->move($path, $filename);

				$row->update(['file' => $filename]);
			}
		}
		return response()->json('success');
    }

	protected function delDigital()
	{


		Product_digital::where('code' , request()->code)->delete();
        return response()->json('success');
	}

	public function getdonate(Request $request)
	{
		$data = Product_donation::where('product_id', $request->product_id)
			->first();
		return $data;
    }

    public function postdonate(Request $request) {

		$rules = [
            'min_price' => 'required',
            'max_price' => 'required',
        ];

        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json('error');
        }

		$row = Product_donation::updateOrCreate(
			[
				'product_id' => $request->product_id,

			],
			[
				'min_price' => $request->min_price,
				'max_price' => $request->max_price,
				'description' => $request->description,
				'product_id' => $request->product_id,

			]
		);

        return response()->json('success');
    }
}
