@extends('admin.layout.index')
@section('title')
    {{_i('Contacts')}}
@endsection
@section('page_header_name')
    {{_i('Contacts')}}
@endsection

@section('content')
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
            @endif
        @endforeach
    </div>

    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-header-title">
            <h4>{{_i('Contacts')}}</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">{{_i('Contacts')}}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
        <!-- Blog-card start -->
        <div class="card blog-page" id="blog">
            <div class="card-block">
            @include('admin.layout.message')
            {!! $dataTable->table([
                'class'=> 'table table-bordered table-striped table-responsive text-center'
            ],true) !!}
        </div> 
    </div>
    </div>

    @push('js')
        {!! $dataTable->scripts() !!}
    @endpush
    <style>
        .table{
            display: table !important;
        }
    </style>
@endsection
