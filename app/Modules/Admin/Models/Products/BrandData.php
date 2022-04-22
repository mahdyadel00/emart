<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandData extends Model
{
    protected $table = 'brands_data';
    public $timestamps = true;
    protected $guarded = [];
}
