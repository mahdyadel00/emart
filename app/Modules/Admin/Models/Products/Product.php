<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use App\Modules\Portal\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $appends = ['price_after_discount'];
    public $timestamps = true;

    public $fillable = ['similar_products'];
    public $hidden = ['category_product'];


    protected $casts = [
        'similar_products' => 'array',
    ];

    public function getPriceAfterDiscountAttribute()
    {
        $price_befor_discount = $this->price * $this->discount / 100;
        $price_after_dicount = $this->price - $price_befor_discount;

        return $price_after_dicount;

    }

    public function sections()
	{
		return $this->belongsToMany(Section::class, 'section_products', 'product_id', 'section_id');
	}

    public function category()
    {
        return $this->belongsTo('Category');
    }

    public function mainPhoto()
    {
        $find = $this->product_photos()->where("main", "1")->first();
        if ($find != null) {
            return $find->photo;
        }

        return "/images/placeholder.png";
    }


    public function category_product()
    {
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id');
    }

    public function order_product()
    {
        return $this->belongsToMany(OrderRequest::class, 'orders_requests_products', 'product_id' , 'order_id');
    }

    public function photo()
    {
        return $this->hasMany(product_photos::class, 'product_id', 'id');
    }
    public function product_photos()
    {
        return $this->hasMany(product_photos::class, 'product_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('Brand');
    }

    public function hasStock()
    {
        return $this->checkStock()->sum('quantity');
    }

    public function checkStock()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }

    public function type()
    {
        return $this->belongsTo('Type');
    }

    public function media()
    {
        return $this->hasMany('ProductMedia');
    }

    public function data()
    {
        return $this->hasMany(product_details::class, 'product_id', 'id');
    }
    public function product_details()
    {
        return $this->hasMany(product_details::class, 'product_id', 'id');
    }

    public function features()
    {
        return $this->hasMany(features::class, 'product_id', 'id');
    }

    public function translation()
    {
        $obj = $this->hasOne(product_details::class, 'product_id', 'id')->where('lang_id', Lang::getSelectedLangId());
        if ($obj->first() == null) {
            $obj = $this->hasOne(product_details::class, 'product_id', 'id');
        }

        return $obj;
    }

    public function detailes()
    {
        $find = $this->hasOne(product_details::class, 'product_id', 'id')->where('product_details.lang_id', Lang::getSelectedLangId());

        if ($find->first() == null) {
            $find = $this->hasOne(product_details::class, 'product_id', 'id');
        }

        return $find;
    }

    public function offers()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'product_id');
    }

}
