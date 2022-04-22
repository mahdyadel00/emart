<?php

namespace App\Http\Controllers\API;

use App\Bll\ProductClass;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryProduct;
use App\Modules\Admin\Models\Products\Product;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    protected function filter(Request $request)
    {
        $errors = [];
        // $category_id = null;
        // $categories = null;
        // $products = null;
        // $product = null;

        $lang = $request->language;
        $language = \App\Models\Language::where('code', $lang)->first();
        $lang_id = $language->id;

        $products = new ProductClass($lang_id , $request);

        $result = $products->productFilter();
        dd($result);


        // if ($request->category_id != null) {
        //     $category_id = $request->category_id;
        // }
        //
        // if ($request->category_id) {
        //     $categories = Category::query()
        //         ->join('categories_data', 'categories.id', 'categories_data.category_id')
        //         ->select('title', 'description', 'category_id', 'parent_id')
        //         ->where('categories_data.category_id', $request->category_id)
        //         ->where('categories_data.lang_id', $lang_id)->get();
        //     if ($categories->isEmpty()) {
        //         $errors['Categories'] = 'Category Not Found';
        //     } else {
        //         foreach ($categories as $category) {
        //             $category_product = CategoryProduct::where('category_id', $category->category_id)->pluck('product_id')->toArray();

        //             $products = Product::query()
        //                 ->join('product_details', 'products.id', 'product_details.product_id')
        //                 ->join('product_photos', 'products.id', 'product_photos.product_id')
        //                 ->join('comments', 'products.id', 'comments.product_id')
        //                 ->select('title', 'price', 'currency_code', 'photo', 'stars', 'currency_code', 'product_details.product_id' , 'discount')
        //                 ->whereIn('products.id', $category_product)
        //                 ->where('product_details.lang_id', $lang_id)->get();
        //             $category->products = $products;

        //         }
        //     }

        // }
        //     $product= Product::query()
        //         ->join('product_details', 'products.id', 'product_details.product_id')
        //         ->join('product_photos', 'products.id', 'product_photos.product_id')
        //         ->join('comments', 'products.id', 'comments.product_id')
        //         ->select('title', 'price', 'currency_code', 'photo', 'stars', 'currency_code', 'product_details.product_id' , 'discount');
        //     if ($request->price) {

        //         $product = $product->whereBetween('price', $request->price);
        //     }if($request->rate){
        //         $product = $product->where('stars', 'like', '%' . $request->rate . "%");
        //     }
        //       $product =  $product->where('product_details.lang_id', $lang_id)->get();
        //     if ($product->isEmpty()) {
        //         $errors['Products'] = 'Products Not Found';
               
        //     }

       

        // return response()->json(['data' => [
        //     $categories, $product], 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);

    }
}
