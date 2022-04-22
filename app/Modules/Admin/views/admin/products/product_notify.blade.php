@extends('admin.layout.index',[
	'title' => _i('Out of stock notify'),
	'subtitle' => _i('Out of stock notify'),
	'activePageName' => _i('Out of stock notify'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Out of stock notify')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="dataTable" class="table table-bordered table-striped dataTable text-center">
							<thead>
							<tr role="row">
								<th> {{_i('ID')}} </th>
								<th> {{_i('Title')}} </th>
								<th> {{_i('User')}} </th>
								<th> {{_i('Created At')}} </th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script  type="text/javascript">
		$(function() {
			$('#dataTable').DataTable({
                order:[[0,'desc']],
				processing: true,
				serverSide: true,
				ajax: '{{ route('products.notify') }}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'title', name: 'title'},
					{data: 'user', name: 'user'},
					{data: 'created_at', name: 'created_at'},
				]
			});
		});
	</script>
@endpush
