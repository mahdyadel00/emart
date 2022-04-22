@extends('site.layout.index')

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ _i('Home') }} </a></li>
                    <li class="breadcrumb-item"><a href="">{{ _i('Categories') }}</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="category-page  py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-wrapper mt-5">

                        <div class="row">
                            @forelse($cats as $cat)
                                @if ($cat->data != null)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single-product-wrapper">
                                            <a href="{{ route('blog_cat', $cat->id) }}">
                                                <img src="{{ asset($cat->photo) }}" alt="" class="img-fluid"
                                                    loading="lazy">
                                                <h3 class="product-title">{{ $cat->data->name }}</h3>
                                            </a>
                                            <div class="floating-icons">
                                                <a href="{{ route('blog_cat', $cat->id) }}" class="full-view"
                                                    data-toggle="tooltip" title="{{ _i('Full View') }}"><i
                                                        class="fa fa-link"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            @empty
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="small-title">{{_i("No Blogs")}}</div>
                                        <div class="section-title fancy-orange"></div>
                                        <div class="description">
                                            <div class="card-header">
                                                <h5>{{_i("The are no blogs found")}}</h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
