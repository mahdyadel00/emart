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
                            @foreach ($cats as $cat)
                                @if ($cat->translation != null)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single-product-wrapper">
                                            <a href="{{ route('cat_product', $cat->id) }}">
                                                <img src="{{ asset($cat->getImage()) }}" alt="" class="img-fluid"
                                                    loading="lazy">
                                                <h3 class="product-title">{{ $cat->translation->title }}</h3>
                                            </a>
                                            <div class="floating-icons">
                                                <a href="{{ route('cat_product', $cat->id) }}" class="full-view"
                                                    data-toggle="tooltip" title="{{ _i('Full View') }}"><i
                                                        class="fa fa-link"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
