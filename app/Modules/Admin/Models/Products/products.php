<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use App\Modules\Portal\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{

//    use Favoriteable;
    // use SoftDeletes;

    protected $table = 'products';
    public $timestamps = true;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $hidden = ['pivot'];
    protected $appends = ['price_after_discount'];



    public function getPriceAfterDiscountAttribute()
    {
        $price_befor_discount = $this->price * $this->discount / 100;
        $price_after_dicount = $this->price - $price_befor_discount;

        return $price_after_dicount;

    }
    // protected $with = ['comments', 'comments.user', 'comments.reply'];

    public function data ()
    {
        return $this->hasMany(product_details::class, 'product_id', 'id');
    }

    public function sections()
	{
		return $this->belongsToMany(Section::class, 'section_products', 'product_id', 'section_id');
	}

    public function mainPhoto()
    {
        $find = $this->product_photos->where("main", "1")->first();
        if ($find != null)
            return $find->photo;
        return "/images/placeholder.png";
    }

//	public function mainPhoto()
//	{
//		return $this->hasOne('App\Models\product\product_photos', 'product_id', 'id');
//	}

    public function favorite()
    {
        return $this->hasOne(Favorite::class, 'favoriteable_id', 'id')->where('user_id', Auth::id());
    }

    public function lables() {
        return $this->belongsToMany(LabelData::class,'product_lables','product_id','lable_data_id');
    }
    public function getThumbnailAttribute()
    {
        $mainPhoto = $this->mainPhoto();
        $explode = explode('/', $mainPhoto);
        $imageName = end($explode);
        $thumbnail = 'uploads/products/' . $this->id . '/thumbnails/' . $imageName;
        if (file_exists($thumbnail)) return $thumbnail;
        return $mainPhoto;
    }

    public function offers()
    {
        return $this->hasOne(Offer_product::class, 'product_id', 'id');
    }

    public function offersFree()
    {
        return $this->hasOne(Offer_free_product::class, 'product_id', 'id');
    }

//	public function commessions ()
//	{
//		return $this->hasOne();
//	}

    public function getPhotoAttribute()
    {
        if (\request()->is('api/*')) {
            return url($this->mainPhoto());
        }
        return $this->mainPhoto();
    }

    public function getImageAttribute($value)
    {
        if (\request()->is('api/*')) {
            return url($value);
        }
        return $value;
    }

    public function Type()
    {
        $find = $this->product_type()->first();
        if ($find != null)
            return $find->id;
        return -1;
    }

    public function Category()
    {
        return $this->categories()->get();
    }

    public function donation()
    {
        return $this->hasOne(Donations::class, 'product_id');
    }

    public function digitals()
    {
        return $this->hasMany(\App\Models\Product_digital::class, 'product_id');
    }

    public function cards()
    {
        return $this->hasMany(\App\Models\Product_card::class, 'product_id');
    }

    // public function Donation() {
    // 	return $this->donations()->get();
    // }

    // public function donations() {
    // 	return $this->hasMany(Donations::class, 'product_id', 'id');
    // }

    public function singleProductDetails()
    {

        $find = $this->product_details()->where('lang_id', Lang::getSelectedLangId())->first();
        return $find;
    }

    public function product_type()
    {
        return $this->belongsTo(Product_type::class, 'product_type');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id');
    }

    public function features()
    {
        return $this->hasMany(features::class, 'product_id', 'id');
    }

    public function product_details()
    {
        return $this->hasMany(product_details::class, 'product_id', 'id', 'lang_id');
    }

    public function detailes()
    {
        $find = $this->hasOne(product_details::class, 'product_id', 'id')->where('lang_id', Lang::getSelectedLangId()) ??$this->hasOne(product_details::class, 'product_id', 'id');
        return $find;
    }

    public function product_photos()
    {
        return $this->hasMany(product_photos::class, 'product_id', 'id');
    }

    public function main_product_photo()
    {
        return $this->hasOne(product_photos::class, 'product_id', 'id')->whereMain(1);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id')->whereNull('comment_id');
    }

    public function translation()
    {
        $obj = $this->hasOne(product_details::class, 'product_id', 'id')->where('lang_id', Lang::getSelectedLangId());
        // if ($obj->first() == null)
        //     $obj = $this->hasOne(product_details::class, 'product_id', 'id');
        return $obj;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function video()
    {
        return $this->hasOne(ProductVideo::class, 'product_id');
    }

    public function vzt($product_id = NULL)
    {
        return ProductVisit::where('product_id', $product_id)->get();
    }

    public function all_visits()
    {
        return ProductVisit::get();
    }

    public function toFeedItem()
    {
        $lang = request()->segment(1);
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->title,
            'updated' => $this->updated_at,
            'link' => $lang . '/product/' . $this->id,
            'author' => 'Soin',
        ]);
    }

    public static function getFeedItems()
    {
        $lang = request()->segment(1);
        $lang = Language::where('code', $lang)->first();
        $lang_id = $lang->id;
        return products::join('product_details', 'product_details.product_id', 'products.id')
            ->select('products.id', 'products.created_at', 'products.updated_at', 'product_details.title')
            ->where('product_details.lang_id', $lang_id)
            ->take(30)
            ->get();
    }

    public function originCountry()
    {
        return $this->belongsTo(CountriesData::class, 'country_of_origin', 'country_id')->where('lang_id', Lang::getSelectedLangId());
    }

    public function checkStock()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }

    public function hasStock()
    {
        return $this->checkStock()->sum('quantity');
    }

    public function fields()
    {
        return $this->hasMany(ProductCustomField::class, 'product_id')->orderBy('sort');
    }
    public function price()
    {
        $user_currency = Utility::get_default_currency();
        $price = "";
        if ($this->product_type == '54')
            if ($this->donation) {
                $price = Utility::product_price_after_discount_new($this->donation->min_price, $this->discount, false, $this->currency_code, false, $user_currency)
                    . " " . $user_currency->short_name . Utility::product_price_after_discount_new($this->donation->max_price, $this->discount, false, $this->currency_code, false, $user_currency) . " "
                    . $user_currency->short_name;
            } else {
                $price = Utility::product_price_after_discount_new($this->price, $this->discount, false, $this->currency_code, false, $user_currency) . " " . $user_currency->short_name;
                if (!empty($this->discount))

                    $price .= $this->discount . " %-";
            }
    }


    public function getLabelData()
    {
        $label = ProductLabel::leftJoin('lables','lables.id','product_lables.lable_id')
            ->leftJoin('products','products.id','product_lables.product_id')
            ->leftJoin('lables_data','lables_data.lable_id','lables.id')
            ->leftJoin('product_lables_data','product_lables_data.item_id','product_lables.id')
            ->where('lables_data.lang_id', Lang::getSelectedLangId())
            ->where('product_lables_data.lang_id', Lang::getSelectedLangId())
            ->where('product_lables.product_id', $this->id)->where('product_lables.active', 1)
            ->select('lables_data.title','product_lables_data.value')->get();
        return $label ;

    }

}
