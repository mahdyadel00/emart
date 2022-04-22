<?php

namespace App\Http\Controllers\API;

use App\Bll\ProductClass;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected function index(Request $request)
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

            $product = new ProductClass($lang_id, $request);
            $products = $product->getAll($lang_id);

            if ($request->title) {
                $products = $products->whereHas(
                    'data',
                    function ($query) use ($lang_id, $request) {

                        $query->where([
                            'lang_id' => $lang_id,
                            'title' => $request->title,
                        ])->select('product_id', 'title');
                    },
                );
            }
            if ($request->cat_id) {
                $products = $products->whereHas(
                    'category_product',
                    function ($query) use ($request) {

                        $query->where('category_id', $request->cat_id);
                    },
                );
            }
            //  $products = $products->skip($request->page)->limit($request->limit)->get();
            $products = $products->paginate($perPage = $request->limit);
            if ($products->isEmpty()) {
                $errors['products'] = 'Products Not Found';
                $response['errors'] = $errors;
                $response['data'] = [];
                $response['page'] = $request->page;
                $response['limit'] = $request->limit;
                $response['code'] = 200;
                $response['status'] = false;
            } else {
                $arr = $products->toArray();
                unset($arr["first_page_url"]);
                unset($arr["last_page_url"]);
                unset($arr["links"]);
                unset($arr["next_page_url"]);
                unset($arr["path"]);
                unset($arr["prev_page_url"]);
                unset($arr["to"]);
                $response['data'] = $arr;
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
    } //End OF Index

    protected function single(Request $request, $id)
    {
        $errors = [];
        $lang = $request->language;
        $language = Language::where('code', $lang)->first();
        $lang_id = $language->id;

        $product = new ProductClass($lang_id, $request);
        $products = $product->singleProduct($id);

        // if ($products->isEmpty()) {
        //     $errors['products'] = 'Products Not Found';
        // }

        return response(['data' => $products, 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);
    }
}
