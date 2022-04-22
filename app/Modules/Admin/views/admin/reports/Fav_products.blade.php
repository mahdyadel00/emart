@extends('admin.layout.index',[
	'title' => _i('Reports'),
	'subtitle' => _i('Reports'),
	'activePageName' => _i('Reports'),
	'activePageUrl' => route('reports.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )
@section('content')
<div class="page-body">
	<div class="box-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>{{_i('Count Favorites')}}</h5>
						<div class="card-header-right">
							<i class="icofont icofont-rounded-down"></i>
							<i class="icofont icofont-refresh"></i>
							<i class="icofont icofont-close-circled"></i>
						</div>
					</div>
					<div class="card-block">
						<div class="dt-responsive table-responsive">
							<table id="slider_table" class="table table-bordered table-striped dataTable">
								<thead>
									<tr role="row">
										<th> {{_i('ID')}}</th>
										<th> {{_i('name')}}</th>
										<th> {{_i('Number')}}</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('js')
		<script type="text/javascript">
		$(function () {
			$('#slider_table').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route('reports.Fav.products') }}',
				columns: [
					{data: 'product_ids'},
					{data: 'title'},
					{data: 'count_favorite'},
				]
			});
		});
		</script>
	@endpush
	@endsection
