@extends('admin.layout.index',
[
'title' => _i('Banks'),
'subtitle' => _i('Edit Bank'),
'activePageName' => _i('Banks'),
'activePageUrl' => route('transferBank.index'),
'additionalPageName' => _i('Settings'),
'additionalPageUrl' => route('settings.index') ,
])
@section('content')
<div class="page-body">
	<!-- Blog-card start -->
	<div class="card blog-page" id="blog">
		<div class="card-block">
			{!! Form::model($bank,['route'=>['transferBank.update',$bank->id],'method'=>'PUT','class'=>'form-horizontal','files'=>true,'data-parsley-validate'=>'']) !!}
			<div class="box-body">
				<div class="form-group row">
				</div>
				<div class="form-group row" >
					<label class="col-sm-2 col-form-label " for="txtUser">
					{{_i('name of bank')}} </label>
					{{-- <div class="col-sm-6">
						<input type="text" name="title" value="{{$bank->title}}" id="title" required="" class="form-control">
						@if ($errors->has('title'))
						<span class="text-danger invalid-feedback">
						<strong>{{ $errors->first('title') }}</strong>
						</span>
						@endif
					</div> --}}
				</div>
				<!-- ================================== holder_name =================================== -->
				<div class="form-group row" >
					<label class="col-sm-2 col-form-label " for="holder_name">
					{{_i('holder name')}} </label>
					<div class="col-sm-6">
						<input type="text" name="holder_name" value="{{$bank->holder_name}}" id="holder_name" required="" class="form-control">
						@if ($errors->has('holder_name'))
						<span class="text-danger invalid-feedback">
						<strong>{{ $errors->first('holder_name') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<!-- ================================== iban =================================== -->
				<div class="form-group row" >
					<label class="col-sm-2 col-form-label " for="iban">
					{{_i('iban')}} </label>
					<div class="col-sm-6">
						<input type="text" name="iban" value="{{$bank->iban}}" id="iban" required="" class="form-control">
						@if ($errors->has('iban'))
						<span class="text-danger invalid-feedback">
						<strong>{{ $errors->first('iban') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<!-- ================================== holder_number =================================== -->
				<div class="form-group row" >
					<label class="col-sm-2 col-form-label " for="holder_number">
					{{_i('holder number')}} </label>
					<div class="col-sm-6">
						<input type="number" name="holder_number" value="{{$bank->holder_number}}" id="holder_number" required="" class="form-control">
						@if ($errors->has('holder_number'))
						<span class="text-danger invalid-feedback">
						<strong>{{ $errors->first('holder_number') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<!-- ================================== Attachments =================================== -->
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="logo">{{_i('Logo')}}</label>
					<div class="col-sm-4">
						<input type="file" name="logo" id="logo" onchange="showImg(this)" class="btn btn-default" accept="image/gif, image/jpeg, image/png"
							value="{{old('logo')}}">
						<span class="text-danger invalid-feedback">
						<strong>{{$errors->first('logo')}}</strong>
						</span>
					</div>
					<!-- Photo -->
					<div class="col-sm-6">
						<img class="img-responsive pad" id="article_img" style="margin: 0 auto; width: 270px; height: 270px;display: block;" src="{{ asset( $bank->logo ) }}">
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-info pull-left" >
				{{_i('Save')}}
				</button>
			</div>
			<!-- /.box-footer -->
			{{ Form::close() }}
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
	function showImg(input) {
		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$('#article_img').attr('src', e.target.result).width(250).height(250);
		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);
	}
</script>
@endpush
