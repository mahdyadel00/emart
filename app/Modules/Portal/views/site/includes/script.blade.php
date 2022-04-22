<a class="go-top" href="#"><i class="fa fa-chevron-up"></i></a>

<!-- <script src="{{asset('site/js/jquery-3.3.1.min.js')}}"></script> -->
<!-- <script src="{{asset('site/js/bootstrap.bundle.min.js')}}"></script> -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.0/jquery.waypoints.min.js"></script>-->
<!--<script src="{{asset('site/js/jquery.counterup.min.js')}}"></script>-->
<!-- <script src="https://unpkg.com/counterup2@2.0.2/dist/index.js">	</script> -->
<!-- <script src="{{asset('site/js/slick.min.js')}}"></script> -->
<!-- <script src="{{asset('site/js/jquery.nice-select.min.js')}}"></script> -->

<!-- <script src="{{asset('site/js/custom.js')}}"></script> -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <script src="{{ asset('site') }}/script/home-script.js"></script>
<!-- {{--<script src="{{ asset('custom/bootstrap-notify.min.js') }}"></script>--}} -->
<!-- {{--<script src="{{ asset('custom/notify/notify.min.js') }}"></script>--}} -->
<!-- {{--<script src="{{ asset('custom/notify/notify.js') }}"></script>--}} -->
<!-- Select 2 js -->
<!-- <script type="text/javascript" src="{{asset('AdminFlatAble/bower_components/select2/js/select2.full.min.js')}}"></script> -->
<!-- Custom js -->
<!-- <script type="text/javascript" src="{{asset('AdminFlatAble/assets/pages/advance-elements/select2-custom.js')}}"></script> -->


<!-- <script src="{{ asset('custom/parsley.min.js') }}"></script> -->

@include('site.includes.js')

<!-- <script src="{{ asset('custom/notify/notify.min.js') }}"></script> -->

<!-- <script src="{{ asset('custom/notify/notify.js') }}"></script> -->
<!-- {{--<script src="{{ asset('custom/bootstrap-notify.min.js') }}"></script>--}} -->

<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->


@stack('js')
