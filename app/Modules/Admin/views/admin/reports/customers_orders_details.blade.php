@extends('admin.layout.index',[
	'title' => _i('Reports'),
	'subtitle' => _i('Reports'),
	'activePageName' => _i('Reports'),
	'activePageUrl' => route('reports.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )
@section('content')
<section class="content">
	<div class="row">
		<div class="col-md-3">
			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					<div class='text-center'>
						<img class="profile-user-img img-responsive img-circle" src="{{ asset('images/user4-128x128.jpg') }}" alt="User profile picture">
					</div>
					<h3 class="profile-username text-center">{{ $user->name }}</h3>
					<p class="text-muted text-center">{{ $user->email }}</p>
					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>{{_i('Phone')}}</b> <a class="pull-right">{{ $user->phone }}</a>
						</li>
						<li class="list-group-item">
							<b>{{ _i('Gender') }}</b> <a class="pull-right">{{ $user->gender }}</a>
						</li>
						<li class="list-group-item">
							<b>{{ _i('Birthday') }}</b> <a class="pull-right">{{ $user->birthdate }}</a>
						</li>
						<li class="list-group-item">
							<b>{{ _i('Balance') }}</b> <a class="pull-right">{{ $user->balance }}</a>
						</li>
					</ul>
					<a href="#" class="btn btn-primary btn-block add-balance" data-toggle="modal" data-target="#add-balance-modal"><b>{{ _i('Send email') }}</b></a>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
		<!-- /.col -->
		<div class="col-md-9">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#balance" data-toggle="tab" aria-expanded="false">{{ _i('Orders') }}</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="balance">
						@foreach( $orders AS $order )
						<table class="table table-bordered table-striped">
							<tr>
								<th>{{ _i('ID') }}</th>
								<th>{{ _i('Order id') }}</th>
								<th>{{ _i('Shipping cost') }}</th>
								<th>{{ _i('Cod cost') }}</th>
								<th>{{ _i('Total') }}</th>
								<th>{{ _i('Created at') }}</th>
							</tr>
							<tr>
								<th>{{ $loop->iteration }}</th>
								<th>{{ $order->ordernumber }}</th>
								<th>{{ $order->shipping_cost }}</th>
								<th>{{ $order->cod_cost }}</th>
								<th>{{ $order->total }}</th>
								<th>{{ $order->created_at }}</th>
							</tr>
                        </table>
						@foreach( $order->orderProducts AS $product )
						<table class="table table-bordered table-striped">
							<tr>
								<th>{{ _i('ID') }}</th>
								<th>{{ _i('Title') }}</th>
								<th>{{ _i('Quantity') }}</th>
								<th>{{ _i('Total') }}</th>
							</tr>
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $product->product->translation->title ?? '' }}</td>
								<td>{{ $product->count }}</td>
								<td>{{ $product->price }}</td>
							</tr>
						</table>
						@endforeach
						@endforeach
					</div>
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</section>

<div class="modal fade" id="add-balance-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ _i('Send email') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action='{{ route('mail.coupon') }}' id='add-balance-form' method='post'>
					@csrf
					<input type="hidden" name='user_id' value='{{ $user->id }}'>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">{{ _i('Subject') }}:</label>
						<input type="text" name='subject' class="form-control">
						<label for="recipient-name" class="col-form-label">{{ _i('Body') }}:</label>
						<textarea name='body' class="form-control" rows=7></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
				<button type="submit" class="btn btn-primary" form='add-balance-form'>{{ _i('Send') }}</button>
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')
<script>
	$('body').on('submit','#add-balance-form',function (e) {
		e.preventDefault();
		let url = $(this).attr('action');
		$.ajax({
			url: url,
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
						text: "{{ _i('Mail sent successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('.modal').modal('hide');
				}
			},
		});
	});
</script>
@endpush
