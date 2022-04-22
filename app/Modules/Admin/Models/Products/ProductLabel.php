<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductLabel extends Model
{
    protected $table = "product_lables";
    protected $guarded = [];

    public function Data() {
        return $this->hasMany(ProductLabelData::class, 'item_id', 'id');
    }
    // public function value() {
    // 	return $this->hasOne(ProductLabelData::class ,'item_id','id')->where('lang_id',getLang());
    // }
    // public function another() {
    // 	return $this->hasOne(ProductLabelData::class ,'item_id','id')->where('lang_id','!=',getLang());
    // }
    public function Label ()
    {
        return $this->hasOne(Label::class, 'id', 'lable_id');
    }
}
