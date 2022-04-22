@extends('admin.layout.index',
[
	'title' => _i('Blogs'),
	'subtitle' => _i('Blogs'),
	'activePageName' => _i('Blogs'),
	'activePageUrl' => route('blogs.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('blogs.index')
])
@section('content')
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 mb-3">
			<span class="pull-left">
			<button id="create_new" class="btn btn-primary create add-permissiont" type="button" data-toggle="modal"
                    data-target="#modal-default">
				<span><i class="ti-plus"></i> {{_i('Create new Blog')}} </span>
			</button>
			</span>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('Blogs')}}</h5>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive text-center">
                            <table id="slider_table" class="table table-bordered table-striped dataTable text-center">
                                <thead>
                                <tr role="row">
                                    <th>#</th>
                                    <th>{{ _i('image') }}</th>
                                    <th>{{ _i('status') }}</th>
                                    <th>{{ _i('category') }}</th>
                                    <th>{{ _i('title') }}</th>
                                    <th>{{ _i('Created at') }}</th>
{{--                                    <th>{{ _i('Last Edition') }}</th>--}}
                                    <th>{{ _i('Options') }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.blogs.modal')
@endsection
@push('js')
    <script>
        let table = $('.dataTable').DataTable({
            order: [],
            processing: true,
            serverSide: true,
            ajax: '{{route('blogs.index')}}',
            columns: [
                {data: 'id', name: 'id'},
                {
                    data: function (e) {
                        return e.image;
                    }
                },
                {
                    data: function (o) {
                        if (o.status === 1) {
                            return 'published'
                        } else {
                            return 'not yet'
                        }
                    }
                },
                {data: 'category', name: 'category'},
                {data: 'title', name: 'title'},
                {data: 'created_at', name: 'created_at'},
                // {data: 'updated_at', name: 'updated_at'},
                {data: 'options', name: 'options'}
            ]
        });

        $(document).on('click', '#create_new', function () {
            if (CKEDITOR.instances.contentcreate) {
                CKEDITOR.instances.contentcreate.setData('');
            }
            $('#image-create').val('')
            $('#add-form').find('select').val('');
            $('input[name="status"]').prop('checked', true);
            $('#title-create').val('')
        });

        $(document).on('click', '.add-attach', function () {
            let id = $(this).data('id')
            $('#job-attach-id').val(id)
        })

        $(document).on('click', '.edit-row', function () {
            let id = $(this).data('id')
            let status = $(this).data('status')
            let image = $(this).data('image')
            // let title = $(this).data('title')
            // let content = $(this).data('content')
            let category = $(this).data('category')
            $('#modal-id').val(id)
            let img = document.getElementById("blog-cat-image");
            img.src = image;
            if (status === 1) {
                $("#blog-cat-status").attr('checked', true)
            } else {
                $("#blog-cat-status").attr('checked', false)
            }
            $('#image-hidden').val(image)
            $('#selected_category').val(category).change();
            {{--$('#edit-title').val(title);--}}
            {{--CKEDITOR.replace('edit-title', {--}}
            {{--    extraPlugins: 'colorbutton,colordialog',--}}
            {{--    filebrowserUploadUrl: "{{ asset('masterAdmin/bower_components/ckeditor/ck_upload_master') }}",--}}
            {{--    filebrowserUploadMethod: 'form'--}}
            {{--});--}}
            {{--$('#edit-cont').val(content);--}}
            {{--CKEDITOR.replace('edit-cont', {--}}
            {{--    extraPlugins: 'colorbutton,colordialog',--}}
            {{--    filebrowserUploadUrl: "{{ asset('masterAdmin/bower_components/ckeditor/ck_upload_master') }}",--}}
            {{--    filebrowserUploadMethod: 'form'--}}
            {{--});--}}
        });

        $(document).on('submit', '#add-form', function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response === 'success') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Saved successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal').modal('hide');
                        $('.dataTable').DataTable().draw(false);
                    }
                },
            });
        });

        $(document).on('submit', '#add-attach-form', function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response === 'success') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Uploaded successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal').modal('hide');
                        $('#blog-attach').val('')
                        $('.dataTable').DataTable().draw(false);
                    }
                },
            });
        });

        $(document).on('submit', '#edit-form', function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response === 'success') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Updated successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal').modal('hide');
                        $('.dataTable').DataTable().draw(false);
                    }
                },
            });
        });

        $(document).on('click', '#btn-delete-blog', function (e) {
            e.preventDefault();
            let id = $(this).data('id')
            {{--let url = "{{url('reviews/destroy')}}/"+id;--}}
            // url = url.replace('id', id)
            let url = "{{route('blogs.delete', 'id')}}"
            url = url.replace('id', id)
            $.ajax({
                url: url,
                method: 'get',
                success: function () {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: "{{ _i('Deleted successfully')}}",
                        timeout: 2000,
                        killer: true
                    }).show();
                    $('.dataTable').DataTable().draw(false);
                }
            })
        });

        $(document).on('click', '.lang_ex', function (e) {
            e.preventDefault();
            $('#id_data').val('')
            $('#lang_id_data').val('')
            $('#transtitle').val('')
            if (CKEDITOR.instances.cont) {
                CKEDITOR.instances.cont.destroy();
            }
            let transRowId = $(this).data('id');
            let lang_id = $(this).data('lang');
            let name = $(this).data('title')
            let description = $(this).data('content')
            // alert(description)
            $('#id_data').val(transRowId)
            $('#lang_id_data').val(lang_id)
            $('#transtitle').val(name);
            $('#cont').val(description);
            CKEDITOR.replace('cont', {
                extraPlugins: 'colorbutton,colordialog',
                filebrowserUploadUrl: "{{ asset('masterAdmin/bower_components/ckeditor/ck_upload_master') }}",
                filebrowserUploadMethod: 'form'
            });
            $.ajax({
                url: '{{route('all_langs')}}',
                method: "get",
                data: {
                    lang_id: lang_id,
                },
                success: function (response) {
                    $('#header').empty();
                    $('#header').text('Translate to : ' + response);
                }
            });
        });

        $(document).on('submit', '#lang_submit', function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "post",
                "_token": "{{ csrf_token() }}",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.errors) {
                        $('#masages_model').empty();
                        $.each(response.errors, function (index, value) {
                            $('#masages_model').show();
                            $('#masages_model').append(value + "<br>");
                        });
                    }
                    if (response === 'SUCCESS') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Translated Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.dataTable').DataTable().draw(false);
                        $('.modal.modal_create').modal('hide');
                        $('#trans-title').val('')
                        $('#trans-desc').val('')
                    }
                },
            });
        });
    </script>
@endpush
