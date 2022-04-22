<?php

namespace App\Modules\Portal\Models;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SitePage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'site_pages';

    public function data()
	{
		return $this->hasOne(SitePageData::class ,'page_id','id')->where('lang_id',Lang::getSelectedLangId());
	}
}
