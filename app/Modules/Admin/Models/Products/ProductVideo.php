<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideo extends Model
{
    protected $table = 'product_photos';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(products::class,'id','product_id');
    }

    public function getPhotoAttribute($value)
    {
        if(\request()->is('api/*')){
            return url($value );
        }
        return $value;
    }
}
