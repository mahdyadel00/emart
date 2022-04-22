@extends('admin.layout.index',[
	'title' => _i('Pages'),
	'subtitle' => _i('Pages'),
	'activePageName' => _i('Pages'),
	'activePageUrl' => route('pages.index'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('pages.index') ,
] )
@section('content')
    <div class="row">
        <div class="col-sm-12 mb-3">
			<span class="pull-left">
			<a href="{{url('admin/pages/create')}}" class="btn btn-primary create add-permissiont">
				<span><i class="ti-plus"></i> {{_i('Create new page')}} </span>
			</a>
			</span>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> {{ _i('Pages List') }} </h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive text-center">
                    {!! $dataTable->table(["class"=> "table table-bordered table-striped dataTable text-center"],true) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal_edit fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header"> {{_i('Edit Page')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate=""
                          enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="box-body">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="checkboxx">
                                    {{_i('Publish')}}
                                </label>
                                <div class="checkbox-fade fade-in-primary col-sm-6">
                                    <label>
                                        <input type="checkbox" id="checkboxx" name="published" value="1">
                                        <span class="cr">
								<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
								</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="imagePage">
                                    {{_i('Image')}}
                                </label>
                                <div class="col-sm-6">
                                    <label>
                                        <input type="file" id="imagePage" name="image">
                                        <img style="width: 100px; height: 100px" class="img-fluid" id="page-photo" src="" alt="">
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="place" id="hidden-place">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal"> {{_i('Close')}}
                            </button>
                            <button class="btn btn-info" type="submit" id="s_form_1"> {{_i('Save')}} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="get_link" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="margin-top:40px;">
        <div class="modal-dialog" role="document">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{_i('Page Link')}}  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="box-body">
                                <!----============================== link =============================-->
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="text" readonly="" placeholder="{{_i('Article Category Title')}}"
                                               name="title" value=""
                                               class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                               id="link">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{_i('Close')}}</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal_create" id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="margin-top:40px;">
        {{--
        <div class="modal fade modal_create " id="langedit" role="dialog" aria-labelledby="exampleModalLabel" >
            --}}
        <div class="modal-dialog" role="document">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="header"> {{_i('Trans To')}} : </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('page_lang_store')}}" method="post" class="form-horizontal"
                              id="lang_submit" data-parsley-validate="">
                            {{method_field('post')}}
                            {{csrf_field()}}
                            <input type="hidden" name="id" id="id_data" value="">
                            <input type="hidden" name="lang_id_data" id="lang_id_data" value="">
                            <div class="box-body">
                                <!----============================== title =============================-->
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 control-label "> {{_i('Title')}} </label>
                                    <div class="col-md-10">
                                        <input type="text" placeholder="{{_i('Page Title')}}" name="title" value=""
                                               class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                               required="" id="titletrans">
                                    </div>
                                </div>
                                <!----============================== content =============================-->
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 control-label"> {{_i('Content')}} </label>
                                    <div class="col-sm-10">
                                        <textarea id="editor1" class="form-control editor1" name="content"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{_i('Close')}}</button>
                                <button type="submit" class="btn btn-primary">
                                    {{_i('Save')}}
                                </button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('css')
        <style>
            .modal_create {
                margin: 2px auto;
                z-index: 1100 !important;
            }
        </style>
    @endpush
@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        var id = '';
        $(document).on('click', '.edit', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            let place = $(this).data('place');
            let published = $(this).data('published');
            let image = $(this).data('image')
            let img = document.getElementById("page-photo");
            img.src = image;
            $('#id').val(id);
            $('#hidden-place').val(place);
            if (published === 1) {
                $('#checkboxx').prop('checked', true);
            }

        });

        $(function () {
            $('#form_edit').submit(function (e) {
                e.preventDefault();
                let id = $('#id').val()
                let url = "{{route('pages.update', 'id')}}";
                url = url.replace('id', id)
                $.ajax({
                    url: url,
                    method: "POST",
                    "_token": "{{ csrf_token() }}",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response == 'SUCCESS') {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Saved Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_edit').modal('hide');
                            $('.table').DataTable().ajax.reload()

                        }
                    }
                });
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {
            CKEDITOR.editorConfig = function (config) {
                config.baseFloatZIndex = 102000;
                config.FloatingPanelsZIndex = 100005;
            };
            CKEDITOR.replace('editor1', {
                extraPlugins: 'colorbutton,colordialog',
                filebrowserUploadUrl: "{{asset('masterAdmin/bower_components/ckeditor/ck_upload_master')}}",
                filebrowserUploadMethod: 'form'
            });
        });
        $('body').on('click', '.get_link', function (e) {
            var link = $(this).data('link');
            $('#link').val(link);
        });
        $('body').on('click', '.lang_ex', function (e) {
            e.preventDefault();
            var transRowId = $(this).data('id');
            var lang_id = $(this).data('lang');
            $.ajax({
                url: '{{route('page_lang_value')}}',
                method: "get",
                "_token": "{{ csrf_token() }}",
                data: {
                    'lang': lang_id,
                    'transRow': transRowId,
                },
                success: function (response) {
                    if (response.data == 'false') {
                        $('#titletrans').val('');
                        $('#editor1').val('');
                    } else {
                        //alert(response.data.info);
                        $('#titletrans').val(response.data.title);
                        CKEDITOR.instances.editor1.setData(response.data.content);
                    }
                }
            });
            // get lang title
            $.ajax({
                url: '{{route('all_langs')}}',
                method: "get",
                data: {
                    lang_id: lang_id,
                },
                success: function (response) {
                    $('#langedit #header').empty();
                    $('#langedit #header').text('Translate to : ' + response);
                    $('#id_data').val(transRowId);
                    $('#lang_id_data').val(lang_id);
                }
            }); // end get language title

            // submit translate lang && save translation
            $('body').on('submit', '#lang_submit', function (e) {
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
                        if (response == 'SUCCESS') {

                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Translated Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_create').modal('hide');
                        }
                    },
                });
            });
        });

    </script>
@endpush
