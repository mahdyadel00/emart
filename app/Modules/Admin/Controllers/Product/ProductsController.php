<?php

namespace App\Modules\Admin\Controllers\Product;


use App\Bll\Constants;
use App\Bll\Lang;
use App\Bll\Translate;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\User;
use App\Modules\Admin\Models\Products\Brand;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Products\countries_data;
use App\Modules\Admin\Models\Products\feature_data;
use App\Modules\Admin\Models\Products\feature_option_data;
use App\Modules\Admin\Models\Products\feature_options;
use App\Modules\Admin\Models\Products\FeatureImage;
use App\Modules\Admin\Models\Products\features;
use App\Modules\Admin\Models\Products\orders;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\product_details;
use App\Modules\Admin\Models\Products\Product_donation;
use App\Modules\Admin\Models\Products\product_photos;
use App\Modules\Admin\Models\Products\Product_type;
use App\Modules\Admin\Models\Products\ProductCustomField;
use App\Modules\Admin\Models\Products\ProductCustomFieldOption;
use App\Modules\Admin\Models\Products\ProductOutNotify;
use App\Modules\Admin\Models\Products\products;
use App\Modules\Admin\Models\Products\ProductVideo;
use App\Modules\Admin\Models\Products\RequestProduct;
use App\Modules\Admin\Models\Products\Stock;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use function _i;
use function array_first;
use function array_pluck;
use function auth;
use function redirect;
use function request;
use function response;
use function route;
use function view;

//use LukeSnowden\GoogleShoppingFeed\Containers\GoogleShopping;


class ProductsController extends Controller
{


    public function index()
    {


        $settings = Utility::get_main_settings(); // Setting::first();
        $lang_id = Lang::getSelectedLangId();
        $product_type = Product_type::join('product_types_data', 'product_types_data.product_types_id', 'product_types.id')
            ->where('product_types_data.lang_id', $lang_id)
            ->select('product_types.id', 'product_types_data.title', 'product_types_data.description')
            ->get();

        // $product_type = Product_type::join('product_types_data','product_types_data.product_types_id','product_types.id')
        // ->where('product_types_data.lang_id', Lang::getSelectedLangId())
        // ->pluck("product_types_data.title", "product_types.id");



        $categories = [];
        array_map(function ($elem) use (&$categories) {
            if (!array_key_exists($elem["category_id"], $categories))
                $categories[$elem["category_id"]][$elem["lang_id"]] = json_decode(json_encode($elem));
        }, CategoryData::all()->toArray());



        $brands = Brand::select('brands.id', 'brands_data.name')
            ->join('brands_data', 'brands.id', 'brands_data.brand_id')
            ->where('lang_id', $lang_id)
            ->get();

        $countries = countries_data::where('lang_id', $lang_id)->get();

        $cats = [];

        $category_tree = Category::select('categories.*', 'title')
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->orderBy('number', 'asc')
            ->get();

        $category_tree = Category::whereNull("parent_id")
            ->orderBy('number', 'asc')
            ->get();


//        dd($category_tree,  $cats);
        Utility::getCategories($category_tree,  $cats);
        //dd($cats, $category_tree);

        $products = products::select('products.*')
            ->orderBy("id", "desc");

        if (request()->query("cat") != null) {
            $products = $products->join("categories_products", "categories_products.product_id", "products.id")
                ->where("categories_products.category_id", request()->query("cat"));
        }

        if (request()->query("prod") != null) {
            $products = $products->where("products.id", request()->query("prod"));
        }



        $features = features::pluck('product_id')->toArray();

        if (request()->ajax()) {

            if (request()->filter != null || request()->filter != '') {
                $products = $products->whereHas('data', function ($query) {
                    $query->where('title', "like", "%" . request()->filter . "%");
                })
                    ->groupBy('products.id')
                    ->paginate($settings->products_per_page_admin);
            } else {
                $products = $products->paginate($settings->products_per_page_admin);
            }
            // dd($products);
            return view('admin.products.products.ajax.items', compact('product_type', 'features', "cats", "categories", 'products', 'brands', 'countries'));
        }

        $products = $products->paginate($settings->products_per_page_admin);
        $all_products = Product::with('product_details')->get();
        //dd($cats, $categories);
        return view('admin.products.index', compact('product_type', 'features', "cats", "categories", 'products', 'brands', 'countries', 'all_products'));
    }

    public function get_ajax_addition(Request $request)
    {
        $type = $request->type;
        return ['data' => view('admin.products.products.partial.tab.ajax.' . $type)->render()];
    }

    public function delete($id)
    {

        $product = products::where("id", $id)->first();
        $prod_data = product_details::query()->where('product_id', $id)->first();
        $prod_data->delete();
        $product->delete();
        return redirect()->back()->with('success', _i('Deleted Successfully !'));
    }

