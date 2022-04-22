<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model
{
    public $timestamps = true;

    protected $table = 'orders_requests';

    protected $softDelete = true;

    protected $guarded = [];

    public function order_product()
    {
        return $this->belongsToMany(Product::class, 'orders_requests_products', 'order_id', 'product_id');
    }


}
