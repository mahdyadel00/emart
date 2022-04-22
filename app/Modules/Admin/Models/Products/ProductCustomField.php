<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomField extends Model
{
    protected $table = 'custom_fields';
    protected $guarded = [];

    public function getNameAttribute($name)
    {
        return $name == NULL ? '' : $name;
    }

    public function getDescAttribute($desc)
    {
        return $desc == NULL ? '' : $desc;
    }

    public function options()
    {
        return $this->hasMany(ProductCustomFieldOption::class, 'custom_field_id');
    }
}
