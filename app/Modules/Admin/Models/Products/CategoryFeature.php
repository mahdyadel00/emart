<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFeature extends Model
{
    protected  $table = 'category_features' ;
    protected  $fillable =[
        'category_id' ,
        'file',
    ] ;

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id') ;
    }
}
