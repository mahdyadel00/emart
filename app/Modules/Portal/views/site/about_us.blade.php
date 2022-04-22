@extends('site.layout.index')

@section('content')
    @push('css')
        <style>
            .date {
                color: #E5660F;
                font-size: 14px;
                font-weight: bold;
                margin-top: 10px;
            }
        </style>
    @endpush
    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ _i('Home') }} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ _i('About Us') }}</li>
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
                            @foreach ($pages as $page)
                                @if ($page->data != null)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single-product-wrapper">
                                            <a href="{{ route('site.page.show', $page->id) }}">
                                                <img src="{{ asset($page->image) }}" alt="" class="img-fluid"
                                                     loading="lazy">
                                                <h3 class="product-title">{{ $page->data->title }}</h3>
                                            </a>
                                            <div class=" date">{{ date('d-m-Y', strtotime($page->created_at)) }}</div>
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
