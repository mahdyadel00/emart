@extends('site.layout.index')

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{_i("Home")}} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
                </ol>
            </nav>
        </div>
    </div>


    <section class="single-product-page  py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">


                    <div class="content-wrapper">
                        <div class="section-title fancy-orange">{{$product->title}}</div>

                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-img">
                                    <img src="{{asset($product->getThumbnailAttribute())}}" alt="" class="img-fluid img-thumbnail rounded10"
                                         loading="lazy">
                                </div>
                            </div>
                            <div class="col-lg-7  ">
                                <div class="product-info lh-lg">
                                    <div class="item-code main-text-color fw-bold mb-3">{{_i('Item Code')}}: <span
                                            class="text-orange">{{$product->code}}</span>
                                    </div>
                                    <strong class="title main-text-color">{{_i('Specifications')}}</strong>
                                    <div class="specs">
                                        <ul class="list-unstyled">
                                            {!! $product->description !!}
{{--                                            @foreach($product->getLabelData() as $lable)--}}
{{--                                                <li>{{$lable['title']}} : {{$lable['value']}}</li>--}}
{{--                                            @endforeach--}}
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="content-wrapper mt-5">
                                <div class="small-title">{{_i('Details')}}</div>
                                <div class="section-title fancy-orange"></div>
                                <div class="description">
                                    {!! $product->info !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content-wrapper mt-5">
                        <div class="section-title fancy-orange">{{_i('Similar products')}}</div>
                        <div class="row">

                            @foreach($products as $product_item)
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-product-wrapper">
                                        <a href="{{route('product', $product_item->id)}}">
                                            <img src="{{asset($product_item->getThumbnailAttribute())}}" alt="" class="img-fluid" loading="lazy">
                                            <h3 class="product-title">{{$product_item->title}}</h3>
                                        </a>
                                        <div class="floating-icons">
                                            <a href="{{route('product', $product_item->id)}}" class="quick-view" data-bs-toggle="modal" data-bs-target="#productModal-{{$product_item->id}}"
                                               data-toggle="tooltip" title="{{_i('Quick View')}}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{route('product', $product_item->id)}}" class="full-view" data-toggle="tooltip" title="{{_i('Full View')}}"><i
                                                    class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Modal -->
                                <div class="modal fade product-modal" id="productModal-{{$product_item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg rounded10">
                                        <div class="modal-content rounded10">

                                            <div class="modal-body p-3 rounded10">
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                                                        class="fa fa-times-circle"></i></button>
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="product-img">
                                                            <img src="{{asset($product_item->getThumbnailAttribute())}}" alt="" class="img-fluid img-thumbnail rounded10"
                                                                 loading="lazy">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 d-lg-flex align-items-center">
                                                        <div class="product-info lh-lg">
                                                            <div class="item-code main-text-color fw-bold mb-3">{{_i('Item Code')}}: <span
                                                                    class="text-orange">{{$product_item->code}}</span>
                                                            </div>

                                                            <strong class="title main-text-color">{{_i('Specifications')}}</strong>
                                                            <div class="specs">
                                                                <ul class="list-unstyled">
                                                                    {!! $product_item->description !!}
{{--                                                                    @foreach($product_item->getLabelData() as $lable)--}}
{{--                                                                        <li>{{$lable['title']}} : {{$lable['value']}}</li>--}}
{{--                                                                    @endforeach--}}
                                                                </ul>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @endforeach
                                <div class="col-lg-4 col-md-6">
                                    {{$products->links()}}
                                </div>

                        </div>
                    </div>

                </div>
                @include('site.products.includes.nav')

            </div>
        </div>
    </section>
@endsection
