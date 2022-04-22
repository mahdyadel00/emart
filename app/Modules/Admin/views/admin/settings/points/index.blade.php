@extends('admin.layout.index',
[
	'title' => _i('Points Settings'),
	'subtitle' => _i('Points Settings'),
	'activePageName' => _i('Points Settings'),
	'activePageUrl' => route('point_settings.index'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index') ,
])
@section('content')
<div class="card">
	<div class="card-header">
		<h5>{{ _i('Points Settings') }}</h5>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-sm-12 col-xl-12 m-b-10">
				<form action="{{ route('point_settings.update') }}" method="post" id="form_store">
					@csrf
					@method('PATCH')
					<div class="row form-group">
						<label class="col-md-4" for="points_mode"> {{ _i('Points Mode') }}</label>
						<div class="col-md-8">
							<input type="checkbox" form="form_store" class="js-single" id="points_mode"
							name="points_mode"
							@if($settings->points_mode == 1) checked="" @endif
							data-switchery="true"
							style="display: none;">
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-4" for="points_minimum"> {{ _i('Minimum points') }}</label>
						<div class="col-md-2">
							<input type='text' form="form_store" class="form-control"
								name="points_minimum"
								id="points_minimum"
								placeholder="{{ _i('Minimum points') }}" value='{{ ($settings->points_minimum != null) ? $settings->points_minimum : '' }}'>
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-4" for="points_quantity"> {{ _i('Points Price') }}</label>
						<div class="col-md-2">
							<input type='text' form="form_store" class="form-control"
								name="points_quantity"
								id="points_quantity"
								placeholder="{{ _i('Quantity') }}" value='{{ ($settings->points_quantity != null) ? $settings->points_quantity : '' }}'>
						</div>
						<div class="col-md-2">
							<input type='text' form="form_store" class="form-control"
								name="points_price"
								id="points_price"
								placeholder="{{ _i('Price') }}" value='{{ ($settings->points_price != null) ? $settings->points_price : '' }}'>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 d-flex justify-content-center">
							<button type="submit" form="form_store"
								class="btn btn-primary m-b-0">{{ _i('Submit') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script type="text/javascript">
	$('body').on('submit', '#form_store', function (e) {
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
			error: function (response) {
				if (response.responseJSON.errors){
					$.each(response.responseJSON.errors, function(index, value) {
						new Noty({
							type: 'error',
							layout: 'topRight',
							text: value,
							timeout: 4000,
						}).show();
					});
				}
			},
			success: function (response) {
				if (response == 'SUCCESS'){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Updated Successfully !')}}",
						timeout: 2000,
						killer: true
					}).show();
				}
			},
		});
	});
</script>
@endpush