<?php

namespace App\Modules\Admin\Models;

use App\Bll\Lang;
 use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Models\SectionData;
use App\Modules\Admin\Models\Settings\Banner;
use App\Modules\Admin\Models\Services\Services;
use App\Modules\Admin\Models\Settings\SuccessPartner;
 use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\products;

class SectionProducts extends Model
{
	protected $table = 'section_products';
	protected $guarded = [];


    public function sections()
    {
        return $this->hasOne('App\Modules\Admin\Models\Section','section_id','section_id');
    }
    public function products()
    {
        return $this->hasOne('App\Modules\Admin\Models\Products\Product','product_id','product_id');
    }
}
