@extends('admin.layout.index',
[
	'title' => $job->data? $job->data->title: '',
	'subtitle' => $job->data? $job->data->title: _i('Jobs'),
	'activePageName' => $job->data? $job->data->title: _i('Jobs'),
	'activePageUrl' => route('jobs.show', $job->id),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('settings.index')
])
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> {{ $job->data? $job->data->title: '' }} </h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                    </div>
                </div>
                <section class="py-5">
                    <div class="container">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 control-label">
                                        <h3 class="box-title">{{_i("Job Details")}} :: </h3>
                                    </label>
                                    <label for="inputEmail3" class="col-sm-3 control-label">
                                        {{ $job->data? $job->data->title: '' }}
                                    </label>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">{{_i("Job Title")}} :</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled value="{{ $job->data? $job->data->title: '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 control-label">{{_i("Job Description")}} :</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" disabled rows="6" cols="6">{{$job->data? $job->data->description : ''}}</textarea>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 control-label"><b>{{_i("Files")}}::</b></label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-9">
                                        @if($job->attachment)
                                            @foreach($job->attachment as $attach)
                                                <div class="col-sm-12 text-center" >
                                                    <a href="{{asset($attach->file)}}" title="{{_i('file')}} {{$key++}}" class="btn btn-warning  col-sm-8" download="">
                                                        {{_i('file')}} {{$key++}} <i class="fa fa-download"></i>
                                                    </a>
                                                </div>
                                                <br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 text-center" >
                            <a href="{{url('admin/jobs')}}" title="{{_i('All Jobs')}}" class="btn btn-primary  col-sm-8" >{{_i('Back')}}</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>




    {{--    <div class="row">--}}
{{--        <div class="col-sm-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h5> {{ $job->data? $job->data->title: '' }} </h5>--}}
{{--                    <div class="card-header-right">--}}
{{--                        <i class="icofont icofont-rounded-down"></i>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-block">--}}
{{--                    <div class="card-body">--}}
{{--                        <h5> {{ $job->data? $job->data->description: '' }} </h5>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-block">--}}
{{--                    <table class="table table-hover">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th class="text-center" scope="col">{{_i('Job ID')}}</th>--}}
{{--                            <th class="text-center" scope="col">{{_i('Title')}}</th>--}}
{{--                            <th class="text-center" scope="col">{{_i('Description')}}</th>--}}
{{--                            <th class="text-center" scope="col">{{_i('Files')}}</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tr>--}}
{{--                            <td style="text-align: center; vertical-align: middle">{{$job->id}}</td>--}}
{{--                            <td style="text-align: center; vertical-align: middle">{{$job->data? $job->data->title : ''}}</td>--}}
{{--                            <td style="text-align: center; vertical-align: middle">{{$job->data? $job->data->description : ''}}</td>--}}
{{--                            <td>--}}
{{--                                <table>--}}
{{--                                    @if($job->attachment)--}}
{{--                                        @foreach($job->attachment as $attach)--}}
{{--                                            <tr class="download-catalog mt-3">--}}
{{--                                                <td>--}}
{{--                                                    <a href="{{asset($attach->file)}}"--}}
{{--                                                       class="" download="">--}}
{{--                                                        <p>--}}
{{--                                                            <img src="{{$attach->file}}" alt="" class="img-fluid"--}}
{{--                                                                 loading="lazy">--}}
{{--                                                            {{_i('file')}} {{$key++}}--}}
{{--                                                        </p>--}}
{{--                                                        <i class="fa fa-download"></i>--}}
{{--                                                    </a>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
{{--                                </table>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                        <tbody>--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}


{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection
