<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['pivot'];


    public function translation()
    {
        $cat = $this->hasOne(CategoryData::class, 'category_id', 'id') ? $this->hasOne(CategoryData::class, 'category_id', 'id')->where('lang_id', Lang::getSelectedLangId()) : $this->hasOne(CategoryData::class, 'category_id', 'id');
        // if ($cat->first() == null)
        //     $cat = $this->hasOne(CategoryData::class, 'category_id', 'id');

        return $cat;
    }

    public function Data(){
        return $this->hasMany(CategoryData::class, 'category_id');
    }

    public function getImage()
    {
        $find = $this->image;
        if ($find != null)
            return $find;
        return "/images/placeholder.png";
    }

    public function getImageAttribute($value)
    {
        if (\request()->is('api/*')) {
            return url($value);
        }
        return $value;
    }

    public function products()
    {
        return $this->belongsToMany(products::class, 'categories_products', 'category_id', 'product_id');
    }

    public function productss()
    {
        return $this->hasMany(category_product::class, 'category_id');
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function childrenV2()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function grandchildren()
    {
        return $this->children()->with('grandchildren');
    }

    //	public function children()
    //	{
    //		return $this->hasMany(Category::class,'parent_id','id')->with('translation');
    //	}
    function flatten($array)
    {
        $result = [];
        foreach ($array as $item) {
            if (is_array($item)) {
                $result[] = array_filter($item, function ($array) {
                    return !is_array($array);
                });
                $result = array_merge($result, $this->flatten($item));
            }
        }
        return array_filter($result);
    }

    public function feature()
    {
        return $this->hasOne(CategoryFeature::class);
    }

    public function childCount()
    {
        $category = $this;
        $categoriesv2 = $category->flatten($category->grandchildren->toArray());
        return count($categoriesv2);
    }
    public function parentv2()
    {
        return $this->where('id', $this->parent_id)->first();
    }
    public function listAllParents()
    {
        $board = $this;
        $parents = [];
        while (!is_null($board->parent_id) && $board->parent_id != 0) {
            $board = $board->parentv2();
            $parents[] = $board;
        }
        return $parents;
    }
}
