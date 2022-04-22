<?php

namespace App\Modules\Portal\Controllers;

use App\Bll\Lang;
use App\Bll\Site;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\product\products;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Products\CategoryProduct;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\product_details;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ProductsController extends Controller
{

    public function category($cat_id)
    {
        $lang_id = Lang::getSelectedLangId();
        $category = Category::join('categories_data', 'categories_data.category_id', 'categories.id')
            ->whereNull("parent_id")
            ->select('categories.image','categories_data.title','categories_data.description','categories_data.quality','categories_data.category_id','categories.number')
            ->where('categories_data.lang_id', $lang_id)
            ->where('category_id', $cat_id)

            ->first();
        if($category == null){
            return view('site.not_found');
        }

        $product_ids  = CategoryProduct::where("category_id", $cat_id)->pluck('product_id')->toArray();
        $products = \App\Modules\Admin\Models\Products\products::whereIn("products.id", $product_ids)
            ->join("product_details", "product_details.product_id", "products.id")
            ->select("products.*", "product_details.title", "product_details.description", "product_details.info")
            ->where('product_details.lang_id', $lang_id)
            ->where("hidden", "!=" ,0)
            ->simplePaginate(12);
        $subCategories = Site::getCategoryChildren($cat_id);
        return view('site.products.category.index', compact('category','products','subCategories'));
    }


    public function product($pro_id)
    {
        $lang_id = Lang::getSelectedLangId();
        $product = \App\Modules\Admin\Models\Products\products::where("products.id", $pro_id)
            ->join("product_details", "product_details.product_id", "products.id")
            //->leftJoin("product_photos", "product_photos.product_id", "products.id")
            ->select("products.*", "product_details.title", "product_details.description", "product_details.info")
            ->where('product_details.lang_id', $lang_id)
            //->where('product_photos.main', 1)
            ->where("products.hidden", "!=" ,0)
            ->first();

        if($product == null){
            return view('site.not_found');
        }

        $catIds = CategoryProduct::where("product_id", $pro_id)->pluck('category_id')->toArray();
        $product_ids  = CategoryProduct::whereIn("category_id", $catIds)->pluck('product_id');
        $products = \App\Modules\Admin\Models\Products\products::whereIn("products.id", $product_ids)
            ->join("product_details", "product_details.product_id", "products.id")
            ->select("products.*", "product_details.title", "product_details.description", "product_details.info")
            ->where('products.id', "!=", $pro_id)
            ->where('product_details.lang_id', $lang_id)
            ->where("hidden", "!=" ,0)
            ->simplePaginate(12);
        return view('site.products.single_product', compact('product','products'));
    }

    protected function categoryProduct(){

        $cats = Category::with('translation')
        ->where('parent_id', null)
        ->get();
        return view('site.products.category.all_categories', compact('cats'));
    }





}
