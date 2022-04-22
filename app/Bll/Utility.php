<?php

namespace App\Bll;

use App\DefaultImage;
use App\ImageAccount;
use App\Models\Language;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Products\Currency;
use App\Modules\Admin\Models\Products\CurrencyStore;
use App\Setting;
use Carbon\Carbon;

class Utility
{


    static function get_all_categories()
    {
        return Category::join('categories_data', 'categories.id', 'categories_data.category_id')
            ->select('categories.id', 'categories.image', 'categories_data.title', "parent_id")
            //->whereNull('parent_id')
            ->where('categories_data.lang_id', Lang::getSelectedLangId())
            ->with("children")
            ->get();
    }
    public static function dates($timestamp): string
    {
        $fullCreatedAt = preg_replace('/[[:space:]]/', ' - ', $timestamp);
        $oldTimeStamp = substr($fullCreatedAt, strrpos($fullCreatedAt, '- ') + 1);
        $newTimeStamp  = date("g:i a", strtotime($oldTimeStamp));
        $oldDateStamp = substr($fullCreatedAt, 0, strpos($fullCreatedAt, ' -'));
        $newDateStamp = \Illuminate\Support\Carbon::parse($oldDateStamp)->format('d M Y');
        $day = Carbon::parse($oldDateStamp)->format('l');
        $fullCreatedAt = str_replace(
            [$oldTimeStamp, $oldDateStamp],
            [$newTimeStamp, $newDateStamp],
            $fullCreatedAt
        );
        $result = substr($day, 0, 3).' - '.preg_replace('/[[:space:]]+-/', ' || ', $fullCreatedAt);
        return $result;
    }
    public static function getSelectedLang()
    {
        $language = Language::where('code', session('locale'))->first();
        if ($language == null)
            return Language::first();
        return $language;
    }
    public static function get_main_settings()
    {
        if (session("setting") != null)
            return session("setting");
        $setting = \App\Setting::join('settings_data', 'settings.id', 'settings_data.setting_id')
            ->select(
                'settings_data.id',
                'settings_data.title',
                'settings.id as setting_id',
                'settings_data.lang_id',
                'settings.logo',
                'settings.facebook_url',
                'settings.twitter_url',
                'settings.instagram_url',
                'settings.order_accept',
                'settings.product_rating',
                'settings.product_outStock',
                'settings.discount_codes',
                'settings.similar_products',
                'settings.chat_mode',
                'settings.chat_code'
            )
            ->where('settings_data.lang_id', Lang::getSelectedLangId())
            ->first();
        session()->put("setting", $setting);
        return $setting;
    }
    public static function get_site_settings()
    {
        $settings = Setting::join('settings_data', 'settings.id', 'settings_data.setting_id')
            ->where('settings_data.lang_id', Lang::getSelectedLangId())
            ->first();
        return $settings;
    }
    public static function get_default_images()
    {
        $images = DefaultImage::first();

        $user_image = ImageAccount::value('image_account');
        $data = (object) [
            'favicon' => asset('/uploads/default_images/' . $images->favicon),
            'header' =>
                file_exists('uploads/default_images/'  . $images->header) ? asset('/uploads/default_images/'  . $images->header) : asset('/uploads/default.svg'),
            'footer' => asset('/uploads/default_images/' .  $images->footer),
            'not_found' => asset('/uploads/default_images/' .  $images->not_found),
            'user_image' => !empty($user_image) ? asset('/uploads/image_accounts/' .  $user_image) : '',
        ];
        return $data;
    }
    public static function getAdminprofile()
    {
        $id = auth()->guard('admin')->id;
        $admin = \App\Models\User::where('id', $id)->first();
        return $admin;
    }
    public static function get_settings()
    {
        if (session("settings") == null) {


            session()->put("settings", \App\Setting::first());
        }
        return  session("settings");
    }
    public static function get_default_currency($admin = false)
    {
        if ($admin) {
            //			$currency = \App\Currency::where('is_default', 1)->where('published', 1)->first();
            $currency = Currency::where('is_default', 1)->first();
            if ($currency == NULL) {
                //				$currency = \App\Currency::where('published', 1)->first();
                $currency = Currency::first();
            }
            return $currency;
        }
        $currency_id = session()->get('currency_id');

        if (empty($currency_id)) {
            $currency = CurrencyStore::select('currency_store.*', 'currencies_data.name', 'currencies_data.short_name', 'currencies.flag', 'currencies.code')
                ->join('currencies_data', 'currency_store.currency_id', 'currencies_data.currency_id')
                ->join('currencies', 'currencies.id', 'currency_store.currency_id')->where('currency_store.is_default', 1)
                ->where('currencies_data.lang_id', Lang::getSelectedLangId())->first();

            if ($currency == null) {
                $currency = CurrencyStore::select('currency_store.*', 'currencies_data.name', 'currencies_data.short_name', 'currencies.flag', 'currencies.code')
                    ->join('currencies_data', 'currency_store.currency_id', 'currencies_data.currency_id')
                    ->join('currencies', 'currencies.id', 'currency_store.currency_id')
                    ->where('currencies_data.lang_id', Lang::getSelectedLangId())->first();
            }
            session()->put('currency_id', $currency->currency_id);
        } else {
            $currency = CurrencyStore::select('currency_store.*', 'currencies_data.name', 'currencies_data.short_name', 'currencies.flag', 'currencies.code')
                ->join('currencies_data', 'currency_store.currency_id', 'currencies_data.currency_id')
                ->join('currencies', 'currencies.id', 'currency_store.currency_id')
                ->where('currency_store.currency_id', $currency_id)
                ->where('currencies_data.lang_id', Lang::getSelectedLangId())->first();

            if ($currency == null) {
                $currency = CurrencyStore::select('currency_store.*', 'currencies_data.name', 'currencies_data.short_name', 'currencies.flag', 'currencies.code')
                    ->join('currencies_data', 'currency_store.currency_id', 'currencies_data.currency_id')
                    ->join('currencies', 'currencies.id', 'currency_store.currency_id')
                    ->where('currency_store.is_default', 1)
                    ->where('currencies_data.lang_id', Lang::getSelectedLangId())->first();
            }

            if ($currency == null) {
                $currency = CurrencyStore::select('currency_store.*', 'currencies_data.name', 'currencies_data.short_name', 'currencies.flag', 'currencies.code')
                    ->join('currencies_data', 'currency_store.currency_id', 'currencies_data.currency_id')
                    ->join('currencies', 'currencies.id', 'currency_store.currency_id')
                    ->where('currencies_data.lang_id', Lang::getSelectedLangId())->first();
            }

            session()->put('currency_id', $currency->currency_id);
        }
        //		dd($currency);

        return $currency;
    }
    public static function product_price_after_discount_new(
        $price,
        $discount,
        $quantity = false,
        $currency_code = false,
        $abort_currency_change = false,
        $currency = false
    ) {
        if (!$currency) $currency = get_default_currency();
        if (!$price) return 0;
        $price = floatval($quantity ? $price * $quantity * (100 - $discount) / 100 : $price * (100 - $discount) / 100);
        if ($abort_currency_change == false) {
            $price = floatval($price * $currency->rate);
        }
        $price = number_format($price, 2, '.', '');
        return $price;
    }

