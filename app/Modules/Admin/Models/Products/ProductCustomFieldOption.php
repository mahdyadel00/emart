<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomFieldOption extends Model
{
    protected $table = 'custom_fields_options';
    protected $guarded = [];

    public function getNameAttribute($name)
    {
        return $name == NULL ? '' : $name;
    }

    public function getPriceAttribute($price)
    {
        return $price == NULL ? '' : $price;
    }
}
