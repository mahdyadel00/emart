<!DOCTYPE html>
@if(\App\Bll\Lang::getLangCode()== "ar")
    <html lang="ar" dir="rtl"><!-- Change to RTL in Arabic version -->
@else
    <html lang="en" dir="ltr">
@endif

@php
    $settings = \App\Bll\Site::getSettings();
    $contentSection = \App\Bll\Site::getPagesFooter();
    $cats = \App\Bll\Site::getCategories();
    $catsBlog = \App\Bll\Site::blogCategory();
  //dd($cats);
 @endphp

@include('site.includes.style',['settings' => $settings])

<body>



@yield('content')


@include('site.layout.footer' ,['settings' => $settings ,'contentSection' => $contentSection])

@include('site.includes.script')

</body>

</html>
