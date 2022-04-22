<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{

    protected $table = 'orders_requests_products';
    public $timestamps = true;

    protected $guarded = [];

    public function order_request()
    {
        return $this->hasOne(' App\Modules\Admin\Models\Products','order_request_id','order_request_id');
    }
    public function product()
    {
        return $this->hasOne('App\Modules\Admin\Models\Products','product_id','product_id');
    }




}
