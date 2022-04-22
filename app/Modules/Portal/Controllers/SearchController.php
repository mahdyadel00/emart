<?php

namespace App\Modules\Portal\Controllers;

use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Products\product_details;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class SearchController extends Controller
{


    public function search(Request $request)
    {
        $key = $request->search_key;
        $query = product_details::join("products", "products.id", "product_details.product_id")
            //->joinSub("select photo,product_id from product_photos where main=1", "photos", "product_details.product_id", "photos.product_id")
            ->where("product_details.title", "like", "%" . $key . "%")
            ->where("products.hidden", "!=" ,0)
            ->where('product_details.lang_id', Lang::getSelectedLangId())
            ->select("product_details.product_id as pro_id", "title","description")
            ->get();

        $query_cat = CategoryData::join('categories', 'categories.id', 'categories_data.category_id')
            ->where("categories_data.title", "like", "%" . $key . "%")
            ->where('categories_data.lang_id', Lang::getSelectedLangId())
            ->select('categories_data.title', 'categories_data.category_id' , 'categories_data.description')
            ->get();
        //dd($query,$query_cat);

        // $mergedCollection = $query->toBase()->merge($query_cat);
        $mergedCollection = $query->concat($query_cat);

        // $query->put('products', $query_cat);
        // $query->push($query_cat);
        //$collection = $mergedCollection->simplePaginate(12);

        $data   = self::paginate($mergedCollection);

        return view('site.products.search', compact('data','key'));

    }
    private static function paginate($items, $perPage = 20, $page = null, $options = [])
    {
        $options['path'] = url()->current();
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
