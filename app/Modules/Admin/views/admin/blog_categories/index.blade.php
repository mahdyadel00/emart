@extends('admin.layout.index',
[
	'title' => _i('Blogs Categories'),
	'subtitle' => _i('Blogs Categories'),
	'activePageName' => _i('Blogs Categories'),
	'activePageUrl' => route('blogs_categories.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('blogs_categories.index')
])
@section('content')
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 mb-3">
			<span class="pull-left">
			<button id="create_new" class="btn btn-primary create add-permissiont" type="button" data-toggle="modal"
                    data-target="#modal-default">
				<span><i class="ti-plus"></i> {{_i('Create new Blogs Category')}} </span>
			</button>
			</span>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('Blogs Category')}}</h5>
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
                                    <th>{{ _i('photo') }}</th>
                                    <th>{{ _i('active') }}</th>
                                    <th>{{ _i('name') }}</th>
                                    {{--                                    <th>{{ _i('description') }}</th>--}}
                                    {{--                                    <th>{{ _i('Attachment') }}</th>--}}
                                    <th>{{ _i('Created at') }}</th>
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
    @include('admin.blog_categories.modal')
@endsection
@push('js')
    <script>
        let table = $('.dataTable').DataTable({
            order: [],
            processing: true,
            serverSide: true,
            ajax: '{{route('blogs_categories.index')}}',
            columns: [
                {data: 'id', name: 'id'},
                // {data: function (e){
                //     return '<img class="img-fluid" src="'+e.photo+'">';
                //     }},
                {data: 'photo', name: 'photo'},
                {
                    data: function (o){
                        if(o.active === 1){
                            return 'active'
                        }else{
                            return 'not active'
                        }
                    }
                },
                {data: 'name', name: 'name'},
                // {data: 'description', name: 'description'},
                // {data: 'file', name: 'file'},
                {data: 'created_at', name: 'created_at'},
                {data: 'options', name: 'options'}
            ]
        });

        // $(document).ready(function (){
        //     if( document.getElementById("input-photo").files.length !== 0 ){
        //         alert('as')
        //         document.getElementById("blog-cat-photo").src = document.getElementById("input-photo").val();
        //     }
        // })
        $(document).on('click', '#create_new', function () {
            // if (CKEDITOR.instances.editor1) {
            //     CKEDITOR.instances.editor1.destroy();
            // }

            $('#add-form').find('select').val('');
            $('input[name="status"]').prop('checked', true);
            $('.imageadd').val('');
            $('.nameadd').val('');
            $('.descriptionadd').val();
            CKEDITOR.instances.editor1.setData('');
        });

        $(document).on('click', '.add-attach', function () {
            let id = $(this).data('id')
            $('#job-attach-id').val(id)
        })

        // $('#input-photo').on('change', function () {
        //     let value = $("#input-photo").val().replace(/^C:\\fakepath\\/i, '')
        //     alert(value)
        //    $("#blog-cat-photo").src = value;
        // })
        $(document).on('click', '.edit-row', function () {
            let id = $(this).data('id')
            let active = $(this).data('active')
            let photo = $(this).data('photo')
            // let name = $(this).data('name')
            // let description = $(this).data('description')
            $('#modal-id').val(id)
            let img = document.getElementById("blog-cat-photo");
            img.src = photo;
            if (active === 1) {
                $("#blog-cat-active").attr('checked', true)
            } else {
                $("#blog-cat-active").attr('checked', false)
            }

            {{--$('#editordesc').val(description);--}}
            {{--CKEDITOR.replace('editordesc', {--}}
            {{--    extraPlugins: 'colorbutton,colordialog',--}}
            {{--    filebrowserUploadUrl: "{{ asset('masterAdmin/bower_components/ckeditor/ck_upload_master') }}",--}}
            {{--    filebrowserUploadMethod: 'form'--}}
            {{--});--}}
            {{--$('#editorname').val(name);--}}
            {{--CKEDITOR.replace('editordesc', {--}}
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

        $(document).on('click', '#btn-delete-blog-cat', function (e) {
            e.preventDefault();
            let id = $(this).data('id')
            {{--let url = "{{url('reviews/destroy')}}/"+id;--}}
            // url = url.replace('id', id)
            let url = "{{route('blogs_categories.delete', 'id')}}"
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
            if (CKEDITOR.instances.desclangtrans) {
                CKEDITOR.instances.desclangtrans.destroy();
            }
            $('#trans-name').val(' ');
            let transRowId = $(this).data('id');
            let lang_id = $(this).data('lang');
            let description = $(this).data('desc')
            let name = $(this).data('name')
            $('#id_data').val(transRowId)
            $('#lang_id_data').val(lang_id)
            $('#trans-name').val(name);
            $('#desclangtrans').val(description);
            CKEDITOR.replace('desclangtrans', {
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
            }); // end get language title

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
