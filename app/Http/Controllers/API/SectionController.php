<?php

namespace App\Http\Controllers\API;

use App\Bll\SectionClass;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\products;
use App\Modules\Admin\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    protected function section(Request $request)
    {
        $errors = [];
        $lang = $request->language;
        $language = Language::where('code', $lang)->first();
        $lang_id = $language->id;

        $sections = new SectionClass();
        $sections = $sections->section()
            ->where('sections_data.lang_id', $lang_id)->get();

        if ($sections->isEmpty()) {
            $errors['sections'] = 'Sections Not Found';
        } else {
            foreach ($sections as $section) {

                //$section_product = DB::table('section_products')->where('section_id', $section->section_id)->pluck('product_id')->toArray();

                // dd($section);

                $arr = $this->getProducts($lang_id, $request, $section);

                $section->products = $arr;
            }
        }

        return response()->json(['data' => $sections, 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);
    } //End Of Section
    private function getProducts($lang_id, $request, $section)
    {
        $products =  products::select('products.id', 'price', 'discount')
            ->with([
                'data' => function ($query) use ($lang_id, $request) {

                    $query->where('lang_id', $lang_id)->select('product_id', 'title');
                },
            ])->with([
                'product_photos' => function ($query) use ($request) {
                    $query->select('product_id', 'photo')->where("main", "1");
                },
            ])->with([
                'comments' => function ($comments) {

                    $comments->select('product_id', 'stars');
                },
            ])->join("section_products", "section_products.product_id", "products.id")->where("section_products.section_id", $section->id);


        $arr = $products->paginate($perPage = $request->limit)->toArray();
        unset($arr["first_page_url"]);
        unset($arr["last_page_url"]);
        unset($arr["links"]);
        unset($arr["next_page_url"]);
        unset($arr["path"]);
        unset($arr["prev_page_url"]);
        unset($arr["to"]);
        return $arr;
    }
    protected function sectionSingle(Request $request, $id)
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

            $sections = new SectionClass();
            $sections = $sections->section()
                ->where('sections.id', $id)
                ->where('sections_data.lang_id', $lang_id)->first();

            if ($sections == null) {
                $errors['sections'] = 'Sections Not Found';
            } else {
                $arr = $this->getProducts($lang_id, $request, $sections);

                $sections->products = $arr;
                $response['data'] = $sections;
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
    } // End of Single Section

    protected function homeSection(Request $request)
    {

        $errors = [];
        $lang = $request->language;
        $language = Language::where('code', $lang)->first();
        $lang_id = $language->id;

        $sections = new SectionClass();
        $sections = $sections->section()
            ->select('image', 'title', 'sections.id')
            ->where('sections_data.lang_id', $lang_id)->get();

        if ($sections->isEmpty()) {

            $errors['sections'] = 'Home Section Not Found';
        }

        return response()->json(['data' => $sections, 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);
    } // End Of Home Section

}
