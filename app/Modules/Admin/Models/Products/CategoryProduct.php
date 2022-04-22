<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{

    protected $table = 'categories_products';
    public $timestamps = true;

    protected $guarded = [];
    protected $hidden = ['productss'];

    public function cates()
    {
        return $this->hasOne('App\CategoryData','category_id','category_id');
    }
    public function prods()
    {
        return $this->hasOne('App\Models\product\product_details','product_id','product_id');
    }

    public function product_photos() {
        return $this->hasMany('App\Models\product\product_photos', 'product_id', 'id');

    }


}
