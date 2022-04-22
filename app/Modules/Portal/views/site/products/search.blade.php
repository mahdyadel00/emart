@extends('site.layout.index')

@section('content')

    @push('css')
        <style>
            .pro-number , .pro-description{
                color: #878282;
            }
            .pro-name{
                color: #1A6BB9;
                font-weight: bold;
            }

            hr{
                border-top:1px solid #c9c0c0;
            }
        </style>
    @endpush



    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{_i("Home")}} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{_i('Search')}}</li>
                </ol>
            </nav>
        </div>
    </div>


    <section class="category-page  py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    <div class="card-header pb-5">
                        <small>{{_i('Your Search')}}: <b>{{$key}} </b> &nbsp; &nbsp;  {{_i('Find')}} {{$data->count()}} {{_i('Items')}}</small>
                        <hr>
                        @foreach($data as $k => $item)
                        <div class="d-flex">
                            <span class="pro-number" > {{$k+1}}. &nbsp;</span>
                            <a href="@if($item->getTable()=="product_details") {{route('product',$item->pro_id)}} @else {{route('cat_product',$item->category_id)}}  @endif">
                                <small class="pro-name" >
                                    {{$item->title}}
                                </small>
                            </a>
                        </div>
                        <small class="pro-description" >
                            {!! Str::limit(strip_tags($item->description), 180) !!}
                        </small>
                        <hr >
                        @endforeach
                        <div class="col-lg-4 col-md-6">
                            {{$data->links()}}
                        </div>

                    </div>

                </div>

                @include('site.products.includes.nav')

            </div>

        </div>
    </section>



@endsection
