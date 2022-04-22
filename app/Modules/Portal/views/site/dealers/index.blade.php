@extends('site.layout.index')

@section('content')

    @push('js')
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
        <script src="https://maps.google.com/maps/api/js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
    @endpush

    @push('css')
        <style type="text/css">
            #mymap {
                border:1px solid red;
                width: 100%;
                height: 500px;
            }
        </style>
    @endpush

    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{_i('Dealers')}}</a></li>
                </ol>
            </nav>
        </div>
    </div>


    <section class="contact-us-page  py-5">

        <div class="container">

            <div class="bg-light-blue rounded10">
                <div class="tab-content" id="myTabContent">

                        <div class="form-wrapper p-5 ">
                            <div class="text-blue fz21 fw-bold mb-3"> {{_i('Locate our dealers')}}</div>
                            <div class="row ">
                                <div class="col-md-4 sale-point">
                                    <select name="city_id" id="filtercity" class="w-100 wide mt-4 js-example-basic-single" required="">
                                        <option selected disabled>{{_i('Select Branch')}}</option>
                                        @foreach($locations as $location)
                                        <option value="{{$location->id}}">{{$location->city}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @include('site.dealers.map_filter')

                            </div>
                        </div>

                </div>

            </div>
        </div>

    </section>




@endsection

