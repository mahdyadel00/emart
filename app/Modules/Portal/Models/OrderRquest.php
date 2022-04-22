<?php

namespace App\Modules\Portal\Models;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Models\Products\products;

class OrderRquest extends Model
{
	protected $table   = 'orders_requests';
	protected $guarded = [];


    public function products()
    {
        return $this->belongsToMany(products::class, 'orders_requests_products', 'order_request_id', 'product_id');
    }
}
