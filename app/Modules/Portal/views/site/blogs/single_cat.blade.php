@extends('site.layout.index')

@section('content')
    @php
        $settings = \App\Bll\Site::getSettings();
    @endphp
    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{_i("Home")}} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$category->data->name ?? ""}}</li>
                </ol>
            </nav>
        </div>
    </div>


    <section class="category-page  py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hero-img">
                        <div class="cat-floating-name">{{$category->data->name ?? ""}}</div>
                        <img src="{{asset($category->photo)}}" alt="" class="img-fluid" loading="lazy">
                    </div>

                    <div class="content-wrapper mt-5">
                        <div class="small-title">{{_i('Details')}}</div>
                        <div class="section-title fancy-orange">{{$category->name}}</div>
                        <div class="description">
                            {!! $category->data->description?? "" !!}
                        </div>
                    </div>

                    <div class="content-wrapper mt-5">
                        <div class="section-title fancy-orange">{{_i('Blogs')}}</div>
                        <div class="row">
                            @foreach($blogs as $blog_item)
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-product-wrapper">
                                        <a href="{{route('blog', $blog_item->blog_id)}}">
                                            <img src="{{asset($blog_item->image)}}" alt="" class="img-fluid" loading="lazy">
                                            <h3 class="product-title">{{$blog_item->title}}</h3>
                                        </a>
                                        <div class="floating-icons">
                                            <a href="{{route('blog', $blog_item->blog_id)}}" class="full-view" data-toggle="tooltip" title="{{_i('Full View')}}"><i
                                                    class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                </div>
                <div class="col-md-4">
                    <div class="search-form">
                        <form action="{{route('search')}}" method="get"  data-parsley-validate="">
                            @csrf
                            <input type="text" class="form-control" name="search_key" required="" placeholder="{{_i('Search')}}..">
                            <button type="submit" class="btn btn-orange"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
{{--                    @if($category->attachment)--}}
{{--                    <div class="download-catalog mt-3">--}}
{{--                        <a href="{{asset($category->attachment->file)}}" class="d-flex justify-content-between align-items-center" download="">--}}
{{--                            <p>--}}
{{--                                <img src="{{$category->attachment->file}}" alt="" class="img-fluid" loading="lazy">--}}
{{--                                {{_i('Download File')}}--}}
{{--                            </p>--}}
{{--                            <i class="fas fa-download"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    @endif--}}

                    <div class="cats-list bg-light-blue   p-2 mt-3">
                        <div class="title bg-blue text-white fw-bold rounded p-3 fz21">{{_i('Categories')}}</div>
                        <ul class="list-unstyled p-2 pb-0 mb-0">
                            @foreach($blog_categories as $cat_item)
                                <li><a href="{{route('blog_cat', $cat_item->blog_id)}}">{{$cat_item->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="support-box mt-3">
                        <div class="fw-bold fz30">{{_i('Can us help you')}}?</div>
                        <div class="fz21">{{_i('Technical Support Number')}}</div>
                        @php
                            $settings = \App\Bll\Site::getSettings();
                        @endphp
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
