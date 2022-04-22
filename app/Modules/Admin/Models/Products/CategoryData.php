<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryData extends Model
{
    protected $table = 'categories_data';
    public $timestamps = true;
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