    public function dublicated(Request $request)
    {

        $product = products::where("id", $request->id)->first();
        if ($product == null) {
            return redirect()->back()->with('error', _i('Product Not found !'));
        }

        DB::beginTransaction();
        try {
            /** @var products $newProduct */
            $newProduct = products::create([

                'currency_code' => $product->currency_code,
                'sku' => $product->sku,
                'max_count' => $product->max_count,
                'weight' => $product->weight,
                'price' => $product->price,
                'net' => $product->net,
                'stock' => $product->stock,
                'cost' => $product->cost,
                'discount' => $product->discount,
                'discount_type' => $product->discount_type,
                //				'delivary' => $product->delivary,
                'delivary' => 1,
                'product_type' => $product->product_type,
                'brand_id' => $product->brand_id,
            ]);

            if ($product->Category() != null) {
                $newProduct->categories()->attach($product->Category()); // ??
            }
            if ($product->Donation() != null) {
                foreach ($product->Donation() as $donation) {
                    $newFeature = $donation->replicate();
                    $newFeature->product_id = $newProduct->id;
                    $newFeature->save();
                }
            }
            if ($product->features()->get() != null) {
                foreach ($product->features()->get() as $feature) {
                    $newFeature = $feature->replicate();
                    $newFeature->product_id = $newProduct->id;
                    $newFeature->save();
                    foreach ($feature->data()->get() as $data) {
                        $newData = $data->replicate();
                        $newData->feature_id = $newFeature->id;
                        $newData->save();
                    }
                    foreach ($feature->options()->get() as $option) {
                        $newOption = $option->replicate();
                        $newOption->feature_id = $newFeature->id;
                        $newOption->save();
                        foreach ($option->data()->get() as $data) {
                            $newData = $data->replicate();
                            $newData->feature_option_id = $newOption->id;
                            $newData->save();
                        }
                    }
                }
            }
            $details = $product->singleProductDetails();
            $product_details = product_details::create([

                'title' => $details->title,
                'description' => $details->description,
                'product_id' => $newProduct->id, 'lang_id' => Lang::getSelectedLangId(),

            ]);
            DB::commit();
            \Illuminate\Support\Facades\File::copyDirectory(public_path('uploads/products/' . $product->id), public_path('uploads/products/' . $newProduct->id));
            $photos = $product->product_photos()->get();
            foreach ($photos as $photo) {
                product_photos::create([

                    'product_id' => $newProduct->id,
                    'photo' => str_replace("/{$photo->product_id}/", "/" . $newProduct->id . "/", $photo->photo),
                    'description' => $photo->description,
                    'tag' => $photo->tag,
                    'main' => $photo->main,
                ]);
            }
            return redirect()->back()->with('success', _i('Duplicated Successfully !'));
        } catch (\Exception $e) {
            return $e;
            DB::rollBack();
        }
        return redirect()->back()->with('error', _i('Failed !'));
    }

    public function hidden(Request $request)
    {
        $product = products::where("id", $request->id)->first();
        $val = 0;
        if ($product == null) {
            $val = 1;
            return response()->json(['pro_hidden' => $val, 'status' => 'success']);
        }
        if ($product->hidden == 0) {
            $val = 1;
        }
       // dd($product,$val);
        $product->hidden = $val;

        $product->save();

        return response()->json(['pro_hidden' => $val, 'status' => 'success']);
    }

    public function Get_users_product($id)
    {
        $product = products::where('id', $id)->first();
        $users_product = User::leftJoin('orders', 'orders.user_id', '=', 'users.id')
            ->leftJoin('order_products', 'order_products.order_id', '=', 'orders.id')
            ->leftJoin('product_details', 'product_details.product_id', '=', 'order_products.product_id')
            ->where("order_products.product_id", $id)
            ->select('product_details.title as proname', 'users.name as username', 'users.lastname as userlastname', 'users.image as userimage')
            ->get();
        return view('admin.products.product.pro_users', compact('users_product'));
    }

    public function get_category()
    {
        $categories = Category::where('parent_id', null)->orderBy('number', 'asc')->get();
        foreach ($categories as $key => $category) {
            $sub_categories = Category::where('parent_id', $category->id)->orderBy('number', 'asc')->get();
            $cat_result[] = [
                'parent_cat' => $category,
                'child_cat' => $sub_categories
            ];
        }
        return $cat_result;
    }

    public function Get_status(Request $request)
    {


        $proorders = orders::leftJoin('order_products', 'order_products.order_id', '=', 'orders.id')
            // ->where("order_products.product_id", $request->id)
        ;

        //->get();
        if ($request->type == "day") {
            $dayAfter = (new DateTime($request->day))->modify('+1 day')->format('Y-m-d');

            $proorders->whereDate('orders.created_at', ">=", $request->day)
                ->whereDate('orders.created_at', "<", $dayAfter);
        } elseif ($request->type == "year") {
            $proorders->whereYear('orders.created_at', $request->year);
        } elseif ($request->type == "month") {
            $proorders->whereMonth('orders.created_at', $request->month)
                ->whereYear('orders.created_at', $request->month_year);
        } elseif ($request->type == "week") {
            $date = explode("/", $request->week);
            $start = $date[0];
            $end = $date[1];
            //dd($start , $end);
            $proorders->whereBetween('orders.created_at', [$start . " 00:00:00", $end . " 00:00:00"]);
        } else { // if type => all
            $proorders = orders::leftJoin('order_products', 'order_products.order_id', '=', 'orders.id');
        }
        //echo $proorders->toSql();
        $proorders = $proorders->get();
        $sum = $proorders->sum('total');
        //dd($sum,$proorders);
        if ($sum < 0)
            $sum = 0;
        $order_numb = $proorders->count();
        $penfit = $sum - $proorders->sum('shipping_cost');
        if ($penfit < 0)
            $penfit = 0;
        // dd($proorders);
        return response()->json(['sum' => $sum, 'order_num' => $order_numb, 'penfit' => $penfit, 'status' => 'success']);

        // $proorders = orders::leftJoin('order_products', 'order_products.order_id', '=', 'orders.id')
        // 		->where("order_products.product_id", $request->id)
        // 		->get();

        // $sum = $proorders->sum('total');
        // $order_numb = $proorders->count();
        // $penfit = $sum - $proorders->sum('shipping_cost');
        // return response()->json(['sum' => $sum, 'order_num' => $order_numb, 'penfit' => $penfit, 'status' => 'success']);
    }

