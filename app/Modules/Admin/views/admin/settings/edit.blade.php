@extends('admin.layout.index',
[
	'title' => _i('Settings'),
	'subtitle' => _i('Settings'),
	'activePageName' => _i('Settings'),
	'activePageUrl' => route('settings.edit'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index') ,
])

@section('content')

<div class="row">
	<div class="col-md-3 col-lg-3">
		<div class="card">
			<div class="card-header">
				<h5>{{ _i('Favicon icon') }}</h5>
			</div>
			<div class="card-block">
				<div>
					<img class="default_images" src="{{$images->favicon}}" style="width: 100px;height: 100px;cursor: pointer;">
				</div>
			</div>
			<form action="{{route('admin.default.images.edit' , ['favicon' , $images->id])}}" enctype="multipart/form-data" method="post">
				{{ csrf_field() }}
				<input class="default_images_input" hidden  type="file" name="image">
			</form>
		</div>
	</div>
	<div class="col-md-3 col-lg-3">
		<div class="card">
			<div class="card-header">
				<h5>{{ _i('Header logo') }}</h5>
			</div>
			<div class="card-block">
				<div>
					<img class="default_images" src="{{$images->header}}" style="width: 100px;height: 100px;cursor: pointer;">
				</div>
			</div>
			<form action="{{route('admin.default.images.edit' , ['header' , $images->id])}}" enctype="multipart/form-data" method="post">
				{{ csrf_field() }}
				<input class="default_images_input" hidden  type="file" name="image">
			</form>
		</div>
	</div>
	<div class="col-md-3 col-lg-3">
		<div class="card">
			<div class="card-header">
				<h5>{{ _i('Footer logo') }}</h5>
			</div>
			<div class="card-block">
				<div>
					<img class="default_images" src="{{$images->footer}}" style="width: 100px;height: 100px;cursor: pointer;">
				</div>
			</div>
			<form action="{{route('admin.default.images.edit' , ['footer' , $images->id])}}" enctype="multipart/form-data" method="post">
				{{ csrf_field() }}
				<input class="default_images_input" hidden  type="file" name="image">
			</form>
		</div>
	</div>
	<div class="col-md-3 col-lg-3">
		<div class="card">
			<div class="card-header">
				<h5>{{ _i('Not found image') }}</h5>
			</div>
			<div class="card-block">
				<div>
					<img class="default_images" src="{{$images->not_found}}" style="width: 100px;height: 100px;cursor: pointer;">
				</div>
			</div>
			<form action="{{route('admin.default.images.edit' , ['not_found' , $images->id])}}" enctype="multipart/form-data" method="post">
				{{ csrf_field() }}
				<input class="default_images_input" hidden  type="file" name="image">
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-lg-3">
		<div class="card">
			<div class="card-header">
				<h5>{{ _i('Image Account') }}</h5>
			</div>
			<div class="card-block">
				<div>
					<img class="image_account" src="{{$image_account->image_account}}" style="width: 100px;height: 100px;cursor: pointer;">
				</div>
			</div>
			<form action="{{route('admin.image.account.edit')}}" enctype="multipart/form-data" method="post">
				@csrf
				<input type="hidden" name="id" value="{{$image_account_id}}">
				<input class="image_account_input" hidden  type="file" name="image">
			</form>
		</div>
	</div>
</div>

<form action="{{route('settings.update')}}" method="post" class="form-horizontal" id="fileupload" enctype="multipart/form-data" data-parsley-validate="">
	@csrf
	@method('PATCH')

	<div class="row">
		<div class="card col-md-12">
			<div class="card-header">
				<h5>{{ _i('Main Settings') }}</h5>
				<div class="btn-group">
					 <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title="{{ _i('Translation') }}">
						{{ _i('Translation') }}
					</button>
					<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
					@foreach ($languages as $lang)
						<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="1" data-lang="{{ $lang->id }}" style="display: block; padding: 5px 10px 10px;">{{ $lang->title }}</a></li>
					@endforeach
					</ul>
				 </div>
			</div>
			<div class="card-block">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="title">
						{{_i('Site Name')}} </label>
					<div class="col-sm-6">
						<input name="title" value="{{ $site_settings->title }}" id="title" class="form-control" placeholder="{{_i('Site Name')}}" type="text" data-parsley-type="text" disabled>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="worktime">
						{{_i('Site Worktime')}} </label>
					<div class="col-sm-6">
						<input name="work_time" value="{{ $site_settings->work_time }}" id="work_time" class="form-control" placeholder="{{_i('Site Worktime')}}" type="text" data-parsley-type="text">
						@if ($errors->has('work_time'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('work_time') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="worktime">
						{{_i('Captcha')}} </label>
					<div class="col-sm-6">
						<input type="checkbox" value="1" name="captcha" class="js-switch" {{$site_settings['captcha_enabled'] == 1 ? "checked" : ""}} />

						@if ($errors->has('captcha'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('captcha') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " >
						{{_i('Terms & Conditions')}} </label>
					<div class="col-sm-6">
						@php
							use App\Bll\Lang;use App\Modules\Admin\Models\SitePages\PageData;$list = PageData::where("lang_id",Lang::getSelectedLangId())->get();
						@endphp
					{!! Form::select("terms", $list->pluck("title","page_id"), $site_settings['terms_page'], ["class"=>"selectpicker","data-live-search"=>"true"]) !!}

					</div>
				</div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label " for="worktime">
                        {{_i('Customers Count')}} </label>
                    <div class="col-sm-6">
                        <input name="customer_count" value="{{ $site_settings->customer_count }}"  class="form-control" placeholder="{{_i('Customers Count')}}" type="text" data-parsley-type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label " for="worktime">
                        {{_i('Projects Count')}} </label>
                    <div class="col-sm-6">
                        <input name="projects_count" value="{{ $site_settings->projects_count }}"  class="form-control" placeholder="{{_i('Projects Count')}}" type="text" data-parsley-type="text">
                    </div>
                </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="card col-md-12">
			<div class="card-header"><h5>{{ _i('technical support') }}</h5></div>
			<div class="card-block">
				<!-- Custom Tabs -->
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="phone1">
						{{_i('phone 1')}} </label>
					<div class="col-sm-6">
						<input name="phone1" value="{{ $site_settings->phone1 }}" id="phone1" class="form-control"
							placeholder="{{_i('phone 1')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('phone1'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('phone1') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="phone2">
						{{_i('Phone 2')}} </label>
					<div class="col-sm-6">
						<input name="phone2" value="{{ $site_settings->phone2 }}" id="phone2" class="form-control"
							placeholder="{{_i('Phone 2')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('phone2'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('phone2') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="email">
						{{_i('Email')}} </label>
					<div class="col-sm-6">
						<input name="email" value="{{ $site_settings->email }}" id="email" class="form-control"
							placeholder="{{_i('Website Email')}}" type="email"
							data-parsley-type="email">
						@if ($errors->has('email'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="card col-md-12">
			<div class="card-header"><h5>{{ _i('socialmedia sites') }}</h5></div>
			<div class="card-block">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="facebook">
						{{_i('Facebook')}} </label>
					<div class="col-sm-6">
						<input name="facebook_url" value="{{ $site_settings->facebook_url }}" id="facebook" class="form-control"
							placeholder="{{_i('Facebook')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('facebook'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('facebook') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="instagram">
						{{_i('Instagram')}} </label>
					<div class="col-sm-6">
						<input name="instagram_url" value="{{ $site_settings->instagram_url }}" id="instagram" class="form-control"
							placeholder="{{_i('instagram')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('instagram'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('instagram') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="twitter">
						{{_i('Twitter')}} </label>
					<div class="col-sm-6">
						<input name="twitter_url" value="{{ $site_settings->twitter_url }}" id="twitter" class="form-control"
							placeholder="{{_i('Twtter')}}" type="twitter"
							data-parsley-type="twitter">
						@if ($errors->has('twitter'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('twitter') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="youtube">
						{{_i('Youtube')}} </label>
					<div class="col-sm-6">
						<input name="youtube_url" value="{{ $site_settings->youtube_url }}" id="youtube" class="form-control"
							placeholder="{{_i('Youtube')}}" type="youtube"
							data-parsley-type="youtube">
						@if ($errors->has('youtube'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('youtube') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="mail">
						{{_i('Mail')}} </label>
					<div class="col-sm-6">
						<input name="mail_url" value="{{ $site_settings->mail_url }}" id="mail" class="form-control"
							placeholder="{{_i('Mail')}}" type="mail"
							data-parsley-type="twitter">
						@if ($errors->has('mail'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('mail') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="snapchat">
						{{_i('Snapchat')}} </label>
					<div class="col-sm-6">
						<input name="snapchat_url" value="{{ $site_settings->snapchat_url }}" id="snapchat" class="form-control"
							placeholder="{{_i('Snapchat')}}" type="snapchat"
							data-parsley-type="snapchat">
						@if ($errors->has('snapchat'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('snapchat') }}</strong>
						</span>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<button type="submit" class="btn btn-info col-md-12">
			{{_i('Save')}}
		</button>
	</div>
</form>

@include('admin.settings.translate')

@endsection

@push('js')
<script>
	$('.default_images').click(function() {
		$(this).parent().parent().parent().find('.default_images_input').trigger('click');
	});
	$('input[name="image"]').change(function() {
		$(this).parent().submit();
	});
	// Image Account
	$('.image_account').click(function() {
		$('.image_account_input').trigger('click');
	});
	$('input[name="image"]').change(function() {
		$(this).parent().submit();
	});


</script>
<script>
	$(document).ready(function () {
		$('#sliders-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{url("/admin/settings/slider/datatable")}}',
			columns: [{
					data: 'id',
					name: 'id'
				},
				{
					data: 'title',
					name: 'title'
				},
				{
					data: 'url',
					name: 'url'
				},
				{
					data: 'image',
					name: 'image'
				},
				{
					data: 'created_at',
					name: 'created_at'
				},

				// {data: 'action', name: 'action', orderable: false, searchable: false}
				{
					data: 'delete',
					name: 'delete',
					orderable: false,
					searchable: false
				}
			]
		});

	});


	$("#sort_order").bind('keyup', function () {
		// console.log($('#sort_order').val() == 5)
		if ($('#sort_order').val() == 5) {
			$('#category').css('display', 'block');
		} else {
			$('#category').css('display', 'none');
		}
	});

	function showSliderImage(input) {
		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$('#slider_img').attr('src', e.target.result).width(180).height(120);
		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);
	}
	//show slider logo
	function showSliderLogo(input) {
		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$('#slider_logo').attr('src', e.target.result).width(180).height(120);
		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);
	}

	function showImg(input) {

		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$('#setting_img').attr('src', e.target.result).width(250).height(250);
		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);

	}

	function showOldImg(input) {

		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$("#old_img").attr('src', e.target.result).width(300).height(250);

		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);

	}

	function apperImage(input) {

		var filereader = new FileReader();
		filereader.onload = (e) => {
			// console.log(e);
			$('#new_img').attr('src', e.target.result).width(300).height(250);
		};
		// console.log(input.files);
		filereader.readAsDataURL(input.files[0]);

	}
	$(document).ready(function () {
		// For A Delete Record Popup
		$('.remove-record').click(function () {
			var id = $(this).attr('data-id');
			var url = $(this).attr('data-url');
			var token = '{{csrf_token()}}';
			$(".remove-record-model").attr("action", url);
			$('body').find('.remove-record-model').append(
				'<input name="_token" type="hidden" value="' + token + '">');
			$('body').find('.remove-record-model').append(
				'<input name="_method" type="hidden" value="DELETE">');
			$('body').find('.remove-record-model').append(
				'<input name="id" type="hidden" value="' + id + '">');
		});
		$('.remove-data-from-delete-form').click(function () {
			$('body').find('.remove-record-model').find("input").remove();
		});
		$('.modal').click(function () {
			// $('body').find('.remove-record-model').find( "input" ).remove();
		});
	});

	$(document).ready(function () {
		// For A Delete Record Popup
		$('.remove-edit').click(function () {
			var id = $(this).attr('data-id');
			var url = $(this).attr('data-url');
			var token = '{{csrf_token()}}';
			console.log(id, url, token);
			$(".remove-edit-model").attr("action", url);
			$('body').find('.remove-edit-model').append(
				'<input name="_token" type="hidden" value="' + token + '">');
			$('body').find('.remove-edit-model').append(
				'<input name="_method" type="hidden" value="DELETE">');
			$('body').find('.remove-edit-model').append(
				'<input name="id" type="hidden" value="' + id + '">');
		});
		$('.remove-data-from-delete-form').click(function () {
			$('body').find('.remove-edit-model').find("input").remove();
		});
		$('.modal').click(function () {
			// $('body').find('.remove-edit-model').find( "input" ).remove();
		});
	});
	$('body').on('click', '.lang_ex', function (e) {
		e.preventDefault();
		var transRowId = $(this).data('id');
		var lang_id = $(this).data('lang');
		$.ajax({
			url: '{{route('settings.translation')}}',
			method: "get",
			"_token": "{{ csrf_token() }}",
			data: {
				'lang_id': lang_id,
				'transRow': transRowId,
			},
			success: function (response) {
				if (response.data == 'false'){
					$('#langedit #title').val('');
					$('#langedit #description').val('');
					$('#langedit #keywords').val('');
					$('#langedit #footer_description').val('');
					$('#langedit #working_time').val('');
				} else{
					$('#langedit #title').val(response.data.title);
					$('#langedit #description').val(response.data.description);
					$('#langedit #keywords').val(response.data.keywords);
					$('#langedit #footer_description').val(response.data.footer_description);
					$('#langedit #working_time').val(response.data.working_hours);
				}
			}
		});
		$.ajax({
			url: '{{route('admin.get.lang')}}',
			method: "get",
			data: {
				lang_id: lang_id,
			},
			success: function (response) {
				$('#header').empty();
				$('#langedit #header').text('Translate to : ' + response);
				$('#id_data').val(transRowId);
				$('#lang_id_data').val(lang_id);
			}
		});
	});
	$('body').on('submit', '#lang_submit', function (e) {
		e.preventDefault();
		let url = $(this).attr('action');
		$.ajax({
			url: url,
			method: "post",
			"_token": "{{ csrf_token() }}",
			data: new FormData(this),
			dataType: 'json',
			cache       : false,
			contentType : false,
			processData : false,
			success: function (response) {
				if (response.errors){
					$('#masages_model').empty();
					$.each(response.errors, function(index, value) {
						$('#masages_model').show();
						$('#masages_model').append(value + "<br>");
					});
				}
				if (response == 'SUCCESS'){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Translated Successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('.modal').modal('hide');
				}
			},
		});
	});
</script>
<script>
	$(function () {
		'use strict'
		$('#sliders-table_wrapper').removeClass('form-inline');
	});
</script>
@endpush
