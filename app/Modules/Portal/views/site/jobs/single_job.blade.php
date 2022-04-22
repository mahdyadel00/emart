@extends('site.layout.index')

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ _i('Home') }} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $job->data ? $job->data->title : '' }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="jobs-page  py-5">
        <div class="container">
            <div class="row">
                @if ($job->data != null)
                    <div class="col-md-6">
                        <div class="single-job">
                            <div class="job-info">
                                <div class="title">{{ $job->data->title }}</div>
                                <div class="description">{{ $job->data->description }}</div>
                                <div class="date">{{ $job->date }}</div>
                                <form id="formfile" enctype="multipart/form-data">
                                    <div class="mb-3 mt-3 row">
                                        <label for="formFile"
                                            class="form-label">{{ _i('Upload Your Attatchment') }}</label>
                                        <input class="form-control" type="file" id="formFile">
                                        <input class="form-control" type="hidden" id="job_id" value="{{ $job->id }}">
                                    </div>

                                    <button type="button" form="#formfile"
                                        class="btn btn-primary submit m-0">{{ _i('Submit') }}</button>

                                </form>
                            </div>
                        </div>

                    </div>
                @endif


            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', '.submit', function(e) {

                e.preventDefault();

                var fd = new FormData();
                var files = $('#formFile')[0].files;
                var id = $('#job_id').val();
                console.log

                if (files.length > 0) {
                    fd.append('file', files[0]);
                    fd.append('id', id);

                    $.ajax({
                        url: "{{ route('upload.file.job') }}",
                        type: 'post',
                        data: fd,

                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success == 'ok') {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: "{{ _i('Your request has been send') }}",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                            $('#formFile').empty();
                        },
                        error: function(response) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'warning',
                                title: "{{ _i('Your Attatchment should be pdf , doc') }}",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    });
                } else {
                    alert("Please select a file.");
                }
            });
        });
    </script>
@endpush
