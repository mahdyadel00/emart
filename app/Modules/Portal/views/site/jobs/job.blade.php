@extends('site.layout.index')

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ _i('Home') }} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ _i('Jobs') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="jobs-page  py-5">
        <div class="container">
            <div class="row">
                @foreach ($jobs as $job)
                @if ($job->data != null)
                     <div class="col-md-6">
                        <div class="single-job">
                            <div class="job-info">
                                <div class="title">{{ $job->data->title }}</div>
                                <div class="date">{{ $job->date }}</div>
                            </div>
                            <a href="{{ route('single_job',$job->id) }}" class="btn btn-orange">
                                {{ _i('Apply') }}
                            </a>
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
