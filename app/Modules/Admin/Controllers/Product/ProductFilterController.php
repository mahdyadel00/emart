<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Models\product\features;
use App\Models\product\products;
use App\Models\product\stores;
use App\Models\Product_type;
use App\Models\Settings\Setting;
use App\Modules\Admin\Controllers\Admin\Product\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function view;

class ProductFilterController extends Controller
{
	public $settings;

	public function __construct()
	{
		$this->settings = Setting::first();
	}
	public function product_status(Request $request)
	{
		$product_type = Product_type::
			join('product_types_data','product_types_data.product_types_id','product_types.id')
			->where('product_types_data.lang_id', Lang::getSelectedLangId())
			->select('product_types.id', 'product_types_data.title', 'product_types_data.description')
			->get();

		$categories = $category_tree = Category::select('categories.*', 'title')
			->join('categories_data', 'categories.id', 'categories_data.category_id')
			->where('lang_id', Lang::getSelectedLangId())
			->orderBy('number', 'asc')
			->get();

		$cats = [];
		\App\Bll\Utility::getCategories($category_tree, $cats);

		if ($request->ajax()) {
			if ($request->code == 'all') {
				$products = products::orderBy("id", "desc")->paginate($this->settings->products_per_page_admin);
			}
			if ($request->code == 'discount') {
				$products = products::where('discount', '!=', null)->orderBy("id", "desc")->paginate($this->settings->products_per_page_admin);
			}
			if ($request->code == 'sale') {
				$products = products::orderBy("id", "desc")->paginate($this->settings->products_per_page_admin);
			}
			if ($request->code == 'outofstock') {
				$products = products::
					join('stocks', 'products.id', 'stocks.product_id')
					->select(DB::raw('SUM(stocks.quantity) as total_stock'), 'products.*')
					->groupBy('stocks.product_id')
					->orderByDesc('stocks.id')
					->get();
				$products = $products->where('total_stock', '<', 1)->pluck('id')->toArray();
				$products = products::whereIn('id', $products)->paginate($this->settings->products_per_page_admin);
			}

			return view('admin.products.products.ajax.product_ajax', compact('product_type', "cats", "categories", 'products'))->render();
		}
	}


	public function product_type(Request $request)
	{
		$product_type = Product_type::
			join('product_types_data','product_types_data.product_types_id','product_types.id')
			->where('product_types_data.lang_id', Lang::getSelectedLangId())
			->select('product_types.id', 'product_types_data.title', 'product_types_data.description')
			->get();

		$categories = $category_tree = Category::select('categories.*', 'title')
			->join('categories_data', 'categories.id', 'categories_data.category_id')
			->where('lang_id', Lang::getSelectedLangId())
			->orderBy('number', 'asc')
			->get();

		$cats = [];
		\App\Bll\Utility::getCategories($category_tree, $cats);

		if ($request->ajax()) {
			if ($request->id != null) {
				$products = products::where('product_type', $request->id)->orderBy("id", "desc")->paginate($this->settings->products_per_page_admin);
			}
			return view('admin.products.products.ajax.product_ajax', compact('product_type', "cats", "categories", 'products'))->render();
		}
	}

	public function product_brand(Request $request)
	{
		$product_type = Product_type::
			join('product_types_data','product_types_data.product_types_id','product_types.id')
			->where('product_types_data.lang_id', Lang::getSelectedLangId())
			->select('product_types.id', 'product_types_data.title', 'product_types_data.description')
			->get();

		$categories = $category_tree = Category::select('categories.*', 'title')
			->join('categories_data', 'categories.id', 'categories_data.category_id')
			->where('lang_id', Lang::getSelectedLangId())
			->orderBy('number', 'asc')
			->get();

		$cats = [];
		\App\Bll\Utility::getCategories($category_tree, $cats);

		if ($request->ajax()) {
			if ($request->id != null) {
			//	$category = Category::where('id', $request->category)->first()->id;
				$products = products::where('brand_id', $request->id)->paginate($this->settings->products_per_page_admin);
			}
			return view('admin.products.products.ajax.product_ajax', compact('product_type', "cats", "categories", 'products'))->render();
		}
	}
	public function product_search(Request $request)
	{
		//dd($request->all());
		$settings = Setting::first();
		$lang_id = Lang::getSelectedLangId();
		$product_type = Product_type::
			join('product_types_data','product_types_data.product_types_id','product_types.id')
			->where('product_types_data.lang_id', Lang::getSelectedLangId())
			->select('product_types.id', 'product_types_data.title', 'product_types_data.description')
			->get();
			$brands = Brand::
			select('brands.id', 'brands_data.name')
			->join('brands_data', 'brands.id', 'brands_data.brand_id')
			->where('lang_id', $lang_id)
			->get();

		$categories = $category_tree = Category::select('categories.*', 'title')
			->join('categories_data', 'categories.id', 'categories_data.category_id')
			->where('lang_id', Lang::getSelectedLangId())
			->orderBy('number', 'asc')
			->get();

		$cats = [];
		\App\Bll\Utility::getCategories($category_tree, $cats);

		if ($request->ajax()) {
			if ($request->keyword != null) {
			//	$category = Category::where('id', $request->category)->first()->id;
				$products = products::join("product_details","products.id","product_details.product_id")
				->where("title","like","%".$request->keyword."%")->select("products.*","product_details.title","product_details.description")
				->paginate($this->settings->products_per_page_admin);
				// dd($this->settings->products_per_page_admin, $products);
				$features = features::pluck('product_id')->toArray();
				return view('admin.products.products.ajax.items', compact('product_type', "cats", "categories", 'products', 'brands','features'))->render();
			}

			// return view('admin.products.products.ajax.product_ajax', compact('product_type', "cats", "categories", 'products'))->render();
		}
	}
	public function product_category(Request $request)
	{
		$product_type = Product_type::
			join('product_types_data','product_types_data.product_types_id','product_types.id')
			->where('product_types_data.lang_id', Lang::getSelectedLangId())
			->select('product_types.id', 'product_types_data.title', 'product_types_data.description')
			->get();

		$categories = $category_tree = Category::select('categories.*', 'title')
			->join('categories_data', 'categories.id', 'categories_data.category_id')
			->where('lang_id', Lang::getSelectedLangId())
			->orderBy('number', 'asc')
			->get();

		$cats = [];
		\App\Bll\Utility::getCategories($category_tree, $cats);

		if ($request->ajax()) {
			if ($request->category != null) {
				$category = Category::where('id', $request->category)->first()->id;
				$products = products::whereHas('categories', function ($query) use ($category) {
					$query->where('category_id', $category);
				})->paginate($this->settings->products_per_page_admin);
			}
			return view('admin.products.products.ajax.product_ajax', compact('product_type', "cats", "categories", 'products'))->render();
		}
	}
}
