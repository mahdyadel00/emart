@extends('site.layout.index')

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{ $page->title ?? null }}</a></li>
                </ol>
            </nav>
        </div>
    </div>


    <section class="about-us-page py-5 ">
        <div class="container">
            @if ($page != null)
            <div class="hero-img">
                <img src="{{asset($page->image)}}" alt="" class="img-fluid">
            </div>
            <div class="section-title fancy-orange">{{_i('Overview')}}</div>
            <p class="description mt-4">{!! $page->content !!}</p>
            @endif

        </div>
    </section>


@endsection
