<?php

namespace App\Modules\Portal\Controllers;

use App\Bll\Lang;
use Illuminate\Http\Request;

use App\Modules\Portal\Models\Job;
use App\Http\Controllers\Controller;
use App\Modules\Portal\Models\SitePage;
use App\Modules\Portal\Models\JobAttatchment;


class AboutUsController extends Controller
{

    protected function index(){
        $page = SitePage::join('site_pages_data', 'site_pages.id', 'site_pages_data.page_id')
            ->where('place', 'about_us')
            ->where('site_pages_data.lang_id', Lang::getSelectedLangId())
            ->first();
//        $pages = SitePage::with('data')
//        ->where('published', 1)
//        ->where('place', 'about_us')
//        ->orderBy('page_order')->get();

        return view('site.pages.page_details' , compact('page'));
    }


}
