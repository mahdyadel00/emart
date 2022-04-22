@extends('site.layout.index',['settings' => $settings])

@section('content')
    @php
        $settings = \App\Bll\Site::getSettings();
    @endphp

    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{_i("Home")}} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$service->title}}</li>
                </ol>
            </nav>
        </div>
    </div>


    <section class="category-page  py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hero-img">
                        <div class="cat-floating-name">{{$service->title}}</div>
                        <img src="{{asset($service->image)}}" alt="" class="img-fluid" loading="lazy">
                    </div>

                    <div class="content-wrapper mt-5">
                        <div class="small-title">{{_i('Details')}}</div>
                        <div class="section-title fancy-orange">{{$service->title}}</div>
                        <div class="description">
                            {!! $service->body !!}
                        </div>
                    </div>

                    <div class="content-wrapper mt-5">
                        <div class="section-title fancy-orange">{{_i('Services')}}</div>
                        <div class="row">
                            @foreach($services as $service_item)
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-product-wrapper">
                                        <a href="">
                                            <img src="{{asset($service_item->image)}}" alt="" class="img-fluid" loading="lazy">
                                            <h3 class="product-title">{{$service_item->title}}</h3>
                                        </a>
                                        <div class="floating-icons">
                                            <a href="{{route('service', $service_item->service_id)}}" class="full-view" data-toggle="tooltip" title="{{_i('Full View')}}"><i
                                                    class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                </div>


                <div class="col-md-4">

                    @foreach($attachments as $key => $attach)
                    <div class="download-catalog mt-3">
                        <a href="{{$attach->file}}" class="d-flex justify-content-between align-items-center" download="">
                            <p>
                                <img src="{{$attach->file}}"  alt="" class="img-fluid" loading="lazy" >
                                {{_i('file')}} {{$key+1}}
                            </p>
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                    @endforeach


                    <div class="cats-list bg-light-blue   p-2 mt-3">
                        <div class="title bg-blue text-white fw-bold rounded p-3 fz21">{{_i('Services')}}</div>
                        <ul class="list-unstyled p-2 pb-0 mb-0">
                            @foreach($services as $service_item)
                                <li><a href="{{route('service', $service_item->service_id)}}">{{$service_item->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="support-box mt-3">
                        <div class="fw-bold fz30">{{_i('Can us help you')}}?</div>
                        <div class="fz21">{{_i('Technical Support Number')}}</div>

                        @if($settings != null)
                            <a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a>
                            <a href="tel:{{$settings->phone2}}">{{$settings->phone2 }}</a>
                        @endif

                    </div>
                        @include('site.layout.sale_point')

                </div>

            </div>

        </div>
    </section>

@endsection
