<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Currency;
use App\Http\Controllers\Controller;
use App\Mail\InvoiceCreated;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\MailingTemplate;
use App\Models\product\products;
use App\Models\Settings\Setting;
use App\Modules\Admin\Controllers\Admin\Product\Lang;
use App\Product;
use App\User;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use function _i;
use function App\Modules\Admin\Controllers\Admin\Product\get_default_currency;
use function back;
use function redirect;
use function request;
use function response;
use function route;
use function session;
use function view;

class InvoicesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (request()->ajax()) {
			$invoices = Invoice::get();
			//::orderByDesc('id');
			return DataTables::of($invoices)
				->addColumn('action', function ($invoices) {
					$html = '<a href ='. route('invoice.print', $invoices->id) .' class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Print").'" target="_blank"><i class="ti-printer"></i></a> <a href ='. route('invoice.edit', $invoices->id) .' class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'"><i class="ti-pencil-alt"></i></a>  <a href="'.route('invoice.destroy', $invoices->id).'" data-remote="'.route('invoice.destroy', $invoices->id).'" class="btn btn-delete waves-effect waves-light btn btn-danger text-center" title="'._i("Delete").'"><i class="ti-trash center"></i></a>
					</div>';
				 return $html;
			})
			->rawColumns([
				'action',
			])
			->make(true);
		}
		return view('admin.invoices.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request  $request)
	{


		$invoice = Invoice::latest()->first();
		if( $invoice == null )
		{
			$no = date('Y').'-0001';
		}
		else
		{
			$old_no = explode('-', $invoice->no);
			if ( date('Y-m-d') == date('Y-01-01')){
				$no = date('Y').'-0001';
			} else {
				$next = sprintf('%04d', $old_no[1] + 1);
				$no = $old_no[0] . '-' . $next;
			}
		}

		$users = User::get();
		$products = products::select('products.*', 'product_details.title')
			->join('product_details', 'products.id', 'product_details.product_id')
			->where('lang_id', Lang::getSelectedLangId())

			->get();

		return view('admin.invoices.create', compact('users', 'products', 'no'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			'no' => 'required|unique:invoices',
			'date' => 'required|date',
			'due_date' => 'required|date',
			'invoice_total' => 'required',
		]);

		$invoice = Invoice::create([

			'no' => $request->no,
			'date' => $request->date,
			'due_date' => $request->due_date,
			'total' => $request->invoice_total,
			'user_id' => $request->user_id,
			'payment_id' => $request->payment_id,
		]);

		foreach( $request->products AS $key => $product_id )
		{
			$product = Product::where('id' , $product_id)->first();
			if( $product == null )
			{
				return back()->with('error', _i('Product Not Found !') . ' # ' . $product_id);
			}
			InvoiceProduct::create([

				'invoice_id' => $invoice->id,
				'product_id' => $product->id,
				'price' => $product->price,
				'quantity' => $request->quantity[$key],
				'total_price' => $request->quantity[$key] * $product->price,
			]);
		}
		$user = User::find($request->user_id);
	  $malingTempalte =	MailingTemplate::where('category', 'invoices')->where('type', 'send_invoice')->where('lang_id', Lang::getSelectedLangId())->first();
		if( !empty( $user )  &&  $malingTempalte)
		{
			//Mail::to('thxphp@gmail.com',new InvoiceCreated($user, $request, $invoice));
			 Mail::to($user->email,new InvoiceCreated($user, $request, $invoice));
		}
		session()->flash('success' , _i('Added Successfully !'));
		return redirect()->route('invoice.index');
	}


	public function print($id)
	{

		$invoice = Invoice::where('id', $id)->first();
		$user = User::find($invoice->user_id);
		$setting = Setting::join('settings_data', 'settings.id', 'settings_data.setting_id')
			->where('lang_id', Lang::getSelectedLangId())
			->first();
		$currency = get_default_currency(true);

		$qrCode = new QrCode();
		$qrCode
			->setText("No: $invoice->no \nDate: $invoice->date \nDue Date: $invoice->due_date")
			->setSize(100)
			->setPadding(10)
			->setErrorCorrection('high')
			->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
			->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
			// ->setLabel('Scan Qr Code')
			->setLabelFontSize(16)
			->setImageType(QrCode::IMAGE_TYPE_PNG);
		$qr_code_type = $qrCode->getContentType();
		$qr_code = $qrCode->generate();
		return view('admin.invoices.print', compact('invoice', 'user', 'setting', 'currency', 'qr_code_type', 'qr_code'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$invoice = Invoice::where('id', $id)->first();

		$users = User::get();
		$products = products::select('products.*', 'product_details.title')
			->join('product_details', 'products.id', 'product_details.product_id')
			->where('lang_id', Lang::getSelectedLangId())

			->get();

		return view('admin.invoices.edit', compact('invoice', 'users', 'products'));
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

		$request->validate([
			'no' => 'required',
			'date' => 'required|date',
			'due_date' => 'required|date',
			'invoice_total' => 'required',
		]);

		$invoice = Invoice::where('id' , $id)->first();
		$invoice->update([
			'date' => $request->date,
			'due_date' => $request->due_date,
			'total' => $request->invoice_total,
			'user_id' => $request->user_id,
			'payment_id' => $request->payment_id,
		]);

		$invoice->products()->delete();

		$request->products = $request->products ?? [];
		foreach( $request->products AS $key => $product_id )
		{
			$product = Product::where('id' , $product_id)->first();
			if( $product == null )
			{
				return back()->with('error', _i('Product Not Found !') . ' # ' . $product_id);
			}
			InvoiceProduct::create([

				'invoice_id' => $invoice->id,
				'product_id' => $product->id,
				'price' => $product->price,
				'quantity' => $request->quantity[$key],
				'total_price' => $request->quantity[$key] * $product->price,
			]);
		}

		return back()->with('success', _i('Updated Successfully !'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{


		$invoice = Invoice::where('id' , $id)->first();
		if( $invoice == NULL )
		{
			return response()->json(['status' => 'error']);
		}
		else
		{
			$invoice->products()->delete();
			$invoice->delete();
			return response()->json(['status' => 'success']);
		}
	}
}
