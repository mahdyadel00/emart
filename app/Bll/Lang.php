<?php

namespace App\Bll;

use \App\Models\Language;
class Lang
{
    public static function getLanguages()
    {
        $languages = Language::all();
        return $languages;
    }

    public static function getSelectedLang()
    {
        $language = Language::where('code', session('locale'))->first();
        if ($language == null)
            return Language::first();
        return $language;
    }

    public static function getSelectedLangId()
    {
        $language = Language::where('code', session('locale'))->first();
        if ($language == null)
            return Language::first()->id;
        return $language->id;
    }

    public static function getLang($session)
    {
        $language = Language::where('code', $session)->first();
        if ($language == null) {
            return $language = Language::first()->id;
        } else {
            return $language['id'];
        }
    }

    public static function getLangDir()
    {
        return session()->get('locale') == 'en' ? 'ltr' : 'rtl';
    }

    public static function getLangCode()
    {
        return session()->get('locale');
    }
}
