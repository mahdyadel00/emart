@php 
$site_settings = \App\Bll\Utility::get_site_settings();
@endphp

<div class="footer">
        <div class="container-fluid p-5">
            <div class="subscribe text-center">
                <div class="heading">
                    <h3>SUBSCRIBE TO OUR NEWSLETTER</h3>
                    <p>Get the latest updates on new products and upcoming sales</p>
                </div>
                <div class="inp">
                    <input type="text" placeholder="Entr your email address">
                    <button>Subscribe</button>
                </div>
            </div>
            <div class="row pt-5 px-4">
                <div class="col-sm-6 pb-sm-4 col-md-4 col-lg-3">
                    <h2 class="head">CATEGOIES</h2>
                    <p>Appliances</p>
                    <p>Computers & Laptops</p>
                    <p>Cameras</p>
                    <p>Mobile Phones & Tablets</p>
                    <p>Televisions</p>
                    <p>Video Games & Systems</p>
                    <p>Weekly Deals</p>
                </div>
                <hr>
                <div class="col-sm-6 pb-sm-4 col-md-4 col-lg-3">
                    <h2 class="head">FURTHER INFO.</h2>
                    <p>About us</p>
                    <p>Gift Certificates</p>
                    <p>Theme Styles</p>
                    <p>Contact us</p>
                    <p>Blog</p>
                    <p>Brands</p>
                    <p>Sitemap</p>
                </div>
                <hr>
                <div class="col-sm-6 pb-sm-4 col-md-4 col-lg-3">
                    <h2 class="head">CUSTOMER SERVICE</h2>
                    <p>Help & FAQs</p>
                    <p>Terms of Conditions</p>
                    <p>Privacy Policy</p>
                    <p>Online Returns Policy</p>
                    <p>Rewards Program</p>
                    <p>Rebate Center</p>
                    <p>Partners</p>
                </div>
                <hr>
                <div class="col-sm-6 pb-sm-4 col-md-4 col-lg-3 contact">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ $site_settings->logo }}"
                                alt="">
                        </a>
                    </div>
                    <!-- <div class="address d-flex">
                        <i class="fa fa-location-dot mr-4"></i>
                        <p>685 Market Street San Francisco, CA <br> 94105, US</p>
                    </div> -->
                    <div class="call d-flex">
                        <i class="fa fa-phone mr-4"></i>
                        <p>Call us at: {{ $site_settings->phone1 }}</p>
                    </div>
                    <div class="email d-flex">
                        <i class="fa fa-envelope mr-4"></i>
                        <p>Email: {{ $site_settings->email }}</p>
                    </div>
                    <hr>
                    <div class="social d-flex mt-3">
                        <i class="fab fa-facebook"></i>
                        <i class="fab fa-twitter"></i>
                        <i class="fab fa-instagram"></i>
                        <i class="fab fa-youtube"></i>
                        <i class="fab fa-tiktok"></i>
                        <i class="fab fa-pinterest"></i>
                    </div>
                </div>
            </div>
        </div>

  
        </body>

</html>