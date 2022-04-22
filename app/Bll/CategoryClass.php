<?php

namespace App\Bll;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryProduct;

class CategoryClass
{
    public function category(){

        $categories = Category::query()
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            ->select('image', 'title', 'categories.id');

            return $categories;



    }

}
