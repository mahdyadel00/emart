<?php

namespace App\Http\Controllers\API;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Settings\Banner;

class BannerController extends Controller
{
    protected function index(Request $request){

        $errors = [];
        $errors = [];
        $lang = $request->language;
        $language = Language::where('code', $lang)->first();
        $lang_id = $language->id;

        $banners = Banner::select('banners.*' , 'banners_data.title')
            ->join('banners_data' , 'banners.id' , 'banners_data.banner_id')
            ->select('image' , 'link' , 'banners_data.title' , 'banners_data.description')
            ->where('published' , 1)
            ->where('banners_data.lang_id' , $lang_id)->get();

            if($banners->isEmpty()){
                $errors['banners'] = 'Banners Not Found';
            }

        return response()->json(['data' => $banners, 'errors' => $errors , 'code' => '200', 'status' => 'success'], 200);

    }
}
