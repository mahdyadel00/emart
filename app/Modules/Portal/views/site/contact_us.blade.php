@extends('site.layout.index')

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{_i('Contact Us')}}</a></li>
                </ol>
            </nav>
        </div>
    </div>

@include('site.includes.sessions')

    <section class="contact-us-page  py-5">
        <div class="container">
            <div class="bg-light-blue rounded10">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="form--1-tab" data-bs-toggle="tab" data-bs-target="#form--1"
                                type="button" role="tab" aria-controls="form--1" aria-selected="true">{{_i('Customer Service')}}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="form--2-tab" data-bs-toggle="tab" data-bs-target="#form--2"
                                type="button" role="tab" aria-controls="form--2" aria-selected="false">{{_i('Sales Request')}}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="form--3-tab" data-bs-toggle="tab" data-bs-target="#form--3"
                                type="button" role="tab" aria-controls="form--3" aria-selected="false">{{_i('Recruitment')}}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="form--4-tab" data-bs-toggle="tab" data-bs-target="#form--4"
                                type="button" role="tab" aria-controls="form--4" aria-selected="false">{{_i('Vendors')}}
                        </button>
                    </li>
                </ul>
            </div>
            <div class="bg-light-blue rounded10">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="form--1" role="tabpanel" aria-labelledby="form--1-tab">
                        <div class="form-wrapper p-5 ">
                            <div class="text-blue fz21 fw-bold mb-3">{{_i('Contact Us')}}</div>
                            <form action="{{route('contact.post')}}" method="POST"  data-parsley-validate="" >
                                @csrf
                            <div class="row">
                                <input type="hidden" name="contact_type" value="Customer Service">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" placeholder="{{_i('Full name')}}" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" maxlength="15" data-parsley-maxlength="15" class="form-control"
                                           name="phone" placeholder="{{_i('Phone')}}">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" data-parsley-type="email" class="form-control" name="email" placeholder="{{_i('Email')}}" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" placeholder="{{_i('City')}}">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="8" name="message" placeholder="{{_i('Message')}}" required=""></textarea>
                                </div>
                                <div class="col-md-12 d-md-flex justify-content-end">
                                    <input type="submit" class="btn btn-blue mt-4" value="Send">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="form--2" role="tabpanel" aria-labelledby="form--2-tab">
                        <div class="form-wrapper p-5 ">
                            <div class="text-blue fz21 fw-bold mb-3">{{_i('Sales Request')}}</div>
                            <form action="{{route('contact.post')}}" method="POST"  data-parsley-validate="" >
                                @csrf
                            <div class="row">
                                <input type="hidden" name="contact_type" value="Sales Request">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" placeholder="{{_i('Full name')}}" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" maxlength="15" data-parsley-maxlength="15" class="form-control"
                                           name="phone" placeholder="{{_i('Phone')}}">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" data-parsley-type="email" class="form-control" name="email" placeholder="{{_i('Email')}}" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" placeholder="{{_i('City')}}">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="8" name="message" placeholder="{{_i('Message')}}" required=""></textarea>
                                </div>
                                <div class="col-md-12 d-md-flex justify-content-end">
                                    <input type="submit" class="btn btn-blue mt-4" value="Send">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="form--3" role="tabpanel" aria-labelledby="form--3-tab">
                        <div class="form-wrapper p-5 ">
                            <div class="text-blue fz21 fw-bold mb-3">{{_i('Recruitment')}}</div>
                            <form action="{{route('contact.post')}}" method="POST"  data-parsley-validate="" >
                                @csrf
                            <div class="row">
                                <input type="hidden" name="contact_type" value="Recruitment">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" placeholder="{{_i('Full name')}}" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" maxlength="15" data-parsley-maxlength="15" class="form-control"
                                           name="phone" placeholder="{{_i('Phone')}}">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" data-parsley-type="email" class="form-control" name="email" placeholder="{{_i('Email')}}" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" placeholder="{{_i('City')}}">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="8" name="message" placeholder="{{_i('Message')}}" required=""></textarea>
                                </div>
                                <div class="col-md-12 d-md-flex justify-content-end">
                                    <input type="submit" class="btn btn-blue mt-4" value="Send">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="form--4" role="tabpanel" aria-labelledby="form--4-tab">
                        <div class="form-wrapper p-5 ">
                            <div class="text-blue fz21 fw-bold mb-3">{{_i('Vendors')}}</div>
                            <form action="{{route('contact.post')}}" method="POST"  data-parsley-validate="" >
                                @csrf
                            <div class="row">
                                <input type="hidden" name="contact_type" value="Vendors">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" placeholder="{{_i('Full name')}}" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" maxlength="15" data-parsley-maxlength="15" class="form-control"
                                           name="phone" placeholder="{{_i('Phone')}}">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" data-parsley-type="email" class="form-control" name="email" placeholder="{{_i('Email')}}" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" placeholder="{{_i('City')}}">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="8" name="message" placeholder="{{_i('Message')}}" required=""></textarea>
                                </div>
                                <div class="col-md-12 d-md-flex justify-content-end">
                                    <input type="submit" class="btn btn-blue mt-4" value="Send">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
