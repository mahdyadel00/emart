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
		<form method='post' action='{{ route('reports.comments') }}'>
			<div class="row mb-3">
				<div class="col-md-3">
					<label for="">{{ _i('From date') }}</label>
					<input type="date" class='date form-control search-filter-from'>
				</div>
				<div class="col-md-3">
					<label for="">{{ _i('To date') }}</label>
					<input type="date" class='date form-control search-filter-to'>
				</div>
				<div class="col-md-3">
					<button type='button' class='btn btn-info search-filter-submit' style='margin-top: 30px;font-size: 14px;padding: 8px 10px;'>{{ _i('Submit') }}</button>
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>{{_i('Comments')}}</h5>
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
										<th> {{_i('Comment')}}</th>
										<th> {{_i('Product')}}</th>
										<th> {{_i('Created at')}}</th>
										<th> {{_i('Details')}}</th>
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
			var table = $('.dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route('reports.comments') }}',
				columns: [
					{data: 'id'},
					{data: 'comment'},
					{data: 'title'},
					{data: 'created_at'},
					{data: 'details'},
				]
            });

            $('.search-filter-submit').click(function(){
				var from = $('.search-filter-from').val();
				var to = $('.search-filter-to').val();
				table.ajax.url( '{{ route('reports.comments') }}?from=' + from + '&to=' + to ).load();
			})
		});
		</script>
	@endpush
	@endsection
