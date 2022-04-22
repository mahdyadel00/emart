<?php

namespace App\Bll;

use App\Setting;
use App\Models\Blog\BlogCategory;
use App\Modules\Portal\Models\SitePage;
use App\Modules\Admin\Models\Pages\SubPages;
use App\Modules\Portal\Models\ContentSection;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Sections\Sections;
use App\Modules\Admin\Models\Services\Services;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Services\ServicesData;

class Site
{
    public static function getCategoriess($categories,  &$result)
	{

		//dd($categories);
		$items = Category::get()->toArray();
		$data = CategoryData::get()->toArray();
		$trans = new Translate($items, $data, Lang::getSelectedLangId());
		$data = $trans->getData("category_id", ["title", "lang_id", "category_id"]);

		// foreach ($categories as $cat) {

		// 	self::getChildren($cat, $data, $result,  0);
		// }
	}
    public static function getContent()
    {
        $sections = Sections::leftJoin('sections_data', 'sections_data.section_id', 'sections.id')
            ->where('sections_data.lang_id', Lang::getSelectedLangId())
            ->where('published', 1)
            ->orderBy('display_order', 'asc')->get();
        return $sections;
    }

    public static function getPagesFooter()
    {
        $pages = SitePage::with('data')
            ->where('published', 1)
			->where('place', 'footer')
            ->orderBy('page_order')
			->get();
 		return $pages;
    }

    public static function getPagesHeader()
    {
        $pages = SitePage::leftJoin('site_pages_data','site_pages_data.page_id','site_pages.id')
            ->select('site_pages.id','site_pages_data.title')
            ->where('published', 1)
            ->where('place', 'header')
            ->where('lang_id', Lang::getSelectedLangId())
            ->orderBy('page_order')
            ->get();
        return $pages;
    }

    public static function blogCategory(){
        $blog_categories = BlogCategory::with('data','blogs.data')->where('active',1)->get();
        return $blog_categories;
     }


    public static function getCategories()
    {
        $cats = Category::with('translation','productss.prods.translation','children')
             ->whereNull("parent_id")
			 ->get();

 		return $cats;
    }

    public static function getCategoryChildren($catId)
    {
        $cats = Category::with('translation','productss.prods.translation','children')
            ->where("parent_id", $catId)
            ->get();
        return $cats;
    }

    static function get_all_categories()
    {
        return Category::join('categories_data', 'categories.id', 'categories_data.category_id')
            ->select('categories.id', 'categories.image', 'categories_data.title', "parent_id")
            //->whereNull('parent_id')
            ->where('categories_data.lang_id', Lang::getSelectedLangId())
            ->with("children")
            ->get();
    }


    public static function getSubPages()
    {
        $sub_pages = SitePage::leftJoin('site_pages_data', 'site_pages_data.page_id', 'site_pages.id')
            ->select('site_pages.image', 'site_pages_data.*')
            ->where('site_pages_data.lang_id', Lang::getSelectedLangId())
            ->where('site_pages.place', "home")
            ->orderBy('site_pages.id', 'desc')->take(3)->get();

//        $sub_pages = SubPages::leftJoin('sub_pages_data', 'sub_pages_data.page_id', 'sub_pages.id')
//            ->select('sub_pages.image', 'sub_pages_data.*')
//            ->where('sub_pages_data.lang_id', Lang::getSelectedLangId())
//            ->orderBy('sub_pages.order', 'asc')->take(3)->get();
        return $sub_pages;
    }

    public static function getSettings()
    {
        $setting = Setting::join('settings_data', 'settings.id', 'settings_data.setting_id')
            ->select(
                'settings_data.id',
                'settings_data.title',
                'settings.id as setting_id',
                'settings_data.lang_id',
                'settings.logo',
                'settings.facebook_url',
                'settings.twitter_url',
                'settings.youtube_url',
                'settings.instagram_url',
                'settings.order_accept',
                'settings.product_rating',
                'settings.product_outStock',
                'settings.discount_codes',
                'settings.similar_products',
                'settings.chat_mode',
                'settings.chat_code',
                'settings.phone1',
                'settings.phone2',
                'settings.customer_count',
                'settings.projects_count',
            )
            ->where('settings_data.lang_id', Lang::getSelectedLangId())
            ->first();
        if($setting == null)
            $setting = Setting::first();
        return $setting;
    }


    public static function getServices()
    {
        $services = Services::leftJoin('services_data', 'services_data.service_id', 'services.id')
            ->select('services_data.title', 'services.id')
            ->where('services_data.lang_id', Lang::getSelectedLangId())->where('services.status', 1)
            ->get();
        return $services;
    }


    public static function catProducts()
    {
         $cats = Category::join('categories_data', 'categories.id', 'categories_data.category_id')
            ->select('categories.id', 'categories.image', 'categories_data.title', "parent_id")
            //->whereNull('parent_id')
            ->where('categories_data.lang_id', Lang::getSelectedLangId())
            ->with("children")
            ->get();

        $products = Product::leftJoin('product_details','product_details.product_id','products.id')
            ->select('products.id','product_details.title')
            ->where('product_details.lang_id', Lang::getSelectedLangId())
            ->where('products.hidden', 0)->get();
        return $products;
    }

    public static function getProCategories()
    {
        $categories = Category::leftJoin('categories_data', 'categories_data.category_id', 'categories.id')
            ->whereNull("parent_id")
            ->select('categories.image','categories_data.title','categories_data.description','categories_data.category_id','categories.number')
            ->where('categories_data.lang_id', Lang::getSelectedLangId())->orderBy('number', 'asc')->take(10)->get();

        return $categories;
    }
}
