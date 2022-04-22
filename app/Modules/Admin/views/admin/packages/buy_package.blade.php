@extends('admin.layout.index',[
	'title' => _i('Buy package'),
	'subtitle' => _i('Buy package'),
	'activePageName' => _i('Buy package'),
	'activePageUrl' => route('admin.packages.buyPackage'),
	'additionalPageName' => _i('Packages'),
	'additionalPageUrl' => route('admin.packages.index') ,
] )
@push('css')
	<style>
		.register-form .form-control {
			margin: 0;
		}
	</style>
@endpush
@section('content')
	<div class="card">
		<div class="card-header">
			<h5>
				<i class="ti-layout position-left"></i>
				{{ _i('Complete Payment') }}  </h5>
			<div class="card-header-right">
			</div>
		</div>
		<div class="card-block">
			<section class="register-form common-wrapper ">
				<div class="container">
					<div class="row">
						<div class="col-md-12 shadow mb-4">
							<form action="{{ route('executePaymentAdminPackage') }}" method="post" data-parsley-validate="">
								@csrf
								<div class="row">
									@foreach($payment_gates as $payment)
										<div class="col-md-3">
											<button type='submit' class='btn btn-info payment-method-small' name='payment_method_id' value="{{$payment->id}}">
												<span>{{$payment->method}}</span>
											</button>
										</div>
									@endforeach
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
@endsection