    public static function getCategories($categories,  &$result)
    {

        //dd($categories);
        $items = Category::get()->toArray();
        $data = CategoryData::get()->toArray();
//        dd(Lang::getSelectedLangId());
        $trans = new Translate($items, $data, Lang::getSelectedLangId());
        $data = $trans->getData("category_id", ["title", "lang_id", "category_id"]);

        foreach ($categories as $cat) {

            self::getChildren($cat, $data, $result,  0);
        }
    }
    public static function getChildren($cat, $data, &$result, $depth = 0)
    {

        //add category. Don't forget the dashes in front. Use ID as index

        $result[$cat->id] = (($depth > 0) ? "|" : "") . str_repeat('--', $depth) . $data[$cat->id]->title;
        //go deeper - let's look for "children" of current category
        if ($cat->children->count() > 0) {
            foreach ($cat->children as $child)
                self::getChildren($child, $data, $result, $depth + 1);
        }
    }
    public static function get_main_categories()
    {
        return Category::join('categories_data', 'categories.id', 'categories_data.category_id')
            ->select('categories.id', 'categories.image', 'categories_data.title')
            ->whereNull('parent_id')
            ->where('categories_data.lang_id', Lang::getSelectedLangId())
            ->get();
    }
    public static function currencies()
    {
        $currencies = Currency::
            join('currencies_data', 'currencies.id', 'currencies_data.currency_id')
            ->where('currencies_data.lang_id', Lang::getSelectedLangId())
            ->select('currencies.*')
            ->get();
        return $currencies;
    }
}
