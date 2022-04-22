<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class category_product extends Model
{

    protected $table = 'categories_products';
    public $timestamps = true;

	protected $guarded = [];

    public function cates()
    {
        return $this->hasOne(CategoryData::class,'category_id','category_id');
    }
	public function prods()
    {
        return $this->hasOne(products::class,'id','product_id')->where('hidden','!=',0);
    }

	public function product_photos() {
		return $this->hasMany(product_photos::class, 'product_id', 'id');

	}


}
