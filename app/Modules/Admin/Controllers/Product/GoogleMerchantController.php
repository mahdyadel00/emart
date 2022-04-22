<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Controllers\Admin\Product\Lang;
use App\Product;
use Exception;
use Illuminate\Support\Carbon;
use MOIREI\GoogleMerchantApi\Facades\ProductApi;
use function _i;
use function App\Modules\Admin\Controllers\Admin\Product\config_path;
use function asset;
use function env;
use function redirect;
use function route;
use function view;

class GoogleMerchantController extends Controller
{

	function __construct()
	{
		ProductApi::merchant([
			'app_name' => env("APP_NAME"),
			'merchant_id' => '426590897',
			'client_credentials_path' => config_path('service-account-credentials.json')
		]);
	}
	private function addToApi($item)
	{
		try {
			$result = ProductApi::insert(function ($product) use ($item) {
				$product->with($item)->offerId($item->id)
					->title($item->title)
					->description($item->info)
					->price($item->price, "usd")
					->link(route('home_product.show', [app()->getLocale(), $item->id]))
					->imageLink(asset($item->mainPhoto()))
					->targetCountry("sa")
					//->custom('purchase_quantity_limit', 1000)
					//                ->availabilityDate( today()->addDays(7) )
				;
			});

			$googleUpdate = Carbon::now();
			$pro = Product::find($item->id);
			$pro->google_update = $googleUpdate;
			$pro->save();
		} catch (Exception $ex) {
			error_log($ex->getMessage());
		}
	}

	protected function insert($id)
	{

		$item = Product::join("product_details", "products.id", "product_details.product_id")->where("lang_id", Lang::getSelectedLangId())->select("products.*", "product_details.title", "product_details.info")->findOrFail($id);

		$this->addToApi($item);



		return redirect()->back()->with('success', _i('GoogleSync Successfully !'));
	}

	protected function insertSyncAll()
	{

		$products = Product::join("product_details", "products.id", "product_details.product_id")->where("lang_id", Lang::getSelectedLangId())->select("products.*", "product_details.title", "product_details.info")->get();

		foreach ($products as $item) {

			$this->addToApi($item);
		}

		return redirect()->back()->with('success', _i('GoogleSync All Successfully !'));
	}


	protected function index()
	{

		$limit = 10;
		$products = Product::join("product_details", "products.id", "product_details.product_id")->where("lang_id", Lang::getSelectedLangId())->select("products.*", "product_details.title")->paginate($limit);
		//dd($products);

		return view('admin.products.product_marchant.products_details', compact('products'));
	}
}
