<?php

namespace App\Modules\Portal\Controllers;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Models\Language;
use App\Models\Blog\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Modules\Portal\Models\Comment;
use App\Modules\Admin\Models\Pages\Pages;
use App\Modules\Admin\Models\Pages\SubPages;
use App\Modules\Admin\Models\Sections\Sections;
use App\Modules\Admin\Models\Services\Services;
use Xinax\LaravelGettext\Facades\LaravelGettext;
use App\Modules\Admin\Models\Services\ServiceAttachment;
use App\Modules\Portal\Models\Job;

class HomeController extends Controller
{

    public function index(){

       // dd(session('lang_id'));
        $blogs = Blog::leftJoin('blogs_data','blogs_data.blog_id','blogs.id')
            ->select('blogs_data.*','blogs.id','blogs.image')
            ->where('blogs_data.lang_id', Lang::getSelectedLangId())->where('blogs.status', 1)
            ->orderBy('blogs.id', 'desc')->take(6)->get();

        $services = Services::leftJoin('services_data', 'services_data.service_id', 'services.id')
            ->select('services_data.*', 'services.id','services.image')
            ->where('services_data.lang_id', Lang::getSelectedLangId())->where('services.status', 1)
            ->orderBy('services.id', 'desc')
//            ->take(4)
            ->get();

        $reviews = Comment::with('user')->where('published',1)->get();


        return view('site.home' , compact('blogs','services','reviews'));
    }


    public function service($service_id)
    {
        $service = Services::leftJoin('services_data', 'services_data.service_id', 'services.id')
            ->select('services_data.*', 'services.id','services.image')
            ->where('services_data.lang_id', Lang::getSelectedLangId())->where('services.status', 1)
            ->where('services.id', $service_id)->first();
        if($service == null){
            return view('site.not_found');
        }
        $services = Services::leftJoin('services_data', 'services_data.service_id', 'services.id')
            ->select('services_data.*', 'services.id','services.image')
            ->where('services_data.lang_id', Lang::getSelectedLangId())->where('services.status', 1)
            ->where('services.id', "!=",$service_id)->get();

        $attachments = ServiceAttachment::where('service_id', $service_id)->get();
       // dd($attachments);
        return  view('site.blogs.single_service', compact('service','services','attachments'));
    }



    public function changeHomeLang($locale = null)
    {

        App::setLocale($locale);
        LaravelGettext::setLocale($locale);
        session()->put('locale', $locale);
        $language = Language::where('code', $locale)->first();
        if ($language != null) {
            session()->put('lang_id', $language['id']);
            session()->put('lang', $language['code']);
        }
        return  redirect()->back();
    }




}
