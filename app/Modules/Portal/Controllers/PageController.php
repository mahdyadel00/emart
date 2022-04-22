<?php

namespace App\Modules\Portal\Controllers;

use App\Bll\Lang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Portal\Models\SitePage;

class PageController extends Controller
{
	public function index($id)
	{
		$page = SitePage::join('site_pages_data', 'site_pages.id', 'site_pages_data.page_id')
					->where('site_pages.id', $id)
                    ->where('published', 1)
					->where('site_pages_data.lang_id', Lang::getSelectedLangId())
					->first();

		if( empty( $page ) ) return view('site.not_found');

		return view('site.pages.page_details' , compact('page'));
    }
}
