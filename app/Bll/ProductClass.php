<?php

namespace App\Bll;

use App\Modules\Admin\Models\Products\Product;
use Illuminate\Support\Facades\Request;

class ProductClass
{
    protected $lang_id;
    protected $request;
    protected $products;

    public function __construct($lang_id, $request)
    {

        $this->lang_id = $lang_id;
        $this->request = $request;
        $this->getProducts();
    }

    private function getProducts()
    {

        $this->products = Product::query()->select('products.id', 'price', 'currency_code', 'discount')->with([
            'data' => function ($query) {

                $query->select('product_id', 'title')
                    ->where('lang_id', $this->lang_id);

            },
        ])->with(['comments' => function ($query) {

            $query->select('product_id', 'stars');
        },
        ])->with([
            'category_product' => function ($query) {
                $query->select('category_id');
            },
        ]);
    }

    public function getAll($lang_id)
    {

        return $this->products->join("product_details","product_details.product_id","products.id")->where("product_details.lang_id",$lang_id)->with([
            'photo' => function($query){
                $query->select('product_id' , 'photo')->where('main' , 1);
            },
        ]);
    }

    public function singleProduct($id)
    {

        return $this->products->where('products.id', $id)
            ->with([
                'photo' => function($query){

                    $query->select('product_id' , 'photo',"main");
                },
            ])
            ->first();

    }

    public function productFilter()
    {

        if ($this->request->rate != null) {

            $this->products = $this->products->where(function ($query) {

                $query->comments->where('stars', $this->request->rate);
            });
        }
        if ($this->request->price != []) {

            $this->products = $this->products->whereIn('price', $this->request->price);
        }

        return $this->products;
    }

}
