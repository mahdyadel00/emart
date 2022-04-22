@extends('admin.layout.index',[
	'title' => _i('Requested products'),
	'subtitle' => _i('Requested products'),
	'activePageName' => _i('Requested products'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Requested products')}}</h5>
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
								<th  > {{_i('ID')}}</th>
								<th  > {{_i('Title')}}</th>
								<th  > {{_i('Details')}}</th>
								<th  > {{_i('User')}}</th>
								<th  > {{_i('Created At')}}</th>
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
				ajax: '{{ route('products.requested') }}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'title', name: 'title'},
					{data: 'details', name: 'details'},
					{data: 'user', name: 'user'},
					{data: 'created_at', name: 'created_at'},
				]
			});
		});
	</script>
@endpush
