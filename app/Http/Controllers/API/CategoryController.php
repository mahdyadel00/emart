<?php

namespace App\Http\Controllers\API;

use App\Models\Language;
use App\Bll\CategoryClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\products;

class CategoryController extends Controller
{
    protected function index(Request $request)
    {
        $errors = [];

        $category_id = null;
        if ($request->category_id != null) {
            $category_id = $request->category_id;
        }
        $lang = $request->language;
        $language = Language::where('code', $lang)->first();
        $lang_id = $language->id;

        //get categories
        $categories = new CategoryClass();
        $categories = $categories->category()
            ->with([
                'children' => function ($query) use ($lang_id) {
                    $query->select("categories_data.category_id", 'parent_id', "title")->leftjoin("categories_data", "categories_data.category_id", "categories.id")->where("lang_id", $lang_id)->select("categories.id","image","title","parent_id");
                },
            ])

            ->with(['products' => function ($query) use ($lang_id, $request) {
                $query->select('products.id', 'price', 'discount')
                    ->with([
                        'data' => function ($query) use ($lang_id, $request) {

                            $query->where('lang_id', $lang_id)->select('product_id', 'title');
                        },
                    ])->with([
                        'product_photos' => function ($query) use ($request) {
                            $query->select('product_id', 'photo', 'tag');
                        },
                    ])->with([
                        'comments' => function ($comments) {

                            $comments->select('product_id', 'stars');
                        },
                    ]);
            }])->skip($request->page)->limit(5)

            ->where('categories_data.lang_id', $lang_id)->get();

        //    dd($categories[0]['products_count']);
        //    $count = $categories[0]['products_count'] / 5;
        //    dd(number_format($count));
        //    $categories->page_number = number_format($count);
        if ($categories->isEmpty()) {
            $errors['categories'] = 'Categroy Not Found';
        }

        return response(['data' => $categories, 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);
    } //End OF Index

    //get single category
    protected function singleCategory(Request $request, $id)
    {
        $errors = [];
        $lang = $request->language;
        $language = Language::where('code', $lang)->first();
        $lang_id = $language->id;

        $response = [
            'data' => [],
            'errors' => [],
            'code' => null,
            'status' => '',
        ];

        if (isset($request->limit)) {

            $find = Category::where("id",$id);

               $find = $find->with([
                    'children' => function ($query) use ($lang_id) {
                        $query->select("categories_data.category_id", 'parent_id', "title")->leftjoin("categories_data", "categories_data.category_id", "categories.id")->where("lang_id", $lang_id)->select("categories.id","image","title","parent_id");
                    },
                    'Data'=> function($q) use ($lang_id) { $q->where("lang_id",$lang_id)->select("category_id","title","image")->join("categories","categories.id","categories_data.category_id") ;}
                ])->select("id","image")->first();

            $products =  products::select('products.id', 'price', 'discount')
                ->with([
                    'product_details' => function ($query) use ($lang_id, $request) {

                        $query->where('lang_id', $lang_id)->select('product_id', 'title');
                    },
                ])->with([
                    'product_photos' => function ($query) use ($request) {
                        $query->select('product_id', 'photo', 'tag')->where("main", "1");
                    },
                ])->with([
                    'comments' => function ($comments) {

                        $comments->select('product_id', 'stars');
                    },
                ])->join("categories_products", "categories_products.product_id", "products.id")->where("categories_products.category_id", $id);




            if ($find== null) {

                $errors['categories'] = 'Categroy Not Found';
                $response['errors'] = $errors;
                $response['data'] = [];
                $response['page'] = $request->page;
                $response['limit'] = $request->limit;
                $response['code'] = 200;
                $response['status'] = false;
            } else {

                $arr = $products->paginate($perPage = $request->limit)->toArray();
                unset($arr["first_page_url"]);
                unset($arr["last_page_url"]);
                unset($arr["links"]);
                unset($arr["next_page_url"]);
                unset($arr["path"]);
                unset($arr["prev_page_url"]);
                unset($arr["to"]);
                $response = $find;
                $response["products"] = $arr; //$perPage = 15, $columns = ['*'], $pageName = 'users'


                $response['errors'] = [];
                $response['code'] = 200;
                $response['status'] = true;
            }
        } else {

            $errors['Limit'] = 'Limit Must be specified';
            $response['errors'] = $errors;
            $response['data'] = [];
            $response['page'] = $request->page;
            $response['limit'] = $request->limit;
            $response['code'] = 200;
            $response['status'] = false;
        }

        return response($response);
    } //End Of subCategory

    protected function homeCategory(Request $request)
    {

        $lang = $request->language;
        $language = Language::where('code', $lang)->first();
        $lang_id = $language->id;
        $errors = [];

        //get home categories
        $categories = new CategoryClass();
        $categories = $categories->category()
            ->where('categories_data.lang_id', $lang_id)->get();
        if ($categories->isEmpty()) {

            $errors['categories'] = 'Categories Not Found';
        }

        return response(['data' => $categories, 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);
    }
}
