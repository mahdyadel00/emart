<?php

namespace App\Http\Controllers\API;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Portal\Models\SitePage;

class AboutUsController extends Controller
{
    protected function about(Request $request){

        $errors = [];
        $lang = $request->language;
        $language = Language::where('code', $lang)->first();
        $lang_id = $language->id;

        $about = SitePage::query()
                ->join('site_pages_data' ,'site_pages.id' , 'site_pages_data.page_id')
                ->select('image' , 'title' , 'content')
                ->where('place' , 'about_us')
                ->where('site_pages_data.lang_id' , $lang_id)->get();

        if($about->isEmpty()){

            $errors['about'] = 'About Not Found';
        }
        return response(['data' => $about, 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);
        
    }// end of about

    protected function privacy(Request $request){

        $errors = [];

        $lang = $request->language;
        $language = Language::where('code' , $lang)->first();
        $lang_id  = $language->id;

        $privacy = SitePage::query()
                    ->join('site_pages_data' , 'site_pages.id' , 'site_pages_data.page_id')
                    ->select('image' , 'title' , 'content')
                    ->where('place' , 'privacy')
                    ->where('site_pages_data.lang_id' , $lang_id)->get();
        if($privacy->isEmpty()){

            $errors['privacy'] = 'Privacy Not Found';
        }
        return response(['data' => $privacy, 'errors' => $errors, 'code' => '200', 'status' => 'success'], 200);

    }
}
