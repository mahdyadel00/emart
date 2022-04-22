<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_photos extends Model
{
    protected $table = 'product_photos';
    protected $guarded = [];
    public $hidden = ['id' , 'product_id' , 'lang_id' , 'source_id' , 'description' ,'created_at' , 'updated_at' , 'deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class,'id','product_id');
    }
    public function getPhotoAttribute($value)
    {
        if(\request()->is('api/*')){
            return url($value );
        }
        return $value;
    }
}
