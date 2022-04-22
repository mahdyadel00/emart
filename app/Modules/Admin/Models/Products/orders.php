<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    public $timestamps = true;

    protected $table = 'orders';

    protected $primaryKey = "id";

    protected $softDelete = true;

    protected $guarded = [];

    public function gettransactions()
    {
        return $this->belongsTo(Transaction::class, 'id', 'order_id');
    }
    public function track()
    {
        return $this->belongsTo(\App\Models\Order_track::class, 'id', 'order_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function shipping_option()
    {
        return $this->hasOne('App\Models\Shipping\Shipping_option', 'id', 'shipping_option_id');
    }

    public function shipping()
    {
        return $this->belongsTo('App\Models\product\Shipping', 'id', 'order_id');
    }
    //     modified by WFHKB

    public function addresses()
    {
        return $this->hasMany('App\Models\product\Shipping', 'order_id');
    }

    public function store()
    {
        return $this->hasOne('App\Models\product\stores', 'id', 'store_id');
    }

    public function orderProducts()
    {
        return $this->hasMany('App\Models\product\order_products', 'order_id', 'id');
    }

    public function products()
    {
        return $this->hasManyThrough(products::class, 'App\Models\product\order_products', 'order_id', 'id', 'id', 'product_id');
    }

    public function features()
    {
        return $this->belongsToMany(features::class, 'order_feature_options', 'order_id', 'feature_option_id');
    }
    public function options()
    {
        return $this->hasMany(order_feature_options::class, "order_id", "id");
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transactions', 'order_id', 'type_id')->withPivot(
            'status',
            'bank_id',
            'total',
            'currency',
            'discount_code',
            'holder_name',
            'holder_card_number',
            'holder_cvc',
            'holder_expire'
        );
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'order_id');
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'order_tax', 'order_id', 'tax_id');
    }
    public function shippingMethod()
    {
        return $this->belongsTo('ShippingMethod');
    }

    public function discount()
    {
        return $this->belongsTo('DiscountCodes');
    }
}