    public function saveproduct(Request $request)
    {

        $request->validate([
            'price' => 'required',
            'code' => 'required',
            'is_free_shipping' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $product = products::create([

                'max_count' => $request->max_count,
                'price' => $request->price,
                'cost' => $request->cost,
                'code' => $request->code,
                'product_type' => $request->types,
                'currency_code' => Utility::get_default_currency(true)->code,
                //				'is_free_shipping' => 0,
                'delivary' => 1,
                'ref_number' => $request->refrence,
                'is_free_shipping' => $request->is_free_shipping,

            ]);
            if ($request->categories != null) {
                $product->categories()->attach($request['categories']);
            }
            $product_details = product_details::create([

                'title' => $request->product_name,
                'description' => $request->text,
                'product_id' => $product->id,
                'lang_id' => Lang::getSelectedLangId(),
                'info' => $request->description
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
        $products = product_details::where('id', $product_details->id)->with(['product' => function ($query) {
            $query->with('categories');
            $query->with('product_type');
            $query->with('product_photos');
        }])->first();

        $this->insertStock($product->id, $request->max_count);
        return response()->json(['success' => ["id" => $products->product_id]]);
    }


    public function insertStock($product_id, $quantity)
    {
        Stock::create([

            'product_id' => $product_id,
            'quantity' => $quantity,
            'user_id' => auth()->user()->id
        ]);
    }

    public function updateproduct(Request $request)
    {
        $request->validate([
            'price' => 'required',
            'is_free_shipping' => 'required'
        ]);

        if ($request->product_id == -1) {
            return $this->saveproduct($request);
        }

        $product = products::where("id", $request->product_id)->first();
        if ($product == null) {
            return response()->json(['fail' => _i('not found')]);
        }

        $categories = [];
        $product_details = product_details::where("product_id", $request->product_id)->first();
        $product_details->title = $request['product_name'];
        $product_details->save();
        $product_details->with(['product' => function ($query) {
            $query->with('categories');
            $query->with('product_type');
            $query->with('product_photos');
            $query->with(['features' => function ($q) {
                $q->with('options');
            }]);
        }]);

        if ($request->types != 54) {
            Product_donation::where('product_id', $request->product_id)->delete();
        }

        $product_details->product->update([

            'max_count' => $request->max_count,
            'price' => $request->price,
            'cost' => $request->cost,
            'code' => $request->code,
            'product_type' => $request->types,
            'ref_number' => $request->refrence,
            'currency_code' => Constants::defaultCurrency,
            'is_free_shipping' => $request->is_free_shipping,
        ]);
        if ($request['categories'] != null) {
            $product_details->product->categories()->sync($request['categories']);
        }

        return response()->json(['success' => 'success']);
    }

    public function saveAllCat(Request $request)
    {

        $cats = $request->input('category');
        $cats_sort = $request->input('sort');
        $parent_sort = $request->input("parent_sort");
        if ($request->input('parentCategory') != null) {
            foreach ($request->input('parentCategory') as $key => $arr_parent_cats) {

                if ($key == "new") {

                    $parent_sort = $parent_sort["new"];
                    $new_parent_cats_index = 0;
                    foreach ($arr_parent_cats as $virtual_category_id => $new_parent_cat) {
                        $sort_val = $parent_sort[$virtual_category_id];
                        $inserted = null;
                        foreach ($new_parent_cat as $title) {
                            $inserted = Category::create([
                                'title' => $title,

                                'number' => $sort_val[0],
                                'lang_id' => Constants::defaultLanguage
                            ]);

                            $new_parent_cats_index++;
                        }
                        if (isset($cats["new"])) {
                            $new_sub_categories = $cats["new"];
                            if ($new_sub_categories && isset($new_sub_categories[$virtual_category_id])) {
                                $sort_sub = $cats_sort["new"];
                                $sort_sub = $sort_sub[$virtual_category_id];

                                $sub_category_index = 0;
                                //  var_dump($sort_sub);
                                foreach ($new_sub_categories[$virtual_category_id] as $sub_category) {
                                    //  dd($inserted->id);
                                    Category::create([
                                        'title' => $sub_category,

                                        'parent_id' => $inserted->id,
                                        'number' => $sort_sub[$sub_category_index],
                                        'lang_id' => Constants::defaultLanguage
                                    ]);
                                    $sub_category_index++;
                                }

                                unset($cats["new"][$virtual_category_id]);
                            }
                        }
                    }
                } else {
                    $categoryEntity = Category::where('id', $key)->first();
                    $parent_sort = $request->input("parent_sort");
                    $categoryEntity->update(['title' => $arr_parent_cats, 'number' => $parent_sort[$key]]);
                }
            }
        }
        //add children
        if ($cats != null) {

            foreach ($cats as $category_id => $new_parent_cat) {

                foreach ($new_parent_cat as $key => $arr_parent_cats) {
                    $parent_sort = $request->input("sort");
                    $parent_sort = $parent_sort[$category_id];
                    if ($key == "new") {

                        $parent_sort = $parent_sort["new"];
                        $new_parent_cats_index = 0;
                        foreach ($arr_parent_cats as $item_1) {
                            Category::create(['title' => $item_1, 'number' => $parent_sort[$new_parent_cats_index], "parent_id" => $category_id, 'lang_id' => Constants::defaultLanguage]);
                            $new_parent_cats_index++;
                        }
                    } else if ($key == "") {;
                    } else {

                        $categoryEntity = Category::where('id', $key)->first();

                        $categoryEntity->update(['title' => $arr_parent_cats, 'number' => $parent_sort[$key]]);
                    }
                }
            }
        }

        $categories = $this->getCategories();
        return response()->json($categories);
    }

    private function getCategories()
    {
        $categories = Category::whereNull("parent_id")->where('lang_id', Constants::defaultLanguage)->orderBy('number', 'asc')->with(['children' => function ($query) {
            $query->orderBy('number', 'asc');
        }])->get();
        return $categories;
    }

    public function catdel($cat_id)
    {


        $category = Category::where('id', $cat_id)->first();

        if ($category) {
            if (count($category->products) > 0) {
                return response()->json('failed');
            } else {
                $sub_exists = Category::where('parent_id', $category->id)->exists();
                Category::where("parent_id", $category->id)->delete();

                $category->delete();
                $categories = $this->getCategories();

                return response()->json($categories);
            }
        }
    }

    public function getproduct($id)
    {
        $product = products::where('id', $id)->with('product_details')->with('product_photos')->with(['features' => function ($q) {
            $q->with('options');
        }])->first();
        return response()->json($product);
    }

    protected function get_images($id)
    {
        $product = product_photos::where("product_id", $id)->get();
        return response()->json($product);
    }

    protected function getVideos($id)
    {
        $product = ProductVideo::where("product_id", $id)->get();
        return response()->json($product);
    }

    public function imagespost(Request $request)
    {


        foreach ($request->file as $key => $file) {
            if ($request->hasFile('file' . $key)) {
                $request->validate([
                    'file' . $key => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                ]);
            }
            $numberrand = rand(11111, 99999);
            $randname = time() . $numberrand;
            $imageName = $randname . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products/' . $request->product_id), $imageName);
            product_photos::create([

                'product_id' => $request->product_id,
                'photo' => '/uploads/products/' . $request->product_id . '/' . $imageName,
                'description' => $randname,
                'tag' => $randname,
                'main' => 0,
            ]);
        }
        $product = products::where('id', $request->product_id)->with('product_details')->with('product_photos')->first();
        return response()->json($product);
    }

    public function imagesdel(Request $request)
    {

        $id = $request['id'];
        $photo = products::join("product_photos", "products.id", "product_photos.product_id")->where("product_photos.id", $id)->first();
        if ($photo !== null) {
            $image_path = $photo->photo;  // Value is not URL but directory file path
            if (File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            $photo = product_photos::where("id", $id)->first();
            $photo->delete();
            return response()->json('success');
        }
        return response()->json('fail');
    }

    public function imageSubmit(Request $request)
    {

        $image_path = null;
        if ($request->file("file") != null) {
            if ($request->hasFile('file')) {
//                $request->validate([
//                    'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
//                ]);
            }
            $exists = product_photos::where('product_id', $request->product_id)->where('main', 1)->exists();
            if ($exists) {
                $image = product_photos::where('product_id', $request->product_id)->where('main', 1)->first();
                $image_path = $image->photo;  // Value is not URL but directory file path
                if (File::exists(public_path($image_path))) {
                    File::delete(public_path($image_path));
                }
                $numberrand = rand(11111, 99999);
                $imageName = time() . $numberrand . '.' . $request->file("file")->getClientOriginalExtension();
                $image->update([

                    'product_id' => $request->product_id,
                    'photo' => '/uploads/products/' . $request->product_id . '/' . $imageName,
                    'description' => $imageName,
                    'tag' => $imageName,
                    'main' => 1,
                ]);
                $request->file("file")->move(public_path('uploads/products/' . $request->product_id), $imageName);
                return response()->json(["status" => "ok", "data" => '/uploads/products/' . $request->product_id . '/' . $imageName]);
            } else {
                $numberrand = rand(11111, 99999);
                $imageName = time() . $numberrand . '.' . $request->file("file")->getClientOriginalExtension();
                product_photos::create([

                    'product_id' => $request->product_id,
                    'photo' => '/uploads/products/' . $request->product_id . '/' . $imageName,
                    'description' => $imageName,
                    'tag' => $imageName,
                    'main' => 1,
                ]);
                $request->file("file")->move(public_path('uploads/products/' . $request->product_id), $imageName);
                return response()->json(["status" => "ok", "data" => '/uploads/products/' . $request->product_id . '/' . $imageName]);
            }
        }
        if ($request->file("image") != null) {
//            $request->validate([
//                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
//            ]);

            $exists = product_photos::where('product_id', $request->product_id)->where('main', 1)->exists();
            if ($exists) {
                $image = product_photos::where('product_id', $request->product_id)->where('main', 1)->first();
                $image_path = $image->photo;  // Value is not URL but directory file path
                if (File::exists(public_path($image_path))) {
                    File::delete(public_path($image_path));
                }
                $numberrand = rand(11111, 99999);
                $imageName = time() . $numberrand . '.' . $request->file("image")->getClientOriginalExtension();
                $image->update([

                    'product_id' => $request->product_id,
                    'photo' => '/uploads/products/' . $request->product_id . '/' . $imageName,
                    'description' => $imageName,
                    'tag' => $imageName,
                    'main' => 1,
                ]);
                $request->file("image")->move(public_path('uploads/products/' . $request->product_id), $imageName);

                /**
                 * Create product thumbnail
                 */
                if (!file_exists(public_path('uploads/products/' . $request->product_id . '/thumbnails'))) {
                    mkdir(public_path('uploads/products/' . $request->product_id . '/thumbnails'), 0777, true);
                }
                Image::make(public_path('uploads/products/' . $request->product_id . '/' . $imageName))->fit(300, 300)->save(public_path('uploads/products/' . $request->product_id . '/thumbnails/' . $imageName));

                return response()->json(["status" => "ok", "data" => '/uploads/products/' . $request->product_id . '/' . $imageName]);
            } else {
                // dd(1);
                $numberrand = rand(11111, 99999);
                $imageName = time() . $numberrand . '.' . $request->file("image")->getClientOriginalExtension();
                product_photos::create([

                    'product_id' => $request->product_id,
                    'photo' => '/uploads/products/' . $request->product_id . '/' . $imageName,
                    'description' => $imageName,
                    'tag' => $imageName,
                    'main' => 1,
                ]);
                $request->file("image")->move(public_path('uploads/products/' . $request->product_id), $imageName);

                /**
                 * Create product thumbnail
                 */
                if (!file_exists(public_path('uploads/products/' . $request->product_id . '/thumbnails'))) {
                    mkdir(public_path('uploads/products/' . $request->product_id . '/thumbnails'), 0777, true);
                }
                Image::make(public_path('uploads/products/' . $request->product_id . '/' . $imageName))->fit(300, 300)->save(public_path('uploads/products/' . $request->product_id . '/thumbnails/' . $imageName));

                return response()->json(["status" => "ok", "data" => '/uploads/products/' . $request->product_id . '/' . $imageName]);
            }
        }
        return response()->json(["status" => "ok", "data" => $image_path]);
    }

    public function uploadVideo(Request $request)
    {

        //dd($request->all());

        if ($request->video != null) {
            $request->validate([
                'video' => 'required|max:20000',
            ]);
            $exists = ProductVideo::where('product_id', $request->product_id)->exists();
            if ($exists) {
                $video = ProductVideo::where('product_id', $request->product_id)->first();
                $video_path = $video->video;
                if (File::exists(public_path($video_path))) {
                    File::delete(public_path($video_path));
                }
                //
                $video->update([
                    'product_id' => $request->product_id,
                    'video' =>  $request->video,
                    'tag' => 0,
                    'mime_type' => 'url',
                ]);
                //
                return response()->json(["status" => "ok", "data" => '/uploads/products/' . $request->product_id . '/' . $request->video]);
            } else {
                ProductVideo::create([
                    'product_id' => $request->product_id,
                    'video' =>  $request->video,
                    'tag' => 0,
                    'mime_type' => 'url',
                ]);
            }
        }
        return response()->json(["status" => "ok", "data" =>  $request->video]);
    }

    public function featuredel($feature_id)
    {

        $feature = features::where('id', $feature_id)->first();

        if ($feature) {
            $sub_exists = feature_options::where('feature_id', $feature->id)->exists();
            if ($sub_exists) {
                $sub_features = feature_options::where('feature_id', $feature->id)->get();
                foreach ($sub_features as $sub_feature) {
                    $sub_feature->delete();
                }
            }
            $feature->products()->detach();
            $feature->delete();
            return response()->json('success');
        }
    }

    public function getFeatures(Request $request)
    {
        $lang_id = Lang::getSelectedLangId();
        $product = products::where('id', $request->id)->first();

        // dd($product->hasStock());
        if ($product->hasStock() == 0) return response()->json(['data' => null, 'status' => _i('This item is out of stock.')]);

        //get features
        $items = features::where('features.product_id', $product->id)->get()->toArray();
        $data = feature_data::whereIn("feature_id", array_column($items, "id"))->get()->toArray();
        $trans = new Translate($items, $data, $lang_id);
        $features = $trans->getData("feature_id", ["title", "type"]);


        //get options array with feature_id key
        $items = feature_options::whereIn("feature_id", array_keys($features))->get()->toArray();
        $data = feature_option_data::whereIn("feature_option_id", array_column($items, "id"))->get()->toArray();
        //dd($items);
        $trans = new Translate($items, $data, $lang_id);
        $features_option = $trans->getData("feature_option_id", ["title", "name"]);
        $type = "";
        if (count($features) > 0)
            $type = (array_first($features))->type;

        //get images with key feature_id
        $features_images = FeatureImage::whereIn('feature_option_id', array_keys($features_option))->get()->toArray();
        $features_images = array_pluck($features_images, "url", "feature_option_id");
        //dd($features_images);
        //assign feature_id
        //$features_option = array_combine(array_column($features_option, "feature_id"), $features_option);
        //dd($features_option);
        //dd(array_first($features_option));
        //collect images and options
        array_walk($features, function ($item) use ($features_option, $features_images) {

            $item->options = array_values($features_option);
            $item->images = ($features_images);
        });
        //dd($features);

        //remove keys
        $features = array_values($features);

        $totalStock = $product->hasStock();


        if (count($features) > 0) {
            return response()->json(['data' => $features, "type" => $type, "option" => array_values($features_option), "totalStock" => $totalStock, 'status' => 'success']);
        } else {
            return response()->json(['data' => null, "type" => $type, "option" => null, "totalStock" => null, 'status' => 'error']);
        }
    }

    public function saveProductDetails(Request $request)
    {

        if ($request->points < 0) {

            $request->validate([
                'points' => 'required|min:1'
            ]);
        }
        // dd($request->all());
        $id = $request['id'];
        $is_free_shipping = $request['is_free_shipping'];
        $sku = $request['sku'];
        $max_count = $request['count'];
        $weight = $request['weight'];
        $weight_unit = $request['weight_unit'];
        $price = $request['price'];
        $cost = $request['cost'];
        $net = $request['net'];
        $stock = $request['stock'];
        $discount = $request['discount'];
        $discount_type = $request['discount_type'];
        //		$delivary = $request['delivary'];
        $delivary = 1;
        $brand = $request['brand'];
        $country_of_origin = $request['country_of_origin'];
        $created_at = date('Y-m-d', strtotime($request['created_at']));
        $product = products::where("id", $id)->first();
        $productdescrption = product_details::where("product_id", $id)->first();
        if ($product == null) {
            return response()->json('fail');
        }

        $product->update([

            'sku' => $sku,
            'max_count' => $max_count,
            'weight' => $weight,
            'weight_unit' => $weight_unit,
            'price' => $price,
            'net' => $net,
            'cost' => $cost,
            'stock' => $stock,
            'discount' => $discount,
            'discount_type' => $discount_type,
            'delivary' => $delivary,
            'brand_id' => $brand,
            'is_free_shipping' => $is_free_shipping,
            'points' => $request->points,
            'country_of_origin' => $country_of_origin,
            'created_at' => $created_at,
            'ref_number' => $request->refrence
        ]);
        $productdescrption->update([
            'description' => $request['text'],
            'info' => str_replace(PHP_EOL, "<br>",  $request['description'])
        ]);
        return response()->json('SUCCESS');
    }

    public function productdel(Request $request)
    {
        // balalam


        $id = $request['id'];
        $product_details = products::where("id", $id)->first();
        if ($product_details != null) {
            //			$product_details->categories()->detach();
            //			if ($product_details->checkStock()->first()) {
            //				$product_details->checkStock()->delete();
            //			}

            //			product_details::where('product_id', $id)->delete();

            $product_details->delete();
            return response()->json(["status" => "ok", "msg" => _i("Deleted Successfully")]);
        }

        return response()->json(["status" => "fail", "msg" => _i("Not found")]);
    }

    public function getData(Request $request)
    {

        $product = products::where('id', $request->id)->first();

        $product['text'] = product_details::where('product_id', $request->id)->where('lang_id', Lang::getSelectedLangId())->value('description');
        $product['description'] = product_details::where('product_id', $request->id)->where('lang_id', Lang::getSelectedLangId())->pluck('info');
        if ($product) {
            return response()->json(['data' => $product, 'status' => 'success']);
        } else {
            return response()->json(['data' => null, 'status' => 'error']);
        }
    }

    public function deleteFeatureOption(Request $request)
    {

        // dd($request->optionId);

        $option = feature_options::find($request->optionId);
        $feature = features::where('id', $option->feature_id)->first();
        $feature_data = feature_data::where('feature_id', $feature->id)->first();

        feature_option_data::where('feature_option_id', $option->id)->delete();

        $image = FeatureImage::where('feature_option_id', $option->id)->first();
        if ($image) {
            if (File::exists('uploads/products/features/' . $image->url)) {
                File::delete('uploads/products/features/' . $image->url);
            }
            $image->delete();
        }
        $option->delete();
        $options = feature_options::where('feature_id', $feature->id)->get();


        if ($options->count() <= 0) {
            $feature_data->delete();

            $feature->delete();
        }


        //		$option = feature_options::delete($request->optionId);

        return response()->json(['data' => 'success']);
    }

    public function ProductrgetLangvalue(Request $request)
    {
        $rowData = product_details::where('product_id', $request->transRow)
            ->where('lang_id', $request->lang)
            ->first(['title', 'description', 'info']);
//        dd($rowData);
        if (!empty($rowData)) {
            return \response()->json(['data' => $rowData]);
        } else {
            return \response()->json(['data' => false]);
        }
    }




    public function ProductstorelangTranslation(Request $request)
    {
        // dd($request->all());
        //		 return $request;
        $rowData = product_details::where('product_id', $request->id)
            ->where('lang_id', $request->lang_id_data)
            ->first();
        if ($rowData != null) {
            $rowData->update([
                'title'       => $request->title,
                'description' => $request->description,
                'info'        => $request->information,
//                'lang_id'     => $request->lang_id_data,
//                'product_id'  => $request->id,
            ]);
        } else {
            $parentRow = product_details::where('product_id', $request->id)->where('source_id', null)->first();
            // dd($parentRow);
            $attr = [

                'title'       => $request->title,
                'description' => $request->input('description'),
                'lang_id'     => $request->lang_id_data,
                'product_id'  => $request->id,
                // 'source_id' => $parentRow->id,
                'info'        => $request->input('information'),
            ];
            if ($parentRow != null) {
                $attr['source_id'] = $parentRow->id;
            }
            product_details::create($attr);
        }
        // return response()->json('success', _i('Translate Successfully !'));
        return response()->json(['status' => 'SUCCESS', 'title' => $request->title]);
    }

    public function productRequest()
    {
        if (request()->ajax()) {
            $users = RequestProduct::join('users', 'users.id', 'request_products.user_id')
                ->select('request_products.*', 'users.name')
                // ->orderByDesc('request_products.id')
                ->get();
            return DataTables::of($users)
                ->addColumn('user', function ($users) {
                    return $users->name;
                })
                ->rawColumns([
                    'user',
                ])
                ->make(true);
        }

        return view('admin.products.request_product');
    }

    public function productOutNotify()
    {
        if (request()->ajax()) {


            $products = ProductOutNotify::join('products', 'products.id', 'product_out_notify.product_id')
                ->join('product_details', 'products.id', 'product_details.product_id')
                ->select('product_out_notify.*', 'product_details.title', 'products.id')
                ->where('lang_id', Lang::getSelectedLangId())
                // ->orderByDesc('product_out_notify.id')
                ->get();


            return DataTables::of($products)
                ->addColumn('title', function ($products) {
                    return "<a href='" . route('home_product.show', [app()->getLocale(), $products->id]) . "' target='_blank'>" . $products->title . "</a>";
                })
                ->addColumn('user', function ($products) {
                    if (empty($products->user_id)) {
                        return _i('Visitor') . $products->email;
                    }
                    return User::find($products->user_id)->name;
                })
                ->rawColumns([
                    'title',
                    'user',
                ])
                ->make(true);
        }

        return view('admin.products.product_notify');
    }

    public function storeCustomFields(Request $request)
    {
        foreach ($request->fields as $code => $field) {
            $field = (object) $field;
            $row = ProductCustomField::updateOrCreate(
                [
                    'code' => $code
                ],
                [
                    'name' => $field->name,
                    'desc' => $field->desc,
                    'required' => isset($field->required) ? 1 : 0,
                    'sort' => $field->sort,
                    'type' => $field->type,
                    'product_id' => $request->product_id,
                    'code' => $code,
                    'lang_id' => Lang::getSelectedLangId(),

                ]
            );
            if (!isset($field->options)) continue;
            foreach ($field->options as $code => $option) {
                $option = (object) $option;
                ProductCustomFieldOption::updateOrCreate(
                    [
                        'code' => $code
                    ],
                    [
                        'name' => $option->name,
                        'price' => $option->price,
                        'custom_field_id' => $row->id,
                        'code' => $code,
                        'lang_id' => Lang::getSelectedLangId(),

                    ]
                );
            }
        }
        return response()->json('success');
    }

    public function showCustomFields(Request $request)
    {
        $fields = ProductCustomField::where('product_id', $request->product_id)->with('options')->orderBy('sort')->get();
        return $fields;
    }

    public function destroyCustomFieldOption(Request $request)
    {
        ProductCustomFieldOption::where('code', $request->code)->first()->delete();
        return response()->json('success');
    }

    public function destroyCustomField(Request $request)
    {
        $field = ProductCustomField::where('code', $request->code)->first();
        if ($field != NULL) {
            $field->options()->delete();
            $field->delete();
        }
        return response()->json('success');
    }

    public function getSimilarProducts(Request $request)
    {
        $products = Product::join('product_details', 'product_details.product_id', 'products.id')
            ->select('products.id', 'products.similar_products', 'product_details.title')
            ->where('product_details.lang_id', Lang::getSelectedLangId())
            ->get();

        return view('admin.products.partial.tab.modal')->with('products', $products);
    }

    public function similarProducts(Request $request)
    {
        $similar =     Product::where('id', $request->id)->first('similar_products');
        return $similar;
    }

    public function saveSimilarProducts(Request $request)
    {
        $similar =     Product::where('id', $request->id)->first();
        $similar->update([
            'similar_products' => $request->similar_products
        ]);
        return response()->json(['success']);
    }

    public function allProducts()
    {

        if (request()->ajax()) {
            $allProducts = Product::join('product_details', 'product_details.product_id', 'products.id')
                ->select('products.id', 'products.sku', 'product_details.title', 'product_details.product_id', 'product_details.lang_id')->where('product_details.lang_id', Lang::getSelectedLangId())->get();
            //			dd($allProducts);
            return DataTables::of($allProducts)
                ->addColumn('photo', function ($allProducts) {

                    $link = URL::to('/');
                    $url = $link . '/admin/qr_code/create/' . $allProducts->id . '';
                    return '<a href="javascript:printMe(' . $allProducts->id . ')"><img id="img-' . $allProducts->id . '" src="' . $url . '" data-name = "' . $allProducts->title . '" data-code = "' . $allProducts->sku . '"  border="0" width="100" class="img-rounded" align="center" /></a>';
                })
                ->rawColumns([
                    'photo',
                ])
                ->make(true);
        }

        return view('admin.products.allProducts');
    }

    public function allProductsQr()
    {

        $allProducts = Product::all();
        //dd($allProducts);
        return view('admin.products.allProductsQr', compact('allProducts'));
    }

    public function newSaveFeature(Request $request, $id)
    {

        //	dd($request->all());
        $feature_options = 0;

        $features = features::where('product_id', $id)->get();
        foreach ($features as $feature) {
            $feature_options += feature_options::where('feature_id', $feature->id)->sum('count');
        }
        $totalCount = Stock::where('product_id', $id)->sum('quantity');
        if ($totalCount - $feature_options < $request->feature_option_color_quantity) {
            return response()->json('error');
        }
        if ($totalCount - $feature_options < $request->feature_option_size_quantity) {
            return response()->json('error');
        }
        $newFeature = features::where("product_id", $id)->first();
        if ($newFeature == null) {
            $newFeature = features::create([
                'product_id' => $id
            ]);
            feature_data::create([
                'feature_id' => $newFeature->id,
                'title' => ($request->type == "color") ? _i("Color") : _i("Size"),
                'lang_id' => Lang::getSelectedLangId(),
                'type' => $request->type
            ]);
        }
        if ($request->type == "color") {
            $option = feature_options::create([
                'feature_id' => $newFeature->id,
                'price' => $request->feature_option_color_price,
                'count' => $request->feature_option_color_quantity
            ]);

            feature_option_data::create([
                'feature_option_id' => $option->id,
                'title' => $request->feature_option_color,
                'name' => $request->feature_option_color_name,
                'lang_id' => Lang::getSelectedLangId()
            ]);

            $image = $request->file('feature_option_color_image');
            if ($image != null) {
                $numberrand = rand(11111, 99999);
                $imageName = time() . $numberrand . '.' . $image->getClientOriginalExtension();
                $request->feature_option_color_image->move(public_path('uploads/products/features'), $imageName);
                FeatureImage::create([

                    'feature_option_id' => $option->id,
                    'url' => $imageName
                ]);
            }
            return response()->json(["status" => "ok", "data" => ["type" => "color"]]);
        } elseif ($request->type == "size") {

            $option = feature_options::create([
                'feature_id' => $newFeature->id,
                'price' => $request->feature_option_size_price,
                'count' => $request->feature_option_size_quantity
            ]);

            feature_option_data::create([
                'feature_option_id' => $option->id,
                'title' => $request->feature_option_size,
                'lang_id' => Lang::getSelectedLangId()
            ]);
            return response()->json(["status" => "ok", "data" => ["type" => "size"]]);
        }
        //}

        return response()->json(["status" => "nok"]);
    }

    public function updateFeature(Request $request, $id)
    {
        $option = feature_options::find($id);
        $feature_options = 0;
        $product_id = features::where('id', $option->feature_id)->first()->product_id;
        $features = features::where('product_id', $product_id)->get();
        // dd($features);
        foreach ($features as $feature) {
            $feature_options += feature_options::where('feature_id', $feature->id)->where('id', '!=', $id)->sum('count');
        }
        // dd($request->count);
        $totalCount = Stock::where('product_id', $product_id)->sum('quantity');
        //		 dd($totalCount);
        if ($totalCount - $feature_options < $request->count) {
            return response()->json(['error' => _i('Feature Quantity out of stock')]);
        }

        // if ($request->price < 0.1) return response()->json(['error' => _i('Feature price should be greater or equal 0.1')]);
        if ($request->count < 1) return response()->json(['error' => _i('Feature Quantity should be greater or equlal 1')]);

        $option->update([
            'price' => $request->price,
            'count' => $request->count + $option->sold,
        ]);

        $data = feature_option_data::where('feature_option_id', $option->id)->first();
        $data->update([
            'title' => $request->title,
            'name' => $request->name ?? $data->name
        ]);


        if ($request->file('image2')) {

            FeatureImage::where('feature_option_id', $id)->delete();
            $image = $request->file('image2');
            $numberrand = rand(11111, 99999);
            $imageName = time() . $numberrand . '.' . $image->getClientOriginalExtension();
            $request->image2->move(public_path('uploads/products/features'), $imageName);
            FeatureImage::create([

                'feature_option_id' => $option->id,
                'url' => $imageName
            ]);
        }
        return response()->json(['success' => _i('Inserted successfuly')]);
    }

    public function checkFeature($id)
    {

        $check = features::where('product_id', $id)->first();
        $check->type = feature_data::where('feature_id', $check->id)->first()->title;
        return response()->json($check);
    }

    //	public function save_detail(Request $request)
    //	{
    //dd($request->all());
    //		$data = Product_new::where("product_id", $request->row_product_id)->delete();
    //
    //		foreach ($request->title as $key => $value) {
    //			foreach ($request->title[$key] as $key2 => $value2) {
    //
    //
    //				$title = [];
    //				$desc = [];
    // 				$filter = [];
    //
    //				$title[$key] = $value2;
    //				$desc[$key] = $request->detail[$key][$key2];
    //
    //
    //				foreach (Language::where('code', '!=', $key)->get() as $lang) {
    //					$title[$lang->id] = ($request->title[$lang->id][$key2]);
    //					$desc[$lang->id] = ($request->detail[$lang->id][$key2]);
    //  					$filter[$key2]   = ($request->filter[$key2]);
    //				}
    // 			    //   dd($filter);
    //				Product_new::create([
    //					'product_id' => $request->row_product_id,
    ////					'title' => $title,
    ////					'description' => $desc,
    //					'active' =>   $filter ? 1 : 0,
    //				]);
    //
    //
    //			}
    //    	break;
    //		}
    //
    //		return json_encode('success');
    //	}



    public function get_translate_feature(Request $request, $id)
    {

        $lang_id = Lang::getSelectedLangId();
        $features = features::leftJoin('features_data', 'features_data.feature_id', 'features.id')
            ->where('features.product_id', $id)->whereNull('features_data.source_id')
            ->select('features.id as id', 'features.product_id as product_id', 'type', 'title', 'features_data.id as features_data_id', 'features_data.source_id')
            ->get();

        $featuresNotNull = features::leftJoin('features_data', 'features_data.feature_id', 'features.id')
            ->where('features.product_id', $id)->whereNotNull('features_data.source_id')
            ->select('features.id as id', 'features.product_id as product_id', 'type', 'title', 'features_data.id as features_data_id', 'features_data.source_id')
            ->get();


        foreach ($features as $feature) {
            $features_option = feature_options::leftJoin('feature_options_data', 'feature_options_data.feature_option_id', 'feature_options.id')
                ->select('feature_options.*', 'feature_options_data.title', 'feature_options_data.id as option_data_id', 'feature_options_data.name', 'feature_options_data.lang_id', 'feature_options_data.source_id')
                ->where('feature_options.feature_id', $feature->id)->whereNull('feature_options_data.source_id')
                ->get();

            $feature['optionsSourceNull'] = $features_option;


            $features_option = feature_options::leftJoin('feature_options_data', 'feature_options_data.feature_option_id', 'feature_options.id')
                ->select('feature_options.*', 'feature_options_data.title', 'feature_options_data.id as option_data_id', 'feature_options_data.name', 'feature_options_data.lang_id', 'feature_options_data.source_id')
                ->where('feature_options.feature_id', $feature->id)->whereNotNull('feature_options_data.source_id')
                ->get();
            $feature['optionsSourceNotNull'] = $features_option;
        }

        $html = view('admin.products.products.includes.TranslateFeature_row', compact('features', 'featuresNotNull'))->render();
        return json_encode($html);
    }

    public function saveTranslateFeature(Request $request)
    {

        $feature = feature_option_data::where('id', $request->option_data_id)->first();

        $featurecount = feature_option_data::where('source_id', $request->option_data_id)->first();

        if (isset($featurecount)) {
            if ($request->option_data_type == 'color') {
                $product_details = $featurecount->update([

                    'name' => $request->translate,

                ]);
            } else {
                $product_details = $featurecount->update([

                    'title' => $request->translate,

                ]);
            }
        } else {
            if ($request->option_data_type == 'color') {
                $product_details = feature_option_data::create([

                    'feature_option_id' => $feature->feature_option_id,
                    'name' => $request->translate,
                    'title' => $feature->title,
                    'lang_id' => 1,
                    'source_id' => $feature->id,
                ]);
            } else {
                $product_details = feature_option_data::create([

                    'feature_option_id' => $feature->feature_option_id,
                    'name' => $feature->name,
                    'title' => $request->translate,
                    'lang_id' => 1,
                    'source_id' => $feature->id,
                ]);
            }
        }




        return response()->json(['success']);
    }

    public function saveTranslateFeatureType(Request $request)
    {

        $feature = feature_data::where('id', $request->id)->first();

        $featurecount = feature_data::where('source_id', $request->id)->first();

        if (isset($featurecount)) {

            $product_details = $featurecount->update([

                'title' => $request->translateType,

            ]);
        } else {
            $product_details = feature_data::create([

                'feature_id' => $feature->feature_id,
                'type' => $feature->type,
                'title' => $request->translateType,
                'lang_id' => 1,
                'source_id' => $feature->id,
            ]);
        }




        return response()->json(['success']);
    }

    public function get_translate_fields(Request $request, $id)
    {

        $lang_id = Lang::getSelectedLangId();
        $fieldsEn = ProductCustomField::where('product_id', $id)->whereNull('source_id')->get();
        $fieldsAr = ProductCustomField::where('product_id', $id)->whereNotNull('source_id')->get();
        //        dd($fields);

        $html = view('admin.products.products.includes.TranslateCustomFields_row', compact('fieldsEn', 'fieldsAr'))->render();
        return json_encode($html);
    }

    public function saveTranslateFields(Request $request)
    {

        $feature = ProductCustomField::where('id', $request->option_data_id)->first();

        $featurecount = ProductCustomField::where('source_id', $request->option_data_id)->first();

        if (isset($featurecount)) {
            $product_details = $featurecount->update([

                'name' => $request->translate,
                'desc' => $request->translateDesc,

            ]);
        } else {
            $product_details = ProductCustomField::create([

                'name' => $request->translate,
                'desc' => $request->translateDesc,
                'lang_id' => 1,
                'required' => 1,
                'sort' => $feature->sort,
                'type' => $feature->type,
                'product_id' => $feature->product_id,
                'code' => $feature->code,
                'source_id' => $feature->id,
            ]);
        }




        return response()->json(['success']);
    }
    public function getlang(\Illuminate\Http\Request $request)
    {
        $lang = Language::where('id', $request->lang_id)->first();
        if ($lang) {
            return Response::json($lang->title);
        }
    }
}
