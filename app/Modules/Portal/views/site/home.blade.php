@extends('site.layout.index')
@php
$site_settings = \App\Bll\Utility::get_site_settings();
@endphp


    <!--Nav Bar-->
    <div class="navv py-1">
        <div class="container-fluid pt-3 pb-2 ">
            <div class="upper">
                <div class="row">
                    <div class="col-3 logo pl-4 pt-2">
                        <a href="{{ route('home') }}">
                        <img class="ml-5"
                            src="{{ $site_settings->logo }}"
                            alt="">
                        </a>
                    </div>
                    <div class="col-5 search">
                        <input type="text" class="search-bar px-3" placeholder="Search the store">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="col-4 icons">
                        <div class="num">
                            <p class="m-0">Available 24/7 at</p>
                            <span class="num">{{ $site_settings->work_time }}</span>
                        </div>
                        <div class="heart">
                            <i class="fa fa-heart"></i>
                            <p>Wish Lists</p>
                        </div>
                        <div class="user">
                            <i class="fa fa-user"></i>
                            <p>sign in</p>
                        </div>
                        <div class="cart">
                            <a href="./cart.html">
                                <i class="fa fa-shopping-cart"></i>
                                <p>Cart </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lower pb-1">
                <div class="row pl-4 pt-3">
                    <div class="col-9">
                        <ul class="list-unstyled d-flex m-0">
                            <li style="margin-left: 35px;"><a href="#">New In</a></li>
                            <li><a href="#">Must Have</a></li>
                            <li><a href="#">Trend</a></li>
                            <li><a href="#">Theme Demos</a></li>
                            <li><a href="#">Child Themes</a></li>
                            <li><a href="#">Pages</a></li>
                            <li><a href="#">Buy Theme</a></li>
                        </ul>
                    </div>
                    <div class="col-3 d-flex justify-content-end pr-5 position-relative">
                        <span class="help mr-5 d-block position-relative">
                            @php
                                $lang_selected = \App\Bll\Lang::getSelectedLang();
                                $langs = \App\Bll\Lang::getLanguages();
                            @endphp
                            @foreach ($langs as $lang)
                                @if ($lang->code != $lang_selected->code)
                                    <a href="{{ route('change_language', $lang->code) }}">
                                        <i><img src="{{ asset('site') . '/' . $lang->flag }}" alt=""
                                            class="img-fluid" loading="lazy"></i>
                                        {{ $lang->title }}
                                    </a>
                                @endif
                            @endforeach
                        </span>
                        <span class="help mr-5 d-block position-relative">
                            <i class="fa fa-user pr-1" style="color: #0a6cdc;font-family: fontawesome;"></i>
                            <span>Help</span>
                        </span>
                        <span class="lang mr-4 pr-2 position-relative d-block">
                            <img class="mr-1"
                                src="https://cdn.shopify.com/s/files/1/0064/4435/1539/t/3/assets/i-lang-1.png?v=2188912747239887746"
                                alt="">
                            <span>EN/USD</span>
                            <div class="lang-list p-3">
                                <div class="EN pb-2">
                                    <img class="mr-1"
                                        src="https://cdn.shopify.com/s/files/1/0064/4435/1539/t/3/assets/i-lang-1.png?v=2188912747239887746"
                                        alt="">
                                    <span>EN</span>
                                </div>
                                <div class="USD">
                                    <img class="mr-1"
                                        src="https://cdn.shopify.com/s/files/1/0064/4435/1539/t/3/assets/i-currency-1_23x.png?v=11890214651498029047"
                                        alt="">
                                    <span>USD</span>
                                </div>
                                <div class="DE">
                                    <img class="mr-1"
                                        src="https://cdn.shopify.com/s/files/1/0064/4435/1539/t/3/assets/i-lang-2.png?v=7201868209134045156"
                                        alt="">
                                    <span>DE</span>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Fixed Side Menu-->
    <div class="fixed-side" style="flex-direction: column;">
        <div class="closee position-absolute">
            <i class="fa fa-chevron-right"></i>
        </div>
        <div class="cart">
            <a href="./cart.html">
                <i class="fa fa-shopping-cart"></i>
            </a>
        </div>
        <div class="camera">
            <span class="title">Recentley Viewed</span>
            <i class="fa fa-camera" style="opacity: .3;"></i>
            <span>Sorry, There are no products</span>
        </div>
        <div class="to-top">
            <div class="all">
                <i class="fa fa-arrow-up-long"></i>
                <span>TOP</span>
            </div>
        </div>
    </div>
    <div class="small-list position-fixed">
        <i class="fa fa-home pb-2 openn"></i>
        <i class="fa fa-arrow-up-long pt-2 pb-2 to-top-2"></i>
    </div>

    <!--solid NaveBar-->
    <div class="fixed-navv">
        <div class="row">
            <div class="col-10">
                <ul class="list-unstyled d-flex">
                    <li class="ml-2"><img
                            src="https://cdn.shopify.com/s/files/1/0064/4435/1539/files/ellamart.png?v=1617004938"
                            alt=""></li>
                    <li><a href="#">New In</a></li>
                    <li><a href="#">Must Have</a></li>
                    <li><a href="#">Trend</a></li>
                    <li><a href="#">Theme Demos</a></li>
                    <li><a href="#">Child Themes</a></li>
                    <li><a href="#">Pages</a></li>
                    <li><a href="#">Buy Theme</a></li>
                </ul>
            </div>
            <div class="col-2 d-flex justify-content-end">
                <div class="search">
                    <i class="fa fa-search"></i>
                </div>
                <div class="cart">
                    <a href="./cart.html">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--Responsive Nav-->
    <div class="res-navv">
        <div class="container-fluid px-5">
            <div class="row py-3 px-5">
                <div class="col-4">
                    <div class="menu">
                        <i class="fa fa-bars"></i>
                    </div>
                </div>
                <div class="col-4">
                    <div class="logo d-flex justify-content-center">
                        <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/files/logo-footer.png?v=1615513680"
                            alt="">
                    </div>
                </div>
                <div class="col-4">
                    <div class="cart text-right">
                        <a href="./cart.html">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="search position-relative">
            <input type="search" placeholder="Search" class="w-100">
            <i class="fa fa-search position-absolute"></i>
        </div>
        <div class="overlay"></div>
        <div class="toggle-menu">
            <ul class="list-unstyled">
                <li><a href="#">New In</a></li>
                <hr>
                <li><a href="#">Must Have</a></li>
                <hr>
                <li><a href="#">Trend</a></li>
                <hr>
                <li><a href="#">Theme Demos</a></li>
                <hr>
                <li><a href="#">Child Themes</a></li>
                <hr>
                <li><a href="#">Pages</a></li>
                <hr>
                <li><a href="#">Buy Theme</a></li>
                <hr>
                </ul>
            <div class="help">
                <p>Availabe 24/7 at <span class="num">(+84) 90 12345</span></p>
                <p>Wunschzettel</p>
                <p>Anmelden</p>
                <i class="fa fa-user"></i><span>Help</span>
            </div>
            <hr>
            <div class="currency">
                <p class="title">Currency</p>
                <div class="row">
              
                    <div class="col-6 mb-4">
                        <div class="usd">
                            <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/t/3/assets/i-currency-1_23x.png?v=11890214651498029047"
                                alt="">
                            <span>USD</span>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="en">
                            <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/t/3/assets/i-currency-3_23x.png?v=17755439837673696050"
                                alt="">
                            <span>GBP</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="de">
                            <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/t/3/assets/i-currency-2_23x.png?v=4240992007912646428"
                                alt="">
                            <span>EUR</span>
                        </div>
                    </div>
                </div>
                <p class="title">Languages</p>
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="en">
                            <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/t/3/assets/i-currency-3_23x.png?v=17755439837673696050"
                                alt="">
                            <span>EN</span>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="usd">
                            <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/t/3/assets/i-currency-1_23x.png?v=11890214651498029047"
                                alt="">
                            <span>USD</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!--Banner-->
    <div class="banner position-relative">
        <div class="desc">
            <h2><strong>Huge Saving</strong> on <br> UHD Televisions</h2>
            <p>Sale up to 70% off on selected items*</p>
            <button>Shop Now</button>
        </div>
        <img class="position-absolute"
            src="https://cdn.shopify.com/s/files/1/0064/4435/1539/files/slider-supermarket-1_8e7ff03d-fe3d-48e3-a8ce-0af729b9d4b1.jpg?v=1638361692"
            alt="">
    </div>

    <!--After Banner-->
    <section class="sec-one">
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-md-4 col-sm-6 pl-md-5 dad">
                    <i class="fa fa-truck"></i>
                    <span>Free Shipping & Returns</span>
                </div>
                <hr>
                <div class="col-md-4 col-sm-6 mid position-relative dad">
                    <i class="fa fa-certificate"></i>
                    <span>Lowest Price Guarantee</span>
                </div>
                <hr>
                <div class="col-md-4 col-sm-6 pr-md-5 mt-sm-3 mt-md-0 dad">
                    <i class="fa fa-trophy"></i>
                    <span>Longest Warranties Offer</span>
                </div>
            </div>
        </div>
    </section>

    <!--Section Two 5 Pics-->
    <section class="sec-two">
        <div class="container-fluid" style="padding: 20px 80px;">
            <div class="row">
                <div class="col-md-4 col-sm-6 dad">
                    <div class="img-parent">
                        <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/files/banner-custom-top-3-1_1024x1024_crop_center.jpg?v=1616145108"
                            alt="">
                        <div class="overlay"></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dad">
                    <div class="img-parent">
                        <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/files/banner-custom-top-3-2_1024x1024_crop_center.jpg?v=1616147842"
                            alt="">
                        <div class="overlay"></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 dad">
                    <div class="img-parent">
                        <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/files/banner-custom-top-3-3_1024x1024_crop_center.jpg?v=1616147850"
                            alt="">
                        <div class="overlay"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 dad">
                    <div class="img-parent">
                        <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/files/banner-custom-top-2-1_1024x1024_crop_center.jpg?v=1616150952"
                            alt="">
                        <div class="overlay"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 dad">
                    <div class="img-parent">
                        <img src="https://cdn.shopify.com/s/files/1/0064/4435/1539/files/banner-custom-top-2-2_1024x1024_crop_center.jpg?v=1616150962"
                            alt="">
                        <div class="overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Mahmoud-->

    <!--Flash Deals-->
    @include('site.layout.section_flash')

    <!--End Flash Deals-->

    <!--Shop By Category Deals-->
    @include('site.layout.shop_bycategory')

    <!--End Shop By Category Deals-->

 

    <!--Whats New-->
    @include('site.layout.whats_new')

    <!-- End Of Whats New-->

    <!--About New Section-->
    @include('site.layout.about')

    <!-- End Of About Section-->

    <!--Top Mobile Section-->
    @include('site.layout.top_mobile')

    <!-- End Of Top Mobile Section-->

    <!--Banner Section-->
    @include('site.layout.banner')

    <!-- End Of Banner Section-->
    
    <!--Top TV Section-->
    @include('site.layout.top_tv')

    <!-- End Of Top TV Section-->
    
    <!--Top Home Section-->
    @include('site.layout.top_home')

    <!-- End Of Top Home Section-->
    
    <!--Feature Products Section-->
    @include('site.layout.feature_product')

    <!-- End Of Feature Products Section-->
    
    <!--Feature Brands Section-->
    @include('site.layout.feature_brand')

    <!-- End Of Feature Brands Section-->
  
    
    <!--Shop With Section-->
    @include('site.layout.shop_with')

    <!-- End Of Shop With Section-->
    
    <!--Pop Body Section-->
    @include('site.layout.pop_body')

    <!-- End Of Pop Body Section-->
    
    <!--Footer Section-->

    <!-- End Of Footer Section-->
   


 
</body>

</html>