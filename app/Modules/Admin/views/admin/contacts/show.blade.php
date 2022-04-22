@extends('admin.layout.index')

@section('title')
{{ _i('Show Message') }}
@endsection

@section('page_header_name')
{{ _i('Show Message') }}
@endsection

@section('content')
<!-- /.box-header -->
<!-- =====Filter Section===== -->
<div class="box-body">
    <form
        action="{{ url('/admin/contacts/'.$contact->id.'/delete') }}"
        method="get" class="form-horizontal">
        @method('DELETE')
        @csrf
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">
                                <a
                                    href="{{ url('/admin/contacts/'.$contact->id.'/delete') }}">
                                    <button type="submit" class="btn btn-danger">
                                        {{ _i('Delete') }}
                                    </button>
                                </a>
                            </li>
                        </ol>

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </form>
    <div class="box-body">

        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h5>{{ _i('Add Content') }}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>

                </div>
                <div class="card-body card-block">

                    <div class="form-group row">
                        <label class="col-md-2 control-label " for="txtUser">
                            {{ _i('Name') }} </label>
                        <div class="col-md-6">
                            <input type="text" name="name" id="txtUser" class="form-control"
                                value="{{ $contact->name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label " for="txtUser">
                            <?=_i('Email')?> </label>
                        <div class="col-md-6">
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ $contact->email }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label " for="txtUser">
                            <?=_i('Phone')?> </label>
                        <div class="col-md-6">
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ $contact->phone }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label " for="txtUser">
                            <?=_i('Message')?> </label>
                        <div class="col-md-8">
                            <textarea id="message"
                                class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}"
                                name="message">{{ $contact->message }}</textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ url('/admin/contacts') }}">
                            <button type="button" class="btn btn-default ">
                                {{ _i('Back') }}
                            </button>
                        </a>

                        {{-- <button type="submit" class="btn btn-danger " > --}}
                        {{-- {{_i('Delete') }}--}}
                        {{-- </button> --}}
                    </div>
                    <!-- /.box-footer -->

                </div>
            </div>
        </div>

{{--        <div class="col-sm-12">--}}
{{--            <div class="card card-info">--}}
{{--                <div class="card-header">--}}
{{--                     <div class="card-header-right">--}}
{{--                        <i class="icofont icofont-rounded-down"></i>--}}
{{--                        <i class="icofont icofont-refresh"></i>--}}
{{--                        <i class="icofont icofont-close-circled"></i>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body card-block">--}}
{{--                    <form method='post'--}}
{{--                        action='{{ route('admin.contact.reply', $contact->id) }}'>--}}
{{--                        @csrf--}}
{{--                        <div class="form-group row">--}}
{{--                            --}}
{{--                            <div class="col-md-8">--}}
{{--                                <textarea id="reply"--}}
{{--                                    class="form-control{{ $errors->has('reply') ? ' is-invalid' : '' }}"--}}
{{--                                    name="reply" rows=7></textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="box-footer">--}}
{{--                            <button type="submit" class="btn btn-default">--}}
{{--                                {{ _i('Submit') }}--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

</div>

@endsection
