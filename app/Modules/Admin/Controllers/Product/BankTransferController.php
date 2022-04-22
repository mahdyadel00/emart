<?php

namespace App\Modules\Admin\Controllers\Product;

use App\DataTables\BankTransferDataTable;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\product\bank_transfer;
use App\Models\product\product_photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Nexmo\Numbers\Number;
use function _i;
use function App\Modules\Admin\Controllers\Admin\Product\get_store_id;
use function App\Modules\Admin\Controllers\Admin\Product\getLang;
use function App\Modules\Admin\Controllers\Admin\Product\public_path;
use function back;
use function redirect;
use function response;
use function view;

class BankTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BankTransferDataTable $bank)
    {
        return $bank->render('admin.bank.index');
    }


    public function create()
    {

        return view('admin.bank.create', ['languages' => Language::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = get_store_id();
        $this->validate($request,[
            'title' => 'required',
            'holder_name' => 'required',
            'iban' => 'required',
            'holder_number' => 'required',
            'logo' => 'required',
        ]);

        $sessionStore = get_store_id();
        if($sessionStore == \App\Bll\Utility::$demoId){
            return redirect()->back()->with('flash_message' , _i('Added Successfully'));
		}

		if( $request->hasFile('logo') )
		{
			$request->validate([
				'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
			]);
		}

        $numberrand = rand(11111,99999);
        $imageName = time().$numberrand.'.'.$request->logo->getClientOriginalExtension();
        bank_transfer::create([

            'title' => $request->title,
			'lang_id' => $request->lang_id,
            'holder_name' => $request->holder_name,
            'iban' => $request->iban,
            'holder_number' => $request->holder_number,
            'logo' => '/uploads/bank/'. $imageName,

            'lang_id' => getLang(session('adminlang')),
        ]);
        $request->logo->move(public_path('uploads/bank'), $imageName);
        return back()->with('flash_message',_i('success create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank = bank_transfer::where('id',$id)->first();
        return view('admin.bank.edit',compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bank = bank_transfer::where('id',$id)->first();
        $store = get_store_id();
        $this->validate($request,[
            // 'title' => 'required',
            'holder_name' => 'required',
            'iban' => 'required',
            'holder_number' => 'required',
            'logo' => 'sometimes',
        ]);

        $sessionStore = get_store_id();
        if($sessionStore == \App\Bll\Utility::$demoId){
            return redirect()->back()->with('flash_message' , _i('Updated Successfully'));
        }

		$exists = bank_transfer::where('id',$id)->where('logo','!=',null)->exists();
		if( $request->hasFile('logo') )
		{
			$request->validate([
				'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
			]);
		}

        if ($exists && $request->logo != null) {
            $image = bank_transfer::where('id',$id)->where('logo','!=',null)->first();
            $image_path = $image->logo;  // Value is not URL but directory file path
            if (File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            $numberrand = rand(11111, 99999);
            $imageName = time() . $numberrand . '.' . $request->logo->getClientOriginalExtension();
            $bank->update([
                // 'title' => $request->title,
                'holder_name' => $request->holder_name,
                'iban' => $request->iban,
                'holder_number' => $request->holder_number,
                'logo' => '/uploads/bank/'. $imageName,

            ]);
            $request->logo->move(public_path('uploads/bank'), $imageName);
        }
        $bank->update([
            // 'title' => $request->title,
            'holder_name' => $request->holder_name,
            'iban' => $request->iban,
            'holder_number' => $request->holder_number,

        ]);
        return back()->with('flash_message', _i('success update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sessionStore = get_store_id();
        if($sessionStore == \App\Bll\Utility::$demoId){
            return redirect()->back()->with('flash_message' , _i('Deleted Successfully'));
        }
        $bank = bank_transfer::where('id',$id)->first();

        $exists = bank_transfer::where('id',$id)->where('logo','!=',null)->exists();
        if ($exists) {
            $image = bank_transfer::where('id', $id)->where('logo', '!=', null)->first();
            $image_path = $image->logo;  // Value is not URL but directory file path
            if (File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
        }
		if($bank !=null)
        $bank->delete();

        return back()->with('flash_message', _i('success delete'));
    }

	public function getTranslation(Request $request)
	{

		$rowData = bank_transfer::where('id', $request->transRow)
			->where('lang_id', $request->lang_id)
			->first('title');
		$rowDataa = bank_transfer::where('source_id', $request->transRow)
		->where('lang_id', $request->lang_id)
		->first('title');


		if (!empty($rowData)){
			return response()->json(['data' => $rowData]);
		}
		elseif (!empty($rowDataa)){
			return response()->json(['data' => $rowDataa]);
		}else{
			return response()->json(['data' => false]);
		}
	}

	public function storeTranslation(Request $request)
	{

		$rowData = bank_transfer::where('id', $request->id)
			->where('lang_id' , $request->lang_id)
			->first();
		$rowDataa = bank_transfer::where('source_id', $request->id)
		->where('lang_id' , $request->lang_id)
		->first();

		if ($rowData != null) {
			$rowData->update([
				'title' => $request->name,
			]);
		}
		elseif ($rowDataa != null) {
				$rowDataa->update([
					'title' => $request->name,
				]);
		}else{
			$rowData = bank_transfer::where('id', $request->id)
			->first();
			bank_transfer::create([
				'title' => $request->name,
				'lang_id' => $request->lang_id,
				'source_id' =>$request->id,
				'holder_name'  =>$rowData->holder_name,
				'holder_number'  =>$rowData->holder_number,
				'iban'      => $rowData->iban  ,
				'logo'     =>$rowData->logo
			]);
		}

		return response()->json("SUCCESS");
	}
}
