@extends('admin.layout.index',[
	'title' => _i('Pages'),
	'subtitle' => _i('Create Page'),
	'activePageName' => _i('Create Page'),
	'activePageUrl' => route('pages.create'),
	'additionalPageName' => 'Pages',
	'additionalPageUrl' => route('pages.index') ,
] )

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5> {{ _i('Add Page') }} </h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
					</div>
				</div>
				<div class="card-block">
                    <form id="form_add2" class="form-horizontal"
                    action="{{ url('admin/settings/sections/store/home_sections') }}" method="POST"
                    data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">


                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="checkbox">
                                {{ _i('Display Title') }}
                            </label>
                            <div class="checkbox-fade fade-in-primary col-sm-6">
                                <label>
                                    <input type="checkbox" name="is_title_displayed" value="1"
                                        class='is_title_displayed'>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                </label>
                            </div>
                            <div class="form-group row">
                                <label class=" col-sm-3 col-form-label">{{ _i('Content Type') }} </label>
                                <div class="col-sm-9">
                                    <select class="form-control type" name="type" id="select">
                                        <option selected disabled><?= _i('Select Type') ?></option>
                                        {{-- <option value="latest_products" selected>{{ _i('Latest Products') }}</option> --}}
                                        {{-- <option value="best_selling_products">{{ _i('Best Selling Products') }}</option>
                                <option value="most_visited_products">{{ _i('Most Visited Products') }}</option>
                                 <option value="image_video">{{ _i('Image + Video') }}</option>
                                <option value="banner">{{ _i('Banner') }}</option> --}}
                                        <option value="random_products">{{ _i('Random Products') }}</option>

                                        <option value="image_content">{{ _i('image content') }}</option>
                                        {{-- <option value="header">{{ _i('header') }}</option> --}}
                                        <option value="image_video">{{ _i('Image + Video') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ _i('Title') }} <span
                                        style="color: #F00;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control title" name="title" required=""
                                        placeholder="{{ _i('Place Enter Section Title') }}">
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ _i('Description') }}</label>
                            <div class="col-sm-9">
                                <textarea class="form-control nodesc " name="description"  id="nodesc"
                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" placeholder="Place write content here..."      placeholder="{{ _i('Place Enter description') }}"></textarea>
                            </div>
                        </div>


                        <div class="form-group row image22">
                            <label class="col-sm-3 col-form-label" for="image">{{ _i('Image') }}</label>
                            <div class="col-sm-9">
                                <input type="file" name="image" class="btn btn-default image" accept="image/*">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row image_video" hidden>
                            <label class="col-sm-3 col-form-label" for="video">{{ _i('Video') }}</label>
                            <div class="col-sm-9">
                                <input type="text" name="video" class="form-control video"
                                    placeholder="{{ _i('Youtube Link') }}">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{ $errors->first('video') }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row success_Products" hidden>
                            <label class="col-sm-3 col-form-label">{{ _i('Products') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control myselecttt" name="products[]" data-live-search="true"
                                    multiple>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="checkbox">
                                {{ _i('Publish') }}
                            </label>
                            <div class="checkbox-fade fade-in-primary col-sm-6">
                                <label>
                                    <input type="checkbox" name="published" value="1" class='checkbox'>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="">

                        <button class="btn btn-info col-md-12" type="submit" id="s_form_1"> {{ _i('Save') }} </button>
                    </div>
                </form>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')

    <script>
         $(function() {
            CKEDITOR.replace( 'nodesc');
       });


        $(document).ready(function() {
            $('.myselecttt').select2({
                minimumInputLength: 2,
                placeholder: "{{ _i('Select products') }}",
                ajax: {
                    url: "{{ url('admin/settings/sections/autocomplete') }}",

                    data: function(params) {
                        var query = {
                            q: params.term,
                        }
                        return query;
                    },

                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                console.log(item);

                                return {
                                    text: item.title + ' >> ' + item.cat,
                                    id: item.product_id,
                                }
                            })
                        };
                    },
                    cache: true,
                }


            });


            $(document).on('change', '.type', function() {
                console.log($(this).val());
                let type = $(this).val();
                $('#form_add2')[0].reset();
                $('#select').val(type)
                if (type == 'image_video') {

                    $('.image_video').removeAttr('hidden').show();
                    $('.success_Products').prop('hidden', true);
                    $('.image22').removeAttr('hidden').show();


                } else if (type == 'image_content') {
                    $('.image22').removeAttr('hidden').show();
                    $('.success_Products').prop('hidden', true);
                    $('.image_video').prop('hidden', true);


                } else {
                    $('.success_Products').removeAttr('hidden').show();
                    $('.image_video').prop('hidden', true);
                    $('.image22').prop('hidden', true);
                    $(".myselecttt ").prop('required',true);


                }

                $(document).on('click', '.add-permissiont', function(e) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('admin/settings/sections/autocomplete') }}",
                        dataType: 'json',
                        delay: 250,

                        success: function(response) {
                            //console.log(response.data);

                            $.each(response.data, function(key, value) {
                                console.log(value);

                                $('#make_select1').append('<option>' + value
                                    .title +
                                    '</option>')

                            })

                        },
                        error: function() {

                        }
                    });
                })



                // $('#model_select').selectpicker('refresh');
            });


            $(function() {
                $('#form_add2').submit(function(e) {
                    //	debugger;
                    e.preventDefault();
                    $.ajax({
                        url: "{{ url('admin/settings/sections/store') . '/home_sections' }}",
                        type: "POST",
                        "_token": "{{ csrf_token() }}",
                        data: new FormData(this),
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            //	debugger;

                            if (response.errors) {
                                $('#masages_model').empty();
                                $.each(response.errors, function(index, value) {
                                    $('#masages_model').show();
                                    $('#masages_model').append(value + "<br>");
                                });
                            }
                            if (response == 'SUCCESS') {
                                new Noty({
                                    type: 'success',
                                    layout: 'topRight',
                                    text: "{{ _i('Saved Successfully') }}",
                                    timeout: 2000,
                                    killer: true
                                }).show();
                                $('.modal.modal_create').modal('hide');
                                table.ajax.reload();
                                $('#lang_add').val("");
                                $('#title_add').val("");
                                $('#link_add').val("");
                                $('#image_add').val("");
                                $('#checkbox').val("");
                                $('#description_add').val("");
                            }
                        }
                    });
                });
            });
        });


    </script>
@endpush







