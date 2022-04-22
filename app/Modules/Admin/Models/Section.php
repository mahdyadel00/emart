<?php

namespace App\Modules\Admin\Models;

use App\Bll\Lang;
 use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Models\SectionData;
use App\Modules\Admin\Models\Settings\Banner;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Services\Services;
use App\Modules\Admin\Models\Settings\SuccessPartner;
 use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\products;

class Section extends Model
{
	protected $table = 'sections';
	protected $guarded = [];


    public function Data()
	{
		return $this->hasMany(SectionData::class, 'section_id', 'id');
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'section_category', 'section_id', 'category_id');
	}

	public function banners()
	{
		return $this->belongsToMany(Banner::class, 'banner_section', 'section_id', 'banner_id');
	}

	public function services()
	{
		return $this->belongsToMany(Services::class, 'service_section', 'section_id', 'service_id');
	}

	public function partners()
	{
		return $this->belongsToMany(SuccessPartner::class, 'success_partner_section', 'section_id', 'success_partner_id');
	}

	public function translation()
	{
		return $this->hasOne(SectionData::class,'section_id','id')->where('lang_id', Lang::getSelectedLangId());
	}

	public function getImageAttribute($value)
	{
		if(\request()->is('api/*')){
			return url( $value);
		}
		return $value;
	}
    public function products()
	{
		return $this->belongsToMany(Product::class, 'section_products', 'section_id', 'product_id');
	}

}
