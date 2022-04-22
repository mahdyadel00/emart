@extends('admin.layout.index',[
	'title' => _i('Register at myfatoorah'),
	'subtitle' => _i('Register at myfatoorah'),
	'activePageName' => _i('Register at myfatoorah'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => _i('Settings'),
] )

@section('content')
<div class="box-body">
	<div class="row">
		<div class="col-sm-12">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link {{ $row->type == 'individual' ? 'active' : '' }} btn btn-primary" id="individuals-tab" data-toggle="tab" href="#individuals" role="tab" aria-controls="individuals" aria-selected="true">{{ _i('For individuals') }}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link btn btn-primary {{ $row->type == 'company' ? 'active' : '' }}" id="companies-tab" data-toggle="tab" href="#companies" role="tab" aria-controls="companies" aria-selected="false">{{ _i('For companies') }}</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade {{ $row->type == 'individual' ? 'active show' : '' }}" id="individuals" role="tabpanel" aria-labelledby="individuals-tab">
					<form method="post" action='{{route('settings.do.register.myfatoorah')}}' id='save_individuals' enctype="multipart/form-data">
						@csrf
						<input type="hidden" name='type' value='individual'>
						<div class="card">
							<div class="card-header">
								<div class="card-header-right">
									<i class="icofont icofont-rounded-down"></i>
								</div>
							</div>
							<div class="card-block">
								@if( $row->type == 'individual' )
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Status')}}
									</label>
									<div class="col-sm-10">
										{{ $row->status }}
									</div>
								</div>
								@endif
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Project name')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='project_name' value='{{ $row->type == 'individual' ? $row->project_name : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Bank name')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='bank_name' value='{{ $row->type == 'individual' ? $row->bank_name : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Bank Account number')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='bank_account_number' value='{{ $row->type == 'individual' ? $row->bank_account_number : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Bank Account IBAN')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='bank_account_iban' value='{{ $row->type == 'individual' ? $row->bank_account_iban : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Phone')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='phone' value='{{ $row->type == 'individual' ? $row->phone : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Project email')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='email' value='{{ $row->type == 'individual' ? $row->email : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Screenshot form project page on social media')}}
									</label>
									<div class="col-sm-10">
										<input type="file" class="form-control" name='screen_social'>
										@if( $row->type == 'individual' && !empty( $row->screen_social ) )
										<img src="{{ asset("uploads/settings/my_fatoorah/{$row->screen_social}") }}" class='img-thumbnail'>
										@endif
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('ID photo (front)')}}
									</label>
									<div class="col-sm-10">
										<input type="file" class="form-control" name='id_photo_front'>
										@if( $row->type == 'individual' && !empty( $row->id_photo_front ) )
										<img src="{{ asset("uploads/settings/my_fatoorah/{$row->id_photo_front}") }}" class='img-thumbnail'>
										@endif
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('ID photo (back)')}}
									</label>
									<div class="col-sm-10">
										<input type="file" class="form-control" name='id_photo_back'>
										@if( $row->type == 'individual' && !empty( $row->id_photo_back ) )
										<img src="{{ asset("uploads/settings/my_fatoorah/{$row->id_photo_back}") }}" class='img-thumbnail'>
										@endif
									</div>
								</div>

								<div class="form-group row">
									<div class="col-sm-offset-2 col-sm-2">
										<button type="submit" class="btn btn-primary pull-leftt">{{ _i('Save') }}</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade {{ $row->type == 'company' ? 'active show' : '' }}" id="companies" role="tabpanel" aria-labelledby="companies-tab">
					<form method="post" action='{{route('settings.do.register.myfatoorah')}}' id='save_companies' enctype="multipart/form-data">
						@csrf
						<input type="hidden" name='type' value='company'>
						<div class="card">
							<div class="card-header">
								<div class="card-header-right">
									<i class="icofont icofont-rounded-down"></i>
								</div>
							</div>
							<div class="card-block">
								@if( $row->type == 'company' )
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Status')}}
									</label>
									<div class="col-sm-10">
										{{ $row->status }}
									</div>
								</div>
								@endif
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Company name')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='project_name' value='{{ $row->type == 'company' ? $row->project_name : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Bank name')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='bank_name' value='{{ $row->type == 'company' ? $row->bank_name : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Bank Account number')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='bank_account_number' value='{{ $row->type == 'company' ? $row->bank_account_number : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Bank Account IBAN')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='bank_account_iban' value='{{ $row->type == 'company' ? $row->bank_account_iban : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Phone')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='phone' value='{{ $row->type == 'company' ? $row->phone : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Project email')}}
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name='email' value='{{ $row->type == 'company' ? $row->email : '' }}' required>
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Screenshot form project page on social media')}}
									</label>
									<div class="col-sm-10">
										<input type="file" class="form-control" name='screen_social'>
										@if( $row->type == 'company' && !empty( $row->screen_social ) )
										<img src="{{ asset("uploads/settings/my_fatoorah/{$row->screen_social}") }}" class='img-thumbnail'>
										@endif
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('ID photo (front)')}}
									</label>
									<div class="col-sm-10">
										<input type="file" class="form-control" name='id_photo_front'>
										@if( $row->type == 'company' && !empty( $row->id_photo_front ) )
										<img src="{{ asset("uploads/settings/my_fatoorah/{$row->id_photo_front}") }}" class='img-thumbnail'>
										@endif
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('ID photo (back)')}}
									</label>
									<div class="col-sm-10">
										<input type="file" class="form-control" name='id_photo_back'>
										@if( $row->type == 'company' && !empty( $row->id_photo_back ) )
										<img src="{{ asset("uploads/settings/my_fatoorah/{$row->id_photo_back}") }}" class='img-thumbnail'>
										@endif
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Contract photo')}}
									</label>
									<div class="col-sm-10">
										<input type="file" class="form-control" name='contract_photo'>
										@if( $row->type == 'company' && !empty( $row->contract_photo ) )
										<img src="{{ asset("uploads/settings/my_fatoorah/{$row->contract_photo}") }}" class='img-thumbnail'>
										@endif
									</div>
								</div>
								<div class="form-group row" >
									<label class="col-sm-2 col-form-label">
										{{_i('Commercial ecord photo')}}
									</label>
									<div class="col-sm-10">
										<input type="file" class="form-control" name='commercial_record_photo'>
										@if( $row->type == 'company' && !empty( $row->commercial_record_photo ) )
										<img src="{{ asset("uploads/settings/my_fatoorah/{$row->commercial_record_photo}") }}" class='img-thumbnail'>
										@endif
									</div>
								</div>

								<div class="form-group row">
									<div class="col-sm-offset-2 col-sm-2">
										<button type="submit" class="btn btn-primary pull-leftt save">{{ _i('Save') }}</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
@endsection
@push('js')
<script>
	$('body').on('submit','#save_individuals, #save_companies',function (e) {
		e.preventDefault();
	    $.ajax({
	        url: "{{ route('settings.do.register.myfatoorah') }}",
	        method: "post",
	        data: new FormData(this),
	        dataType: 'json',
	        cache       : false,
	        contentType : false,
	        processData : false,
	        success: function (response) {
	            if (response == 'success'){
	                new Noty({
	                    type: 'success',
	                    layout: 'topRight',
	                    text: "{{ _i('Request has been sent, we will reply to you soon')}}",
	                    timeout: 2000,
	                    killer: true
	                }).show();
					location.reload();
	            }
	        },
	    });
	});
</script>
@endpush
