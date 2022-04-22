@extends('site.layout.index')

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{_i("Home")}} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$category->title}}</li>
                </ol>
            </nav>
        </div>
    </div>


    <section class="category-page  py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    <div class="hero-img">
                        <div class="cat-floating-name">{{$category->title}}</div>
                        <img src="{{asset($category->getImage())}}" alt="" class="img-fluid" loading="lazy">
                    </div>
                    <div class="content-wrapper mt-5">
                        <div class="small-title">{{_i('Overview')}}</div>
                        <div class="section-title fancy-orange">{{$category->title}}</div>
                        <div class="description">
                            {{$category->description}}
                        </div>
                    </div>
                    @if(count($subCategories) > 0)
                        <div class="content-wrapper">
                            <div class="section-title fancy-orange">{{_i('Categories')}}</div>
                            <div class="row">
                                @foreach ($subCategories as $cat)
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
                    @else
                        <div class="content-wrapper">
                            <div class="section-title fancy-orange">{{_i('Products')}}</div>
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
                                                                        class="text-orange">{{$product_item->sku}}</span>
                                                                </div>

                                                                <strong class="title main-text-color">{{_i('Specifications')}}</strong>
                                                                <div class="specs">
                                                                    <ul class="list-unstyled">
                                                                        @foreach($product_item->getLabelData() as $lable)
                                                                            <li>{{$lable['title']}} : {{$lable['value']}}</li>
                                                                        @endforeach
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
                    @endif



                    <div class="content-wrapper mt-5">

                        <div class="section-title fancy-orange">{{_i('QUALITY AND TESTING')}}</div>
                        <div class="description">
                           {!! $category->quality !!}
                        </div>

                    </div>

                </div>


                @php
                    $settings = \App\Bll\Site::getSettings();
                    $categories = \App\Bll\Site::getProCategories();

                @endphp

                <div class="col-md-4">
                    <div class="search-form">
                        <form action="{{route('search')}}" method="get"  data-parsley-validate="">
                            @csrf
                            <input type="text" class="form-control" name="search_key" required="" placeholder="{{_i('Search')}}..">
                            <button type="submit" class="btn btn-orange"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    @php
                    $attach = \Illuminate\Support\Facades\DB::table('category_features')
                    ->where('category_id', $category->category_id)->first();
                    @endphp

                    @if($attach != null)
                    <div class="download-catalog mt-3">
                        <a href="{{asset($attach->file)}}" class="d-flex justify-content-between align-items-center" download="">
                            <p>
                                <img src="{{$attach->file}}" alt="" class="img-fluid" loading="lazy">
                                {{_i('Download file')}}
                            </p>
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                    @endif

                    <div class="cats-list bg-light-blue   p-2 mt-3">
                        <div class="title bg-blue text-white fw-bold rounded p-3 fz21">{{_i('Categories')}}</div>
                        <ul class="list-unstyled p-2 pb-0 mb-0">
                            @foreach($categories as $cat_item)
                                <li><a href="{{route('cat_product', $cat_item->category_id)}}">{{$cat_item->title}}</a></li>
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
