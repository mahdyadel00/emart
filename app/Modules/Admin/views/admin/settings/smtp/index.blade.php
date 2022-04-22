@extends('admin.layout.index',
[
	'title' => _i('SMTP Settings'),
	'subtitle' => _i('SMTP Settings'),
	'activePageName' => _i('SMTP Settings'),
	'activePageUrl' => '',
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index') ,
])
@section('content')
	<div class="card">
		<div class="card-header">
			<h5>{{ _i('SMTP Settings') }}</h5>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-sm-12 col-xl-12 m-b-10">
					<form action="{{ route('smtp_settings.update') }}" method="post" enctype="multipart/form-data" data-parsley-validate="" id="form_store">
						@csrf

						<div class="form-group row">
							<label class="col-sm-2 col-form-label " for="smtp_sender_name">
								{{ _i('Sender name') }} </label>
							<div class="col-sm-6">
								<input name="smtp_sender_name" value="{{ $smtp_settings->smtp_sender_name ?? "" }}" id="smtp_sender_name" class="form-control"
									   placeholder="{{ _i('SMTP sender name') }}" type="text"
									   data-parsley-type="text">
								@if($errors->has('smtp_sender_name'))
									<span class="text-danger invalid-feedback">
										<strong>{{ $errors->first('smtp_sender_name') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label " for="smtp_host">
								{{ _i('Host name') }} </label>
							<div class="col-sm-6">
								<input name="smtp_host" value="{{ $smtp_settings->smtp_host ?? "" }}" id="smtp_host" class="form-control"
									   placeholder="{{ _i('SMTP host') }}" type="text"
									   data-parsley-type="text" required="">
								@if($errors->has('smtp_host'))
									<span class="text-danger invalid-feedback">
										<strong>{{ $errors->first('smtp_host') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label " for="smtp_port">
								{{ _i('Port') }} </label>
							<div class="col-sm-6">
								<input name="smtp_port" value="{{ $smtp_settings->smtp_port ?? "" }}" id="smtp_port"
									   class="form-control" placeholder="{{ _i('Store SMTP port') }}"
									   type="text" data-parsley-type="text" required="">
								@if($errors->has('smtp_port'))
									<span class="text-danger invalid-feedback">
										<strong>{{ $errors->first('smtp_port') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label " for="smtp_username">
								{{ _i('Username') }} </label>
							<div class="col-sm-6">
								<input name="smtp_username" value="{{ $smtp_settings->smtp_username ?? "" }}" id="smtp_username"
									   class="form-control" placeholder="{{ _i('Username') }}"
									   type="text" data-parsley-type="text" required="">
								@if($errors->has('smtp_username'))
									<span class="text-danger invalid-feedback">
										<strong>{{ $errors->first('smtp_username') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label " for="smtp_password">
								{{ _i('Password') }} </label>
							<div class="col-sm-6">
								<input name="smtp_password" value="{{ $smtp_settings->smtp_password ?? "" }}" id="smtp_password"
									   class="form-control" placeholder="{{ _i('Password') }}"
									   type="text" data-parsley-type="text" required="">
								@if($errors->has('smtp_password'))
									<span class="text-danger invalid-feedback">
                                		<strong>{{ $errors->first('smtp_password') }}</strong>
                            		</span>
								@endif
							</div>
						</div>

						<hr>
						<div class="row">
							<div class="col-md-12 d-flex justify-content-center">
								<button type="submit" class="btn btn-info col-md-12">
									{{ _i('Save') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

