@extends('site.layout.index')

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{_i("Home")}} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{_i("Not Found")}}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="category-page  py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-wrapper mt-5">
                        <div class="small-title">{{_i("Error Found")}}</div>
                        <div class="section-title fancy-orange"></div>
                        <div class="description">
                            <div class="card-header">
                                <h5>{{_i("The page you are looking for is not found")}}</h5>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection
