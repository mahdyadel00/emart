<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductLabelData extends Model
{
    protected $table = "product_lables_data";
    protected $guarded = [];

	// public function lables() {
	// 	return $this->belongsTo('App\Models\LabelData','lable_data_id','id');
	// }
}
