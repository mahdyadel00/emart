<!-- <head> -->
    <!-- Required meta tags -->
    <!-- <meta charset="utf-8"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

    <!-- @if(\App\Bll\Lang::getLangCode() == "ar") -->
    <!-- <link href="{{asset('site/css/bootstrap.rtl.min.css')}}" rel="stylesheet">Change to bootstrap.rtl in Arabic version -->
    <!-- @else -->
    <!-- <link href="{{asset('site/css/bootstrap.min.css')}}" rel="stylesheet"> -->
    <!-- @endif -->
    <!-- <link href="{{asset('site/css/all.min.css')}}" rel="stylesheet"> <!-- FontAwesome -->
    <!-- <link href="{{asset('site/css/slick.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('site/css/nice-select.css')}}" rel="stylesheet"> --> 
    <!-- Select 2 css -->
    <!-- <link rel="stylesheet" href="{{asset('AdminFlatAble/bower_components/select2/css/select2.min.css')}}" />


    @if(\App\Bll\Lang::getLangCode() == "ar")
    <link href="{{asset('site/css/rtl.css')}}" rel="stylesheet"><!-- Change to rtl.css in Arabic version -->
    <!-- @else -->
    <!-- <link href="{{asset('site/css/style.css')}}" rel="stylesheet"> -->
    <!-- @endif -->

    <!-- <link href="{{ asset('custom/parsley.css') }}" rel="stylesheet"> -->



    <!-- <title>{{$settings['title']}}</title> -->

    <!-- @stack('css') -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('site')}}/style/bootstrap.css">
    <link rel="stylesheet" href="{{asset('site')}}/style/home.css">
    <link rel="stylesheet" href="{{asset('site')}}/style/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{asset('site')}}/style/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('site')}}/fontawesome-free-6.1.0-web/css/all.css">
    <link rel="stylesheet" href="{{asset('site')}}/fontawesome-free-6.1.0-web/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap"
        rel="stylesheet" />
    <title>Ella Store</title>

</head>
